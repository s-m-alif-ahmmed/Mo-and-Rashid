<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\ProductReviewLike;
use Illuminate\View\View;

class HomeProductController extends Controller
{
    public function brandProductDetail($product_slug): View {
        $brands = Brand::all();
        $product = Product::where('status', 'active')
            ->where('product_slug', $product_slug)
            ->first();

        if (!$product) {
            abort(404); // Product not found
        }

//        Product Reviews
        $reviews = ProductReview::with('likes')->where('status', 'active')->where('product_id', $product->id)->latest()->get();

        $count_reviews = ProductReview::where('product_id', $product->id)->count();

        // Calculate the average rating
        $sumRating = $reviews->count() > 0 ? $reviews->sum('rating') / $reviews->count() : 0;

        // Optionally, round the average rating to one decimal place
        $averageRatings = round($sumRating, 1);

        // For display, you might want to format it or ensure it’s between 1 and 5 stars
        $averageRating = min(max($averageRatings, 1), 5); // Clamp between 1 and 5

        //  Product Review Filters
        $highest_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->whereBetween('rating', [4, 5]) //
            ->with('images')
            ->latest()
            ->get();

        $lowest_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->whereBetween('rating', [1, 3]) // Filter for ratings between 1 and 3
            ->orderBy('rating', 'desc') // Optional: Order by rating in ascending order
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $oldest_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->orderBy('created_at', 'asc') // Corrected line
            ->with('images')
            ->get();

        $latest_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->with('images')
            ->latest()
            ->get();

        $reviewsWithImages = ProductReview::has('images')
            ->where('status', 'active')
            ->where('product_id', $product->id)
            ->with('images')
            ->get();

        $five_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [5])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $four_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [4])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $three_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [3])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $two_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [2])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $one_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [1])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        // Review Star Percentage
        $percentages = $this->getRatingPercentages($product->id);
        // Review Star Percentage End

        // Fetch related products after confirming the product exists
        $relatedProducts = Product::with(['images', 'productColors', 'productSizes'])
            ->where('category_id', $product->category_id)
            ->where('status', 'active')
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(12)
            ->get();

        // Fetch all products in the same category
        $productsInBrand = Product::where('brand_id', $product->brand_id)
            ->where('status', 'active')
            ->orderBy('id') // Adjust this order as needed
            ->get();

        // Find the current product index
        $currentIndex = $productsInBrand->search($product);

        // Determine the next product
        $nextProduct = null;
        if ($currentIndex !== false && $currentIndex + 1 < $productsInBrand->count()) {
            $nextProduct = $productsInBrand[$currentIndex + 1];
        }


        return view('frontend.layouts.product-detail', [
            'brands' => $brands,
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews,
            'highest_star_reviews' => $highest_star_reviews,
            'lowest_star_reviews' => $lowest_star_reviews,
            'oldest_reviews' => $oldest_reviews,
            'latest_reviews' => $latest_reviews,
            'reviewsWithImages' => $reviewsWithImages,
            'five_star_reviews' => $five_star_reviews,
            'four_star_reviews' => $four_star_reviews,
            'three_star_reviews' => $three_star_reviews,
            'two_star_reviews' => $two_star_reviews,
            'one_star_reviews' => $one_star_reviews,
            'percentages' => $percentages,
            'count_reviews' => $count_reviews,
            'averageRating' => $averageRating,
            'nextProduct' => $nextProduct,
        ]);
    }

    public function categoryProductDetail($product_slug): View {
        $brands = Brand::all();

        // Fetch the current product
        $product = Product::where('status', 'active')
            ->where('product_slug', $product_slug)
            ->first();

        if (!$product) {
            abort(404); // Product not found
        }

//        Product Reviews
        $reviews = ProductReview::with('likes')->where('status', 'active')->where('product_id', $product->id)->latest()->get();

        $count_reviews = ProductReview::where('product_id', $product->id)->count();

        // Calculate the average rating
        $sumRating = $reviews->count() > 0 ? $reviews->sum('rating') / $reviews->count() : 0;

        // Optionally, round the average rating to one decimal place
        $averageRatings = round($sumRating, 1);

        // For display, you might want to format it or ensure it’s between 1 and 5 stars
        $averageRating = min(max($averageRatings, 1), 5); // Clamp between 1 and 5

        $highest_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->whereBetween('rating', [4, 5]) // or 'stars' if that's the field name
            ->with('images')
            ->latest()
            ->get();

        $lowest_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->whereBetween('rating', [1, 3]) // Filter for ratings between 1 and 3
            ->orderBy('rating', 'desc') // Optional: Order by rating in ascending order
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $oldest_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->orderBy('created_at', 'asc') // Corrected line
            ->with('images')
            ->get();

        $latest_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->with('images')
            ->latest()
            ->get();

        $reviewsWithImages = ProductReview::has('images')
            ->where('status', 'active')
            ->where('product_id', $product->id)
            ->with('images')
            ->get();

        $five_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [5])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $four_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [4])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $three_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [3])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $two_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [2])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $one_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [1])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        // Review Star Percentage
        $percentages = $this->getRatingPercentages($product->id);
        // Review Star Percentage End


        // Fetch related products after confirming the product exists
        $relatedProducts = Product::with(['images', 'productColors', 'productSizes'])
            ->where('category_id', $product->category_id)
            ->where('status', 'active')
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(12)
            ->get();

        // Fetch all products in the same category
        $productsInCategory = Product::where('category_id', $product->category_id)
            ->where('status', 'active')
            ->orderBy('id') // Adjust this order as needed
            ->get();

        // Find the current product index
        $currentIndex = $productsInCategory->search($product);

        // Determine the next product
        $nextProduct = null;
        if ($currentIndex !== false && $currentIndex + 1 < $productsInCategory->count()) {
            $nextProduct = $productsInCategory[$currentIndex + 1];
        }

        // Pass all necessary variables to the view
        return view('frontend.layouts.product-detail', [
            'brands' => $brands,
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews,
            'highest_star_reviews' => $highest_star_reviews,
            'lowest_star_reviews' => $lowest_star_reviews,
            'oldest_reviews' => $oldest_reviews,
            'latest_reviews' => $latest_reviews,
            'reviewsWithImages' => $reviewsWithImages,
            'five_star_reviews' => $five_star_reviews,
            'four_star_reviews' => $four_star_reviews,
            'three_star_reviews' => $three_star_reviews,
            'two_star_reviews' => $two_star_reviews,
            'one_star_reviews' => $one_star_reviews,
            'percentages' => $percentages,
            'count_reviews' => $count_reviews,
            'averageRating' => $averageRating,
            'nextProduct' => $nextProduct,
        ]);
    }

    public function productDetail($product_slug): View {
        $brands = Brand::all();
        $product = Product::where('status', 'active')
            ->where('product_slug', $product_slug)
            ->first();

//        Product Reviews
        $reviews = ProductReview::with('likes')->where('status', 'active')->where('product_id', $product->id)->latest()->get();

        $count_reviews = ProductReview::where('product_id', $product->id)->count();

        // Calculate the average rating
        $sumRating = $reviews->count() > 0 ? $reviews->sum('rating') / $reviews->count() : 0;

        // Optionally, round the average rating to one decimal place
        $averageRatings = round($sumRating, 1);

        // For display, you might want to format it or ensure it’s between 1 and 5 stars
        $averageRating = min(max($averageRatings, 1), 5); // Clamp between 1 and 5

        if (!$product) {
            abort(404); // Product not found
        }

        $highest_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->whereBetween('rating', [4, 5]) // or 'stars' if that's the field name
            ->with('images')
            ->latest()
            ->get();

        $lowest_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->whereBetween('rating', [1, 3]) // Filter for ratings between 1 and 3
            ->orderBy('rating', 'desc') // Optional: Order by rating in ascending order
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $oldest_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->orderBy('created_at', 'asc') // Corrected line
            ->with('images')
            ->get();

        $latest_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->with('images')
            ->latest()
            ->get();

        $reviewsWithImages = ProductReview::has('images')
            ->where('status', 'active')
            ->where('product_id', $product->id)
            ->with('images')
            ->get();

        $five_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [5])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $four_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [4])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $three_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [3])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $two_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [2])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        $one_star_reviews = ProductReview::where('status', 'active')
            ->where('product_id', $product->id)
            ->where('rating', [1])
            ->with('images')
            ->latest() // Optionally, order by latest
            ->get();

        // Review Star Percentage
        $percentages = $this->getRatingPercentages($product->id);
        // Review Star Percentage End

        // Fetch related products after confirming the product exists
        $relatedProducts = Product::with(['images', 'productColors', 'productSizes'])
            ->where('category_id', $product->category_id)
            ->where('status', 'active')
            ->where('id', '!=', $product->id)
            ->latest()
            ->take(12)
            ->get();

        // Fetch all products in the same category
        $products = Product::where('status', 'active')
            ->orderBy('id') // Adjust this order as needed
            ->get();

        // Find the current product index
        $currentIndex = $products->search($product);

        // Determine the next product
        $nextProduct = null;
        if ($currentIndex !== false && $currentIndex + 1 < $products->count()) {
            $nextProduct = $products[$currentIndex + 1];
        }

        return view('frontend.layouts.product-detail', [
            'brands' => $brands,
            'product' => $product,
            'relatedProducts' => $relatedProducts,
            'reviews' => $reviews,
            'highest_star_reviews' => $highest_star_reviews,
            'lowest_star_reviews' => $lowest_star_reviews,
            'oldest_reviews' => $oldest_reviews,
            'latest_reviews' => $latest_reviews,
            'reviewsWithImages' => $reviewsWithImages,
            'five_star_reviews' => $five_star_reviews,
            'four_star_reviews' => $four_star_reviews,
            'three_star_reviews' => $three_star_reviews,
            'two_star_reviews' => $two_star_reviews,
            'one_star_reviews' => $one_star_reviews,
            'percentages' => $percentages,
            'count_reviews' => $count_reviews,
            'averageRating' => $averageRating,
            'nextProduct' => $nextProduct,
        ]);
    }

//get Review Star Percentage
    public function getRatingPercentages($productId)
    {
        // Get total reviews for the product
        $totalReviews = ProductReview::where('product_id', $productId)->count();

        // Initialize an array to hold the rating counts
        $ratingCounts = [];

        // Loop through each rating from 1 to 5
        for ($i = 1; $i <= 5; $i++) {
            $count = ProductReview::where('product_id', $productId)->where('rating', $i)->count();
            $ratingCounts[$i] = $count;
        }

        // Calculate percentages
        $percentages = [];
        foreach ($ratingCounts as $rating => $count) {
            $percentages[$rating] = $totalReviews > 0 ? ($count / $totalReviews) * 100 : 0;
        }

        return $percentages;
    }


}



