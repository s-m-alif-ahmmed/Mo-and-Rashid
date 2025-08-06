@extends('backend.app')

@section('title', 'Dashboard')

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>

    </style>
@endpush

@section('content')
    {{-- PAGE-HEADER --}}
    <div class="page-header">
        <div>
            <h1 class="page-title">Dashboard</h1>
        </div>
        <div class="ms-auto pageheader-btn">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
            </ol>
        </div>
    </div>
    {{-- PAGE-HEADER --}}

    <div class="row">

         <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('user.index') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $user_count }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Users</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon bg-primary dash ms-auto box-shadow-primary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><path d="M144 0a80 80 0 1 1 0 160A80 80 0 1 1 144 0zM512 0a80 80 0 1 1 0 160A80 80 0 1 1 512 0zM0 298.7C0 239.8 47.8 192 106.7 192l42.7 0c15.9 0 31 3.5 44.6 9.7c-1.3 7.2-1.9 14.7-1.9 22.3c0 38.2 16.8 72.5 43.3 96c-.2 0-.4 0-.7 0L21.3 320C9.6 320 0 310.4 0 298.7zM405.3 320c-.2 0-.4 0-.7 0c26.6-23.5 43.3-57.8 43.3-96c0-7.6-.7-15-1.9-22.3c13.6-6.3 28.7-9.7 44.6-9.7l42.7 0C592.2 192 640 239.8 640 298.7c0 11.8-9.6 21.3-21.3 21.3l-213.3 0zM224 224a96 96 0 1 1 192 0 96 96 0 1 1 -192 0zM128 485.3C128 411.7 187.7 352 261.3 352l117.3 0C452.3 352 512 411.7 512 485.3c0 14.7-11.9 26.7-26.7 26.7l-330.7 0c-14.7 0-26.7-11.9-26.7-26.7z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('order.index.all.orders') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $all_orders }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Orders</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon bg-secondary dash ms-auto box-shadow-secondary">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('order.index') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $pending_order }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Pending Orders</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon bg-info dash ms-auto box-shadow-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M304 48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zm0 416a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM48 304a48 48 0 1 0 0-96 48 48 0 1 0 0 96zm464-48a48 48 0 1 0 -96 0 48 48 0 1 0 96 0zM142.9 437A48 48 0 1 0 75 369.1 48 48 0 1 0 142.9 437zm0-294.2A48 48 0 1 0 75 75a48 48 0 1 0 67.9 67.9zM369.1 437A48 48 0 1 0 437 369.1 48 48 0 1 0 369.1 437z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('order.index.completed') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $complete_order }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Completed Orders</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon bg-info dash ms-auto box-shadow-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><path d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM369 209L241 337c-9.4 9.4-24.6 9.4-33.9 0l-64-64c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l47 47L335 175c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9z"/></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('order.index.return') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $return_order }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Return Orders</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon bg-warning dash ms-auto box-shadow-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path fill-rule="evenodd" d="m340.64 161.21 31.55 18.23L256 246.5l-31.55-18.2 112.08-64.72zm-32.51-14-116.84 67.46c-.14.08-.26.17-.43.26l-3.03 1.76v38.89l11.96 6.92v-34.24h.03c0-2.83 1.47-5.61 4.11-7.14l120.22-69.39-11.91-6.89zm69.47 182.24c1.79-1.02 2.81-2.81 2.81-4.88v-130.9l-116.14 67.07v134.14zm-245.99-4.88c0 2.07 1.02 3.86 2.81 4.88l113.33 65.42V260.73l-31.44-18.14v34.19c0 4.56-3.69 8.25-8.25 8.25-1.79 0-3.43-.57-4.79-1.53l-27.81-16.04a8.246 8.246 0 0 1-4.14-7.14h-.03V216.6l-39.69-22.9v130.87zm121.58-210.59-113.33 65.45 39.77 22.96 2.98-1.73c.14-.08.31-.17.45-.26l112.73-65.08-36.99-21.34c-1.78-1.02-3.82-1.02-5.61 0zm183.89-39.03C390.73 28.6 326.73-.05 256-.05c-38.24 0-74.61 8.42-107.29 23.56C123.05 35.35 99.7 51.37 79.43 70.7c-2.47 2.35-6.41 2.32-8.82-.11l-30.33-30.3c-1.84-1.84-4.45-2.35-6.86-1.36s-3.91 3.23-3.91 5.84v98.05c0 3.46 2.83 6.29 6.32 6.29h98.05c2.61 0 4.82-1.47 5.81-3.88 1.02-2.41.48-5.05-1.36-6.89l-30.19-30.19c-1.25-1.25-1.87-2.78-1.84-4.56.03-1.79.71-3.29 1.98-4.51 16.78-15.79 36.14-28.91 57.4-38.75 27.41-12.67 58-19.73 90.31-19.73 59.5 0 113.36 24.09 152.33 63.07 37.79 37.79 61.6 89.55 63.01 146.86.08 3.03 2.58 5.47 5.61 5.47h29.42c1.59 0 2.92-.57 4.02-1.67 1.11-1.13 1.64-2.49 1.59-4.05-1.48-68.43-29.82-130.26-74.89-175.33zm39.11 287.94h-98.05c-2.61 0-4.85 1.47-5.84 3.88s-.48 5.05 1.39 6.89l30.16 30.19c1.28 1.25 1.9 2.81 1.87 4.56-.03 1.79-.71 3.29-2.01 4.51a216.178 216.178 0 0 1-57.37 38.75c-27.41 12.67-58.03 19.76-90.34 19.76-59.47 0-113.33-24.12-152.31-63.1-37.79-37.79-61.6-89.55-63.04-146.86-.06-3.03-2.55-5.47-5.61-5.47H5.61c-1.56 0-2.92.57-4 1.7-1.11 1.11-1.64 2.47-1.62 4.05 1.5 68.43 29.88 130.22 74.95 175.32C121.3 483.4 185.3 512.05 256 512.05c38.27 0 74.64-8.42 107.32-23.56 25.65-11.85 49.01-27.86 69.28-47.2 2.47-2.35 6.41-2.32 8.82.11l30.3 30.3c1.84 1.84 4.48 2.38 6.89 1.36 2.41-.99 3.91-3.23 3.91-5.84V369.2c-.01-3.47-2.84-6.31-6.33-6.31z" clip-rule="evenodd" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('order.index.canceled') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $canceled_order }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Canceled Orders</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon bg-warning dash ms-auto box-shadow-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M212.96 238.362v246.48c-4.51 0-9.02-1.06-13.173-3.18L24.15 392.122c-10.189-5.19-16.65-15.94-16.65-27.7v-212.03c0-5.93 1.642-11.6 4.578-16.44l200.882 102.41zM418.41 275.073v89.349c0 11.76-6.451 22.51-16.65 27.7l-175.627 89.54a28.944 28.944 0 0 1-13.173 3.18v-246.48M309.572 189.108l-96.612 49.254-200.882-102.41c2.781-4.57 6.712-8.4 11.512-10.97l175.627-94.35c.048-.02.087-.05.135-.07 8.586-4.56 18.775-4.54 27.341.07l83.476 44.844" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class=""></path><path d="M361.498 33.972c11.626-4.404 24.231-6.814 37.4-6.814 58.322 0 105.602 47.28 105.602 105.602s-47.28 105.602-105.602 105.602-105.602-47.28-105.602-105.602c0-31.898 14.143-60.493 36.499-79.856" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class=""></path><path d="m445.06 156.277-23.517-23.517 23.517-23.517c6.253-6.253 6.253-16.392 0-22.645h0c-6.253-6.253-16.392-6.253-22.645 0l-23.517 23.517-23.517-23.517c-6.253-6.253-16.392-6.253-22.645 0v0c-6.253 6.253-6.253 16.392 0 22.645l23.517 23.517-23.517 23.517c-6.253 6.253-6.253 16.392 0 22.645v0c6.253 6.253 16.392 6.253 22.645 0l23.517-23.517 23.517 23.517c6.253 6.253 16.392 6.253 22.645 0h0c6.254-6.253 6.254-16.392 0-22.645z" style="stroke-width:15;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:10;" fill="none" stroke="#000000" stroke-width="15" stroke-linecap="round" stroke-linejoin="round" stroke-miterlimit="10" data-original="#000000" class=""></path></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('order.index.pending.payment') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $payment_pending_order }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Payment Pending Orders</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon bg-warning dash ms-auto box-shadow-warning">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 16 16" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><path d="M14.5 7.354V5.76a1.502 1.502 0 0 0-1.5-1.5h-.5V2.24A1.499 1.499 0 0 0 10.444.846l-2.32.927A4.491 4.491 0 0 0 .5 5a4.386 4.386 0 0 0 .048.47 1.126 1.126 0 0 0-.048.29v8a1.502 1.502 0 0 0 1.5 1.5h11a1.502 1.502 0 0 0 1.5-1.5v-1.59a1.498 1.498 0 0 0 1-1.408v-2a1.498 1.498 0 0 0-1-1.408Zm-3.687-5.58a.5.5 0 0 1 .687.466v2.02H9.425a4.458 4.458 0 0 0-.64-1.675ZM5 1.5A3.5 3.5 0 1 1 1.5 5 3.504 3.504 0 0 1 5 1.5Zm8 12.76H2a.5.5 0 0 1-.5-.5l.006-5.96a4.467 4.467 0 0 0 7.968-2.54H13a.5.5 0 0 1 .5.5v1.502H12a1.502 1.502 0 0 0-1.5 1.5v2a1.502 1.502 0 0 0 1.5 1.5h1.5v1.498a.5.5 0 0 1-.5.5Zm1.5-3.498a.5.5 0 0 1-.495.499L14 11.26l-.01.002H12a.5.5 0 0 1-.5-.5v-2a.5.5 0 0 1 .5-.5h2a.5.5 0 0 1 .5.5Z" fill="#000000" opacity="1" data-original="#000000" class=""></path><path d="M5.646 6.354a.5.5 0 0 0 .707-.707L5.5 4.793V3a.5.5 0 0 0-1 0v2a.5.5 0 0 0 .146.353Z" fill="#000000" opacity="1" data-original="#000000" class=""></path></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

        <div class="col-lg-6 col-sm-12 col-md-6 col-xl-3">
            <a href="{{ route('order.index.payment.failed') }}" class="card-link">
                <div class="card overflow-hidden">
                    <div class="card-body">
                        <div class="row">
                            <div class="col">
                                <h3 class="mb-2 fw-semibold">{{ $payment_fail_order }}</h3>
                                <p class="text-muted fs-13 mb-0">Total Payment Fail Orders</p>
                            </div>
                            <div class="col col-auto top-icn dash">
                                <div class="counter-icon bg-info dash ms-auto box-shadow-info">
                                    <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" width="512" height="512" x="0" y="0" viewBox="0 0 64 64" style="enable-background:new 0 0 512 512" xml:space="preserve" class=""><g><g fill="#293a4c"><path d="M29 45.5H8A4.505 4.505 0 0 1 3.5 41V11c0-2.481 2.019-4.5 4.5-4.5h43c2.481 0 4.5 2.019 4.5 4.5v23.25a1.5 1.5 0 1 1-3 0V11c0-.827-.673-1.5-1.5-1.5H8c-.827 0-1.5.673-1.5 1.5v30c0 .827.673 1.5 1.5 1.5h21a1.5 1.5 0 1 1 0 3z" fill="#293a4c" opacity="1" data-original="#293a4c" class=""></path><path d="M54 24.5H5a1.5 1.5 0 1 1 0-3h49a1.5 1.5 0 1 1 0 3zM54 17.5H5a1.5 1.5 0 1 1 0-3h49a1.5 1.5 0 1 1 0 3zM21 31.5H11a1.5 1.5 0 1 1 0-3h10a1.5 1.5 0 1 1 0 3zM15 36.5h-4a1.5 1.5 0 1 1 0-3h4a1.5 1.5 0 1 1 0 3zM47 30.5c-7.444 0-13.5 6.056-13.5 13.5S39.556 57.5 47 57.5 60.5 51.444 60.5 44 54.444 30.5 47 30.5zm6.06 17.44a1.5 1.5 0 1 1-2.12 2.12L47 46.122l-3.94 3.94c-.292.293-.676.439-1.06.439s-.768-.146-1.06-.44a1.5 1.5 0 0 1 0-2.12L44.878 44l-3.94-3.94a1.5 1.5 0 1 1 2.122-2.12L47 41.878l3.94-3.94a1.5 1.5 0 1 1 2.12 2.122L49.122 44l3.94 3.94z" fill="#293a4c" opacity="1" data-original="#293a4c" class=""></path></g></g></svg>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        </div>

    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr("#start_date", {
            enableTime: true,
            time_24hr: true
        });

        flatpickr("#end_date", {
            enableTime: true,
            time_24hr: true
        });
    </script>
@endpush
