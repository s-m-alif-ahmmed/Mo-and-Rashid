<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;

class FilteringController extends Controller
{
    /**
     * Filter Products
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function filterProducts(Request $request){
        $filter = $request->input('filter');
        $products = Product::query();
        $selectedBrand = Brand::find($request->input('brand'));
        $selectedCategory = Category::find($request->input('category'));

        if($selectedCategory != null){
            $products->where('category_id', $selectedCategory->id);
        }

        if($selectedBrand != null){
            $products->where('brand_id', $request->input('brand'));
        }

        // Apply sorting based on filter type
        switch ($filter) {
            case 'featured':
                $products->where('is_featured', true)->orderBy('created_at', 'desc');
                break;
            case 'lowest-price':
                $products->orderBy('selling_price', 'asc');
                break;
            case 'newest-first':
                $products->orderBy('created_at', 'desc');
                break;
            case 'a-z-order':
                $products->orderBy('name', 'asc');
                break;
            default:
                $products->orderBy('created_at', 'desc'); // Default sort
        }

        $products = $products->get();

        // Render a partial view with the filtered products
        $brand_slug = $selectedBrand?->brand_slug;
        $category_slug = $selectedCategory?->category_slug;
        $html = view('frontend.partials.product-list', compact('products','brand_slug','category_slug'))->render();

        return response()->json(['html' => $html]);
    }
}
