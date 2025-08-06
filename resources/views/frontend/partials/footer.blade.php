@if (request()->routeIs('collections.lookbook.all') || request()->routeIs('collections.lookbook.all.*'))
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
@endif

@if (request()->routeIs('contact') || request()->routeIs('contact.*'))
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
                        <img src="{{asset('/frontend/assets/images/footer-logo.png')}}" alt="" srcset="">
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
@endif

@if (request()->routeIs('product.detail') || request()->routeIs('product.detail.*'))
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
                        <img src="{{asset('/frontend/assets/images/footer-logo.png')}}" alt="" srcset="">
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
@endif

@if (request()->routeIs('dynamic.page') || request()->routeIs('dynamic.page.*'))
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
                        <img src="{{asset('/frontend/assets/images/footer-logo.png')}}" alt="" srcset="">
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
@endif

{{--@if (request()->routeIs('checkout') || request()->routeIs('checkout.*'))--}}
{{--    <footer>--}}
{{--        <div class="footer-content--wrapper">--}}

{{--            <div class="footer-content--container">--}}
{{--                <!-- left -->--}}
{{--                <div class="footer--left">--}}
{{--                    <a href="{{ route('home') }}" class="footer-route-logo">mo&rashids</a>--}}
{{--                    <a href="#" data-bs-toggle="modal" data-bs-target="#searchModal" class="footer-route red-background--route">Search</a>--}}
{{--                    <a href="{{ route('contact') }}" class="footer-route red-background--route ">Contact--}}
{{--                    </a>--}}
{{--                    <a href="{{ route('faq') }}" class="footer-route red-background--route ">F.A.Q</a>--}}
{{--                    @php--}}
{{--                        $dynamicPages = App\Models\DynamicPage::where('status', 'active')->latest()->get();--}}
{{--                    @endphp--}}
{{--                    @foreach($dynamicPages as $page)--}}
{{--                        <a href="{{ route('dynamic.page',$page->page_slug) }}" class="footer-route red-background--route">{{ $page->page_title }}</a>--}}
{{--                    @endforeach--}}
{{--                </div>--}}
{{--                <!-- right -->--}}
{{--                <div class="footer--right">--}}
{{--                    <div class="footer-logo">--}}
{{--                        <img src="{{asset('/frontend/assets/images/footer-logo.png')}}" alt="" srcset="">--}}
{{--                    </div>--}}
{{--                    <p class="newsletter-text">Join our newsletter below.</p>--}}
{{--                    <form action="{{ route('newsletter.store') }}" method="POST" class="newsletter-form--footer newsletter-submit">--}}
{{--                        @csrf--}}
{{--                        <input type="email" name="email" id="email" placeholder="Enter Email" />--}}
{{--                        <button type="submit" class="footer-btn">Subscribe</button>--}}
{{--                    </form>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--            @php--}}
{{--                $systemSetting = App\Models\SystemSetting::first();--}}
{{--            @endphp--}}
{{--            <p class="footer-copyright">--}}
{{--                {{ $systemSetting->copyright_text ?? ''}}--}}
{{--            </p>--}}
{{--        </div>--}}
{{--    </footer>--}}
{{--@endif--}}

@if (request()->routeIs('faq') || request()->routeIs('faq.*'))
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
                        <img src="{{asset('/frontend/assets/images/footer-logo.png')}}" alt="" srcset="">
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
@endif

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



