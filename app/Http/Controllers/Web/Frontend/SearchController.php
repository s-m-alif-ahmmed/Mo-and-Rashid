<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search(Request $request)
    {
        if ($request->ajax()) {
            $searchTerm = $request->get('search', '');

            $products = Product::where(function ($query) use ($searchTerm) {
                $query->where('name', 'LIKE', '%' . $searchTerm . '%')
                    ->orWhere('description', 'LIKE', '%' . $searchTerm . '%');
            })
                ->where('status', 'active')
                ->with('images') // Eager load images to prevent N+1 problem
                ->get();


            $output = '';
            if ($products->count() > 0) {
                foreach ($products as $product) {
                    // Generate the URL directly
                    $url = route('product.detail', $product->product_slug);
                    $output .= '<div class="search-item">';
                    $output .= '<div class="searched-img">';
                    $output .= '<a class="text-black" href="' . $url . '">';

                    // Check if the product has images and loop through them
                    if ($product->images->isNotEmpty()) {
                        foreach ($product->images->take(1) as $image) {
                            $output .= '<img src="' . asset($image->image) . '" alt="Product Image">';
                        }
                    } else {
                        // If no images, show a default image
                        $output .= '<img src="' . asset('default-image-url.jpg') . '" alt="Default Image">';
                    }

                    $output .= '</a>'; // Close search-item
                    $output .= '</div>'; // Close searched-img
                    $output .= '<a class="text-black" href="' . $url . '">';
                    $output .= '<span class="searched-product-title">' . htmlspecialchars($product->name) . '</span>';
                    $output .= '</a>'; // Close search-item
                    $output .= '</div>'; // Close search-item
                }
            } else {
                $output .= '<div class="no-results">No results found.</div>';
            }

            return response()->json(['html' => $output]);
        }

        return response()->json(['html' => '<div class="no-results">Invalid request.</div>'], 400);
    }
}
