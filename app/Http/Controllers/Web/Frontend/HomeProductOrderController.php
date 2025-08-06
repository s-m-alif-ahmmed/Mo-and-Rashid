<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Country;
use App\Models\DynamicPage;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\UserAddress;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session as LaravelSession;
use Srmklive\PayPal\Services\PayPal as PayPalClient;
use Stripe\Checkout\Session as StripeSession;
use Stripe\Stripe;
use Stripe\StripeClient;

class HomeProductOrderController extends Controller
{
    public function checkout()
    {
        $countries = Country::where('status', 'active')->latest()->get();
        $user = Auth::user();
        $carts = Cart::where('user_id', $user->id)->get();
        $dynamic_pages = DynamicPage::where('status', 'active')->latest()->get();
        return view('frontend.layouts.checkout', [
            'countries' => $countries,
            'carts' => $carts,
            'dynamic_pages' => $dynamic_pages,
        ]);
    }

    public function checkoutGuest()
    {
        $countries = Country::where('status', 'active')->latest()->get();
        // Initialize carts
        $carts = [];

        // Check if the user is authenticated
        if (Auth::check()) {
            $user = Auth::user();
            $carts = Cart::where('user_id', $user->id)->get();
        } else {
            // Handle guest checkout, for example by retrieving session cart items
            $carts = session()->get('cart_' . session()->getId(), []);
        }
        $dynamic_pages = DynamicPage::where('status', 'active')->latest()->get();
        return view('frontend.layouts.checkout', [
            'countries' => $countries,
            'carts' => $carts,
            'dynamic_pages' => $dynamic_pages,
        ]);
    }

    public function newOrder(Request $request)
    {
        // Validate incoming request data
        $request->validate([
            'first_name' => 'nullable|string',
            'last_name' => 'required|string',
            'contact' => 'required|string',
            'user_id' => 'required|exists:users,id',
            'country_id' => 'required|exists:countries,id',
            'address' => 'required|string',
            'apartment' => 'nullable|string',
            'city' => 'required|string',
            'postal_code' => 'required|string',
        ]);
        // Get the authenticated user
        $user = Auth::user();

        // Save delivery address if the option is selected
        if ($request->input('save-delivery')) {
            $address = new UserAddress();
            $address->user_id = $user->id;
            $address->first_name = $request->input('first_name');
            $address->last_name = $request->input('last_name');
            $address->address = $request->input('address');
            $address->apartment = $request->input('apartment');
            $address->city = $request->input('city');
            $address->postal_code = $request->input('postal_code');
            $address->contact = $request->input('contact');
            $address->country_id = $request->input('country_id');
            $address->save();
        }

        // Process each product in the cart
        $carts = Cart::where('user_id', $user->id)->get();
        $cartPrice = $carts->sum(function ($cart) {
            return $cart->product->selling_price * $cart->quantity;
        });

        // Create a new Order instance
        $order = new Order();
        $order->user_id = $user->id;
        $order->total = $cartPrice;
        $order->name = trim($request->input('first_name') . ' ' . $request->input('last_name'));
        $order->address = $request->input('address');
        $order->apartment = $request->input('apartment');
        $order->city = $request->input('city');
        $order->postal_code = $request->input('postal_code');
        $order->contact = $request->input('contact');
        $order->country_id = $request->input('country_id');
        $order->tracking_id = $this->generateTrackingId();
        $order->status = 'Pending Payment';
        $order->save();
        LaravelSession::put('t-success', $order->id); // Store order ID in session

        $cancleURL = route('checkout');

        if ($request->input('method') == 'paypal') {

            $redirectUrl = route('paypal.success');

            $provider = new PayPalClient;
            $provider->setApiCredentials(config('paypal'));
            $paypalToken = $provider->getAccessToken();
            $response = $provider->createOrder([
                "intent" => "CAPTURE",
                "application_context" => [
                    "return_url" => $redirectUrl,
                    "cancel_url" => $cancleURL,
                ],
                "purchase_units" => [
                    0 => [
                        "amount" => [
                            "currency_code" => "USD",
                            "value" => $cartPrice,
                        ],
                    ],
                ],
            ]);
            if (isset($response['id']) && $response['id'] != null) {
                // redirect to approve href
                foreach ($response['links'] as $links) {
                    if ($links['rel'] == 'approve') {
                        return redirect()->away($links['href']);
                    }
                }
                return redirect()
                    ->route('order.cancel')
                    ->with('t-error', 'Something went wrong.');
            } else {
                return redirect()
                    ->route('order.cancel')
                    ->with('t-error', $response['message'] ?? 'Something went wrong.');
            }
        } elseif ($request->input('method') == 'stripe') {

            // Set the Stripe API key
            Stripe::setApiKey(config('services.stripe.secret'));

            $redirectUrl = route('order.success').'?token={CHECKOUT_SESSION_ID}';

            // Create a Stripe Checkout session
            $session = StripeSession::create([
                'payment_method_types' => ['card'],
                'line_items' => [[
                    'price_data' => [
                        'currency' => 'usd',
                        'product_data' => [
                            'name' => $user->name,
                        ],
                        'unit_amount' => $cartPrice * 100,
                    ],
                    'quantity' => 1,
                ]],
                'mode' => 'payment',
                'success_url' => $redirectUrl,
                'cancel_url' => $cancleURL,
            ]);

            return redirect($session->url, 303);

        } else {
            return redirect()
                ->route('order.cancel')
                ->with('t-error', 'Something went wrong.');
        }

    }

