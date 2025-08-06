@extends('frontend.app')

@section('title')
   {{ $brand->name }} - mo&rashids
@endsection

@section('content')

    @include('frontend.partials.cart-sidebar')

    @php
        $brandId = $brand->id;
    @endphp

    <div class="all-product--page---wrapper">
        <!-- side bar -->
        <div class="common-side--bar">
            <div class="close---btn--sidebar">
                X
            </div>
            <!-- for side bar 3d  -->
            <a href="{{route('home')}}" class="threed-logo-container">
                <img src="{{ asset('/frontend/assets/images/transparent-background-gif.gif') }}" alt="" srcset="">
            </a>
            <!-- cart items count container -->
            <div class="cart-time-navigation-container">

                <div class="home-time-and-date text-white">
                    {{ now()->setTimezone('America/New_York')->format('n/j/Y g:i A T') }}
                </div>

                @php
                    $cart_count = 0;
                        if (\Illuminate\Support\Facades\Auth::check()) {
                            $user = \Illuminate\Support\Facades\Auth::user();
                            $cart_count = \App\Models\Cart::where('user_id', $user->id)->count();
                        }
                @endphp

                <div class="total-cart-count">
                    <span class="side-bar-common-text show-cart-item ">Cart</span>
                    <span class="cart-count">{{ $cart_count}}</span>
                </div>

                <div class="sidebar-cart-navigation-btns">
                    <a href="#" data-bs-toggle="modal" data-bs-target="#searchModal"
                       class="side-bar-common-text  sidebar-red-background  red-background--route ">Search</a>
                    <span class="speparator"></span>
                    <a href="{{ route('home') }}" class="side-bar-common-text  sidebar-red-background  red-background--route ">Back
                        Home</a>
                </div>

            </div>
            <div class="side-bar-collections-routes">
                @foreach($brands as $brand)
                    <a href="{{ route('brand-product', $brand->brand_slug) }}"
                       class="sidebar-common-route red-background--route {{ request()->is('collection/brand/' . $brand->brand_slug) ? 'active' : '' }}">
                        {{ $brand->name }}
                    </a>
                @endforeach
            </div>
        </div>
        <!-- main display -->
        <div class="main-display">
            <!-- header -->
            <div class="all-product-page-header">
                <div class="search-field--wrapper" data-bs-toggle="modal" data-bs-target="#searchModal">
                    <img src="{{ asset('/frontend/assets/images/search.svg') }}" alt="" srcset="">
                    <span>Search Product</span>
                </div>
                <div class="filter-btns--wrapper">

                    <!-- profile icon -->
                    <span class="header--common-icon hover--profile--icon ">
                <img src="{{ asset('/frontend/assets/images/profile.svg') }}" alt="" srccset="" />
                <div class="user--info--box">
                    <!-- links -->
                    @if(Auth::check())
                        @if(Auth::user()->role == 'admin')
                            <a href="{{route('dashboard')}}">
                                 <span class="common-route">
                                    Dashboard
                                </span>
                            </a>
                        @endif
                        <span class="common-route">{{ Auth::user()->name }}</span>
                        <span class="common-route">{{ Auth::user()->email }}</span>
                        <span class="common-route" data-bs-toggle="modal" data-bs-target="#location-preference-modal">Location preference</span>
                        <a href="" class="common-route" onclick="event.preventDefault(); document.getElementById('logoutForm').submit()">Sign Out</a>
                        <form action="{{ route('logout') }}" method="post" id="logoutForm" >
                            @csrf
                        </form>
                    @else
                        <span class="common-route" data-bs-toggle="modal" data-bs-target="#create-login-modal">Log In</span>
                        <span class="common-route" data-bs-toggle="modal" data-bs-target="#create-account-modal">Create account</span>
                        <span class="common-route" data-bs-toggle="modal" data-bs-target="#location-preference-modal">Location preference</span>
                    @endif
                </div>
            </span>
                    <!-- love icon -->
                    <span class="header--common-icon  show-cart-item">
              <img src="{{ asset('/frontend/assets/images/heart.svg') }}" alt="" srcset="">
            </span>
                    <!-- filter icon -->
                    <span class="header--common-icon filter--btn">
              <img src="{{ asset('/frontend/assets/images/filter.svg') }}" alt="" srcset="">
            </span>
                    <!-- hamburgur -->
                    <span class="header--common-icon open--sidebar" id="open--sidebar">
                      <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none">
                        <path d="M5 9H27M5 16H27M5 23H27" stroke="black" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                      </svg>
                    </span>

                </div>
            </div>
            <!-- products -->
            <div class="all-products-wrapper">


                <div class="product-details--time-cart-logo ">
                    {{--   logo for pc   --}}
                    <a class="all-product-page-logo for--desktop" href="{{ route('home') }}">
                        <img src="{{ asset('/frontend/assets/images/transparent-background--black-gif.gif') }}" alt="" srcset="">
                    </a>

                    <!-- logo -->
                    <a href="{{ route('home') }}" class="all-product-page-logo for--mobile">
                        <img src="{{ asset('/frontend/assets/images/website-logo.png') }}" alt="" srcset="" />
                    </a>
                    <!-- time -->
                    <div class="home-time-and-date margin-time only-mobile">
                        {{ now()->setTimezone('America/New_York')->format('n/j/Y g:i A T') }}
                    </div>

                    @php
                        $cart_count = 0;
                            if (\Illuminate\Support\Facades\Auth::check()) {
                                $user = \Illuminate\Support\Facades\Auth::user();
                                $cart_count = \App\Models\Cart::where('user_id', $user->id)->count();
                            }
                    @endphp

                        <!-- cart -->
                    <div class="product-details--cart--count only-mobile">
                        <span class="show-cart-item">Cart</span>
                        <span class="cart-count--product-details">{{ $cart_count}}</span>
                    </div>
                </div>

                @if ($products->isEmpty())
                    <div class="no--products--screen" >
                        No items found.
                    </div>
                @else
                    <div class="all-products-container--height">

                        <div class="all-products-container">
                            @foreach ($products as $product)
                                <div class="product-page-product-card">
                                    <!-- product images wrapper -->
                                    <div class="product-images--wrapper">

                                        <a href="{{ route('product.detail', ['brand' => $brand_slug, 'product_slug' => $product->product_slug]) }}"
                                           class="product-details--wrapper">

                                            <!-- image on hover -->
                                            @if($product->images->count() > 1)
                                                @foreach ($product->images->take(2) as $image)
                                                    <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                @endforeach
                                            @else
                                                @foreach ($product->images->take(1) as $image)
                                                    <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                    <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                @endforeach
                                            @endif
                                        </a>

                                        <!-- on sale or sold out -->
                                        @if ($product->quantity <= 0)
                                            <span class="product-status sold-out">Sold Out</span>
                                        @else
                                            <span class="product-status on-sale">On Sale</span>
                                        @endif

                                    </div>
                                    <!-- product details -->
                                    <div class="product-details--wrapper">
                                        <p class="product-name">{{ $product->name }}</p>
                                        <p class="product-price">${{ $product->selling_price }}</p>
                                    </div>

                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif

            </div>
            <!-- footer -->
            <footer>
                <div class="footer-content--wrapper">

                    <div class="footer-content--container">
                        <!-- left -->
                        <div class="footer--left">
                            <a href="{{ route('home') }}" class="footer-route-logo">mo&rashids</a>
                            <a href="#" data-bs-toggle="modal" data-bs-target="#searchModal" class="footer-route red-background--route">Search</a>
                            <a href="{{ route('contact') }}" class="footer-route red-background--route ">Contact
                            </a>
                            <a href="{{ route('faq') }}" class="footer-route red-background--route ">F.A.Q</a>
                            @php
                                $dynamicPages = App\Models\DynamicPage::where('status', 'active')->latest()->get();
                            @endphp
                            @foreach($dynamicPages as $page)
                                <a href="{{ route('dynamic.page',$page->page_slug) }}" class="footer-route red-background--route">{{ $page->page_title }}</a>
                            @endforeach
                        </div>
                        <!-- right -->
                        <div class="footer--right">
                            <div class="footer-logo">
                                <img src="{{ asset('/frontend/assets/images/footer-logo.png') }}" alt="" srcset="">
                            </div>
                            <p class="newsletter-text">Join our newsletter below.</p>
                            <form action="{{ route('newsletter.store') }}" method="POST" class="newsletter-form--footer newsletter-submit">
                                @csrf
                                <input type="email" name="email" id="email" placeholder="Enter Email" />
                                <button type="submit" class="footer-btn">Subscribe</button>
                            </form>
                        </div>
                    </div>
                    @php
                        $systemSetting = App\Models\SystemSetting::first();
                    @endphp
                    <p class="footer-copyright">
                        {{ $systemSetting->copyright_text ?? ''}}
                    </p>
                </div>
            </footer>
        </div>

    </div>

    <!-- filter modal -->
    <div class="backdrop-container--filter">

        <form class="filter--box" id="filter-form">
            <div class="filter--header">
                <span>Sort By</span>
                <span class="filter-close">
                    <img src="{{ asset('/frontend/') }}assets/images/roundxmark.svg" alt="" srcset="">
                </span>
            </div>
            <div class="filter-options">
                <input type="radio" class="filter-radio" name="filter" value="featured" id="featured" hidden />
                <label for="featured" class="common-filter-label">Featured</label>

                <input type="radio" class="filter-radio" name="filter" value="lowest-price" id="lowest-price"
                       hidden />
                <label for="lowest-price" class="common-filter-label">Lowest Price</label>

                <input type="radio" class="filter-radio" name="filter" value="newest-first" id="newest-first"
                       hidden />
                <label for="newest-first" class="common-filter-label">Newest First</label>

                <input type="radio" class="filter-radio" name="filter" value="a-z-order" id="a-z-order" hidden />
                <label for="a-z-order" class="common-filter-label">A - Z Order</label>
            </div>
        </form>

    </div>

