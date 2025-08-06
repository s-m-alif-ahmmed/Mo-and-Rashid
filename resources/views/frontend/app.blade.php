<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- All Plugins CSS -->

    @include('frontend.partials.styles')

</head>

<body class="{{ request()->routeIs('home') ? 'body--gray--white' : '' }}" id="body">

<!-- page  preloader -->
<div class="preloader">
    <div class="preloader--logo">
        <img src="{{ asset('/frontend/assets/images/vacation-onboard.png') }}" alt="" srcset="">
    </div>
</div>

@include('frontend.partials.header')


<!-- main area starts -->
<main>

    @yield('content')

</main>
<!-- main area starts -->

<!-- footer area starts -->
@include('frontend.partials.footer')
<!-- footer area ends -->

<!-- Javascript Links -->
@include('frontend.partials.scripts')


</body>

</html>
