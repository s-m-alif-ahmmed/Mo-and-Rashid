<?php

namespace App\Http\Controllers\Web\Backend\Query;

use App\Http\Controllers\Controller;
use App\Models\Newsletter;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class NewsletterController extends Controller
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
            $data = Newsletter::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('email', function ($data) {
                    $email = $data->email;
                    return $email;
                })

                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">

                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['email','action'])
                ->make();
        }
        return view('backend.layouts.query.newsletter');
    }

    /**
     * Remove the specified dynamic page content from storage.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function destroy(int $id): JsonResponse {
        try {
            $data = Newsletter::findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Newsletter deleted successfully.',
            ]);
        } catch (\Exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the Newsletter.',
            ]);
        }
    }
}
