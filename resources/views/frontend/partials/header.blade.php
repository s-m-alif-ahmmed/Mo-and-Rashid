@if (request()->routeIs('home') || request()->routeIs('home.*'))

    <!-- header area starts -->
    <header class="home--header">
        <div class="home-page-header-container">
            <div class="hamburger">
                <img src="{{ asset('/frontend/assets/images/hamburgur.svg') }}" alt="" srcset="">
            </div>

            <!-- for mini menu content -->
            <div class="cart-icon ">
                <img src="{{ asset('/frontend/assets/images/profile.svg') }}" alt="" srcset="">
                <!-- menu items -->
                <div class="common-header-menu-container">
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


            </div>

        </div>
    </header>
    <!-- header area starts -->

@endif

@if (request()->routeIs('collections.lookbook.all') || request()->routeIs('collections.lookbook.all.*'))
    <header class="marquee-header">
        <div data-speed="180" data-direction="left" class='marquee-text'>Free Shipping Worldwide!</div>
    </header>

@endif

@if (request()->routeIs('collections.catalog.all') || request()->routeIs('collections.catalog.all.*'))
    <header class="marquee-header">
        <div data-speed="180" data-direction="left" class='marquee-text'>Free Shipping Worldwide!</div>
    </header>

@endif

@if (request()->routeIs('contact') || request()->routeIs('contact.*'))
    <!-- header area starts -->
    <header class="marquee-header">
        <div data-speed="180" data-direction="left" class='marquee-text'>Free Shipping Worldwide!</div>
    </header>
    <!-- header area starts -->

@endif

@if (request()->routeIs('category-product') || request()->routeIs('category-product.*'))
    <!-- header area starts -->
    <header class="marquee-header">
        <div data-speed="180" data-direction="left" class='marquee-text'>Free Shipping Worldwide!</div>
    </header>
    <!-- header area starts -->

@endif

@if (request()->routeIs('brand-product') || request()->routeIs('brand-product.*'))
    <!-- header area starts -->
    <header class="marquee-header">
        <div data-speed="180" data-direction="left" class='marquee-text'>Free Shipping Worldwide!</div>
    </header>
    <!-- header area starts -->

@endif

@if (request()->routeIs('faq') || request()->routeIs('faq.*'))
    <!-- header area starts -->
    <header class="marquee-header">
        <div data-speed="180" data-direction="left" class='marquee-text'>Free Shipping Worldwide!</div>
    </header>
    <!-- header area starts -->

@endif

@if (request()->routeIs('checkout') || request()->routeIs('checkout.*'))

    <header class="checkout-page--header">
        <div class="content--header--checkout">
            <div class="checkout--header--logo">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('/frontend/assets/images/checkout--header--log.png') }}" alt="" srcset="">
                </a>
            </div>
            <span style="display: none">
        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 14 14" fill="none">
          <path
              d="M3.17431 10.071L3.17431 10.0709L3.53961 4.70001H10.4613L10.8266 10.0709L10.8266 10.071C10.8443 10.3307 10.8084 10.5912 10.7212 10.8364C10.6341 11.0817 10.4974 11.3064 10.3198 11.4967C10.1421 11.6869 9.92732 11.8386 9.68862 11.9424C9.44992 12.0462 9.19244 12.0999 8.93216 12.1H5.06956C5.06953 12.1 5.0695 12.1 5.06946 12.1C4.80915 12.1 4.55162 12.0464 4.31285 11.9427C4.07406 11.8389 3.85914 11.6872 3.68142 11.497C3.5037 11.3067 3.36699 11.0819 3.27975 10.8366C3.19252 10.5913 3.15663 10.3307 3.17431 10.071ZM2.67548 10.037L2.6755 10.037L2.67548 10.037Z"
              stroke="white" />
          <path
              d="M5.40039 3.50002C5.40039 3.07568 5.56896 2.66871 5.86902 2.36865C6.16908 2.0686 6.57604 1.90002 7.00039 1.90002C7.42474 1.90002 7.8317 2.0686 8.13176 2.36865C8.43182 2.66871 8.60039 3.07568 8.60039 3.50002V4.90002C8.60039 5.32437 8.43182 5.73134 8.13176 6.0314C7.8317 6.33145 7.42474 6.50002 7.00039 6.50002C6.57604 6.50002 6.16908 6.33145 5.86902 6.0314C5.56896 5.73134 5.40039 5.32437 5.40039 4.90002V3.50002Z"
              stroke="white" />
        </svg>
      </span>
        </div>
    </header>

