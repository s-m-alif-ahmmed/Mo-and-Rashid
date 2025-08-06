<?php

namespace App\Http\Controllers\Web\Backend\Product;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Wishlist;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class WishlistController extends Controller
{
    /**
     * Display a listing of dynamic page content.
     *
     * @param Request $request
     * @return View|JsonResponse
     * @throws Exception
     */
    public function index(Request $request): View | JsonResponse {
        if ($request->ajax()) {
            $data = Wishlist::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('email', function ($data) {
                    return $data->user->email; // Change user_id to user
                })
                ->addColumn('name', function ($data) {
                    return $data->product->name; // Change product_id to product
                })
                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['action'])
                ->make();
        }
        return view('backend.layouts.product-query.wishlist.index');
    }

    /**
     * Remove the specified dynamic page content from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        try {
            $data = Wishlist::findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Wishlist deleted successfully.',
            ]);
        } catch (\Exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the Wishlist.',
            ]);
        }
    }

}
