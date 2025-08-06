{{--home--}}
<script src="{{ asset('/frontend/assets/js/jquery-3.7.1.min.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/plugins.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/main.js') }}"></script>
<script src="{{ asset('/frontend/assets/js/jquery.marquee.js') }}"></script>

{{--vacation--}}
<script src="{{ asset('/frontend/assets/js/jquery.syotimer.min.js') }}"></script>

<script>

    // Login Popup
    function checkAuthentication() {
        $.ajax({
            url: '{{ route('user.check_authentication') }}',
            method: 'GET',
            success: function(response) {
                console.log(response); // Log the response for debugging
                if (response.authenticated) {
                    submitLikeForm(); // Submit like if authenticated
                } else {
                    $('#create-login-modal').modal('show'); // Show login modal if not authenticated
                }
            },
            error: function() {
                $('#create-login-modal').modal('show'); // Show modal on error
            }
        });

    }

    // Product Filter
    $(document).ready(function() {
        $('input[name="filter"]').on('change', function() {
            const selectedFilter = $(this).val();
            console.log()

            $.ajax({
                url: "{{ route('products.filter')}}",
                type: 'POST',
                data: {
                    filter: selectedFilter,
                    brand: "{{ isset($brandId)? $brandId : null}}",
                    category: "{{ isset($categoryId)? $categoryId : null}}",
                    _token: $('meta[name="csrf-token"]').attr('content') // Include CSRF token
                },
                success: function(response) {
                    $('.backdrop-container--filter').removeClass('active');
                    $('.all-products-container').html(response.html);
                },
                error: function(error) {
                    console.log('Error:', error);
                }
            });
        });
    });
</script>


@stack('script')
