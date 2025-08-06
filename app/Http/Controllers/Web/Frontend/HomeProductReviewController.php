<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Helpers\Helper;
use App\Http\Controllers\Controller;
use App\Models\Contact;
use App\Models\ProductImage;
use App\Models\ProductReview;
use App\Models\ProductReviewImage;
use App\Models\ProductReviewLike;
use App\Models\ProductReviewReport;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class HomeProductReviewController extends Controller
{
    public function addReview(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'user_id'       => 'nullable',
                'product_id'    => 'required',
                'rating'        => 'required|numeric',
                'title'         => 'required|string|max:100',
                'review'        => 'required|string|max:2000',
                'name_format'   => 'nullable|string|max:100',
                'name'          => 'nullable|string|max:100',
                'email'         => 'nullable|string|max:100',
                'image.*'       => 'nullable|image|mimes:jpeg,png,jpg',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with(['errors' => $validator->errors()], 422);
            }

            $data                   = new ProductReview();
            $data->user_id          = $request->user_id;
            $data->product_id       = $request->product_id;
            $data->rating           = $request->rating;
            $data->title            = $request->title;
            $data->review           = $request->review;
            $data->name_format      = $request->name_format;
            $data->name             = $request->name;
            $data->email            = $request->email;
            $data->save();

            // Handle the file upload for images
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $imageName = time() . '_' . uniqid(); // Generate a unique name for the image
                    $imagePath = Helper::fileUpload($image, 'product_review', $imageName); // Use the helper method

                    if ($imagePath) {
                        // Store the image in the product_images table
                        ProductReviewImage::create([
                            'product_review_id' => $data->id,
                            'product_id' => $data->product_id,
                            'image' => $imagePath,
                        ]);
                    }
                }
            }

            // Corrected flash data assignment
            return redirect()->back()->with([
                'success' => 'Review added successfully.',
                'review' => $data,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Add Review failed.');
        }
    }
    public function addReviewUser(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'user_id'       => 'required',
                'product_id'    => 'required',
                'rating'        => 'required|numeric',
                'title'         => 'required|string|max:100',
                'review'        => 'required|string|max:2000',
                'name_format'   => 'nullable|string|max:100',
                'name'          => 'nullable|string|max:100',
                'email'         => 'nullable|string|max:100',
                'image.*'       => 'nullable|image|mimes:jpeg,png,jpg',
            ]);

            if ($validator->fails()) {
                return redirect()->back()->with(['errors' => $validator->errors()], 422);
            }

            $data                   = new ProductReview();
            $data->user_id          = $request->user_id;
            $data->product_id       = $request->product_id;
            $data->rating           = $request->rating;
            $data->title            = $request->title;
            $data->review           = $request->review;
            $data->name_format      = $request->name_format;
            $data->name             = $request->name;
            $data->email            = $request->email;
            $data->save();

            // Handle the file upload for images
            if ($request->hasFile('image')) {
                foreach ($request->file('image') as $image) {
                    $imageName = time() . '_' . uniqid(); // Generate a unique name for the image
                    $imagePath = Helper::fileUpload($image, 'product_review', $imageName); // Use the helper method

                    if ($imagePath) {
                        // Store the image in the product_images table
                        ProductReviewImage::create([
                            'product_review_id' => $data->id,
                            'product_id' => $data->product_id,
                            'image' => $imagePath,
                        ]);
                    }
                }
            }

            // Corrected flash data assignment
            return redirect()->back()->with([
                'success' => 'Review added successfully.',
                'review' => $data,
            ]);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Add Review failed.');
        }
    }

    public function addReviewReportUser(Request $request, $reviewID) {
        try {
            $validator = Validator::make($request->all(), [
                'user_id'       => 'required',
                'product_id'    => 'required',
                'review_id'     => 'required',
                'report'        => 'required',
            ]);

            if ($validator->fails()) {
                return  response()->json([
                    'errors' => $validator->errors(),
                    'success' => false,
                    'message' => 'Review report not send.',
                ], 422);
            }

            $data                   = new ProductReviewReport();
            $data->user_id          = $request->user_id;
            $data->product_id       = $request->product_id;
            $data->review_id        = $request->review_id;
            $data->report           = $request->report;
            $data->save();

            // Corrected flash data assignment
            return response()->json([
                'success' => true,
                'message' => 'Review report successfully.',
                'review-report' => $data,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                    'success' => false,
                    'message' => 'Review report not send.',
                ]);
        }
    }

    public function saveLike(Request $request, $reviewID) {
        // Validate the incoming request
        $validator = Validator::make($request->all(), [
            'user_id' => 'required',
            'product_id' => 'required',
            'product_review_id' => 'required',
            'likes' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
                'success' => false,
                'message' => 'Validation failed. Please check your input.',
            ], 422);
        }

        // Check if the user already liked the review
        $existingLike = ProductReviewLike::where('user_id', $request->user_id)
            ->where('product_review_id', $request->product_review_id)
            ->first();

        if ($existingLike) {
            return response()->json(['success' => false, 'message' => 'You have already liked this review.'], 409);
        } else {
            // Create a new like entry
            $like = ProductReviewLike::create([
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'product_review_id' => $request->product_review_id,
                'likes' => 1,
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Review liked successfully.',
                'new_like_count' => 1 // You might want to return the new like count
            ]);
        }
    }

}





















