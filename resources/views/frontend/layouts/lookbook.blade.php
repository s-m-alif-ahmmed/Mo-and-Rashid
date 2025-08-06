@extends('frontend.app')

@section('title','Lookbook - mo&rashids')

@section('content')

    @include('frontend.partials.cart-sidebar')

    <div class="look-book--page-wrapper">

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
                  <a href="" class="common-route" onclick="event.preventDefault(); document.getElementById('logoutForm').submit()">Sign Out</a>
                  <form action="{{ route('logout') }}" method="post" id="logoutForm" >
                        @csrf
                  </form>
              @else
                  <span class="common-route" data-bs-toggle="modal" data-bs-target="#create-login-modal">Log In</span>
                  <span class="common-route" data-bs-toggle="modal" data-bs-target="#create-account-modal">Create account</span>
                  <span class="common-route" data-bs-toggle="modal" data-bs-target="#location-preference-modal">Location
                preference</span>
              @endif

          </div>
        </span>
        </div>

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

                @php
                    $cart_count = 0;
                        if (\Illuminate\Support\Facades\Auth::check()) {
                            $user = \Illuminate\Support\Facades\Auth::user();
                            $cart_count = \App\Models\Cart::where('user_id', $user->id)->count();
                        }
                @endphp

                <!-- cart -->
                <div class="product-details--cart--count">
                    <span class="show-cart-item" >Cart</span>
                    <span class="cart-count--product-details">{{ $cart_count}}</span>
                </div>
            </div>
        </div>
        <!-- image gallery wrapper  -->
        <div class="look-book--image--gallery--section">

            <div class="look-book--common--container look-book--btns">
                <!-- left -->
                <div class="look-book--btns--left">
                    <span class="title" >Lookbook</span>
                    <span class="subtitle">FW24
                - mo&rashids</span>
                </div>
                <!-- right -->
                <div class="look-book--btns--right">
                    <a href="{{ route('collections.catalog.all') }}" class="look-book--common--btn red">Shop all</a>
                    <a href="{{ route('home') }}" class="look-book--common--btn bg-black">Back Home</a>
                </div>
            </div>
            @if($products->isEmpty())
                <div class="no--products--screen" >
                    No items found.
                </div>
            @else
            <div class="look-book--common--container look-book-image--gallery ">
                @foreach($products as $product)
                    <a href="{{ route('product.detail', $product->product_slug) }}" class="gallery--image">
                        @foreach($product->images->take(1) as $image)
                            <img src="{{ asset($image->image) }}" alt="" srcset="">
                        @endforeach
                    </a>
                @endforeach

            </div>
            @endif

        </div>

    </div>
@endsection

<!-- Toaster  -->
@push('script')
    <script>
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
