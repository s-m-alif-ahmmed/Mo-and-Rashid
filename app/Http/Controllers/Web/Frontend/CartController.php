<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_id' => 'required|exists:colors,id',
            'size_id' => 'required|exists:sizes,id',
        ]);

        // Get the product details
        $item = Product::findOrFail($request->product_id);

        // Get the authenticated user
        $userId = auth()->user()->id;

        // Check the total quantity of this product for the current user
        $userCartQuantity = Cart::where('user_id', $userId)
            ->where('product_id', $request->product_id)
            ->sum('quantity');

        // Check if the total quantity in the user's cart is less than available stock
        if ($userCartQuantity < $item->quantity) {
            // Check if the item is already in the cart
            $cartItem = Cart::where('user_id', $userId)
                ->where('product_id', $request->product_id)
                ->where('color_id', $request->color_id ?? null)
                ->where('size_id', $request->size_id ?? null)
                ->first();

            if ($cartItem) {
                // If the item already exists, increment the quantity
                if ($userCartQuantity + 1 <= $item->quantity) {
                    $cartItem->quantity += 1;
                    $cartItem->save();

                    return response()->json([
                        'success' => true,
                        'message' => 'Item added to cart successfully!',
                        'cart' => $this->formatCartItemResponse($cartItem)
                    ]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Requested quantity exceeds available stock!']);
                }
            } else {
                // Create a new cart item if it doesn't exist
                if ($userCartQuantity < $item->quantity) {
                    $cartItem = Cart::create([
                        'user_id' => $userId,
                        'product_id' => $request->product_id,
                        'color_id' => $request->color_id ?? null,
                        'size_id' => $request->size_id ?? null,
                        'quantity' => 1, // Start with quantity of 1
                        'selling_price' => $item->selling_price,
                        'discount_price' => $item->discount_price,
                    ]);

                    return response()->json([
                        'success' => true,
                        'message' => 'Item added to cart successfully!',
                        'cart' => $this->formatCartItemResponse($cartItem)
                    ]);
                } else {
                    return response()->json(['success' => false, 'message' => 'Requested quantity exceeds available stock!']);
                }
            }
        } else {
            return response()->json(['success' => false, 'message' => 'Requested quantity exceeds available stock!']);
        }
    }

    private function formatCartItemResponse($cartItem)
    {
        return [
            'id' => $cartItem->id,
            'product' => [
                'name' => $cartItem->product->name,
                'image' => asset($cartItem->product->images->first()->image), // Make sure to get the correct image URL
                'selling_price' => $cartItem->product->selling_price,
            ],
            'color' => [
                'color' =>  $cartItem->color ? $cartItem->color->color : null, // Handle nullable color
            ],
            'size' => [
                'size' => $cartItem->size ? $cartItem->size->size : null, // Handle nullable size
            ],
            'quantity' => $cartItem->quantity,
        ];
    }

    public function removeCartItem($id)
    {
        try {
            // Find the cart item
            $cartItem = Cart::findOrFail($id);
            //
            if ($cartItem) {
                $cartItem->delete(); // Remove the item from the cart
                return response()->json(['success' => true, 'message' => 'Item removed from cart successfully!']);
            } else {
                return response()->json(['success' => false, 'message' => 'Item not found.'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Could not remove item from cart.'], 500);
        }
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:carts,id',
            'quantity' => 'required|integer|min:1',
        ]);

        try {
            $user = Auth::user();
            $cartItem = Cart::findOrFail($request->id);
            $product = Product::findOrFail($cartItem->product_id);

            // Calculate total quantity already in the cart for this product
            $totalCartQuantity = Cart::where('product_id', $cartItem->product_id)
                ->where('user_id', $user->id)
                ->sum('quantity');

            // Calculate new total quantity
            $newTotalQuantity = $totalCartQuantity - $cartItem->quantity + $request->quantity;

            if ($newTotalQuantity > $product->quantity) {
                return response()->json(['success' => false, 'message' => 'Requested quantity exceeds available stock.'], 400);
            }

            // Update the quantity
            $cartItem->quantity = $request->quantity;
            $cartItem->save();

            // Prepare response
            return response()->json([
                'success' => true,
                'message' => 'Cart item updated successfully!',
                'cart' => [
                    'id' => $cartItem->id,
                    'product' => [
                        'name' => $cartItem->product->name,
                        'image' => asset($cartItem->product->images->first()->image),
                        'selling_price' => $cartItem->product->selling_price,
                    ],
                    'color' => [
                        'color' =>  $cartItem->color ? $cartItem->color->color : null, // Handle nullable color
                    ],
                    'size' => [
                        'size' => $cartItem->size ? $cartItem->size->size : null, // Handle nullable size
                    ],
                    'quantity' => $cartItem->quantity,
                    'total_price' => $cartItem->quantity * $cartItem->product->selling_price,
                ],
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Could not update cart item.'], 500);
        }
    }

    public function moveToWishlist(Request $request, $cartItemId)
    {
        // Get the current authenticated user
        $auth = auth()->user();

        // Find the cart item
        $cartItem = Cart::findOrFail($cartItemId);
        $product = Product::findOrFail($cartItem->product_id);

        // Get color and size from the cart item
        $colorId = $cartItem->color_id ?? null;
        $sizeId = $cartItem->size_id ?? null;

        // Check if the product is already in the cart
        $wishlist = Wishlist::where('product_id', $cartItem->product_id)
            ->where('user_id', $auth->id)
            ->first();

        if (!$wishlist) {
            // Create a new wishlist item
            $wishlist = Wishlist::create([
                'product_id' => $cartItem->product_id,
                'user_id' => $auth->id,
                'product_color_id' => $colorId,
                'product_size_id' => $sizeId,
            ]);

            // Remove the cart item
            $cartItem->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product moved to wishlist successfully',
                'wishlistItem' => [
                    'wishlistId' => $wishlist->id,
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => $product->selling_price,
                    'color' => $wishlist->color ? $wishlist->color->color : null, // Handle nullable color
                    'size' => $wishlist->size ? $wishlist->size->size : null, // Handle nullable size
                    'image' => asset($product->images->first()->image), // Ensure the correct image URL
                ],
            ]);

        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product already added to wishlist!',
            ]);
        }
    }

