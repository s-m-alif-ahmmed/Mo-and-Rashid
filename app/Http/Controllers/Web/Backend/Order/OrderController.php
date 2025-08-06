<?php

namespace App\Http\Controllers\Web\Backend\Order;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class OrderController extends Controller
{
    public function index(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::where('status', 'Pending')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($data) {
                    return $data->created_at->setTimezone('America/New_York')->format('n/j/Y g:i A T');
                })
                ->addColumn('tracking_id', function ($data) {
                    return $data->tracking_id;
                })
                ->addColumn('status', function ($data) {
                    $statusOptions = [
                        'Pending' => 'Pending',
                        'Complete' => 'Complete',
                        'Return' => 'Return',
                        'Canceled' => 'Canceled',
                        'Pending Payment' => 'Pending Payment',
                        'Payment Failed' => 'Payment Failed',
                    ];

                    $statusSelect = '<select onchange="showStatusChangeAlert(event, ' . $data->id . ')" class="form-control" style="width: auto;">';

                    foreach ($statusOptions as $value => $label) {
                        $selected = $data->status == $value ? 'selected' : '';
                        $statusSelect .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                    }

                    $statusSelect .= '</select>';

                    return $statusSelect;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <a href="' . route('order.show', ['id' => $data->id]) . '" class="btn btn-primary fs-14 text-white" title="Edit">
                                <i class="fe fe-eye"></i>
                            </a>
                            <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white" title="Delete">
                                <i class="fe fe-trash"></i>
                            </a>
                        </div>';
                })
                ->rawColumns(['created_at', 'tracking_id', 'status', 'action'])
                ->make();
        }

        return view('backend.layouts.order.index');
    }
    public function pendingPayment(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::where('status', 'Pending Payment')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($data) {
                    return $data->created_at->setTimezone('America/New_York')->format('n/j/Y g:i A T');
                })
                ->addColumn('tracking_id', function ($data) {
                    return $data->tracking_id;
                })
                ->addColumn('status', function ($data) {
                    $statusOptions = [
                        'Pending' => 'Pending',
                        'Complete' => 'Complete',
                        'Return' => 'Return',
                        'Canceled' => 'Canceled',
                        'Pending Payment' => 'Pending Payment',
                        'Payment Failed' => 'Payment Failed',
                    ];

                    $statusSelect = '<select onchange="showStatusChangeAlert(event, ' . $data->id . ')" class="form-control" style="width: auto;">';

                    foreach ($statusOptions as $value => $label) {
                        $selected = $data->status == $value ? 'selected' : '';
                        $statusSelect .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                    }

                    $statusSelect .= '</select>';

                    return $statusSelect;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <a href="' . route('order.show', ['id' => $data->id]) . '" class="btn btn-primary fs-14 text-white" title="Edit">
                                <i class="fe fe-eye"></i>
                            </a>
                            <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white" title="Delete">
                                <i class="fe fe-trash"></i>
                            </a>
                        </div>';
                })
                ->rawColumns(['created_at', 'tracking_id', 'status', 'action'])
                ->make();
        }

        return view('backend.layouts.order.payment-pending');
    }
    public function paymentFailed(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::where('status', 'Payment Failed')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($data) {
                    return $data->created_at->setTimezone('America/New_York')->format('n/j/Y g:i A T');
                })
                ->addColumn('tracking_id', function ($data) {
                    return $data->tracking_id;
                })
                ->addColumn('status', function ($data) {
                    $statusOptions = [
                        'Pending' => 'Pending',
                        'Complete' => 'Complete',
                        'Return' => 'Return',
                        'Canceled' => 'Canceled',
                        'Pending Payment' => 'Pending Payment',
                        'Payment Failed' => 'Payment Failed',
                    ];

                    $statusSelect = '<select onchange="showStatusChangeAlert(event, ' . $data->id . ')" class="form-control" style="width: auto;">';

                    foreach ($statusOptions as $value => $label) {
                        $selected = $data->status == $value ? 'selected' : '';
                        $statusSelect .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                    }

                    $statusSelect .= '</select>';

                    return $statusSelect;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <a href="' . route('order.show', ['id' => $data->id]) . '" class="btn btn-primary fs-14 text-white" title="Edit">
                                <i class="fe fe-eye"></i>
                            </a>
                            <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white" title="Delete">
                                <i class="fe fe-trash"></i>
                            </a>
                        </div>';
                })
                ->rawColumns(['created_at', 'tracking_id', 'status', 'action'])
                ->make();
        }

        return view('backend.layouts.order.payment-failed');
    }
    public function allOrders(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($data) {
                    return $data->created_at->setTimezone('America/New_York')->format('n/j/Y g:i A T');
                })
                ->addColumn('tracking_id', function ($data) {
                    return $data->tracking_id;
                })
                ->addColumn('status', function ($data) {
                    $statusOptions = [
                        'Pending' => 'Pending',
                        'Complete' => 'Complete',
                        'Return' => 'Return',
                        'Canceled' => 'Canceled',
                        'Pending Payment' => 'Pending Payment',
                        'Payment Failed' => 'Payment Failed',
                    ];

                    $statusSelect = '<select onchange="showStatusChangeAlert(event, ' . $data->id . ')" class="form-control" style="width: auto;">';

                    foreach ($statusOptions as $value => $label) {
                        $selected = $data->status == $value ? 'selected' : '';
                        $statusSelect .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                    }

                    $statusSelect .= '</select>';

                    return $statusSelect;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <a href="' . route('order.show', ['id' => $data->id]) . '" class="btn btn-primary fs-14 text-white" title="Edit">
                                <i class="fe fe-eye"></i>
                            </a>
                            <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white" title="Delete">
                                <i class="fe fe-trash"></i>
                            </a>
                        </div>';
                })
                ->rawColumns(['created_at', 'tracking_id', 'status', 'action'])
                ->make();
        }

        return view('backend.layouts.order.all-orders');
    }


    public function indexComplete(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::where('status','Complete')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($data) {
                    return $data->created_at->setTimezone('America/New_York')->format('n/j/Y g:i A T');
                })
                ->addColumn('tracking_id', function ($data) {
                    return $data->tracking_id;
                })
                ->addColumn('status', function ($data) {
                    $statusOptions = [
                        'Pending' => 'Pending',
                        'Complete' => 'Complete',
                        'Return' => 'Return',
                        'Canceled' => 'Canceled',
                        'Pending Payment' => 'Pending Payment',
                        'Payment Failed' => 'Payment Failed',
                    ];

                    $statusSelect = '<select onchange="showStatusChangeAlert(event, ' . $data->id . ')" class="form-control" style="width: auto;">';

                    foreach ($statusOptions as $value => $label) {
                        $selected = $data->status == $value ? 'selected' : '';
                        $statusSelect .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                    }

                    $statusSelect .= '</select>';

                    return $statusSelect;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <a href="' . route('order.show', ['id' => $data->id]) . '" class="btn btn-primary fs-14 text-white" title="Edit">
                                <i class="fe fe-eye"></i>
                            </a>
                            <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white" title="Delete">
                                <i class="fe fe-trash"></i>
                            </a>
                        </div>';
                })
                ->rawColumns(['created_at', 'tracking_id', 'status', 'action'])
                ->make();
        }

        return view('backend.layouts.order.indexComplete');
    }

    public function indexReturn(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::where('status','Return')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($data) {
                    return $data->created_at->setTimezone('America/New_York')->format('n/j/Y g:i A T');
                })
                ->addColumn('tracking_id', function ($data) {
                    return $data->tracking_id;
                })
                ->addColumn('status', function ($data) {
                    $statusOptions = [
                        'Pending' => 'Pending',
                        'Complete' => 'Complete',
                        'Return' => 'Return',
                        'Canceled' => 'Canceled',
                        'Pending Payment' => 'Pending Payment',
                        'Payment Failed' => 'Payment Failed',
                    ];

                    $statusSelect = '<select onchange="showStatusChangeAlert(event, ' . $data->id . ')" class="form-control" style="width: auto;">';

                    foreach ($statusOptions as $value => $label) {
                        $selected = $data->status == $value ? 'selected' : '';
                        $statusSelect .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                    }

                    $statusSelect .= '</select>';

                    return $statusSelect;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <a href="' . route('order.show', ['id' => $data->id]) . '" class="btn btn-primary fs-14 text-white" title="Edit">
                                <i class="fe fe-eye"></i>
                            </a>
                            <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white" title="Delete">
                                <i class="fe fe-trash"></i>
                            </a>
                        </div>';
                })
                ->rawColumns(['created_at', 'tracking_id', 'status', 'action'])
                ->make();
        }

        return view('backend.layouts.order.indexReturn');
    }

    public function indexCanceled(Request $request): View | JsonResponse
    {
        if ($request->ajax()) {
            $data = Order::where('status','Canceled')->latest()->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('created_at', function ($data) {
                    return $data->created_at->setTimezone('America/New_York')->format('n/j/Y g:i A T');
                })
                ->addColumn('tracking_id', function ($data) {
                    return $data->tracking_id;
                })
                ->addColumn('status', function ($data) {
                    $statusOptions = [
                        'Pending' => 'Pending',
                        'Complete' => 'Complete',
                        'Return' => 'Return',
                        'Canceled' => 'Canceled',
                        'Pending Payment' => 'Pending Payment',
                        'Payment Failed' => 'Payment Failed',
                    ];

                    $statusSelect = '<select onchange="showStatusChangeAlert(event, ' . $data->id . ')" class="form-control" style="width: auto;">';

                    foreach ($statusOptions as $value => $label) {
                        $selected = $data->status == $value ? 'selected' : '';
                        $statusSelect .= '<option value="' . $value . '" ' . $selected . '>' . $label . '</option>';
                    }

                    $statusSelect .= '</select>';

                    return $statusSelect;
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                            <a href="' . route('order.show', ['id' => $data->id]) . '" class="btn btn-primary fs-14 text-white" title="Edit">
                                <i class="fe fe-eye"></i>
                            </a>
                            <a href="#" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white" title="Delete">
                                <i class="fe fe-trash"></i>
                            </a>
                        </div>';
                })
                ->rawColumns(['created_at', 'tracking_id', 'status', 'action'])
                ->make();
        }

        return view('backend.layouts.order.indexCanceled');
    }

    public function show(Request $request, $id)
    {
        try {
            $order = Order::with([
                'orderDetails.product',
                'orderDetails.productColor',
                'orderDetails.productSize',
            ])->findOrFail($id);

            return view('backend.layouts.order.detail', compact('order'));
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'error' => 'Error fetching order details.'], 500);
        }
    }

    public function status(Request $request, $id)
    {
        try {
            $order = Order::findOrFail($id);
            $status = $request->input('status'); // Ensure the status is sent in the request body
            $order->update(['status' => $status]);

            return response()->json(['success' => true, 'message' => 'Order status changed successfully.']);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Error updating order status.'], 500);
        }
    }

    /**
     * Remove the specified dynamic page content from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        try {
            // Find the order with its related order details
            $order = Order::with('orderDetails')->findOrFail($id);

            // Delete related order details and restore product stock
            foreach ($order->orderDetails as $orderDetail) {
                $product = Product::find($orderDetail->product_id);
                if ($product) {
                    // Increase the product stock
                    $product->quantity += $orderDetail->quantity;
                    $product->save();
                }
            }

            // Now delete related order details
            $order->orderDetails()->delete();

            // Now delete the order itself
            $order->delete();

            return response()->json([
                'success' => true,
                'message' => 'Order deleted successfully.',
            ]);
        } catch (\Exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the Order.',
            ]);
        }
    }

}