    public function checkoutSuccess(Request $request)
    {
        try {
            $stripe = new StripeClient(config('services.stripe.secret'));
            $user = auth()->user();
            // saving the session
            $session = $stripe->checkout->sessions->retrieve($request->token);
            // checking all is present
            if (!empty($session) && $session->payment_status == 'paid') {
                DB::beginTransaction();

                $carts = $user->carts;
                $order = Order::where('user_id', $user->id)->latest()->first();
                $order->status = 'Pending';
                $order->save();

                foreach ($carts as $cart) {
                    $orderDetail = new OrderDetail();
                    $orderDetail->order_id = $order->id;
                    $orderDetail->product_id = $cart->product->id;
                    $orderDetail->discount_price = $cart->discount_price ?? null;
                    $orderDetail->selling_price = $cart->selling_price;
                    $orderDetail->quantity = $cart->quantity;

                    // Assign product_size_id if present
                    $orderDetail->product_size_id = $cart->size_id ?? null;

                    // Assign product_color_id if present
                    $orderDetail->product_color_id = $cart->color_id ?? null;

                    // Save the order detail
                    $orderDetail->save();

                    // Delete the cart
                    $cart->delete();
                }

                DB::commit();

                return redirect()->route('home')->with([
                    't-success' => 'Purchase completed',
                    'order' => $order,
                ]);
            } else {
                return redirect()->route('home')->with('t-error', 'Transection Fail...!');
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->route('home')->with([
                't-error' => 'Order completed successfully.',
                'order' => $order,
                ]);
        }
    }

    public function paypalSuccess(Request $request)
    {
        $provider = new PayPalClient;
        $provider->setApiCredentials(config('paypal'));
        $provider->getAccessToken();
        $response = $provider->capturePaymentOrder($request['token']);
        if (isset($response['status']) && $response['status'] == 'COMPLETED') {
            DB::beginTransaction();

            $user = auth()->user();
            $carts = $user->carts;
            $order = Order::where('user_id', $user->id)->latest()->first();
            $order->status = 'Pending';
            $order->save();

            foreach ($carts as $cart) {
                $orderDetail = new OrderDetail();
                $orderDetail->order_id = $order->id;
                $orderDetail->product_id = $cart->product->id;
                $orderDetail->discount_price = $cart->discount_price ?? null;
                $orderDetail->selling_price = $cart->selling_price;
                $orderDetail->quantity = $cart->quantity;

                // Assign product_size_id if present
                $orderDetail->product_size_id = $cart->size_id ?? null;

                // Assign product_color_id if present
                $orderDetail->product_color_id = $cart->color_id ?? null;

                // Save the order detail
                $orderDetail->save();

                // Delete the cart
                $cart->delete();
            }

            DB::commit();

            return redirect()->route('home')->with([
                't-success' => 'Purchase completed',
                'order' => $order,
            ]);
        } else {
            return redirect()
                ->route('home')
                ->with('t-error', $response['message'] ?? 'Something went wrong.');
        }
    }

    public function checkoutCancel()
    {
        return view('frontend.layouts.home')->with('t-error', 'Transection Fail...!');
    }

    private function generateTrackingId()
    {
        $length = 10; // Fixed length
        $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
        $trackingId = '';

        for ($i = 0; $i < $length; $i++) { // Changed from <= to < for correct length
            $trackingId .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $trackingId;
    }

}