//    Session Guest
    public function addToCartGuest(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'color_id' => 'nullable|exists:colors,id',
            'size_id' => 'nullable|exists:sizes,id',
        ]);

        // Unique session key to store the cart
        $cartSessionKey = 'cart_' . session()->getId();
        $cartItems = Session::get($cartSessionKey, []);

        // Get the product details, including images
        $item = Product::with(['images'])->find($request->product_id); // Make sure images are loaded

        // Check if the item exists
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }

        // Generate a unique key for the item in the cart (combining product_id, color_id, and size_id)
        $existingItemKey = "{$request->product_id}_{$request->color_id}_{$request->size_id}";

        // Add or update the cart item in the session
        if (isset($cartItems[$existingItemKey])) {
            // If item exists, check the quantity and increment
            $currentQuantity = $cartItems[$existingItemKey]['quantity'];
            if ($currentQuantity + 1 <= $item->quantity) {
                $cartItems[$existingItemKey]['quantity'] += 1;
                Session::put($cartSessionKey, $cartItems);

                return response()->json([
                    'success' => true,
                    'message' => 'Item added to cart successfully!',
                    'cartItem' => $cartItems[$existingItemKey],
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Requested quantity exceeds available stock!']);
            }
        } else {
            // Add new item to the session cart if there's enough stock
            if ($item->quantity > 0) {
                $cartItems[$existingItemKey] = [
                    'cartId' => $existingItemKey,
                    'product' => [
                        'id' => $item->id,
                        'name' => $item->name,
                    ],
                    'selling_price' => $item->selling_price,
                    'discount_price' => $item->discount_price,
                    'quantity' => 1,
                    'color' => $request->color_id ? \App\Models\Color::find($request->color_id) : null, // Fetch the color model
                    'size' => $request->size_id ? \App\Models\Size::find($request->size_id) : null, // Fetch the size model
                    'images' => $item->images->pluck('image')->toArray(), // Store images URLs in the session
                ];

                Session::put($cartSessionKey, $cartItems);

                return response()->json([
                    'success' => true,
                    'message' => 'Item added to cart successfully!',
                    'cartItem' => $cartItems[$existingItemKey],
                ]);
            } else {
                return response()->json(['success' => false, 'message' => 'Out of stock!']);
            }
        }
    }

    public function guestCartRemove(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'cart_id' => 'required|string',
        ]);

        // Unique session key to store the cart
        $cartSessionKey = 'cart_' . session()->getId();
        $cartItems = Session::get($cartSessionKey, []);

        // Check if the item exists in the cart
        if (isset($cartItems[$request->cart_id])) {
            unset($cartItems[$request->cart_id]); // Remove the item
            Session::put($cartSessionKey, $cartItems);

            return response()->json(['success' => true, 'message' => 'Item removed from cart successfully!']);
        }

        return response()->json(['success' => false, 'message' => 'Item not found in cart.']);
    }

    public function updateGuestCart(Request $request)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
            'product_id' => 'required|integer',
            'color_id' => 'nullable|integer',
            'size_id' => 'nullable|integer',
        ]);

        try {
            // Unique session key for the guest cart
            $cartSessionKey = 'cart_' . session()->getId();
            $cartItems = Session::get($cartSessionKey, []);

            // Generate a unique key for the item in the cart
            $existingItemKey = "{$request->product_id}_{$request->color_id}_{$request->size_id}";

            // Check if the item exists in the cart
            if (!isset($cartItems[$existingItemKey])) {
                return response()->json(['success' => false, 'message' => 'Item not found in cart.'], 404);
            }

            // Get the product details to check stock
            $item = Product::findOrFail($request->product_id);

            // Validate requested quantity against available stock
            if ($request->quantity > $item->quantity) {
                return response()->json(['success' => false, 'message' => 'Requested quantity exceeds available stock.'], 400);
            }

            // Update the quantity in the cart session
            $cartItems[$existingItemKey]['quantity'] = $request->quantity;
            Session::put($cartSessionKey, $cartItems);

            // Prepare response
            return response()->json([
                'success' => true,
                'message' => 'Cart item updated successfully!',
                'cartItem' => [
                    'cartId' => $existingItemKey,
                    'product' => [
                        'id' => $item->id,
                        'name' => $item->name,
                    ],
                    'selling_price' => $item->selling_price,
                    'discount_price' => $item->discount_price,
                    'quantity' => $request->quantity, // Updated quantity
                    'color' => $request->color_id ? \App\Models\Color::find($request->color_id) : null,
                    'size' => $request->size_id ? \App\Models\Size::find($request->size_id) : null,
                    'images' => $item->images->pluck('image')->toArray(),
                ],
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json(['success' => false, 'message' => 'Could not update cart item.'], 500);
        }
    }

    public function moveToWishlistGuest(Request $request)
    {
        // Retrieve the cartItemId from the AJAX request
        $cartItemId = $request->input('cartItemId'); // Ensure the correct parameter name

        // Unique session key to store the wishlist
        $wishlistSessionKey = 'wishlist_' . session()->getId();
        $wishlistItems = Session::get($wishlistSessionKey, []);

        // Unique session key to store the cart
        $cartSessionKey = 'cart_' . session()->getId();
        $cartItems = Session::get($cartSessionKey, []);

        // Check if the cart item exists in the session cart
        if (!isset($cartItems[$cartItemId])) {
            return response()->json(['success' => false, 'message' => 'Product not found in cart.']);
        }

        // Get the cart item details
        $cartItem = $cartItems[$cartItemId];
        $item = Product::with(['images'])->find($cartItem['product']['id']); // Ensure images are loaded

        // Check if the item exists in the database
        if (!$item) {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }

        // Ensure color and size are checked for null before accessing their properties
        $colorId = $cartItem['color'] ? $cartItem['color']['id'] : null;
        $sizeId = $cartItem['size'] ? $cartItem['size']['id'] : null;

        // Create a unique key for the wishlist item
        $existingItemKey = "{$cartItem['product']['id']}_{$colorId}_{$sizeId}";

        // Check if the item already exists in the wishlist
        if (!isset($wishlistItems[$existingItemKey])) {
            // Move the cart item to the wishlist
            $wishlistItems[$existingItemKey] = [
                'wishlistId' => $existingItemKey,
                'product' => [
                    'id' => $item->id,
                    'name' => $item->name,
                ],
                'selling_price' => $item->selling_price,
                'discount_price' => $item->discount_price,
                'color' => $cartItem['color'] ?? null,  // Safe check for null
                'size' => $cartItem['size'] ?? null,    // Safe check for null
                'images' => $item->images->pluck('image')->toArray(),
            ];

            // Remove the cart item from the session
            unset($cartItems[$cartItemId]);

            // Save the updated cart and wishlist to session
            Session::put($wishlistSessionKey, $wishlistItems);
            Session::put($cartSessionKey, $cartItems); // Ensure the cart is updated

            return response()->json([
                'success' => true,
                'message' => 'Product moved to wishlist successfully!',
                'wishlistItem' => $wishlistItems[$existingItemKey],
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Product already in wishlist!',
            ]);
        }
    }

}