@endsection


<!-- Toaster  -->
@push('script')
    <script>
        $(document).ready(function() {
            $(document).on('submit', '.newsletter-submit', function(e) {
                e.preventDefault(); // Prevent default form submission

                const form = $(this);
                const url = form.attr('action');
                const formData = form.serialize();

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        if (response.success) {
                            showSuccessToast(response.message);
                            form[0].reset(); // Reset the form
                        } else {
                            showErrorToast(response.message);
                        }
                    },
                    error: function(xhr) {
                        const errors = xhr.responseJSON.errors;
                        if (errors) {
                            for (let field in errors) {
                                showErrorToast(errors[field][0]); // Show the first error for each field
                            }
                        } else {
                            showErrorToast('This email already subscribe.');
                        }
                    }
                });
            });
        });

        function showSuccessToast(message) {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top", // top or bottom
                position: 'right', // left, center or right
                backgroundColor: "#28232D", // success color
                color: "#FFFFFF",
                stopOnFocus: true // Prevents dismissing of toast on hover
            }).showToast();
        }

        function showErrorToast(message) {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top", // top or bottom
                position: 'right', // left, center or right
                backgroundColor: "#FE0000", // error color
                color: "#FFFFFF",
                stopOnFocus: true // Prevents dismissing of toast on hover
            }).showToast();
        }
    </script>
@endpush

