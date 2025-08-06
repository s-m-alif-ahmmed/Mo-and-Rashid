@extends('frontend.app')

@section('title')
    F.A.Q - mo&rashids
@endsection

@section('content')

    @include('frontend.partials.cart-sidebar')

    <div class="policy-page--wrapper">

        <div class="route--icon--wrapper">
            <!-- <span class="header--common-icon  show-cart-item">
              <img src="./assets/images/heart.svg" alt="" srcset="">
            </span> -->
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
                <h1 class="policy--heading">FAQ</h1>
                <!-- policy -->
                <div class="policy--wrapper">
                    <!-- faq 1 -->
                    @foreach($faqs as $faq)
                        <div class="faq">
                            <div class="faq-title">{{ $faq->question }}</div>
                            <div class="policy-normal--text">
                                {!! $faq->answer !!}
                            </div>
                        </div>
                    @endforeach

                </div>
                <!-- buttons -->
                <a href="{{ route('home') }}" class="common--policy--btn">Back Home</a>

            </div>
        </div>

    </div>

@endsection