@endif

<script>
    $.ajax({
        url: '/submit-form',
        type: 'POST',
        data: {
            // Your form data here
        },
        success: function(response) {
            // Handle success
        },
        error: function(xhr) {
            if (xhr.status === 403) {
                // User is not authenticated, show the login modal
                $('#create-login-modal').modal('show');
            } else {
                // Handle other errors
            }
        }
    });

</script>


<!-- login modal -->
<div class="modal fade" id="create-login-modal" tabindex="-1" aria-labelledby="create-login-modal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('/frontend/assets/images/modal-header-image.png') }}" alt="" srcset="">
            </div>
            <div class="modal-body">
                <form autocomplete="off" action="{{ route('login') }}" method="POST" class="common--auth--form">
                    @csrf
                    <!-- auth form title -->
                    <div class="common--auth--form-title">
                        <span>Log In</span>
                        <span class="common--auth--close--btn" data-bs-dismiss="modal">Close</span>
                    </div>
                    <!-- common float input wrapper -->
                    <div class="form-floating">
                        <input type="email" name="email" id="Email or Username" placeholder=" " value="{{ old('email') }}" required>
                        <label for="Email"><span>Email</span></label>
                        @error('email')
                        <p class="error--msg--auth">*{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="password" name="password" id="password" placeholder=" " required>
                        <label for="password">
                            <span>Password</span>
                            <span class="show--password--btn">Show</span>
                        </label>
                        @error('password')
                        <p class="error--msg--auth">*{{ $message }}</p>
                        @enderror
                    </div>

                    <button type="submit" class="common-auth-btn">LOG IN</button>

                    <!-- or -->
                    <div class="or-section--auth">
                        <hr>
                        <span>or</span>
                    </div>

                    <a href="{{ route('auth.google') }}" class="common-auth-btn">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                            <g clip-path="url(#clip0_197_151)">
                                <path
                                    d="M0 8C0 3.5888 3.5888 0 8 0C9.78156 0 11.4678 0.573181 12.8765 1.6576L11.0174 4.07253C10.1464 3.40206 9.10301 3.04762 8 3.04762C5.26926 3.04762 3.04762 5.26926 3.04762 8C3.04762 10.7307 5.26926 12.9524 8 12.9524C10.1994 12.9524 12.0684 11.5114 12.7125 9.52381H8V6.47619H16V8C16 12.4112 12.4112 16 8 16C3.5888 16 0 12.4112 0 8Z"
                                    fill="white" />
                            </g>
                            <defs>
                                <clipPath id="clip0_197_151">
                                    <rect width="16" height="16" fill="white" />
                                </clipPath>
                            </defs>
                        </svg>
                        <span>Join with google</span>
                    </a>

                    @php
                        $dynamicPages = App\Models\DynamicPage::where('status', 'active')->latest()->get();
                    @endphp

                    <!-- common-link -->
                    <a class="common---link--auth" data-bs-toggle="modal" data-bs-target="#create-account-modal">Create
                        Account</a>
                    <p class="terms--policy--text">By proceeding, you agree to the
                        @if($dynamicPages->count() > 0)
                            @foreach($dynamicPages as $index => $dynamicPage)
                                <a class="common--privacy--link" href="{{ route('dynamic.page', $dynamicPage->page_slug) }}">
                                    {{ $dynamicPage->page_title }}
                                </a>
                                @if($index < $dynamicPages->count() - 1)
                                    &
                                @endif
                            @endforeach
                        @endif
                    </p>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- create account modal -->
<div class="modal fade" id="create-account-modal" tabindex="-1" aria-labelledby="create-account-modal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('/frontend/assets/images/modal-header-image.png') }}" alt="" srcset="">
            </div>
            <div class="modal-body">
                <form action="{{ route('register') }}" method="POST" autocomplete="off" class="common--auth--form">
                    @csrf
                    <!-- auth form title -->
                    <div class="common--auth--form-title">
                        <span>Create account</span>
                        <span class="common--auth--close--btn" data-bs-dismiss="modal">Close</span>
                    </div>
                    <!-- common float input wrapper -->
                    <div class="form-floating">
                        <input type="email" name="email" id="email" placeholder=" " :value="old('email')" required autocomplete="username">
                        <label for="email"><span>Email</span></label>
                        @error('email')
                        <p class="error--msg--auth">*{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="form-floating">
                        <input type="text" name="name" id="user-name" placeholder=" " :value="old('name')" required autofocus autocomplete="name" />
                        <label for="user-name"><span>User Name</span></label>
                        @error('name')
                        <p class="error--msg--auth">*{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="password" name="password" autocomplete="new-password" id="password" placeholder=" " required>
                        <label for="password">
                            <span>Password</span>
                            <span class="show--password--btn">Show</span>
                        </label>
                        @error('password')
                        <p class="error--msg--auth">*{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="form-floating">
                        <input type="password" name="password_confirmation" id="confirm-password" autocomplete="new-password" placeholder=" " required>
                        <label for="confirm-password">
                            <span>Confirm Password</span>
                            <span class="show--password--btn">Show</span>
                        </label>
                        @error('password_confirmation')
                        <p class="error--msg--auth">*{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- common checkbox auth -->
                    <div class="common-form-check--auth">
                        <input type="checkbox" name="terms_and_policy" value="1" id="terms" required>
                        <label for="terms">
                            I would like to receive emails with exclusive promos, popular releases and more
                        </label>
                    </div>

                    <button type="submit" class="common-auth-btn">CREATE ACCOUNT</button>

                    <!-- common-link -->
                    <a class="common---link--auth" data-bs-toggle="modal" data-bs-target="#create-login-modal">Login</a>
                    <p class="terms--policy--text">By proceeding, you agree to the
                        @if($dynamicPages->count() > 0)
                            @foreach($dynamicPages as $index => $dynamicPage)
                                <a class="common--privacy--link" href="{{ route('dynamic.page', $dynamicPage->page_slug) }}">
                                    {{ $dynamicPage->page_title }}
                                </a>
                                @if($index < $dynamicPages->count() - 1)
                                    &
                                @endif
                            @endforeach
                        @endif
                    </p>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- forget password modal -->
<div class="modal fade" id="forgot-password-modal" tabindex="-1" aria-labelledby="forgot-password-modal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('/frontend/assets/images/modal-header-image.png') }}" alt="" srcset="">
            </div>
            <div class="modal-body">
                <form autocomplete="off" action="" class="common--auth--form">
                    <!-- auth form title -->
                    <div class="common--auth--form-title">
                        <span>Forget Password</span>
                        <span class="common--auth--close--btn" data-bs-dismiss="modal">Close</span>
                    </div>

                    <div class="form-floating">
                        <input type="email" id="email" placeholder=" " required>
                        <label for="password">
                            <span>Email</span>
                        </label>
                        <!-- <p class="error--msg--auth">*Field is required</p> -->
                    </div>

                    <button type="submit" class="common-auth-btn">SEND RESET LINK</button>

                    <!-- common-link -->
                    <a class="common---link--auth">Help</a>

                </form>
            </div>

        </div>
    </div>
</div>

<!-- preference location password modal -->
<div class="modal fade" id="location-preference-modal" tabindex="-1" aria-labelledby="location-preference-modal"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered ">
        <div class="modal-content">
            <div class="modal-header">
                <img src="{{ asset('/frontend/assets/images/modal-header-image.png') }}" alt="" srcset="">
            </div>
            <div class="modal-body">
                @if(Auth::check())
                    <form id="country-update-form" autocomplete="off" action="{{ route('user.country.address.update', Auth::user()->id) }}" method="POST" class="common--auth--form">
                        @csrf
                        @method('PATCH')
                        <!-- Auth form title -->
                        <div class="common--auth--form-title">
                            <span>Choose your location for accurate shipping rates, taxes, and duties.</span>
                            <span class="common--auth--close--btn" data-bs-dismiss="modal">Close</span>
                        </div>

                        <!-- Custom select -->
                        @php
                            $countries = \App\Models\Country::where('status', 'active')->latest()->get();
                            $userCountryId = Auth::user()->country_id; // Get the current user's country ID
                        @endphp

                        <div class="form-floating">
                            <select name="country" id="country" required>
                                <option value="" disabled {{ is_null($userCountryId) ? 'selected' : '' }}>Choose Country</option>

                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ $country->id == $userCountryId ? 'selected' : '' }}>
                                        {{ $country->country }}
                                    </option>
                                @endforeach
                            </select>
                            <label for="country">Location</label>
                        </div>

                        <div class="form-floating">
                            <input type="text" id="currency" name="currency" placeholder="USD" value="USD" readonly required>
                            <label for="currency"><span>Currency</span></label>
                        </div>

                        <button type="submit" class="common-auth-btn">CONFIRM</button>
                    </form>
                @else
                    <form id="country-update-form" autocomplete="off" action="{{ route('session.country.store') }}" method="POST" class="common--auth--form">
                        @csrf
                        <!-- Auth form title -->
                        <div class="common--auth--form-title">
                            <span>Choose your location for accurate shipping rates, taxes, and duties.</span>
                            <span class="common--auth--close--btn" data-bs-dismiss="modal">Close</span>
                        </div>

                        <!-- Custom select -->
                        @php
                            $countries = \App\Models\Country::where('status', 'active')->latest()->get();
                            $sessionCountryId = session('selected_country'); // Get the country ID from the session
                        @endphp

                        <div class="form-floating">
                            <select name="country" id="country" required>
                                <option value="" disabled selected>Choose Country</option>

                                @foreach($countries as $country)
                                    <option value="{{ $country->id }}" {{ $country->id == $sessionCountryId ? 'selected' : '' }}>{{ $country->country }}</option>
                                @endforeach
                            </select>
                            <label for="country">Location</label>
                        </div>

                        <div class="form-floating">
                            <input type="text" id="currency" name="currency" placeholder="USD" value="USD" readonly required>
                            <label for="currency"><span>Currency</span></label>
                        </div>

                        <button type="submit" class="common-auth-btn">CONFIRM</button>
                    </form>
                @endif
            </div>

        </div>
    </div>
</div>


{{--Country Select--}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('#country-update-form').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            let formData = $(this).serialize(); // Serialize the form data
            let url = $(this).attr('action'); // Keep the original action URL

            if ({{ Auth::check() ? 'true' : 'false' }}) {
                // User is logged in
                $.ajax({
                    url: url,
                    type: 'PATCH',
                    data: formData,
                    success: function(response) {
                        showSuccessToast(response.message);
                        $('#location-preference-modal').modal('hide');
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON && xhr.responseJSON.message
                            ? xhr.responseJSON.message
                            : 'Error updating country:';
                        showErrorToast(errorMessage);
                    }
                });
            } else {
                // User is not logged in
                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        showSuccessToast(response.message);
                        $('#location-preference-modal').modal('hide');
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON && xhr.responseJSON.message
                            ? xhr.responseJSON.message
                            : 'Error updating country:';
                        showErrorToast(errorMessage);
                    }
                });
            }
        });
    });
</script>

<!-- search modal -->
<div class="modal fade mt-lg-5" id="searchModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog  ">
        <div class="modal-content">

            <form class="modal-body" id="searchForm" onsubmit="return false;">
                <input class="search-input form-control" type="text" name="search" id="search" onfocus="this.value='' ">
                <div class="searched-matched-items" id="search-list"></div>
                <hr>
                <p class="search-bottom--text">Show all results for "<span id="searchTerm"></span>"</p>
            </form>

        </div>
    </div>
</div>

{{--Search--}}
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#search').on('keyup', function() {
            var value = $(this).val();
            $('#searchTerm').text(value); // Display current search term

            if (value.length > 0) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('search') }}", // Ensure this points to the correct route
                    data: { 'search': value },
                    success: function(data) {
                        $('#search-list').html(data.html);
                    },
                    error: function(xhr, status, error) {
                        console.error("AJAX Error:", status, error);
                    }
                });
            } else {
                $('#search-list').empty();
            }
        });
    });
</script>


<!-- Toaster  -->
@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if($errors->any())
            @foreach ($errors->all() as $error)
            showErrorToast("{{ $error }}");
            @endforeach
            @endif
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
