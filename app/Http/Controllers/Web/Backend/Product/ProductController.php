<?php

namespace App\Http\Controllers\Web\Backend\Product;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Color;
use App\Models\ColorSizeQuantity;
use App\Models\Product;
use App\Models\ProductCareInstruction;
use App\Models\ProductColor;
use App\Models\ProductImage;
use App\Models\ProductSize;
use App\Models\Size;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
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
            $data = Product::latest()->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('name', function ($data) {
                    $name = $data->name;
                    return $name;
                })

                ->addColumn('status', function ($data) {
                    $backgroundColor  = $data->status == "active" ? '#4CAF50' : '#ccc';
                    $sliderTranslateX = $data->status == "active" ? '26px' : '2px';
                    $sliderStyles     = "position: absolute; top: 2px; left: 2px; width: 20px; height: 20px; background-color: white; border-radius: 50%; transition: transform 0.3s ease; transform: translateX($sliderTranslateX);";

                    $status = '<div class="form-check form-switch" style="margin-left:40px; position: relative; width: 50px; height: 24px; background-color: ' . $backgroundColor . '; border-radius: 12px; transition: background-color 0.3s ease; cursor: pointer;">';
                    $status .= '<input onclick="showStatusChangeAlert(' . $data->id . ')" type="checkbox" class="form-check-input" id="customSwitch' . $data->id . '" getAreaid="' . $data->id . '" name="status" style="position: absolute; width: 100%; height: 100%; opacity: 0; z-index: 2; cursor: pointer;">';
                    $status .= '<span style="' . $sliderStyles . '"></span>';
                    $status .= '<label for="customSwitch' . $data->id . '" class="form-check-label" style="margin-left: 10px;"></label>';
                    $status .= '</div>';

                    return $status;
                })

                ->addColumn('action', function ($data) {
                    return '<div class="btn-group btn-group-sm" role="group" aria-label="Basic example">
                                <a href="' . route('products.edit', ['id' => $data->id]) . '" type="button" class="btn btn-primary fs-14 text-white edit-icn" title="Edit">
                                    <i class="fe fe-edit"></i>
                                </a>

                                <a href="#" type="button" onclick="showDeleteConfirm(' . $data->id . ')" class="btn btn-danger fs-14 text-white delete-icn" title="Delete">
                                    <i class="fe fe-trash"></i>
                                </a>
                            </div>';
                })
                ->rawColumns(['name', 'status', 'action'])
                ->make();
        }
        return view('backend.layouts.product.product.index');
    }

    /**
     * Show the form for creating a new dynamic page content.
     *
     * @return View
     */
    public function create(): View {
        $categories = Category::all();
        $brands = Brand::all();
        $sizes = Size::all();
        $colors = Color::all();
        return view('backend.layouts.product.product.create',[
            'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes,
            'colors' => $colors,
        ]);
    }

    /**
     * Store a newly created dynamic page content in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse {
        try {

            // Validate the incoming request data
            $validator = Validator::make($request->all(), [
                'name'            => 'required|string|max:255',
                'category_id'     => 'required|exists:categories,id',
                'brand_id'        => 'required|exists:brands,id',
                'image.*'         => 'required',
                'description'     => 'nullable|string',
                'discount_price' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'selling_price'  => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'quantity'        => 'nullable|integer|min:0',
                'size.*'          => 'nullable|exists:sizes,id',
                'color.*'         => 'nullable|exists:colors,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            // Create the product instance
            $data = new Product();
            $data->name = $request->name;
            $data->category_id = $request->category_id;
            $data->brand_id = $request->brand_id;
            $data->description = $request->description;
            $data->discount_price = $request->discount_price;
            $data->selling_price = $request->selling_price;
            $data->quantity = $request->quantity;
            $data->product_slug = Str::slug($request->name.'-'.rand(100000, 999999), '-');
            $data->save();

            // Handle the file upload for images
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $imageName = time() . '_' . uniqid(); // Generate a unique name for the image
                    $imagePath = Helper::fileUpload($image, 'product', $imageName); // Use the helper method

                    if ($imagePath) {
                        // Store the image in the product_images table
                        ProductImage::create([
                            'product_id' => $data->id,
                            'image' => $imagePath,
                        ]);
                    }
                }
            }

            // Store product colors
            if ($request->has('color_id')) {
                foreach ($request->color_id as $color) {
                    if (!empty($color)) {
                        ProductColor::create([
                            'product_id' => $data->id,
                            'color_id' => $color,
                        ]);
                    }
                }
            }

            // Store product sizes
            if ($request->has('size_id')) {
                foreach ($request->size_id as $size) {
                    if (!empty($size)) {
                        ProductSize::create([
                            'product_id' => $data->id,
                            'size_id' => $size,
                        ]);
                    }
                }
            }


            return redirect()->route('products.index')->with('t-success', 'Product created successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', 'Product creation failed.')->withInput();
        }
    }

    /**
     * Show the form for editing the specified dynamic page content.
     *
     * @param int $id
     * @return View
     */
    public function edit(int $id): View {
        $data = Product::with(['productSizes.size', 'productColors.color', 'images'])->findOrFail($id);
        $categories = Category::all();
        $brands = Brand::all();
        $sizes = Size::all();
        $colors = Color::all();

        return view('backend.layouts.product.product.edit', [
            'categories' => $categories,
            'brands' => $brands,
            'sizes' => $sizes,
            'colors' => $colors,
            'data' => $data, // Make sure to include $data here
        ]);
    }

    /**
     * Update the specified dynamic page content in storage.
     *
     * @param Request $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(Request $request, int $id): RedirectResponse {
        try {
            $validator = Validator::make($request->all(), [
                'name'            => 'required|string|max:255',
                'category_id'     => 'required|exists:categories,id',
                'brand_id'        => 'required|exists:brands,id',
                'image.*'         => 'nullable',
                'description'     => 'nullable|string',
                'discount_price' => 'nullable|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'selling_price'  => 'required|numeric|regex:/^\d+(\.\d{1,2})?$/',
                'quantity'        => 'nullable|integer|min:0',
                'size.*'          => 'nullable|exists:sizes,id',
                'color.*'         => 'nullable|exists:colors,id',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            }

            $data = Product::findOrFail($id);
            $data->name = $request->name;
            $data->category_id = $request->category_id;
            $data->brand_id = $request->brand_id;
            $data->description = $request->description;
            $data->discount_price = $request->discount_price;
            $data->selling_price = $request->selling_price;
            $data->quantity = $request->quantity;
//            $data->product_slug = Str::slug($request->name.'-'.rand(100000, 999999), '-');
            $data->save();

            // Handle the file upload for images
            if ($request->hasFile('image')) {
                foreach ($data->images as $image) {
                    $imagePath = public_path($image->image); // Adjust path as needed
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Remove the file
                    }
                    $image->delete(); // Remove from database
                }

                foreach ($request->file('image') as $image) {
                    $imageName = time() . '_' . uniqid();
                    $imagePath = Helper::fileUpload($image, 'product', $imageName);

                    if ($imagePath) {
                        ProductImage::create([
                            'product_id' => $data->id,
                            'image' => $imagePath,
                        ]);
                    }
                }
            }

            // Handle removal of selected images
            if ($request->has('remove_images')) {
                foreach ($request->remove_images as $imageId) {
                    $image = ProductImage::findOrFail($imageId);
                    $imagePath = public_path($image->image); // Adjust path as needed
                    if (file_exists($imagePath)) {
                        unlink($imagePath); // Remove the file
                    }
                    $image->delete(); // Remove from database
                }
            }

            if ($request->has('color_id')) {
                ProductColor::where('product_id', $data->id)->delete();
                foreach ($request->color_id as $color) {
                    if (!empty($color)) {
                        ProductColor::create([
                            'product_id' => $data->id,
                            'color_id' => $color,
                        ]);
                    }
                }
            } else {
                // If no colors are provided, ensure that existing colors are removed
                ProductColor::where('product_id', $data->id)->delete();
            }

            if ($request->has('size_id')) {
                ProductSize::where('product_id', $data->id)->delete();
                foreach ($request->size_id as $size) {
                    if (!empty($size)) {
                        ProductSize::create([
                            'product_id' => $data->id,
                            'size_id' => $size,
                        ]);
                    }
                }
            } else {
                // If no sizes are provided, ensure that existing sizes are removed
                ProductSize::where('product_id', $data->id)->delete();
            }

            return redirect()->route('products.index')->with('t-success', 'Product updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('t-error', 'Product update failed.')->withInput();
        }
    }

    /**
     * Change the status of the specified dynamic page content.
     *
     * @param int $id
     * @return JsonResponse
     */
    public function status(int $id): JsonResponse {
        $data = Product::findOrFail($id);
        if ($data->status == 'active') {
            $data->status = 'inactive';
            $data->save();

            return response()->json([
                'success' => false,
                'message' => 'Unpublished Successfully.',
                'data'    => $data,
            ]);
        } else {
            $data->status = 'active';
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Published Successfully.',
                'data'    => $data,
            ]);
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
            $data = Product::findOrFail($id);
            $data->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.',
            ]);
        } catch (\Exception) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete the Product.',
            ]);
        }
    }
}
