<?php

namespace App\Http\Controllers\Web\Backend;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Vacation;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    /**
     * Display the dashboard page.
     *
     * @return View
     */


    public function index(): View
    {

        // Get the current date and time
        $currentDate = Carbon::now()->format('Y-m-d');
        $currentTime = Carbon::now()->format('H:i:s');

        $user_count = User::where('role', 'user')->count();
        $all_orders = Order::all()->count();
        $payment_fail_order = Order::where('status', 'Payment Failed')->count();
        $payment_pending_order = Order::where('status', 'Pending Payment')->count();
        $pending_order = Order::where('status', 'Pending')->count();
        $complete_order = Order::where('status', 'Complete')->count();
        $return_order = Order::where('status', 'Return')->count();
        $canceled_order = Order::where('status', 'Canceled')->count();

        if (Auth::check()) {
            if (Auth::user()->role == 'admin') {

                $vacation = Vacation::first();


                return view('backend.layouts.dashboard.index',[
                    'user_count' => $user_count,
                    'all_orders' => $all_orders,
                    'payment_fail_order' => $payment_fail_order,
                    'payment_pending_order' => $payment_pending_order,
                    'pending_order' => $pending_order,
                    'complete_order' => $complete_order,
                    'return_order' => $return_order,
                    'canceled_order' => $canceled_order,
                ], compact('vacation'));
            }else{
                return redirect()->back();
            }
        }else{
            return redirect()->back();
        }

    }
}
