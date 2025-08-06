@extends('frontend.app')

@section('title', 'Vacation - mo&rashids')

@section('content')

    <div class="modal fade" id="store-owner" tabindex="-1" aria-labelledby="store-owner" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header mb-3">
                    <h1 class="modal-title">ENTER STORE PASSWORD</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('login') }}" method="POST" class="modal-body">
                    @csrf
                    @php
                        $user = \App\Models\User::where('role', 'admin')->first();
                    @endphp
                    <input class="owner-submit--input" type="hidden" id="owner-email" value="{{ $user->email }}" name="email"
                        placeholder="Enter Email" />
                    <input class="owner-submit--input" type="password" id="owner-password" name="password"
                        placeholder="*******" />
                    <button type="submit" class="owner-submit--btn">ENTER</button>
                </form>
            </div>
        </div>
    </div>

    <div class="vacation--page---wrapper">
        <span data-bs-toggle="modal" data-bs-target="#store-owner"
            class="store--owner--link--text red-background--route">Store Owner?</span>
        <div class="vacation--logo">
            <img src="{{ asset('/frontend/assets/images/vacation-onboard.png') }}" alt="" srcset="">
        </div>

        <div class="timer--wrapper">
            <div class="timer--box" id="timer--box" data-start-time="{{ $vacation->start_date ?? null }}" data-end-time="{{ $vacation->end_date ?? null }}"></div>
        </div>

        <div class="vacation--mood--footer">
            <div class="vacation--footer--content">
                <div class="vacation--footer--text">
                    We'll Be Back Soon!
                    <br>
                    We're currently working on something exciting. Stay tuned for our launch in just a few days! Sign up
                    below to be the first to know when we're live.
                </div>
                <form action="{{ route('newsletter.store') }}" method="POST" autocomplete="off"
                    class="vacation--footer--form newsletter-submit ">
                    @csrf
                    <input type="email" name="email" id="email" placeholder="Enter Email">
                    <button class="join---btn" type="submit">JOIN</button>
                </form>
            </div>
        </div>
        <video autoplay muted loop class="background-video">
            <source src="{{ asset('/frontend/assets/videos/vacation.mp4') }}" type="video/mp4">
        </video>
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
