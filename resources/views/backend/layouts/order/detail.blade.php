@extends('backend.app')

@section('title', 'Order Detail')

@section('content')
    <section>
        <div class="main-content mt-0">
            <div class="">

                <!-- CONTAINER -->
                <div class="">

                    <!-- PAGE-HEADER -->
                    <div class="page-header" id="pageHeader">
                        <div>
                            <h1 class="page-title">Invoice Details</h1>
                        </div>
                        <div class="ms-auto pageheader-btn">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="">Invoices</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Invoice Details</li>
                            </ol>
                        </div>
                    </div>
                    <!-- PAGE-HEADER END -->

                    <!-- ROW-1 OPEN -->
                    <div class="row" id="order-detail" style="display: block;">
                        <div class="col-md-12">
                            <div class="card" id="invoiceCard">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-start">
                                            <h3 class="card-title mb-0">#Order id: {{ $order->tracking_id }}</h3>
                                        </div>
                                        <div class="float-end">
                                            <h3 class="card-title">Date: {{ $order->created_at->setTimezone('America/New_York')->format('m-d-Y g:i A T') }}</h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="table-responsive push">
                                        <table class="table table-bordered table-hover mb-0 text-nowrap border-bottom w-100">
                                            <thead>
                                            <tr>
                                                <th>User Name</th>
                                                <th>Country</th>
                                                <th class="text-center"> email</th>
                                                <th class="text-center"> Address</th>
                                                <th class="text-center"> Address</th>
                                                <th class="text-center"> City</th>
                                                <th class="text-center"> Postal Code</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>{{ $order->name }}</td>
                                                    <td>{{ $order->country->country }}</td>
                                                    <td class="text-center">{{ $order->contact }}</td>
                                                    <td class="text-center">{{ $order->address ?? 'N/A' }}</td>
                                                    <td class="text-center">{{ $order->apartment ?? 'N/A' }}</td>
                                                    <td class="text-end">{{ $order->city }}</td>
                                                    <td class="text-end">{{ $order->postal_code }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <hr>
                                    <div class="clearfix">
                                        <div class="float-start">
                                            <h3 class="card-title my-3">Order Details</h3>
                                        </div>
                                    </div>
                                    <div class="table-responsive push">
                                        <table class="table table-bordered table-hover mb-0 text-nowrap border-bottom w-100">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th class="text-center">Product Size</th>
                                                <th class="text-center">Product Color</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-end">Price</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($order->orderDetails as $product)
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $product->product->name }}</td>
                                                    <td class="text-center">{{ $product->quantity }} pcs</td>
                                                    <td class="text-center">{{ $product->productColor->color ?? 'N/A' }}</td>
                                                    <td class="text-center">{{ $product->productSize->size ?? 'N/A' }}</td>
                                                    <td class="text-end">${{ number_format($product->product->selling_price, 2) }}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer text-end" id="invoiceFooter">
                                    <button type="button" class="btn btn-info mb-1" onclick="printInvoice();"><i class="si si-printer"></i> Print Invoice</button>
                                </div>
                            </div>
                        </div><!-- COL-END -->
                    </div>
                    <!-- ROW-1 CLOSED -->

                    <!-- ROW-1 OPEN -->
                    <div class="row" style="display: none;" id="invoice">
                        <div class="col-md-12">
                            <div class="card" id="invoiceCard">
                                <div class="card-body">
                                    <div class="clearfix">
                                        <div class="float-start">
                                            <h3 class="card-title mb-0">#Order id: {{ $order->tracking_id }}</h3>
                                        </div>
                                        <div class="float-end">
                                            <h3 class="card-title">Date: {{ now()->setTimezone('America/New_York')->format('m-d-Y g:i A T') }}</h3>
                                        </div>
                                    </div>
                                    <hr>
                                    <div class="row d-flex px-3">
                                        <div class="col-lg-6">
                                            <p class="h3">Invoice From:</p>
                                            @php
                                                $systemSetting = App\Models\SystemSetting::first();
                                            @endphp
                                            <img class="img-fluid py-1" src="{{ asset($systemSetting->logo ?? 'frontend/eVento_logo.png') }}" alt="" style="height: 50px; width: auto;">
                                        </div>
                                        <div class="col-lg-6 text-end">
                                            <p class="h3">Invoice To:</p>
                                            <address>
                                                {{ $order->name }}<br>
                                                {{ $order->address }}<br>
                                                @if($order->apartment)
                                                    {{ $order->apartment }}<br>
                                                @endif
                                                {{ $order->city }} - {{ $order->postal_code }}<br>
                                                {{ $order->contact }}
                                            </address>
                                        </div>
                                    </div>
                                    <div class="table-responsive push">
                                        <table class="table table-bordered table-hover mb-0 text-nowrap border-bottom w-100">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Name</th>
                                                <th class="text-center">Color</th>
                                                <th class="text-center">Size</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-end">Unit Price</th>
                                                <th class="text-end">Sub Total</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @php $totalSum = 0; @endphp
                                            @foreach($order->orderDetails as $orderDetail)
                                                @php
                                                    $subTotal = $orderDetail->quantity * $orderDetail->product->selling_price;
                                                    $totalSum += $subTotal;
                                                @endphp
                                                <tr>
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td>{{ $orderDetail->product->name }}</td>
                                                    <td class="text-center">{{ $orderDetail->productColor->color }}</td>
                                                    <td class="text-center">{{ $orderDetail->productSize->size }}</td>
                                                    <td class="text-center">{{ $orderDetail->quantity }} pcs</td>
                                                    <td class="text-end">${{ number_format($orderDetail->product->selling_price, 2) }}</td>
                                                    <td class="text-end">${{ number_format($subTotal, 2) }}</td>
                                                </tr>
                                            @endforeach
                                            <tr>
                                                <td colspan="4" class="text-uppercase text-end">Total</td>
                                                <td class="text-end h5">${{ number_format($order->total, 2) }}</td>
                                            </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-footer text-end" id="invoiceFooter">
                                    <button type="button" class="btn btn-info mb-1" onclick="toggleInvoice();"><i class="si si-printer"></i> View Invoice</button>
                                </div>
                            </div>
                        </div><!-- COL-END -->
                    </div>
                    <!-- ROW-1 CLOSED -->

                </div>
            </div>
        </div>
    </section>

    <style>
        @media print {
            #pageHeader {
                display: none;
            }
            #invoiceFooter {
                display: none;
            }
            #back-to-top {
                display: none;
            }
        }
    </style>

    <script>

        function printInvoice() {
            const invoiceSection = document.getElementById('invoice');
            const orderSection = document.getElementById('order-detail');
            invoiceSection.style.display = 'block'; // Ensure the invoice is visible
            orderSection.style.display = 'none'; // hide the order table
            window.print(); // Print the invoice
            invoiceSection.style.display = 'none'; // Hide it again after printing
            orderSection.style.display = 'block'; // hide the order table
        }
    </script>
@endsection
