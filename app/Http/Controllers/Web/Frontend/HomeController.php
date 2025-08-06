<?php

namespace App\Http\Controllers\Web\Frontend;

use App\Models\Faq;
use App\Models\Brand;
use App\Models\Social;
use App\Models\Contact;
use App\Models\Product;
use App\Models\Category;
use App\Models\Vacation;
use Illuminate\View\View;
use App\Models\Newsletter;
use App\Models\DynamicPage;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class HomeController extends Controller {
    /**
     * Display the welcome page.
     *
     * @return View
     */
    public function welcome(): View {
        return view('frontend.welcome');
    }
    public function index(): View {
        $categories = Category::where('status', 'active')->get();
        $socials = Social::where('status', 'active')->get();

        return view('frontend.layouts.home', [
            'categories' => $categories,
            'socials' => $socials,
        ]);

    }

    public function vacation(): View {
        $vacation = Vacation::where('start_date', '<=', date('Y-m-d'))->where('end_date', '>=', date('Y-m-d'))->first();
        return view('frontend.layouts.vacation', compact('vacation'));
    }

    public function faq(): View {
        $faqs = Faq::where('status', 'active')->get();
        return view('frontend.layouts.faq',[
            'faqs' => $faqs,
        ]);
    }

    public function contact(): View {
        return view('frontend.layouts.contact');
    }

    public function contactStore(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'first_name'    => 'required|string|max:100',
                'last_name'     => 'required|string|max:100',
                'email'         => 'required|string|email|max:100',
                'order_number'  => 'required|string|max:100',
                'subject'       => 'required|string|max:255',
                'message'       => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            $data = new Contact();
            $data->first_name = $request->first_name;
            $data->last_name = $request->last_name;
            $data->email = $request->email;
            $data->order_number = $request->order_number;
            $data->subject = $request->subject;
            $data->message = $request->message;
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Message sent successfully.'
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Message not sent: ' . $e->getMessage()
            ], 500);
        }
    }


    public function newsletterStore(Request $request) {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors' => $validator->errors()
                ], 422);
            }

            // Save the email to the newsletter database
            $data = new Newsletter();
            $data->email = $request->email;
            $data->save();

            return response()->json([
                'success' => true,
                'message' => 'Newsletter Subscription successfully.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Message not sent: ' . $e->getMessage()
            ], 500);
        }
    }

    public function categoryProduct($category_slug): View {
        $category = Category::where('status', 'active')->where('category_slug', $category_slug)->first();
        $brands = Brand::where('status', 'active')->get();
        $products = Product::with(['images', 'productColors', 'productSizes'])
            ->where('category_id', $category->id)
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        return view('frontend.layouts.category-product', [
            'category' => $category,
            'brands' => $brands,
            'products' => $products,
            'category_slug' => $category_slug, // Pass the category_slug
        ]);
    }
    public function brandProduct($brand_slug): View {
        $brand = Brand::where('status', 'active')->where('brand_slug', $brand_slug)->first();
        $brands = Brand::where('status', 'active')->get();
        $products = Product::with(['images', 'productColors', 'productSizes'])
            ->where('brand_id', $brand->id)
            ->where('status', 'active')
            ->orderBy('name', 'asc')
            ->get();

        return view('frontend.layouts.brand-product', [
            'brand' => $brand,
            'brands' => $brands,
            'products' => $products,
            'brand_slug' => $brand_slug, // Pass the category_slug
        ]);
    }

    public function catalogCollections(): View {
        $brands = Brand::where('status', 'active')->get();
        $products = Product::with(['images', 'productColors', 'productSizes'])->where('status', 'active')->orderBy('name', 'asc')->get();

        return view('frontend.layouts.catalog',compact('brands','products'));
    }

    public function lookBookCollections(): View {
        $products = Product::with(['images', 'productColors', 'productSizes'])->where('status', 'active')->inRandomOrder()->get();

        return view('frontend.layouts.lookbook',compact('products'));
    }

    public function dynamicPage($page_slug): View {
        $dynamic_page = DynamicPage::where('page_slug', $page_slug)->first();

        // Check if the page exists, otherwise return a 404
        if (!$dynamic_page) {
            abort(404); // Or you can return a custom view for the error
        }

        return view('frontend.layouts.dynamic_page', [
            'dynamic_page' => $dynamic_page,
        ]);
    }

    public function checkout(): View {

        return view('frontend.layouts.checkout');
    }

}
