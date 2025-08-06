@extends('frontend.app')

@section('title')
    Contact - mo&rashids
@endsection

@section('content')

    @include('frontend.partials.cart-sidebar')

    <div class="policy-page--wrapper">
        <div class="route--icon--wrapper">
            <span class="header--common-icon  show-cart-item">
              <img src="{{ asset('/frontend/assets/images/heart.svg') }}" alt="" srcset="">
            </span>
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
        </div>

        <!-- logo and time -->
        <div class="container">
            <div class="product-details--time-cart-logo">
                <!-- logo -->
                <a href="{{ route('home') }}" class="product-details-page-logo">
                    <img src="{{ asset('/frontend/assets/images/logo-no-background.png') }}" alt="" srcset="">
                </a>
                <!-- time -->
                <div class="home-time-and-date">
                    {{ now()->setTimezone('America/New_York')->format('n/j/Y g:i A T') }}
                </div>

            </div>
        </div>

        <!-- refund policy -->
        <div class="container">
            <div class="refund-contact-shipping--container">
                <h2 class="policy-subheading">Allow 3-5 business days for a response to your inguiry.</h2>

                <form action="{{ route('contact.store') }}" method="POST" class="contact-form contact-submit">
                    @csrf

                    <div class="contact-form--input--group">
                        <input type="text" class="common-input" name="first_name" id="fname" placeholder="First Name" />
                        <input type="text" class="common-input" name="last_name" id="lname" placeholder="Last Name" />
                    </div>

                    <div class="contact-form--input--group" >
                        <input type="email" class="common-input" name="email" id="email" placeholder="Email Address" />
                        <input type="text" class="common-input" name="order_number" id="order-number"
                               placeholder="Order Number" />
                    </div>

                    <input type="text" class="common-input" name="subject" id="subject" placeholder="Subject" />
                    <textarea class="common-input textarea" name="message" id="message" placeholder="Message"></textarea>

                    <div class="form-btns">
                        <a href="{{ route('home') }}" class="common--policy--btn">Back Home</a>
                        <button class="common--policy--btn" type="submit">Send</button>
                    </div>

                </form>
            </div>
        </div>

    </div>

@endsection


<!-- Toaster  -->
@push('script')
    <script>

        $(document).ready(function() {
            $(document).on('submit', '.contact-submit', function(e) {
                e.preventDefault(); // Prevent default submission

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
                            showErrorToast('An error occurred. Please try again.');
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
