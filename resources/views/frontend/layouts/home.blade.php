@extends('frontend.app')

@section('title', 'mo&rashids')

@section('content')

    <div class="email---page--wrapper" id="newsletter" style="display: none;">
        <div class="email--page--content">
            <div class="email--page--logo">
                <img src="{{ asset('/frontend/assets/images/email-page-logo.png') }}" alt="" srcset="">
            </div>
            <form class="email--page--form newsletter-submit" action="{{ route('newsletter.store') }}" method="POST">
                @csrf
                <div class="email-modal-close-btn" onclick="closePopup()">✖</div>
                <div class="email--page--title">Sign Up for exclusive drops</div>
                <div class="email--page--subtitle">
                    By signing up for our
                    ex lusive email list,
                    customers gain early access
                    to new clothing brand drops,
                    ensuring they can secure
                    their favorite pieces before
                    they sell out.
                </div>
                <input placeholder="Enter Email" type="email" name="email" id="email" class="email--page--input">
                <button class="email---page--submit--btn" type="submit">JOIN</button>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Check if the user has visited before
            if (!localStorage.getItem('newsletterPopupShown')) {
                // Hide other elements
                document.querySelector('.home--header').style.display = 'none';
                document.querySelector('.backdrop-container--home').style.display = 'none';
                document.querySelector('.home-page-container').style.display = 'none'; // Corrected selector

                document.getElementById('newsletter').style.display = '';

                // Change body class
                document.getElementById('body').classList.remove('body--gray--white');
                document.getElementById('body').classList.add('body--black');

                localStorage.setItem('newsletterPopupShown', 'true');
            }
        });

        function closePopup() {
            document.getElementById('newsletter').style.display = 'none';
            // Hide other elements
            document.querySelector('.home--header').style.display = '';
            document.querySelector('.backdrop-container--home').style.display = '';
            document.querySelector('.home-page-container').style.display = ''; // Corrected selector

            // Reset body class
            document.getElementById('body').classList.remove('body--black');
            document.getElementById('body').classList.add('body--gray--white');
        }
    </script>


    @if(session('t-success'))
        @if(Auth::check())
            @if(session('order'))
                @php
                    $order = session('order');
                @endphp
                <!-- review submit success modal starts -->
                <div class="modal fade" id="success-modal" tabindex="-1" aria-labelledby="write-review-modal" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-body">
                                <h3 class="success-modal--title">Order purchased successfully!</h3>
                                <p class="success-modal--subtitle">Thank you for purchase our product. Save this order id: "<span
                                        style="font-weight: 700;">{{ $order->tracking_id }}</span>" for further information.</p>
                                <div class="success--icon">
                                    <img src="{{ asset('/frontend/assets/images/success-icon.svg') }}" alt="" srcset="">
                                </div>

                                <button class="review-submit--btn ok--success" data-bs-dismiss="modal" id="paymentSuccessBtn" onclick="window.close()">Ok</button>

                            </div>
                        </div>
                    </div>
                </div>
                <!-- review submit success modal ends -->
                <script>
                    $(document).ready(function() {
                        $('#success-modal').modal('show');
                    });
                </script>
           @endif
        @endif
    @endif

    <!-- Canvas for confetti -->
    <canvas id="confetti-canvas"></canvas>

    <div class="home-page-container">

        <div class="home-logo--and--time--date">
            <div class="header-logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('/frontend/assets/images/website-logo.png') }}" alt="Logo"/>
                </a>
            </div>

            <div class="home-time-and-date">
                {{ now()->setTimezone('America/New_York')->format('n/j/Y g:i A T') }}
            </div>

        </div>


        <div class="home-product-img position-relative">
            <!-- product image -->
            <img src="{{ asset('/frontend/assets/images/home-product.png') }}" alt="" srcset=""/>
            <!-- dots -->
            <!-- tooltip for shirt -->

            @php
                $categories = \App\Models\Category::where('status', 'active')->get();
                $socials = \App\Models\Social::where('status', 'active')->get();
            @endphp

            @foreach($categories as $category)
                <a href="{{ route('category-product', $category->category_slug) }}">
                    <div class="tooltip-dot category{{ $category->id }}">
                        <span></span>
                        <div class="tooltip-text">{{ $category->name }}</div>
                    </div>
                </a>
            @endforeach

            <!-- shop all arrow -->
            <a href="{{ route('collections.catalog.all') }}" class="shop-all-arrow desktop">
                <span class="shop-all-text">SHOP ALL</span>
                <!-- arrow -->
                <div class="arrow-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M13.5 4.5L21 12M21 12L13.5 19.5M21 12H3" stroke="white" stroke-width="1.5"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>

            </a>
            <!-- shop all arrow -->


            <div  class="shop-all-arrow mobile">
                <a style="color: white" href="{{ route('collections.catalog.all') }}" class="shop-all-text">SHOP ALL</a>
                <!-- arrow -->
                <div class="arrow-icon">
                    <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
                        <path d="M13.5 4.5L21 12M21 12L13.5 19.5M21 12H3" stroke="white" stroke-width="1.5"
                              stroke-linecap="round"
                              stroke-linejoin="round"/>
                    </svg>
                </div>

            </div>



        </div>
    </div>
    <!-- backdrop -->
    <div class="backdrop-container--home">
        <div class="backdrop-container--inner---container" data-inner-content>

            <div class="close--navigation">
                <img src="{{ asset('/frontend/assets/images/xmark.svg') }}" alt="" srcset="">
            </div>

            <div class="home-menu--container">
                <div class="home-menu--pages---container">
                    {{--                <button type="button" class="review-submit--btn" data-bs-target="#success-modal" data-bs-toggle="modal">Submit Review</button>--}}
                    <a href="{{ route('home') }}" class="home-common-route red-background--route">Home</a>
                    <a href="{{ route('collections.catalog.all') }}" class="home-common-route red-background--route">Catalog</a>
                    <a href="{{ route('collections.lookbook.all') }}" class="home-common-route red-background--route">Lookbook</a>
                    <a href="{{ route('contact') }}" class="home-common-route red-background--route">Contact</a>
                    <a href="{{ route('faq') }}" class="home-common-route red-background--route">F.A.Q</a>
                    @php
                        $dynamicPages = App\Models\DynamicPage::where('status', 'active')->latest()->get();
                    @endphp
                    @foreach($dynamicPages as $page)
                        <a href="{{ route('dynamic.page',$page->page_slug) }}"
                           class="home-common-route red-background--route">{{ $page->page_title }}</a>
                    @endforeach
                </div>
                <div class="home-accessories--container">
                    @foreach($categories as $category)
                        <a href="{{ route('category-product', $category->category_slug) }}"
                           class="home-common-route red-background--route">{{ $category->name }}</a>
                    @endforeach
                </div>
                <div class="social--links---container">
                    <!-- instagram -->
                    @foreach($socials->take(1) as $social)
                        <a href="{{ $social->instagram }}" target="_black" >
                            <img src="{{ asset('/frontend/assets/images/instagram.svg') }}" alt="" srcset="">
                        </a>
                        <!-- whatsapp -->
                        <a href="{{ $social->whatsapp }}" target="_black" >
                            <img src="{{ asset('/frontend/assets/images/whatsapp.svg') }}" alt="" srcset="">
                        </a>
                        <!-- X -->
                        <a href="{{ $social->twitter }}" target="_black">
                            <img src="{{ asset('/frontend/assets/images/xcom.svg') }}" alt="" srcset="">
                        </a>

                        <!-- tiktok -->
                        <a href="{{ $social->tiktok }}" target="_black">
                            <img src="{{ asset('/frontend/assets/images/tiktok.svg') }}" alt="" srcset="">
                        </a>
                    @endforeach
                </div>
            </div>

        </div>
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

