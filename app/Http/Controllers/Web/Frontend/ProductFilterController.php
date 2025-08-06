<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductFilterController extends Controller
{
    public function filterProducts(Request $request) {
        // Validate the request
        $request->validate([
            'featured' => 'sometimes|boolean',
            'lowest-price' => 'sometimes|boolean',
            'newest-first' => 'sometimes|boolean',
            'a-z-order' => 'sometimes|boolean',
            'category_slug' => 'required|string'
        ]);

        $category = Category::where('status', 'active')->where('category_slug', $request->category_slug)->first();

        // Build the query
        $query = Product::with(['images', 'productColors', 'productSizes'])
            ->where('category_id', $category->id)
            ->where('status', 'active');

        if ($request->filled('lowest-price')) {
            $query->orderBy('selling_price', 'asc');
        } elseif ($request->filled('newest-first')) {
            $query->orderBy('created_at', 'desc');
        } elseif ($request->filled('a-z-order')) {
            $query->orderBy('name', 'asc');
        }

        $products = $query->latest()->get();

        return response()->json($products);
    }

}
