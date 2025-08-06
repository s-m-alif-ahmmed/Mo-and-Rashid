@extends('frontend.app')

@section('title')
    Checkout - mo&rashids
@endsection

@section('content')

    <div class="checkout--page--wrapper">
        <div class="checkout--info--form--side">
            @if(Auth::check())
                <form action="{{ route('order.new') }}" id="checkout-form" method="POST" class="checkout--from--wrapper">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                    {{--                buttons wrapper --}}
                    <div class="payment--methods--button--wrapper">
                        <button class="common-payment--method--btn stripe " type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="white" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" style="enable-background:new 0 0 468 222.5;" xml:space="preserve" viewBox="54 36 360.02 149.84">  <g> 	<path class="st0" d="M414,113.4c0-25.6-12.4-45.8-36.1-45.8c-23.8,0-38.2,20.2-38.2,45.6c0,30.1,17,45.3,41.4,45.3   c11.9,0,20.9-2.7,27.7-6.5v-20c-6.8,3.4-14.6,5.5-24.5,5.5c-9.7,0-18.3-3.4-19.4-15.2h48.9C413.8,121,414,115.8,414,113.4z    M364.6,103.9c0-11.3,6.9-16,13.2-16c6.1,0,12.6,4.7,12.6,16H364.6z"/> 	<path class="st0" d="M301.1,67.6c-9.8,0-16.1,4.6-19.6,7.8l-1.3-6.2h-22v116.6l25-5.3l0.1-28.3c3.6,2.6,8.9,6.3,17.7,6.3   c17.9,0,34.2-14.4,34.2-46.1C335.1,83.4,318.6,67.6,301.1,67.6z M295.1,136.5c-5.9,0-9.4-2.1-11.8-4.7l-0.1-37.1   c2.6-2.9,6.2-4.9,11.9-4.9c9.1,0,15.4,10.2,15.4,23.3C310.5,126.5,304.3,136.5,295.1,136.5z"/> 	<polygon class="st0" points="223.8,61.7 248.9,56.3 248.9,36 223.8,41.3  "/> 	<rect x="223.8" y="69.3" class="st0" width="25.1" height="87.5"/> 	<path class="st0" d="M196.9,76.7l-1.6-7.4h-21.6v87.5h25V97.5c5.9-7.7,15.9-6.3,19-5.2v-23C214.5,68.1,202.8,65.9,196.9,76.7z"/> 	<path class="st0" d="M146.9,47.6l-24.4,5.2l-0.1,80.1c0,14.8,11.1,25.7,25.9,25.7c8.2,0,14.2-1.5,17.5-3.3V135   c-3.2,1.3-19,5.9-19-8.9V90.6h19V69.3h-19L146.9,47.6z"/> 	<path class="st0" d="M79.3,94.7c0-3.9,3.2-5.4,8.5-5.4c7.6,0,17.2,2.3,24.8,6.4V72.2c-8.3-3.3-16.5-4.6-24.8-4.6   C67.5,67.6,54,78.2,54,95.9c0,27.6,38,23.2,38,35.1c0,4.6-4,6.1-9.6,6.1c-8.3,0-18.9-3.4-27.3-8v23.8c9.3,4,18.7,5.7,27.3,5.7   c20.8,0,35.1-10.3,35.1-28.2C117.4,100.6,79.3,105.9,79.3,94.7z"/> </g> </svg>
                        </button>
                        <button class="common-payment--method--btn paypal" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="77" height="25" viewBox="0 0 77 25" fill="none">
                                <g clip-path="url(#clip0_683_439)">
                                    <path d="M9.80946 2.73999H3.95946C3.58446 2.73999 3.20946 3.03999 3.13446 3.41499L0.809458 18.415C0.734458 18.715 0.959458 18.94 1.25946 18.94H4.03446C4.40946 18.94 4.78446 18.64 4.85946 18.265L5.45946 14.215C5.53446 13.84 5.83446 13.54 6.28446 13.54H8.15946C11.9845 13.54 14.2345 11.665 14.8345 7.98999C15.0595 6.41499 14.8345 5.13999 14.0845 4.23999C13.2595 3.26499 11.7595 2.73999 9.80946 2.73999ZM10.4845 8.21499C10.1845 10.315 8.53446 10.315 7.03446 10.315H6.13446L6.73446 6.41499C6.73446 6.18999 6.95946 6.03999 7.18446 6.03999H7.55946C8.60946 6.03999 9.58446 6.03999 10.1095 6.63999C10.4845 6.93999 10.6345 7.46499 10.4845 8.21499Z" fill="#003087"/>
                                    <path d="M27.2083 8.14001H24.4333C24.2083 8.14001 23.9833 8.29001 23.9833 8.51501L23.8333 9.26501L23.6083 8.96502C23.0083 8.06501 21.6583 7.76501 20.3083 7.76501C17.2333 7.76501 14.6083 10.09 14.0833 13.39C13.7833 15.04 14.1583 16.615 15.1333 17.665C15.9583 18.64 17.2333 19.09 18.6583 19.09C21.1333 19.09 22.5583 17.515 22.5583 17.515L22.4083 18.265C22.3333 18.565 22.5583 18.865 22.8583 18.865H25.4083C25.7833 18.865 26.1583 18.565 26.2333 18.19L27.7333 8.59001C27.8083 8.44001 27.5083 8.14001 27.2083 8.14001ZM23.3833 13.54C23.0833 15.115 21.8833 16.24 20.2333 16.24C19.4083 16.24 18.8083 16.015 18.3583 15.49C17.9083 14.965 17.7583 14.29 17.9083 13.54C18.1333 11.965 19.4833 10.84 21.0583 10.84C21.8833 10.84 22.4833 11.14 22.9333 11.59C23.3083 12.115 23.4583 12.79 23.3833 13.54Z" fill="#003087"/>
                                    <path d="M42.134 8.14001H39.359C39.059 8.14001 38.834 8.29001 38.684 8.51501L34.784 14.215L33.134 8.74001C33.059 8.36501 32.684 8.14001 32.384 8.14001H29.609C29.309 8.14001 29.009 8.44001 29.159 8.81501L32.234 17.89L29.309 21.94C29.084 22.24 29.309 22.69 29.684 22.69H32.459C32.759 22.69 32.984 22.54 33.134 22.315L42.509 8.81501C42.734 8.59001 42.509 8.14001 42.134 8.14001Z" fill="#003087"/>
                                    <path d="M51.4345 2.73999H45.5845C45.2095 2.73999 44.8345 3.03999 44.7595 3.41499L42.4345 18.34C42.3595 18.64 42.5845 18.865 42.8845 18.865H45.8845C46.1845 18.865 46.4095 18.64 46.4095 18.415L47.0845 14.14C47.1595 13.765 47.4595 13.465 47.9095 13.465H49.7845C53.6095 13.465 55.8595 11.59 56.4595 7.91499C56.6845 6.33999 56.4595 5.06499 55.7095 4.16499C54.8095 3.26499 53.3845 2.73999 51.4345 2.73999ZM52.1095 8.21499C51.8095 10.315 50.1595 10.315 48.6595 10.315H47.7595L48.3595 6.41499C48.3595 6.18999 48.5845 6.03999 48.8095 6.03999H49.1845C50.2345 6.03999 51.2095 6.03999 51.7345 6.63999C52.1095 6.93999 52.1845 7.46499 52.1095 8.21499Z" fill="#009CDE"/>
                                    <path d="M68.8333 8.14001H66.0583C65.8333 8.14001 65.6083 8.29001 65.6083 8.51501L65.4583 9.26501L65.2333 8.96502C64.6333 8.06501 63.2833 7.76501 61.9333 7.76501C58.8583 7.76501 56.2333 10.09 55.7083 13.39C55.4083 15.04 55.7833 16.615 56.7583 17.665C57.5833 18.64 58.8583 19.09 60.2833 19.09C62.7583 19.09 64.1833 17.515 64.1833 17.515L64.0333 18.265C63.9583 18.565 64.1833 18.865 64.4833 18.865H67.0333C67.4083 18.865 67.7833 18.565 67.8583 18.19L69.3583 8.59001C69.3583 8.44001 69.1333 8.14001 68.8333 8.14001ZM64.9333 13.54C64.6333 15.115 63.4333 16.24 61.7833 16.24C60.9583 16.24 60.3583 16.015 59.9083 15.49C59.4583 14.965 59.3083 14.29 59.4583 13.54C59.6833 11.965 61.0333 10.84 62.6083 10.84C63.4333 10.84 64.0333 11.14 64.4833 11.59C64.9333 12.115 65.0833 12.79 64.9333 13.54Z" fill="#009CDE"/>
                                    <path d="M72.1333 3.11499L69.7333 18.34C69.6583 18.64 69.8833 18.865 70.1833 18.865H72.5833C72.9583 18.865 73.3333 18.565 73.4083 18.19L75.8083 3.26499C75.8833 2.96499 75.6583 2.73999 75.3583 2.73999H72.6583C72.3583 2.73999 72.2083 2.88999 72.1333 3.11499Z" fill="#009CDE"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_683_439">
                                        <rect width="75.75" height="24" fill="white" transform="translate(0.630859 0.640015)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </button>
                        <button class="common-payment--method--btn google-pay" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="59" height="25" viewBox="0 0 59 25" fill="none">
                                <g clip-path="url(#clip0_683_448)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M28.1252 4.36V10.1242H31.6801C32.5271 10.1242 33.2274 9.83906 33.7808 9.27012C34.3497 8.70259 34.6349 8.02495 34.6349 7.24142C34.6349 6.47342 34.3497 5.80424 33.7808 5.23389C33.2274 4.65083 32.5271 4.35859 31.6801 4.35859L28.1252 4.36ZM28.1252 12.1529V18.8391H26.002V2.3313H31.6349C33.065 2.3313 34.2791 2.80706 35.2801 3.76C36.2965 4.71295 36.8048 5.87342 36.8048 7.24142C36.8048 8.64048 36.2965 9.80942 35.2801 10.7454C34.2961 11.6842 33.0791 12.1515 31.6335 12.1515L28.1252 12.1529ZM38.9507 15.3817C38.9507 15.9351 39.185 16.3953 39.6551 16.7652C40.1238 17.1322 40.6744 17.3172 41.3041 17.3172C42.1977 17.3172 42.9925 16.9868 43.6928 16.3275C44.3944 15.6654 44.7431 14.8889 44.7431 13.9981C44.081 13.4758 43.1577 13.2146 41.9732 13.2146C41.1121 13.2146 40.3921 13.4235 39.8161 13.8386C39.2387 14.2537 38.9507 14.7661 38.9507 15.3817ZM41.698 7.17224C43.2678 7.17224 44.506 7.59153 45.4151 8.42871C46.3215 9.2673 46.7761 10.4165 46.7761 11.8762V18.8391H44.7445V17.272H44.6528C43.7747 18.5624 42.6057 19.2089 41.1431 19.2089C39.898 19.2089 38.8547 18.8391 38.0161 18.1021C37.1775 17.3638 36.7582 16.4419 36.7582 15.3351C36.7582 14.1661 37.2001 13.2372 38.0852 12.5454C38.9704 11.8537 40.1507 11.5078 41.6288 11.5078C42.8881 11.5078 43.9285 11.7379 44.7431 12.1995V11.7139C44.7431 10.9769 44.4509 10.3501 43.8664 9.83624C43.3033 9.3295 42.5698 9.05374 41.8123 9.064C40.6264 9.064 39.689 9.56236 38.9958 10.5633L37.1267 9.38589C38.1572 7.91059 39.682 7.17224 41.698 7.17224ZM58.4316 7.54212L51.3445 23.8198H49.1521L51.7836 18.1247L47.122 7.54212H49.4302L52.8001 15.6584H52.8452L56.1234 7.54071L58.4316 7.54212Z" fill="white"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5438 10.7116C19.5438 10.0438 19.4874 9.39861 19.3801 8.78308H10.4238V12.4367H15.5542C15.449 13.0205 15.2267 13.5769 14.9006 14.0724C14.5745 14.5679 14.1514 14.9921 13.6568 15.3196V17.6913H16.7189C18.5118 16.0396 19.5438 13.5972 19.5438 10.7116Z" fill="#4285F4"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4242 19.9812C12.9879 19.9812 15.1451 19.1412 16.7192 17.6927L13.6571 15.3195C12.8058 15.8927 11.7089 16.2273 10.4242 16.2273C7.94792 16.2273 5.84439 14.5586 5.09334 12.311H1.93945V14.7548C2.73065 16.3266 3.94294 17.6478 5.44111 18.5708C6.93929 19.4939 8.66444 19.9827 10.4242 19.9826" fill="#34A853"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.09386 12.3111C4.69767 11.1332 4.69767 9.85796 5.09386 8.68003V6.23627H1.93997C1.27324 7.55651 0.926486 9.0151 0.927738 10.4941C0.927738 12.0259 1.2948 13.473 1.93997 14.7534L5.09386 12.3097V12.3111Z" fill="#FABB05"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4247 4.76377C11.8252 4.76377 13.0788 5.24377 14.0671 6.18683V6.18824L16.7776 3.48048C15.1343 1.95012 12.9885 1.00989 10.4261 1.00989C8.66654 1.00965 6.94149 1.49819 5.44333 2.42102C3.94517 3.34384 2.7328 4.66468 1.94141 6.23624L5.09529 8.68001C5.84635 6.43248 7.94846 4.76377 10.4247 4.76377Z" fill="#E94235"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_683_448">
                                        <rect width="57.8824" height="24" fill="white" transform="translate(0.558594 0.640015)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </button>
                        <button class="common-payment--method--btn apple-pay" type="submit">
                            <svg fill="white" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" baseProfile="tiny" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 210.2" xml:space="preserve">
                        <path id="XMLID_34_" d="M93.6,27.1C87.6,34.2,78,39.8,68.4,39c-1.2-9.6,3.5-19.8,9-26.1c6-7.3,16.5-12.5,25-12.9  C103.4,10,99.5,19.8,93.6,27.1 M102.3,40.9c-13.9-0.8-25.8,7.9-32.4,7.9c-6.7,0-16.8-7.5-27.8-7.3c-14.3,0.2-27.6,8.3-34.9,21.2  c-15,25.8-3.9,64,10.6,85c7.1,10.4,15.6,21.8,26.8,21.4c10.6-0.4,14.8-6.9,27.6-6.9c12.9,0,16.6,6.9,27.8,6.7  c11.6-0.2,18.9-10.4,26-20.8c8.1-11.8,11.4-23.3,11.6-23.9c-0.2-0.2-22.4-8.7-22.6-34.3c-0.2-21.4,17.5-31.6,18.3-32.2  C123.3,42.9,107.7,41.3,102.3,40.9 M182.6,11.9v155.9h24.2v-53.3h33.5c30.6,0,52.1-21,52.1-51.4c0-30.4-21.1-51.2-51.3-51.2H182.6z   M206.8,32.3h27.9c21,0,33,11.2,33,30.9c0,19.7-12,31-33.1,31h-27.8V32.3z M336.6,169c15.2,0,29.3-7.7,35.7-19.9h0.5v18.7h22.4V90.2  c0-22.5-18-37-45.7-37c-25.7,0-44.7,14.7-45.4,34.9h21.8c1.8-9.6,10.7-15.9,22.9-15.9c14.8,0,23.1,6.9,23.1,19.6v8.6l-30.2,1.8  c-28.1,1.7-43.3,13.2-43.3,33.2C298.4,155.6,314.1,169,336.6,169z M343.1,150.5c-12.9,0-21.1-6.2-21.1-15.7c0-9.8,7.9-15.5,23-16.4  l26.9-1.7v8.8C371.9,140.1,359.5,150.5,343.1,150.5z M425.1,210.2c23.6,0,34.7-9,44.4-36.3L512,54.7h-24.6l-28.5,92.1h-0.5  l-28.5-92.1h-25.3l41,113.5l-2.2,6.9c-3.7,11.7-9.7,16.2-20.4,16.2c-1.9,0-5.6-0.2-7.1-0.4v18.7C417.3,210,423.3,210.2,425.1,210.2z  "/>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                        </svg>
                        </button>
                    </div>
                    {{--       or section         --}}
                    <div class="or-section">
                        <hr/>
                        <span>
                        Or
                    </span>
                    </div>
                    <!-- first one -->
                    <div class="checkout--contact--fieldset">

                        <div class="fieldset--header"><span class="checkout--fieldset--header-text" >Contact</span>
                            <p class="text--blue--underline--user">{{ Auth::user()->name }}</p>
                        </div>

                        <div class="checkout--single--input--wrapper">
                            <div class="input-container">
                                <input class="common--checkout--input" value="{{ Auth::user()->email }}" type="email" name="contact" id="email" placeholder="Email" required />
                                <label class="input-label" for="email">Email</label>
                            </div>
                            @if ($errors->has('contact'))
                                <p class="error--msg">{{ $errors->first('contact') }}</p>
                            @endif
                        </div>
                    </div>
                    <!-- second one -->
                    <div class="checkout--delivery--fieldset">
                        @if (Auth::user()->user_address)

                            <span class="checkout--fieldset--header-text">Delivery</span>

                            <div class="checkout--single--input--wrapper">
                                <select class="common--checkout--input country--error"  name="country_id" id="region" required >
                                    @if(Auth::user()->country_id)
                                        <option value="{{ Auth::user()->country_id }}" selected>
                                            {{ Auth::user()->country->country }}
                                        </option>
                                    @else
                                        <option value="">Choose Country</option>
                                    @endif
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country_id'))
                                    <p class="error--msg">{{ $errors->first('country_id') }}</p>
                                    <style>
                                        .common--checkout--input.country--error{
                                            border: 1px solid red;
                                        }
                                    </style>
                                @endif
                            </div>

                            @php
                                $userAddress = \Illuminate\Support\Facades\Auth::user()->user_address->first(); // Fetch the first address, if it exists
                            @endphp
                            <div class="common--two--field--wrapper">
                                <div class="contact--input--inner--wrapper">
                                    <div class="input-container">
                                        <input type="text" name="first_name" id="fname" value="{{ $userAddress->first_name }}" placeholder="First name (optional)" class="common--checkout--input" />
                                        <label class="input-label" for="fname">First Name</label>
                                    </div>
                                    @if ($errors->has('first_name'))
                                        <p class="error--msg">{{ $errors->first('first_name') }}</p>
                                    @endif
                                </div>
                                <div class="contact--input--inner--wrapper">
                                    <div class="input-container">
                                        <input type="text" name="last_name" id="lname" value="{{ $userAddress->last_name }}" placeholder="Last name" class="common--checkout--input" required />
                                        <label class="input-label" for="lname">Last Name</label>
                                    </div>
                                    @if ($errors->has('last_name'))
                                        <p class="error--msg">{{ $errors->first('last_name') }}</p>
                                    @endif
                                </div>
                            </div>

                            <div class="checkout--single--input--wrapper">
                                <div class="input-container">
                                    <input type="text" name="address" id="address" value="{{ $userAddress->address }}" placeholder="Address" class="common--checkout--input" required />
                                    <label class="input-label" for="address">Address</label>
                                </div>
                                @if ($errors->has('address'))
                                    <p class="error--msg">{{ $errors->first('address') }}</p>
                                @endif
                            </div>

                            <div class="checkout--single--input--wrapper">
                                <div class="input-container">
                                    <input type="text" name="apartment" id="apartment" value="{{ $userAddress->apartment }}" placeholder="Address" class="common--checkout--input" />
                                    <label class="input-label" for="apartment">Address</label>
                                </div>
                                @if ($errors->has('apartment'))
                                    <p class="error--msg">{{ $errors->first('apartment') }}</p>
                                @endif
                            </div>

                            <div class="common--two--field--wrapper">
                                <div class="contact--input--inner--wrapper">
                                    <div class="input-container">
                                        <input type="text" name="city" id="city" value="{{ $userAddress->city }}" placeholder="City" class="common--checkout--input" required />
                                        <label class="input-label" for="city">City</label>
                                    </div>
                                    @if ($errors->has('city'))
                                        <p class="error--msg">{{ $errors->first('city') }}</p>
                                    @endif
                                </div>
                                <div class="contact--input--inner--wrapper">
                                    <div class="input-container">
                                        <input type="text" name="postal_code" id="code" value="{{ $userAddress->postal_code }}" placeholder="Postal code (optional)" class="common--checkout--input" required />
                                        <label class="input-label" for="code">Postal Code</label>
                                    </div>
                                    @if ($errors->has('postal_code'))
                                        <p class="error--msg">{{ $errors->first('postal_code') }}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="common--checkbox--wrapper">
                                <input name="save-delivery" id="save-delivery" value="1" type="checkbox" class="common--checkbox" />
                                <label for="save-delivery" class="common--small--text--checkout">Save this information for next time</label>
                            </div>

                        @else

                            <span class="checkout--fieldset--header-text">Delivery</span>

                            <div class="checkout--single--input--wrapper">
                                <select class="common--checkout--input country--error" name="country_id" id="region" required >
                                    @if(Auth::user()->country_id)
                                        <option value="{{ Auth::user()->country_id }}" selected>
                                            {{ Auth::user()->country->country }}
                                        </option>
                                    @else
                                        <option value="">Choose Country</option>
                                    @endif
                                    @foreach ($countries as $country)
                                        <option value="{{ $country->id }}">{{ $country->country }}</option>
                                    @endforeach
                                </select>
                                @if ($errors->has('country_id'))
                                    <p class="error--msg">{{ $errors->first('country_id') }}</p>
                                    <style>
                                        .common--checkout--input.country--error{
                                            border: 1px solid red;
                                        }
                                    </style>
                                @endif
                            </div>

                            <div class="common--two--field--wrapper">

                                <div class="contact--input--inner--wrapper">
                                    <div class="input-container">
                                        <input type="text" name="first_name" id="fname" placeholder="First name (optional)" class="common--checkout--input" />
                                        <label class="input-label" for="fname">First Name</label>
                                    </div>
                                    @if ($errors->has('first_name'))
                                        <p class="error--msg">{{ $errors->first('first_name') }}</p>
                                    @endif
                                </div>
                                <div class="contact--input--inner--wrapper">
                                    <div class="input-container">
                                        <input type="text" name="last_name" id="lname" placeholder="Last name" class="common--checkout--input" required />
                                        <label class="input-label" for="lname">Last Name</label>
                                    </div>
                                    @if ($errors->has('last_name'))
                                        <p class="error--msg">{{ $errors->first('last_name') }}</p>
                                    @endif
                                </div>

                            </div>

                            <div class="checkout--single--input--wrapper" >
                                <div class="input-container">
                                    <input type="text" name="address" id="address" placeholder="Address" class="common--checkout--input" required  />
                                    <label class="input-label" for="address">Address</label>
                                </div>
                                @if ($errors->has('address'))
                                    <p class="error--msg">{{ $errors->first('address') }}</p>
                                @endif
                            </div>

                            <div class="checkout--single--input--wrapper" >
                                <div class="input-container">
                                    <input type="text" name="apartment" id="apartment" placeholder="Address" class="common--checkout--input" />
                                    <label class="input-label" for="apartment">Apartment</label>
                                </div>
                                @if ($errors->has('apartment'))
                                    <p class="error--msg">{{ $errors->first('apartment') }}</p>
                                @endif
                            </div>

                            <div class="common--two--field--wrapper">
                                <div class="contact--input--inner--wrapper">
                                    <div class="input-container">
                                        <input type="text" name="city" id="city" placeholder="City" class="common--checkout--input" required />
                                        <label class="input-label" for="city">City</label>
                                    </div>
                                    @if ($errors->has('city'))
                                        <p class="error--msg">{{ $errors->first('city') }}</p>
                                    @endif
                                </div>
                                <div  class="contact--input--inner--wrapper">
                                    <div class="input-container">
                                        <input type="text" name="postal_code" id="code" placeholder="Postal code (optional)" class="common--checkout--input" required />
                                        <label class="input-label" for="code">Postal Code</label>
                                    </div>
                                    @if ($errors->has('postal_code'))
                                        <p class="error--msg">{{ $errors->first('postal_code') }}</p>
                                    @endif
                                </div>

                            </div>
                            <div class="common--checkbox--wrapper">
                                <input name="save-delivery" id="save-delivery" value="1" type="checkbox" class="common--checkbox" />
                                <label for="save-delivery" class="common--small--text--checkout">Save this information for next time</label>
                            </div>

                        @endif
                    </div>

                    <!-- third one -->
                    <div class="shipping--method--fieldset">
                        <span class="checkout--fieldset--header-text">Shipping method</span>
                        <div class="shipping--method---box">

                            <div class="method--box--left">
                                <span>Free International Shipping</span>
                                <span class="common--small--text--checkout">8-16 Days Worldwide Delivery</span>
                            </div>
                            <span>FREE</span>

                        </div>
                    </div>

                    <!-- fourth one -->
                    <div class="payments--method--fieldset">
                        <p class="checkout--fieldset--header-text">Payment</p>
                        <p class="common--small--text--checkout">All transactions are secure and encrypted.</p>
                        <div class="payment--box">

                            <div class="accordion" id="payment_methods">
                                {{--                            stripe--}}

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <input id="stripe" type="radio" name="stripe" hidden  >
                                        <label for="stripe" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stipe_form"  aria-controls="stipe_form">
                                            <span class="payment-text">Stripe</span>

                                            <span class="payment--logo--in--accordion">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" style="enable-background:new 0 0 468 222.5;" xml:space="preserve" viewBox="54 36 360.02 149.84" fill="#635BFF">  <g> 	<path class="st0" d="M414,113.4c0-25.6-12.4-45.8-36.1-45.8c-23.8,0-38.2,20.2-38.2,45.6c0,30.1,17,45.3,41.4,45.3   c11.9,0,20.9-2.7,27.7-6.5v-20c-6.8,3.4-14.6,5.5-24.5,5.5c-9.7,0-18.3-3.4-19.4-15.2h48.9C413.8,121,414,115.8,414,113.4z    M364.6,103.9c0-11.3,6.9-16,13.2-16c6.1,0,12.6,4.7,12.6,16H364.6z"/> 	<path class="st0" d="M301.1,67.6c-9.8,0-16.1,4.6-19.6,7.8l-1.3-6.2h-22v116.6l25-5.3l0.1-28.3c3.6,2.6,8.9,6.3,17.7,6.3   c17.9,0,34.2-14.4,34.2-46.1C335.1,83.4,318.6,67.6,301.1,67.6z M295.1,136.5c-5.9,0-9.4-2.1-11.8-4.7l-0.1-37.1   c2.6-2.9,6.2-4.9,11.9-4.9c9.1,0,15.4,10.2,15.4,23.3C310.5,126.5,304.3,136.5,295.1,136.5z"/> 	<polygon class="st0" points="223.8,61.7 248.9,56.3 248.9,36 223.8,41.3  "/> 	<rect x="223.8" y="69.3" class="st0" width="25.1" height="87.5"/> 	<path class="st0" d="M196.9,76.7l-1.6-7.4h-21.6v87.5h25V97.5c5.9-7.7,15.9-6.3,19-5.2v-23C214.5,68.1,202.8,65.9,196.9,76.7z"/> 	<path class="st0" d="M146.9,47.6l-24.4,5.2l-0.1,80.1c0,14.8,11.1,25.7,25.9,25.7c8.2,0,14.2-1.5,17.5-3.3V135   c-3.2,1.3-19,5.9-19-8.9V90.6h19V69.3h-19L146.9,47.6z"/> 	<path class="st0" d="M79.3,94.7c0-3.9,3.2-5.4,8.5-5.4c7.6,0,17.2,2.3,24.8,6.4V72.2c-8.3-3.3-16.5-4.6-24.8-4.6   C67.5,67.6,54,78.2,54,95.9c0,27.6,38,23.2,38,35.1c0,4.6-4,6.1-9.6,6.1c-8.3,0-18.9-3.4-27.3-8v23.8c9.3,4,18.7,5.7,27.3,5.7   c20.8,0,35.1-10.3,35.1-28.2C117.4,100.6,79.3,105.9,79.3,94.7z"/> </g> </svg>
                                        </span>
                                        </label>
                                    </h2>
                                    <div id="stipe_form" class="accordion-collapse collapse" data-bs-parent="#payment_methods">
                                        <div class="accordion-body">
                                            <div class="checkout--payment--methods--form">
                                                <div class="checkout--single--input--wrapper">
                                                    <div class="input-container">
                                                        <input type="text" name="address" id="address" value="" placeholder="Address" class="common--checkout--input" required />
                                                        <label class="input-label" for="address">Address</label>
                                                    </div>
                                                    {{--                                            @if ($errors->has('address'))--}}
                                                    {{--                                                <p class="error--msg">{{ $errors->first('address') }}</p>--}}
                                                    {{--                                            @endif--}}
                                                </div>
                                                <div class="common--two--field--wrapper">
                                                    <div class="contact--input--inner--wrapper">
                                                        <div class="input-container">
                                                            <input type="text" name="first_name" id="fname" value="" placeholder="First name (optional)" class="common--checkout--input" />
                                                            <label class="input-label" for="fname">First Name</label>
                                                        </div>
                                                        {{--                                                @if ($errors->has('first_name'))--}}
                                                        {{--                                                    <p class="error--msg">{{ $errors->first('first_name') }}</p>--}}
                                                        {{--                                                @endif--}}
                                                    </div>
                                                    <div class="contact--input--inner--wrapper">
                                                        <div class="input-container">
                                                            <input type="text" name="last_name" id="lname" value="" placeholder="Last name" class="common--checkout--input" required />
                                                            <label class="input-label" for="lname">Last Name</label>
                                                        </div>
                                                        {{--                                                @if ($errors->has('last_name'))--}}
                                                        {{--                                                    <p class="error--msg">{{ $errors->first('last_name') }}</p>--}}
                                                        {{--                                                @endif--}}
                                                    </div>
                                                </div>
                                                <div class="checkout--single--input--wrapper">
                                                    <div class="input-container">
                                                        <input type="text" name="address" id="address" value="" placeholder="Address" class="common--checkout--input" required />
                                                        <label class="input-label" for="address">Address</label>
                                                    </div>
                                                    {{--                                            @if ($errors->has('address'))--}}
                                                    {{--                                                <p class="error--msg">{{ $errors->first('address') }}</p>--}}
                                                    {{--                                            @endif--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- paypal --}}

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <input id="paypal" type="radio" name="paypal" hidden  >
                                        <label for="paypal" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paypal_form"  aria-controls="paypal_form">
                                            <span class="payment-text">Paypal</span>

                                            <span class="payment--logo--in--accordion">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="77" height="25" viewBox="0 0 77 25" fill="none">
                            <g clip-path="url(#clip0_683_439)">
                                <path d="M9.80946 2.73999H3.95946C3.58446 2.73999 3.20946 3.03999 3.13446 3.41499L0.809458 18.415C0.734458 18.715 0.959458 18.94 1.25946 18.94H4.03446C4.40946 18.94 4.78446 18.64 4.85946 18.265L5.45946 14.215C5.53446 13.84 5.83446 13.54 6.28446 13.54H8.15946C11.9845 13.54 14.2345 11.665 14.8345 7.98999C15.0595 6.41499 14.8345 5.13999 14.0845 4.23999C13.2595 3.26499 11.7595 2.73999 9.80946 2.73999ZM10.4845 8.21499C10.1845 10.315 8.53446 10.315 7.03446 10.315H6.13446L6.73446 6.41499C6.73446 6.18999 6.95946 6.03999 7.18446 6.03999H7.55946C8.60946 6.03999 9.58446 6.03999 10.1095 6.63999C10.4845 6.93999 10.6345 7.46499 10.4845 8.21499Z" fill="#003087"/>
                                <path d="M27.2083 8.14001H24.4333C24.2083 8.14001 23.9833 8.29001 23.9833 8.51501L23.8333 9.26501L23.6083 8.96502C23.0083 8.06501 21.6583 7.76501 20.3083 7.76501C17.2333 7.76501 14.6083 10.09 14.0833 13.39C13.7833 15.04 14.1583 16.615 15.1333 17.665C15.9583 18.64 17.2333 19.09 18.6583 19.09C21.1333 19.09 22.5583 17.515 22.5583 17.515L22.4083 18.265C22.3333 18.565 22.5583 18.865 22.8583 18.865H25.4083C25.7833 18.865 26.1583 18.565 26.2333 18.19L27.7333 8.59001C27.8083 8.44001 27.5083 8.14001 27.2083 8.14001ZM23.3833 13.54C23.0833 15.115 21.8833 16.24 20.2333 16.24C19.4083 16.24 18.8083 16.015 18.3583 15.49C17.9083 14.965 17.7583 14.29 17.9083 13.54C18.1333 11.965 19.4833 10.84 21.0583 10.84C21.8833 10.84 22.4833 11.14 22.9333 11.59C23.3083 12.115 23.4583 12.79 23.3833 13.54Z" fill="#003087"/>
                                <path d="M42.134 8.14001H39.359C39.059 8.14001 38.834 8.29001 38.684 8.51501L34.784 14.215L33.134 8.74001C33.059 8.36501 32.684 8.14001 32.384 8.14001H29.609C29.309 8.14001 29.009 8.44001 29.159 8.81501L32.234 17.89L29.309 21.94C29.084 22.24 29.309 22.69 29.684 22.69H32.459C32.759 22.69 32.984 22.54 33.134 22.315L42.509 8.81501C42.734 8.59001 42.509 8.14001 42.134 8.14001Z" fill="#003087"/>
                                <path d="M51.4345 2.73999H45.5845C45.2095 2.73999 44.8345 3.03999 44.7595 3.41499L42.4345 18.34C42.3595 18.64 42.5845 18.865 42.8845 18.865H45.8845C46.1845 18.865 46.4095 18.64 46.4095 18.415L47.0845 14.14C47.1595 13.765 47.4595 13.465 47.9095 13.465H49.7845C53.6095 13.465 55.8595 11.59 56.4595 7.91499C56.6845 6.33999 56.4595 5.06499 55.7095 4.16499C54.8095 3.26499 53.3845 2.73999 51.4345 2.73999ZM52.1095 8.21499C51.8095 10.315 50.1595 10.315 48.6595 10.315H47.7595L48.3595 6.41499C48.3595 6.18999 48.5845 6.03999 48.8095 6.03999H49.1845C50.2345 6.03999 51.2095 6.03999 51.7345 6.63999C52.1095 6.93999 52.1845 7.46499 52.1095 8.21499Z" fill="#009CDE"/>
                                <path d="M68.8333 8.14001H66.0583C65.8333 8.14001 65.6083 8.29001 65.6083 8.51501L65.4583 9.26501L65.2333 8.96502C64.6333 8.06501 63.2833 7.76501 61.9333 7.76501C58.8583 7.76501 56.2333 10.09 55.7083 13.39C55.4083 15.04 55.7833 16.615 56.7583 17.665C57.5833 18.64 58.8583 19.09 60.2833 19.09C62.7583 19.09 64.1833 17.515 64.1833 17.515L64.0333 18.265C63.9583 18.565 64.1833 18.865 64.4833 18.865H67.0333C67.4083 18.865 67.7833 18.565 67.8583 18.19L69.3583 8.59001C69.3583 8.44001 69.1333 8.14001 68.8333 8.14001ZM64.9333 13.54C64.6333 15.115 63.4333 16.24 61.7833 16.24C60.9583 16.24 60.3583 16.015 59.9083 15.49C59.4583 14.965 59.3083 14.29 59.4583 13.54C59.6833 11.965 61.0333 10.84 62.6083 10.84C63.4333 10.84 64.0333 11.14 64.4833 11.59C64.9333 12.115 65.0833 12.79 64.9333 13.54Z" fill="#009CDE"/>
                                <path d="M72.1333 3.11499L69.7333 18.34C69.6583 18.64 69.8833 18.865 70.1833 18.865H72.5833C72.9583 18.865 73.3333 18.565 73.4083 18.19L75.8083 3.26499C75.8833 2.96499 75.6583 2.73999 75.3583 2.73999H72.6583C72.3583 2.73999 72.2083 2.88999 72.1333 3.11499Z" fill="#009CDE"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_683_439">
                                    <rect width="75.75" height="24" fill="white" transform="translate(0.630859 0.640015)"/>
                                </clipPath>
                            </defs>
                        </svg>
                                        </span>
                                        </label>
                                    </h2>
                                    <div id="paypal_form" class="accordion-collapse collapse" data-bs-parent="#payment_methods">
                                        <div class="accordion-body">
                                            <div class="payment--redirect--section">
                                                <div class="payment--redirect--img">
                                                    <img src="{{ asset('/frontend/assets/images/redirect__img.svg') }}" alt="" >
                                                </div>
                                                <span class="payment-text">After clicking "Pay with PayPal", you will be redirected to PayPal to complete your purchase securely.</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--Gpay--}}
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <input id="gpay" type="radio" name="gpay" hidden  >
                                        <label for="gpay" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#gpay_form"  aria-controls="gpay_form">
                                            <span class="payment-text">Gpay</span>

                                            <span class="payment--logo--in--accordion">
                                          <svg xmlns="http://www.w3.org/2000/svg" width="59" height="25" viewBox="0 0 59 25" fill="none">
                            <g clip-path="url(#clip0_683_448)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M28.1252 4.36V10.1242H31.6801C32.5271 10.1242 33.2274 9.83906 33.7808 9.27012C34.3497 8.70259 34.6349 8.02495 34.6349 7.24142C34.6349 6.47342 34.3497 5.80424 33.7808 5.23389C33.2274 4.65083 32.5271 4.35859 31.6801 4.35859L28.1252 4.36ZM28.1252 12.1529V18.8391H26.002V2.3313H31.6349C33.065 2.3313 34.2791 2.80706 35.2801 3.76C36.2965 4.71295 36.8048 5.87342 36.8048 7.24142C36.8048 8.64048 36.2965 9.80942 35.2801 10.7454C34.2961 11.6842 33.0791 12.1515 31.6335 12.1515L28.1252 12.1529ZM38.9507 15.3817C38.9507 15.9351 39.185 16.3953 39.6551 16.7652C40.1238 17.1322 40.6744 17.3172 41.3041 17.3172C42.1977 17.3172 42.9925 16.9868 43.6928 16.3275C44.3944 15.6654 44.7431 14.8889 44.7431 13.9981C44.081 13.4758 43.1577 13.2146 41.9732 13.2146C41.1121 13.2146 40.3921 13.4235 39.8161 13.8386C39.2387 14.2537 38.9507 14.7661 38.9507 15.3817ZM41.698 7.17224C43.2678 7.17224 44.506 7.59153 45.4151 8.42871C46.3215 9.2673 46.7761 10.4165 46.7761 11.8762V18.8391H44.7445V17.272H44.6528C43.7747 18.5624 42.6057 19.2089 41.1431 19.2089C39.898 19.2089 38.8547 18.8391 38.0161 18.1021C37.1775 17.3638 36.7582 16.4419 36.7582 15.3351C36.7582 14.1661 37.2001 13.2372 38.0852 12.5454C38.9704 11.8537 40.1507 11.5078 41.6288 11.5078C42.8881 11.5078 43.9285 11.7379 44.7431 12.1995V11.7139C44.7431 10.9769 44.4509 10.3501 43.8664 9.83624C43.3033 9.3295 42.5698 9.05374 41.8123 9.064C40.6264 9.064 39.689 9.56236 38.9958 10.5633L37.1267 9.38589C38.1572 7.91059 39.682 7.17224 41.698 7.17224ZM58.4316 7.54212L51.3445 23.8198H49.1521L51.7836 18.1247L47.122 7.54212H49.4302L52.8001 15.6584H52.8452L56.1234 7.54071L58.4316 7.54212Z" fill="black"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5438 10.7116C19.5438 10.0438 19.4874 9.39861 19.3801 8.78308H10.4238V12.4367H15.5542C15.449 13.0205 15.2267 13.5769 14.9006 14.0724C14.5745 14.5679 14.1514 14.9921 13.6568 15.3196V17.6913H16.7189C18.5118 16.0396 19.5438 13.5972 19.5438 10.7116Z" fill="#4285F4"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4242 19.9812C12.9879 19.9812 15.1451 19.1412 16.7192 17.6927L13.6571 15.3195C12.8058 15.8927 11.7089 16.2273 10.4242 16.2273C7.94792 16.2273 5.84439 14.5586 5.09334 12.311H1.93945V14.7548C2.73065 16.3266 3.94294 17.6478 5.44111 18.5708C6.93929 19.4939 8.66444 19.9827 10.4242 19.9826" fill="#34A853"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M5.09386 12.3111C4.69767 11.1332 4.69767 9.85796 5.09386 8.68003V6.23627H1.93997C1.27324 7.55651 0.926486 9.0151 0.927738 10.4941C0.927738 12.0259 1.2948 13.473 1.93997 14.7534L5.09386 12.3097V12.3111Z" fill="#FABB05"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4247 4.76377C11.8252 4.76377 13.0788 5.24377 14.0671 6.18683V6.18824L16.7776 3.48048C15.1343 1.95012 12.9885 1.00989 10.4261 1.00989C8.66654 1.00965 6.94149 1.49819 5.44333 2.42102C3.94517 3.34384 2.7328 4.66468 1.94141 6.23624L5.09529 8.68001C5.84635 6.43248 7.94846 4.76377 10.4247 4.76377Z" fill="#E94235"/>
                            </g>
                            <defs>
                                <clipPath id="clip0_683_448">
                                    <rect width="57.8824" height="24" fill="white" transform="translate(0.558594 0.640015)"/>
                                </clipPath>
                            </defs>
                        </svg>
                                        </span>
                                        </label>
                                    </h2>
                                    <div id="gpay_form" class="accordion-collapse collapse" data-bs-parent="#payment_methods">
                                        <div class="accordion-body">
                                            <div class="payment--redirect--section">
                                                <div class="payment--redirect--img">
                                                    <img src="{{ asset('/frontend/assets/images/redirect__img.svg') }}" alt="" >
                                                </div>
                                                <span class="payment-text">After clicking "Pay with PayPal", you will be redirected to PayPal to complete your purchase securely.</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--Applepay--}}
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <input id="apple_pay" type="radio" name="apple_pay" hidden  >
                                        <label for="apple_pay" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#apple_pay_form"  aria-controls="apple_pay_form">
                                            <span class="payment-text">Apple Pay</span>

                                            <span class="payment--logo--in--accordion">
                                           <svg fill="black" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" baseProfile="tiny" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 210.2" xml:space="preserve">
<path id="XMLID_34_" d="M93.6,27.1C87.6,34.2,78,39.8,68.4,39c-1.2-9.6,3.5-19.8,9-26.1c6-7.3,16.5-12.5,25-12.9  C103.4,10,99.5,19.8,93.6,27.1 M102.3,40.9c-13.9-0.8-25.8,7.9-32.4,7.9c-6.7,0-16.8-7.5-27.8-7.3c-14.3,0.2-27.6,8.3-34.9,21.2  c-15,25.8-3.9,64,10.6,85c7.1,10.4,15.6,21.8,26.8,21.4c10.6-0.4,14.8-6.9,27.6-6.9c12.9,0,16.6,6.9,27.8,6.7  c11.6-0.2,18.9-10.4,26-20.8c8.1-11.8,11.4-23.3,11.6-23.9c-0.2-0.2-22.4-8.7-22.6-34.3c-0.2-21.4,17.5-31.6,18.3-32.2  C123.3,42.9,107.7,41.3,102.3,40.9 M182.6,11.9v155.9h24.2v-53.3h33.5c30.6,0,52.1-21,52.1-51.4c0-30.4-21.1-51.2-51.3-51.2H182.6z   M206.8,32.3h27.9c21,0,33,11.2,33,30.9c0,19.7-12,31-33.1,31h-27.8V32.3z M336.6,169c15.2,0,29.3-7.7,35.7-19.9h0.5v18.7h22.4V90.2  c0-22.5-18-37-45.7-37c-25.7,0-44.7,14.7-45.4,34.9h21.8c1.8-9.6,10.7-15.9,22.9-15.9c14.8,0,23.1,6.9,23.1,19.6v8.6l-30.2,1.8  c-28.1,1.7-43.3,13.2-43.3,33.2C298.4,155.6,314.1,169,336.6,169z M343.1,150.5c-12.9,0-21.1-6.2-21.1-15.7c0-9.8,7.9-15.5,23-16.4  l26.9-1.7v8.8C371.9,140.1,359.5,150.5,343.1,150.5z M425.1,210.2c23.6,0,34.7-9,44.4-36.3L512,54.7h-24.6l-28.5,92.1h-0.5  l-28.5-92.1h-25.3l41,113.5l-2.2,6.9c-3.7,11.7-9.7,16.2-20.4,16.2c-1.9,0-5.6-0.2-7.1-0.4v18.7C417.3,210,423.3,210.2,425.1,210.2z  "/>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
                            <g>
                            </g>
</svg>
                                        </span>
                                        </label>
                                    </h2>
                                    <div id="apple_pay_form" class="accordion-collapse collapse" data-bs-parent="#payment_methods">
                                        <div class="accordion-body">
                                            <div class="payment--redirect--section">
                                                <div class="payment--redirect--img">
                                                    <img src="{{ asset('/frontend/assets/images/redirect__img.svg') }}" alt="" >
                                                </div>
                                                <span class="payment-text">After clicking "Pay with PayPal", you will be redirected to PayPal to complete your purchase securely.</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>


                            </div>



















































                            {{--                        <div class="payment--row">--}}
                            {{--                            <input class="common-payment--input" type="radio" name="method" id="paypal" value="paypal" required>--}}
                            {{--                            <label class="common-payment--label" for="paypal">--}}
                            {{--                                <span class="payment-text">PayPal</span>--}}
                            {{--                                <span class="payment--logo">--}}
                            {{--                                    <img src="{{ asset('/frontend/assets/images/paypal.svg') }}" alt="PayPal">--}}
                            {{--                                </span>--}}
                            {{--                            </label>--}}
                            {{--                        </div>--}}

                            {{--                        <div class="payment--row">--}}
                            {{--                            <input class="common-payment--input" type="radio" name="method" id="stripe" value="stripe" required>--}}
                            {{--                            <label class="common-payment--label" for="stripe">--}}
                            {{--                                <span class="payment-text">Stripe</span>--}}
                            {{--                                <span class="payment--logo">--}}
                            {{--                                     <img src="{{ asset('/frontend/assets/images/stripe.png') }}" alt="Stripe">--}}
                            {{--                                </span>--}}

                            {{--                            </label>--}}
                            {{--                        </div>--}}

                            {{--                        <div class="payment--row">--}}
                            {{--                            <input class="common-payment--input" type="radio" name="method" id="apple-pay" value="apple-pay" required>--}}
                            {{--                            <label class="common-payment--label" for="apple-pay">--}}
                            {{--                                <span class="payment-text">Apple pay</span>--}}
                            {{--                                <span class="payment--logo">--}}
                            {{--                                <img src="{{ asset('/frontend/assets/images/apple-pay.svg') }}" alt="apple-pay">--}}
                            {{--                                </span>--}}
                            {{--                            </label>--}}
                            {{--                        </div>--}}


                            {{--                        <div class="payment--row">--}}
                            {{--                            <input class="common-payment--input" type="radio" name="method" id="google-pay" value="google-pay" required>--}}
                            {{--                            <label class="common-payment--label" for="google-pay">--}}
                            {{--                                <span class="payment-text">Google Pay</span>--}}
                            {{--                                <span class="payment--logo">--}}
                            {{--                                <img src="{{ asset('/frontend/assets/images/dark_gpay.svg') }}" alt="google-pay">--}}
                            {{--                                </span>--}}
                            {{--                            </label>--}}
                            {{--                        </div>--}}

                        </div>




                        <button class="pay---btn" id="pay-now-btn" type="submit" as="button">Pay Now</button>
                        <hr>
                        @foreach ($dynamic_pages as $page)
                            <a class="text--blue--underline"
                               href="{{ route('dynamic.page', $page->page_slug) }}">{{ $page->page_title }}</a>
                        @endforeach
                    </div>

                </form>
            @else
                <form action="{{ route('order.new.guest') }}" id="checkout-form" method="POST" class="checkout--from--wrapper">
                    @csrf
                    @method('POST')

                    <input type="hidden" name="user_id" value="">
                    {{--                buttons wrapper --}}
                    <div class="payment--methods--button--wrapper">
                        <button class="common-payment--method--btn stripe " type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="white" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" style="enable-background:new 0 0 468 222.5;" xml:space="preserve" viewBox="54 36 360.02 149.84">  <g> 	<path class="st0" d="M414,113.4c0-25.6-12.4-45.8-36.1-45.8c-23.8,0-38.2,20.2-38.2,45.6c0,30.1,17,45.3,41.4,45.3   c11.9,0,20.9-2.7,27.7-6.5v-20c-6.8,3.4-14.6,5.5-24.5,5.5c-9.7,0-18.3-3.4-19.4-15.2h48.9C413.8,121,414,115.8,414,113.4z    M364.6,103.9c0-11.3,6.9-16,13.2-16c6.1,0,12.6,4.7,12.6,16H364.6z"/> 	<path class="st0" d="M301.1,67.6c-9.8,0-16.1,4.6-19.6,7.8l-1.3-6.2h-22v116.6l25-5.3l0.1-28.3c3.6,2.6,8.9,6.3,17.7,6.3   c17.9,0,34.2-14.4,34.2-46.1C335.1,83.4,318.6,67.6,301.1,67.6z M295.1,136.5c-5.9,0-9.4-2.1-11.8-4.7l-0.1-37.1   c2.6-2.9,6.2-4.9,11.9-4.9c9.1,0,15.4,10.2,15.4,23.3C310.5,126.5,304.3,136.5,295.1,136.5z"/> 	<polygon class="st0" points="223.8,61.7 248.9,56.3 248.9,36 223.8,41.3  "/> 	<rect x="223.8" y="69.3" class="st0" width="25.1" height="87.5"/> 	<path class="st0" d="M196.9,76.7l-1.6-7.4h-21.6v87.5h25V97.5c5.9-7.7,15.9-6.3,19-5.2v-23C214.5,68.1,202.8,65.9,196.9,76.7z"/> 	<path class="st0" d="M146.9,47.6l-24.4,5.2l-0.1,80.1c0,14.8,11.1,25.7,25.9,25.7c8.2,0,14.2-1.5,17.5-3.3V135   c-3.2,1.3-19,5.9-19-8.9V90.6h19V69.3h-19L146.9,47.6z"/> 	<path class="st0" d="M79.3,94.7c0-3.9,3.2-5.4,8.5-5.4c7.6,0,17.2,2.3,24.8,6.4V72.2c-8.3-3.3-16.5-4.6-24.8-4.6   C67.5,67.6,54,78.2,54,95.9c0,27.6,38,23.2,38,35.1c0,4.6-4,6.1-9.6,6.1c-8.3,0-18.9-3.4-27.3-8v23.8c9.3,4,18.7,5.7,27.3,5.7   c20.8,0,35.1-10.3,35.1-28.2C117.4,100.6,79.3,105.9,79.3,94.7z"/> </g> </svg>
                        </button>
                        <button class="common-payment--method--btn paypal" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="77" height="25" viewBox="0 0 77 25" fill="none">
                                <g clip-path="url(#clip0_683_439)">
                                    <path d="M9.80946 2.73999H3.95946C3.58446 2.73999 3.20946 3.03999 3.13446 3.41499L0.809458 18.415C0.734458 18.715 0.959458 18.94 1.25946 18.94H4.03446C4.40946 18.94 4.78446 18.64 4.85946 18.265L5.45946 14.215C5.53446 13.84 5.83446 13.54 6.28446 13.54H8.15946C11.9845 13.54 14.2345 11.665 14.8345 7.98999C15.0595 6.41499 14.8345 5.13999 14.0845 4.23999C13.2595 3.26499 11.7595 2.73999 9.80946 2.73999ZM10.4845 8.21499C10.1845 10.315 8.53446 10.315 7.03446 10.315H6.13446L6.73446 6.41499C6.73446 6.18999 6.95946 6.03999 7.18446 6.03999H7.55946C8.60946 6.03999 9.58446 6.03999 10.1095 6.63999C10.4845 6.93999 10.6345 7.46499 10.4845 8.21499Z" fill="#003087"/>
                                    <path d="M27.2083 8.14001H24.4333C24.2083 8.14001 23.9833 8.29001 23.9833 8.51501L23.8333 9.26501L23.6083 8.96502C23.0083 8.06501 21.6583 7.76501 20.3083 7.76501C17.2333 7.76501 14.6083 10.09 14.0833 13.39C13.7833 15.04 14.1583 16.615 15.1333 17.665C15.9583 18.64 17.2333 19.09 18.6583 19.09C21.1333 19.09 22.5583 17.515 22.5583 17.515L22.4083 18.265C22.3333 18.565 22.5583 18.865 22.8583 18.865H25.4083C25.7833 18.865 26.1583 18.565 26.2333 18.19L27.7333 8.59001C27.8083 8.44001 27.5083 8.14001 27.2083 8.14001ZM23.3833 13.54C23.0833 15.115 21.8833 16.24 20.2333 16.24C19.4083 16.24 18.8083 16.015 18.3583 15.49C17.9083 14.965 17.7583 14.29 17.9083 13.54C18.1333 11.965 19.4833 10.84 21.0583 10.84C21.8833 10.84 22.4833 11.14 22.9333 11.59C23.3083 12.115 23.4583 12.79 23.3833 13.54Z" fill="#003087"/>
                                    <path d="M42.134 8.14001H39.359C39.059 8.14001 38.834 8.29001 38.684 8.51501L34.784 14.215L33.134 8.74001C33.059 8.36501 32.684 8.14001 32.384 8.14001H29.609C29.309 8.14001 29.009 8.44001 29.159 8.81501L32.234 17.89L29.309 21.94C29.084 22.24 29.309 22.69 29.684 22.69H32.459C32.759 22.69 32.984 22.54 33.134 22.315L42.509 8.81501C42.734 8.59001 42.509 8.14001 42.134 8.14001Z" fill="#003087"/>
                                    <path d="M51.4345 2.73999H45.5845C45.2095 2.73999 44.8345 3.03999 44.7595 3.41499L42.4345 18.34C42.3595 18.64 42.5845 18.865 42.8845 18.865H45.8845C46.1845 18.865 46.4095 18.64 46.4095 18.415L47.0845 14.14C47.1595 13.765 47.4595 13.465 47.9095 13.465H49.7845C53.6095 13.465 55.8595 11.59 56.4595 7.91499C56.6845 6.33999 56.4595 5.06499 55.7095 4.16499C54.8095 3.26499 53.3845 2.73999 51.4345 2.73999ZM52.1095 8.21499C51.8095 10.315 50.1595 10.315 48.6595 10.315H47.7595L48.3595 6.41499C48.3595 6.18999 48.5845 6.03999 48.8095 6.03999H49.1845C50.2345 6.03999 51.2095 6.03999 51.7345 6.63999C52.1095 6.93999 52.1845 7.46499 52.1095 8.21499Z" fill="#009CDE"/>
                                    <path d="M68.8333 8.14001H66.0583C65.8333 8.14001 65.6083 8.29001 65.6083 8.51501L65.4583 9.26501L65.2333 8.96502C64.6333 8.06501 63.2833 7.76501 61.9333 7.76501C58.8583 7.76501 56.2333 10.09 55.7083 13.39C55.4083 15.04 55.7833 16.615 56.7583 17.665C57.5833 18.64 58.8583 19.09 60.2833 19.09C62.7583 19.09 64.1833 17.515 64.1833 17.515L64.0333 18.265C63.9583 18.565 64.1833 18.865 64.4833 18.865H67.0333C67.4083 18.865 67.7833 18.565 67.8583 18.19L69.3583 8.59001C69.3583 8.44001 69.1333 8.14001 68.8333 8.14001ZM64.9333 13.54C64.6333 15.115 63.4333 16.24 61.7833 16.24C60.9583 16.24 60.3583 16.015 59.9083 15.49C59.4583 14.965 59.3083 14.29 59.4583 13.54C59.6833 11.965 61.0333 10.84 62.6083 10.84C63.4333 10.84 64.0333 11.14 64.4833 11.59C64.9333 12.115 65.0833 12.79 64.9333 13.54Z" fill="#009CDE"/>
                                    <path d="M72.1333 3.11499L69.7333 18.34C69.6583 18.64 69.8833 18.865 70.1833 18.865H72.5833C72.9583 18.865 73.3333 18.565 73.4083 18.19L75.8083 3.26499C75.8833 2.96499 75.6583 2.73999 75.3583 2.73999H72.6583C72.3583 2.73999 72.2083 2.88999 72.1333 3.11499Z" fill="#009CDE"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_683_439">
                                        <rect width="75.75" height="24" fill="white" transform="translate(0.630859 0.640015)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </button>
                        <button class="common-payment--method--btn google-pay" type="submit">
                            <svg xmlns="http://www.w3.org/2000/svg" width="59" height="25" viewBox="0 0 59 25" fill="none">
                                <g clip-path="url(#clip0_683_448)">
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M28.1252 4.36V10.1242H31.6801C32.5271 10.1242 33.2274 9.83906 33.7808 9.27012C34.3497 8.70259 34.6349 8.02495 34.6349 7.24142C34.6349 6.47342 34.3497 5.80424 33.7808 5.23389C33.2274 4.65083 32.5271 4.35859 31.6801 4.35859L28.1252 4.36ZM28.1252 12.1529V18.8391H26.002V2.3313H31.6349C33.065 2.3313 34.2791 2.80706 35.2801 3.76C36.2965 4.71295 36.8048 5.87342 36.8048 7.24142C36.8048 8.64048 36.2965 9.80942 35.2801 10.7454C34.2961 11.6842 33.0791 12.1515 31.6335 12.1515L28.1252 12.1529ZM38.9507 15.3817C38.9507 15.9351 39.185 16.3953 39.6551 16.7652C40.1238 17.1322 40.6744 17.3172 41.3041 17.3172C42.1977 17.3172 42.9925 16.9868 43.6928 16.3275C44.3944 15.6654 44.7431 14.8889 44.7431 13.9981C44.081 13.4758 43.1577 13.2146 41.9732 13.2146C41.1121 13.2146 40.3921 13.4235 39.8161 13.8386C39.2387 14.2537 38.9507 14.7661 38.9507 15.3817ZM41.698 7.17224C43.2678 7.17224 44.506 7.59153 45.4151 8.42871C46.3215 9.2673 46.7761 10.4165 46.7761 11.8762V18.8391H44.7445V17.272H44.6528C43.7747 18.5624 42.6057 19.2089 41.1431 19.2089C39.898 19.2089 38.8547 18.8391 38.0161 18.1021C37.1775 17.3638 36.7582 16.4419 36.7582 15.3351C36.7582 14.1661 37.2001 13.2372 38.0852 12.5454C38.9704 11.8537 40.1507 11.5078 41.6288 11.5078C42.8881 11.5078 43.9285 11.7379 44.7431 12.1995V11.7139C44.7431 10.9769 44.4509 10.3501 43.8664 9.83624C43.3033 9.3295 42.5698 9.05374 41.8123 9.064C40.6264 9.064 39.689 9.56236 38.9958 10.5633L37.1267 9.38589C38.1572 7.91059 39.682 7.17224 41.698 7.17224ZM58.4316 7.54212L51.3445 23.8198H49.1521L51.7836 18.1247L47.122 7.54212H49.4302L52.8001 15.6584H52.8452L56.1234 7.54071L58.4316 7.54212Z" fill="white"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5438 10.7116C19.5438 10.0438 19.4874 9.39861 19.3801 8.78308H10.4238V12.4367H15.5542C15.449 13.0205 15.2267 13.5769 14.9006 14.0724C14.5745 14.5679 14.1514 14.9921 13.6568 15.3196V17.6913H16.7189C18.5118 16.0396 19.5438 13.5972 19.5438 10.7116Z" fill="#4285F4"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4242 19.9812C12.9879 19.9812 15.1451 19.1412 16.7192 17.6927L13.6571 15.3195C12.8058 15.8927 11.7089 16.2273 10.4242 16.2273C7.94792 16.2273 5.84439 14.5586 5.09334 12.311H1.93945V14.7548C2.73065 16.3266 3.94294 17.6478 5.44111 18.5708C6.93929 19.4939 8.66444 19.9827 10.4242 19.9826" fill="#34A853"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.09386 12.3111C4.69767 11.1332 4.69767 9.85796 5.09386 8.68003V6.23627H1.93997C1.27324 7.55651 0.926486 9.0151 0.927738 10.4941C0.927738 12.0259 1.2948 13.473 1.93997 14.7534L5.09386 12.3097V12.3111Z" fill="#FABB05"/>
                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4247 4.76377C11.8252 4.76377 13.0788 5.24377 14.0671 6.18683V6.18824L16.7776 3.48048C15.1343 1.95012 12.9885 1.00989 10.4261 1.00989C8.66654 1.00965 6.94149 1.49819 5.44333 2.42102C3.94517 3.34384 2.7328 4.66468 1.94141 6.23624L5.09529 8.68001C5.84635 6.43248 7.94846 4.76377 10.4247 4.76377Z" fill="#E94235"/>
                                </g>
                                <defs>
                                    <clipPath id="clip0_683_448">
                                        <rect width="57.8824" height="24" fill="white" transform="translate(0.558594 0.640015)"/>
                                    </clipPath>
                                </defs>
                            </svg>
                        </button>
                        <button class="common-payment--method--btn apple-pay" type="submit">
                            <svg fill="white" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" baseProfile="tiny" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 210.2" xml:space="preserve">
                        <path id="XMLID_34_" d="M93.6,27.1C87.6,34.2,78,39.8,68.4,39c-1.2-9.6,3.5-19.8,9-26.1c6-7.3,16.5-12.5,25-12.9  C103.4,10,99.5,19.8,93.6,27.1 M102.3,40.9c-13.9-0.8-25.8,7.9-32.4,7.9c-6.7,0-16.8-7.5-27.8-7.3c-14.3,0.2-27.6,8.3-34.9,21.2  c-15,25.8-3.9,64,10.6,85c7.1,10.4,15.6,21.8,26.8,21.4c10.6-0.4,14.8-6.9,27.6-6.9c12.9,0,16.6,6.9,27.8,6.7  c11.6-0.2,18.9-10.4,26-20.8c8.1-11.8,11.4-23.3,11.6-23.9c-0.2-0.2-22.4-8.7-22.6-34.3c-0.2-21.4,17.5-31.6,18.3-32.2  C123.3,42.9,107.7,41.3,102.3,40.9 M182.6,11.9v155.9h24.2v-53.3h33.5c30.6,0,52.1-21,52.1-51.4c0-30.4-21.1-51.2-51.3-51.2H182.6z   M206.8,32.3h27.9c21,0,33,11.2,33,30.9c0,19.7-12,31-33.1,31h-27.8V32.3z M336.6,169c15.2,0,29.3-7.7,35.7-19.9h0.5v18.7h22.4V90.2  c0-22.5-18-37-45.7-37c-25.7,0-44.7,14.7-45.4,34.9h21.8c1.8-9.6,10.7-15.9,22.9-15.9c14.8,0,23.1,6.9,23.1,19.6v8.6l-30.2,1.8  c-28.1,1.7-43.3,13.2-43.3,33.2C298.4,155.6,314.1,169,336.6,169z M343.1,150.5c-12.9,0-21.1-6.2-21.1-15.7c0-9.8,7.9-15.5,23-16.4  l26.9-1.7v8.8C371.9,140.1,359.5,150.5,343.1,150.5z M425.1,210.2c23.6,0,34.7-9,44.4-36.3L512,54.7h-24.6l-28.5,92.1h-0.5  l-28.5-92.1h-25.3l41,113.5l-2.2,6.9c-3.7,11.7-9.7,16.2-20.4,16.2c-1.9,0-5.6-0.2-7.1-0.4v18.7C417.3,210,423.3,210.2,425.1,210.2z  "/>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                                <g>
                                </g>
                        </svg>
                        </button>
                    </div>
                    {{--       or section         --}}
                    <div class="or-section">
                        <hr/>
                        <span>
                        Or
                    </span>
                    </div>
                    <!-- first one -->
                    <div class="checkout--contact--fieldset">

                        <div class="fieldset--header"><span class="checkout--fieldset--header-text" >Contact</span>
                            <a class="text--blue--underline" data-bs-toggle="modal" data-bs-target="#create-login-modal">Log in</a>
                        </div>

                        <div class="checkout--single--input--wrapper">
                            <div class="input-container">
                                <input class="common--checkout--input" value="" type="email" name="contact" id="email" placeholder="Email" required />
                                <label class="input-label" for="email">Email</label>
                            </div>
                            @if ($errors->has('contact'))
                                <p class="error--msg">{{ $errors->first('contact') }}</p>
                            @endif
                        </div>
                    </div>
                    <!-- second one -->
                    <div class="checkout--delivery--fieldset">

                        <span class="checkout--fieldset--header-text">Delivery</span>

                        <div class="checkout--single--input--wrapper">
                            <select class="common--checkout--input country--error" name="country_id" id="region" required >
                                <option value="">Choose Country</option>
                                @foreach ($countries as $country)
                                    <option value="{{ $country->id }}">{{ $country->country }}</option>
                                @endforeach
                            </select>
                            @if ($errors->has('country_id'))
                                <p class="error--msg">{{ $errors->first('country_id') }}</p>
                                <style>
                                    .common--checkout--input.country--error{
                                        border: 1px solid red;
                                    }
                                </style>
                            @endif
                        </div>

                        <div class="common--two--field--wrapper">

                            <div class="contact--input--inner--wrapper">
                                <div class="input-container">
                                    <input type="text" name="first_name" id="fname" placeholder="First name (optional)" class="common--checkout--input" />
                                    <label class="input-label" for="fname">First Name</label>
                                </div>
                                @if ($errors->has('first_name'))
                                    <p class="error--msg">{{ $errors->first('first_name') }}</p>
                                @endif
                            </div>
                            <div class="contact--input--inner--wrapper">
                                <div class="input-container">
                                    <input type="text" name="last_name" id="lname" placeholder="Last name" class="common--checkout--input" required />
                                    <label class="input-label" for="lname">Last Name</label>
                                </div>
                                @if ($errors->has('last_name'))
                                    <p class="error--msg">{{ $errors->first('last_name') }}</p>
                                @endif
                            </div>

                        </div>

                        <div class="checkout--single--input--wrapper" >
                            <div class="input-container">
                                <input type="text" name="address" id="address" placeholder="Address" class="common--checkout--input" required  />
                                <label class="input-label" for="address">Address</label>
                            </div>
                            @if ($errors->has('address'))
                                <p class="error--msg">{{ $errors->first('address') }}</p>
                            @endif
                        </div>

                        <div class="checkout--single--input--wrapper" >
                            <div class="input-container">
                                <input type="text" name="apartment" id="apartment" placeholder="Address" class="common--checkout--input" />
                                <label class="input-label" for="apartment">Apartment</label>
                            </div>
                            @if ($errors->has('apartment'))
                                <p class="error--msg">{{ $errors->first('apartment') }}</p>
                            @endif
                        </div>

                        <div class="common--two--field--wrapper">
                            <div class="contact--input--inner--wrapper">
                                <div class="input-container">
                                    <input type="text" name="city" id="city" placeholder="City" class="common--checkout--input" required />
                                    <label class="input-label" for="city">City</label>
                                </div>
                                @if ($errors->has('city'))
                                    <p class="error--msg">{{ $errors->first('city') }}</p>
                                @endif
                            </div>
                            <div  class="contact--input--inner--wrapper">
                                <div class="input-container">
                                    <input type="text" name="postal_code" id="code" placeholder="Postal code (optional)" class="common--checkout--input" required />
                                    <label class="input-label" for="code">Postal Code</label>
                                </div>
                                @if ($errors->has('postal_code'))
                                    <p class="error--msg">{{ $errors->first('postal_code') }}</p>
                                @endif
                            </div>

                        </div>
                        <div class="common--checkbox--wrapper">
                            <input name="save-delivery" id="save-delivery" value="1" type="checkbox" class="common--checkbox" />
                            <label for="save-delivery" class="common--small--text--checkout">Save this information for next time</label>
                        </div>

                    </div>

                    <!-- third one -->
                    <div class="shipping--method--fieldset">
                        <span class="checkout--fieldset--header-text">Shipping method</span>
                        <div class="shipping--method---box">

                            <div class="method--box--left">
                                <span>Free International Shipping</span>
                                <span class="common--small--text--checkout">8-16 Days Worldwide Delivery</span>
                            </div>
                            <span>FREE</span>

                        </div>
                    </div>

                    <!-- fourth one -->
                    <div class="payments--method--fieldset">
                        <p class="checkout--fieldset--header-text">Payment</p>
                        <p class="common--small--text--checkout">All transactions are secure and encrypted.</p>
                        <div class="payment--box">

                            <div class="accordion" id="payment_methods">
                                {{--                            stripe--}}

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <input id="stripe" type="radio" name="stripe" hidden  >
                                        <label for="stripe" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#stipe_form"  aria-controls="stipe_form">
                                            <span class="payment-text">Stripe</span>

                                            <span class="payment--logo--in--accordion">
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Layer_1" x="0px" y="0px" style="enable-background:new 0 0 468 222.5;" xml:space="preserve" viewBox="54 36 360.02 149.84" fill="#635BFF">  <g> 	<path class="st0" d="M414,113.4c0-25.6-12.4-45.8-36.1-45.8c-23.8,0-38.2,20.2-38.2,45.6c0,30.1,17,45.3,41.4,45.3   c11.9,0,20.9-2.7,27.7-6.5v-20c-6.8,3.4-14.6,5.5-24.5,5.5c-9.7,0-18.3-3.4-19.4-15.2h48.9C413.8,121,414,115.8,414,113.4z    M364.6,103.9c0-11.3,6.9-16,13.2-16c6.1,0,12.6,4.7,12.6,16H364.6z"/> 	<path class="st0" d="M301.1,67.6c-9.8,0-16.1,4.6-19.6,7.8l-1.3-6.2h-22v116.6l25-5.3l0.1-28.3c3.6,2.6,8.9,6.3,17.7,6.3   c17.9,0,34.2-14.4,34.2-46.1C335.1,83.4,318.6,67.6,301.1,67.6z M295.1,136.5c-5.9,0-9.4-2.1-11.8-4.7l-0.1-37.1   c2.6-2.9,6.2-4.9,11.9-4.9c9.1,0,15.4,10.2,15.4,23.3C310.5,126.5,304.3,136.5,295.1,136.5z"/> 	<polygon class="st0" points="223.8,61.7 248.9,56.3 248.9,36 223.8,41.3  "/> 	<rect x="223.8" y="69.3" class="st0" width="25.1" height="87.5"/> 	<path class="st0" d="M196.9,76.7l-1.6-7.4h-21.6v87.5h25V97.5c5.9-7.7,15.9-6.3,19-5.2v-23C214.5,68.1,202.8,65.9,196.9,76.7z"/> 	<path class="st0" d="M146.9,47.6l-24.4,5.2l-0.1,80.1c0,14.8,11.1,25.7,25.9,25.7c8.2,0,14.2-1.5,17.5-3.3V135   c-3.2,1.3-19,5.9-19-8.9V90.6h19V69.3h-19L146.9,47.6z"/> 	<path class="st0" d="M79.3,94.7c0-3.9,3.2-5.4,8.5-5.4c7.6,0,17.2,2.3,24.8,6.4V72.2c-8.3-3.3-16.5-4.6-24.8-4.6   C67.5,67.6,54,78.2,54,95.9c0,27.6,38,23.2,38,35.1c0,4.6-4,6.1-9.6,6.1c-8.3,0-18.9-3.4-27.3-8v23.8c9.3,4,18.7,5.7,27.3,5.7   c20.8,0,35.1-10.3,35.1-28.2C117.4,100.6,79.3,105.9,79.3,94.7z"/> </g> </svg>
                                        </span>
                                        </label>
                                    </h2>
                                    <div id="stipe_form" class="accordion-collapse collapse" data-bs-parent="#payment_methods">
                                        <div class="accordion-body">
                                            <div class="checkout--payment--methods--form">
                                                <div class="checkout--single--input--wrapper">
                                                    <div class="input-container">
                                                        <input type="text" name="address" id="address" value="" placeholder="Address" class="common--checkout--input" required />
                                                        <label class="input-label" for="address">Address</label>
                                                    </div>
                                                    {{--                                            @if ($errors->has('address'))--}}
                                                    {{--                                                <p class="error--msg">{{ $errors->first('address') }}</p>--}}
                                                    {{--                                            @endif--}}
                                                </div>
                                                <div class="common--two--field--wrapper">
                                                    <div class="contact--input--inner--wrapper">
                                                        <div class="input-container">
                                                            <input type="text" name="first_name" id="fname" value="" placeholder="First name (optional)" class="common--checkout--input" />
                                                            <label class="input-label" for="fname">First Name</label>
                                                        </div>
                                                        {{--                                                @if ($errors->has('first_name'))--}}
                                                        {{--                                                    <p class="error--msg">{{ $errors->first('first_name') }}</p>--}}
                                                        {{--                                                @endif--}}
                                                    </div>
                                                    <div class="contact--input--inner--wrapper">
                                                        <div class="input-container">
                                                            <input type="text" name="last_name" id="lname" value="" placeholder="Last name" class="common--checkout--input" required />
                                                            <label class="input-label" for="lname">Last Name</label>
                                                        </div>
                                                        {{--                                                @if ($errors->has('last_name'))--}}
                                                        {{--                                                    <p class="error--msg">{{ $errors->first('last_name') }}</p>--}}
                                                        {{--                                                @endif--}}
                                                    </div>
                                                </div>
                                                <div class="checkout--single--input--wrapper">
                                                    <div class="input-container">
                                                        <input type="text" name="address" id="address" value="" placeholder="Address" class="common--checkout--input" required />
                                                        <label class="input-label" for="address">Address</label>
                                                    </div>
                                                    {{--                                            @if ($errors->has('address'))--}}
                                                    {{--                                                <p class="error--msg">{{ $errors->first('address') }}</p>--}}
                                                    {{--                                            @endif--}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{-- paypal --}}

                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <input id="paypal" type="radio" name="paypal" hidden  >
                                        <label for="paypal" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#paypal_form"  aria-controls="paypal_form">
                                            <span class="payment-text">Paypal</span>

                                            <span class="payment--logo--in--accordion">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="77" height="25" viewBox="0 0 77 25" fill="none">
                                                <g clip-path="url(#clip0_683_439)">
                                                    <path d="M9.80946 2.73999H3.95946C3.58446 2.73999 3.20946 3.03999 3.13446 3.41499L0.809458 18.415C0.734458 18.715 0.959458 18.94 1.25946 18.94H4.03446C4.40946 18.94 4.78446 18.64 4.85946 18.265L5.45946 14.215C5.53446 13.84 5.83446 13.54 6.28446 13.54H8.15946C11.9845 13.54 14.2345 11.665 14.8345 7.98999C15.0595 6.41499 14.8345 5.13999 14.0845 4.23999C13.2595 3.26499 11.7595 2.73999 9.80946 2.73999ZM10.4845 8.21499C10.1845 10.315 8.53446 10.315 7.03446 10.315H6.13446L6.73446 6.41499C6.73446 6.18999 6.95946 6.03999 7.18446 6.03999H7.55946C8.60946 6.03999 9.58446 6.03999 10.1095 6.63999C10.4845 6.93999 10.6345 7.46499 10.4845 8.21499Z" fill="#003087"/>
                                                    <path d="M27.2083 8.14001H24.4333C24.2083 8.14001 23.9833 8.29001 23.9833 8.51501L23.8333 9.26501L23.6083 8.96502C23.0083 8.06501 21.6583 7.76501 20.3083 7.76501C17.2333 7.76501 14.6083 10.09 14.0833 13.39C13.7833 15.04 14.1583 16.615 15.1333 17.665C15.9583 18.64 17.2333 19.09 18.6583 19.09C21.1333 19.09 22.5583 17.515 22.5583 17.515L22.4083 18.265C22.3333 18.565 22.5583 18.865 22.8583 18.865H25.4083C25.7833 18.865 26.1583 18.565 26.2333 18.19L27.7333 8.59001C27.8083 8.44001 27.5083 8.14001 27.2083 8.14001ZM23.3833 13.54C23.0833 15.115 21.8833 16.24 20.2333 16.24C19.4083 16.24 18.8083 16.015 18.3583 15.49C17.9083 14.965 17.7583 14.29 17.9083 13.54C18.1333 11.965 19.4833 10.84 21.0583 10.84C21.8833 10.84 22.4833 11.14 22.9333 11.59C23.3083 12.115 23.4583 12.79 23.3833 13.54Z" fill="#003087"/>
                                                    <path d="M42.134 8.14001H39.359C39.059 8.14001 38.834 8.29001 38.684 8.51501L34.784 14.215L33.134 8.74001C33.059 8.36501 32.684 8.14001 32.384 8.14001H29.609C29.309 8.14001 29.009 8.44001 29.159 8.81501L32.234 17.89L29.309 21.94C29.084 22.24 29.309 22.69 29.684 22.69H32.459C32.759 22.69 32.984 22.54 33.134 22.315L42.509 8.81501C42.734 8.59001 42.509 8.14001 42.134 8.14001Z" fill="#003087"/>
                                                    <path d="M51.4345 2.73999H45.5845C45.2095 2.73999 44.8345 3.03999 44.7595 3.41499L42.4345 18.34C42.3595 18.64 42.5845 18.865 42.8845 18.865H45.8845C46.1845 18.865 46.4095 18.64 46.4095 18.415L47.0845 14.14C47.1595 13.765 47.4595 13.465 47.9095 13.465H49.7845C53.6095 13.465 55.8595 11.59 56.4595 7.91499C56.6845 6.33999 56.4595 5.06499 55.7095 4.16499C54.8095 3.26499 53.3845 2.73999 51.4345 2.73999ZM52.1095 8.21499C51.8095 10.315 50.1595 10.315 48.6595 10.315H47.7595L48.3595 6.41499C48.3595 6.18999 48.5845 6.03999 48.8095 6.03999H49.1845C50.2345 6.03999 51.2095 6.03999 51.7345 6.63999C52.1095 6.93999 52.1845 7.46499 52.1095 8.21499Z" fill="#009CDE"/>
                                                    <path d="M68.8333 8.14001H66.0583C65.8333 8.14001 65.6083 8.29001 65.6083 8.51501L65.4583 9.26501L65.2333 8.96502C64.6333 8.06501 63.2833 7.76501 61.9333 7.76501C58.8583 7.76501 56.2333 10.09 55.7083 13.39C55.4083 15.04 55.7833 16.615 56.7583 17.665C57.5833 18.64 58.8583 19.09 60.2833 19.09C62.7583 19.09 64.1833 17.515 64.1833 17.515L64.0333 18.265C63.9583 18.565 64.1833 18.865 64.4833 18.865H67.0333C67.4083 18.865 67.7833 18.565 67.8583 18.19L69.3583 8.59001C69.3583 8.44001 69.1333 8.14001 68.8333 8.14001ZM64.9333 13.54C64.6333 15.115 63.4333 16.24 61.7833 16.24C60.9583 16.24 60.3583 16.015 59.9083 15.49C59.4583 14.965 59.3083 14.29 59.4583 13.54C59.6833 11.965 61.0333 10.84 62.6083 10.84C63.4333 10.84 64.0333 11.14 64.4833 11.59C64.9333 12.115 65.0833 12.79 64.9333 13.54Z" fill="#009CDE"/>
                                                    <path d="M72.1333 3.11499L69.7333 18.34C69.6583 18.64 69.8833 18.865 70.1833 18.865H72.5833C72.9583 18.865 73.3333 18.565 73.4083 18.19L75.8083 3.26499C75.8833 2.96499 75.6583 2.73999 75.3583 2.73999H72.6583C72.3583 2.73999 72.2083 2.88999 72.1333 3.11499Z" fill="#009CDE"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_683_439">
                                                        <rect width="75.75" height="24" fill="white" transform="translate(0.630859 0.640015)"/>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </span>
                                        </label>
                                    </h2>
                                    <div id="paypal_form" class="accordion-collapse collapse" data-bs-parent="#payment_methods">
                                        <div class="accordion-body">
                                            <div class="payment--redirect--section">
                                                <div class="payment--redirect--img">
                                                    <img src="{{ asset('/frontend/assets/images/redirect__img.svg') }}" alt="" >
                                                </div>
                                                <span class="payment-text">After clicking "Pay with PayPal", you will be redirected to PayPal to complete your purchase securely.</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{--Gpay--}}
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <input id="gpay" type="radio" name="gpay" hidden  >
                                        <label for="gpay" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#gpay_form"  aria-controls="gpay_form">
                                            <span class="payment-text">Gpay</span>

                                            <span class="payment--logo--in--accordion">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="59" height="25" viewBox="0 0 59 25" fill="none">
                                                <g clip-path="url(#clip0_683_448)">
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M28.1252 4.36V10.1242H31.6801C32.5271 10.1242 33.2274 9.83906 33.7808 9.27012C34.3497 8.70259 34.6349 8.02495 34.6349 7.24142C34.6349 6.47342 34.3497 5.80424 33.7808 5.23389C33.2274 4.65083 32.5271 4.35859 31.6801 4.35859L28.1252 4.36ZM28.1252 12.1529V18.8391H26.002V2.3313H31.6349C33.065 2.3313 34.2791 2.80706 35.2801 3.76C36.2965 4.71295 36.8048 5.87342 36.8048 7.24142C36.8048 8.64048 36.2965 9.80942 35.2801 10.7454C34.2961 11.6842 33.0791 12.1515 31.6335 12.1515L28.1252 12.1529ZM38.9507 15.3817C38.9507 15.9351 39.185 16.3953 39.6551 16.7652C40.1238 17.1322 40.6744 17.3172 41.3041 17.3172C42.1977 17.3172 42.9925 16.9868 43.6928 16.3275C44.3944 15.6654 44.7431 14.8889 44.7431 13.9981C44.081 13.4758 43.1577 13.2146 41.9732 13.2146C41.1121 13.2146 40.3921 13.4235 39.8161 13.8386C39.2387 14.2537 38.9507 14.7661 38.9507 15.3817ZM41.698 7.17224C43.2678 7.17224 44.506 7.59153 45.4151 8.42871C46.3215 9.2673 46.7761 10.4165 46.7761 11.8762V18.8391H44.7445V17.272H44.6528C43.7747 18.5624 42.6057 19.2089 41.1431 19.2089C39.898 19.2089 38.8547 18.8391 38.0161 18.1021C37.1775 17.3638 36.7582 16.4419 36.7582 15.3351C36.7582 14.1661 37.2001 13.2372 38.0852 12.5454C38.9704 11.8537 40.1507 11.5078 41.6288 11.5078C42.8881 11.5078 43.9285 11.7379 44.7431 12.1995V11.7139C44.7431 10.9769 44.4509 10.3501 43.8664 9.83624C43.3033 9.3295 42.5698 9.05374 41.8123 9.064C40.6264 9.064 39.689 9.56236 38.9958 10.5633L37.1267 9.38589C38.1572 7.91059 39.682 7.17224 41.698 7.17224ZM58.4316 7.54212L51.3445 23.8198H49.1521L51.7836 18.1247L47.122 7.54212H49.4302L52.8001 15.6584H52.8452L56.1234 7.54071L58.4316 7.54212Z" fill="black"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M19.5438 10.7116C19.5438 10.0438 19.4874 9.39861 19.3801 8.78308H10.4238V12.4367H15.5542C15.449 13.0205 15.2267 13.5769 14.9006 14.0724C14.5745 14.5679 14.1514 14.9921 13.6568 15.3196V17.6913H16.7189C18.5118 16.0396 19.5438 13.5972 19.5438 10.7116Z" fill="#4285F4"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4242 19.9812C12.9879 19.9812 15.1451 19.1412 16.7192 17.6927L13.6571 15.3195C12.8058 15.8927 11.7089 16.2273 10.4242 16.2273C7.94792 16.2273 5.84439 14.5586 5.09334 12.311H1.93945V14.7548C2.73065 16.3266 3.94294 17.6478 5.44111 18.5708C6.93929 19.4939 8.66444 19.9827 10.4242 19.9826" fill="#34A853"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M5.09386 12.3111C4.69767 11.1332 4.69767 9.85796 5.09386 8.68003V6.23627H1.93997C1.27324 7.55651 0.926486 9.0151 0.927738 10.4941C0.927738 12.0259 1.2948 13.473 1.93997 14.7534L5.09386 12.3097V12.3111Z" fill="#FABB05"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" d="M10.4247 4.76377C11.8252 4.76377 13.0788 5.24377 14.0671 6.18683V6.18824L16.7776 3.48048C15.1343 1.95012 12.9885 1.00989 10.4261 1.00989C8.66654 1.00965 6.94149 1.49819 5.44333 2.42102C3.94517 3.34384 2.7328 4.66468 1.94141 6.23624L5.09529 8.68001C5.84635 6.43248 7.94846 4.76377 10.4247 4.76377Z" fill="#E94235"/>
                                                </g>
                                                <defs>
                                                    <clipPath id="clip0_683_448">
                                                        <rect width="57.8824" height="24" fill="white" transform="translate(0.558594 0.640015)"/>
                                                    </clipPath>
                                                </defs>
                                            </svg>
                                        </span>
                                        </label>
                                    </h2>
                                    <div id="gpay_form" class="accordion-collapse collapse" data-bs-parent="#payment_methods">
                                        <div class="accordion-body">
                                            <div class="payment--redirect--section">
                                                <div class="payment--redirect--img">
                                                    <img src="{{ asset('/frontend/assets/images/redirect__img.svg') }}" alt="" >
                                                </div>
                                                <span class="payment-text">After clicking "Pay with PayPal", you will be redirected to PayPal to complete your purchase securely.</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                                {{--Applepay--}}
                                <div class="accordion-item">
                                    <h2 class="accordion-header">
                                        <input id="apple_pay" type="radio" name="apple_pay" hidden  >
                                        <label for="apple_pay" class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#apple_pay_form"  aria-controls="apple_pay_form">
                                            <span class="payment-text">Apple Pay</span>

                                            <span class="payment--logo--in--accordion">
                                            <svg fill="black" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" baseProfile="tiny" id="Layer_1" x="0px" y="0px" viewBox="0 0 512 210.2" xml:space="preserve">
                                            <path id="XMLID_34_" d="M93.6,27.1C87.6,34.2,78,39.8,68.4,39c-1.2-9.6,3.5-19.8,9-26.1c6-7.3,16.5-12.5,25-12.9  C103.4,10,99.5,19.8,93.6,27.1 M102.3,40.9c-13.9-0.8-25.8,7.9-32.4,7.9c-6.7,0-16.8-7.5-27.8-7.3c-14.3,0.2-27.6,8.3-34.9,21.2  c-15,25.8-3.9,64,10.6,85c7.1,10.4,15.6,21.8,26.8,21.4c10.6-0.4,14.8-6.9,27.6-6.9c12.9,0,16.6,6.9,27.8,6.7  c11.6-0.2,18.9-10.4,26-20.8c8.1-11.8,11.4-23.3,11.6-23.9c-0.2-0.2-22.4-8.7-22.6-34.3c-0.2-21.4,17.5-31.6,18.3-32.2  C123.3,42.9,107.7,41.3,102.3,40.9 M182.6,11.9v155.9h24.2v-53.3h33.5c30.6,0,52.1-21,52.1-51.4c0-30.4-21.1-51.2-51.3-51.2H182.6z   M206.8,32.3h27.9c21,0,33,11.2,33,30.9c0,19.7-12,31-33.1,31h-27.8V32.3z M336.6,169c15.2,0,29.3-7.7,35.7-19.9h0.5v18.7h22.4V90.2  c0-22.5-18-37-45.7-37c-25.7,0-44.7,14.7-45.4,34.9h21.8c1.8-9.6,10.7-15.9,22.9-15.9c14.8,0,23.1,6.9,23.1,19.6v8.6l-30.2,1.8  c-28.1,1.7-43.3,13.2-43.3,33.2C298.4,155.6,314.1,169,336.6,169z M343.1,150.5c-12.9,0-21.1-6.2-21.1-15.7c0-9.8,7.9-15.5,23-16.4  l26.9-1.7v8.8C371.9,140.1,359.5,150.5,343.1,150.5z M425.1,210.2c23.6,0,34.7-9,44.4-36.3L512,54.7h-24.6l-28.5,92.1h-0.5  l-28.5-92.1h-25.3l41,113.5l-2.2,6.9c-3.7,11.7-9.7,16.2-20.4,16.2c-1.9,0-5.6-0.2-7.1-0.4v18.7C417.3,210,423.3,210.2,425.1,210.2z  "/>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                                <g>
                                                </g>
                                            </svg>
                                        </span>
                                        </label>
                                    </h2>
                                    <div id="apple_pay_form" class="accordion-collapse collapse" data-bs-parent="#payment_methods">
                                        <div class="accordion-body">
                                            <div class="payment--redirect--section">
                                                <div class="payment--redirect--img">
                                                    <img src="{{ asset('/frontend/assets/images/redirect__img.svg') }}" alt="" >
                                                </div>
                                                <span class="payment-text">After clicking "Pay with PayPal", you will be redirected to PayPal to complete your purchase securely.</span>

                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            {{--                        <div class="payment--row">--}}
                            {{--                            <input class="common-payment--input" type="radio" name="method" id="paypal" value="paypal" required>--}}
                            {{--                            <label class="common-payment--label" for="paypal">--}}
                            {{--                                <span class="payment-text">PayPal</span>--}}
                            {{--                                <span class="payment--logo">--}}
                            {{--                                    <img src="{{ asset('/frontend/assets/images/paypal.svg') }}" alt="PayPal">--}}
                            {{--                                </span>--}}
                            {{--                            </label>--}}
                            {{--                        </div>--}}

                            {{--                        <div class="payment--row">--}}
                            {{--                            <input class="common-payment--input" type="radio" name="method" id="stripe" value="stripe" required>--}}
                            {{--                            <label class="common-payment--label" for="stripe">--}}
                            {{--                                <span class="payment-text">Stripe</span>--}}
                            {{--                                <span class="payment--logo">--}}
                            {{--                                     <img src="{{ asset('/frontend/assets/images/stripe.png') }}" alt="Stripe">--}}
                            {{--                                </span>--}}

                            {{--                            </label>--}}
                            {{--                        </div>--}}

                            {{--                        <div class="payment--row">--}}
                            {{--                            <input class="common-payment--input" type="radio" name="method" id="apple-pay" value="apple-pay" required>--}}
                            {{--                            <label class="common-payment--label" for="apple-pay">--}}
                            {{--                                <span class="payment-text">Apple pay</span>--}}
                            {{--                                <span class="payment--logo">--}}
                            {{--                                <img src="{{ asset('/frontend/assets/images/apple-pay.svg') }}" alt="apple-pay">--}}
                            {{--                                </span>--}}
                            {{--                            </label>--}}
                            {{--                        </div>--}}


                            {{--                        <div class="payment--row">--}}
                            {{--                            <input class="common-payment--input" type="radio" name="method" id="google-pay" value="google-pay" required>--}}
                            {{--                            <label class="common-payment--label" for="google-pay">--}}
                            {{--                                <span class="payment-text">Google Pay</span>--}}
                            {{--                                <span class="payment--logo">--}}
                            {{--                                <img src="{{ asset('/frontend/assets/images/dark_gpay.svg') }}" alt="google-pay">--}}
                            {{--                                </span>--}}
                            {{--                            </label>--}}
                            {{--                        </div>--}}

                        </div>

                        <button class="pay---btn" id="pay-now-btn" type="submit" as="button">Pay Now</button>
                        <hr>
                        @foreach ($dynamic_pages as $page)
                            <a class="text--blue--underline"
                               href="{{ route('dynamic.page', $page->page_slug) }}">{{ $page->page_title }}</a>
                        @endforeach
                    </div>

                </form>
            @endif

        </div>

        <script>
            document.getElementById('pay-now-btn').addEventListener('click', function (event) {
                // Prevent the default form submission
                event.preventDefault();

                // Get the payment method from your form (e.g., PayPal or Stripe)
                const paymentMethod = document.querySelector('input[name="method"]:checked')?.value;
                const checkoutForm = document.getElementById('checkout-form');

                // If no payment method is selected, show an alert
                if (!paymentMethod) {
                    alert("Please select a payment method.");
                    return; // Exit the function
                }

                // PayPal or Stripe URL to submit the form (the URL should point to the correct route)
                const url = "{{ route('order.new') }}";

                // Open a new small tab for payment gateway submission (for PayPal or Stripe)
                const paymentWindow = window.open(url, 'payment-gateway', 'width=600,height=500,scrollbars=yes,resizable=yes');

                // Submit the form to the URL, so it processes the payment
                checkoutForm.target = 'payment-gateway';  // This ensures the form submits to the new window/tab
                checkoutForm.submit();  // Submit the form to the new window

                // Polling mechanism to check when the payment window is closed
                const checkPaymentStatus = setInterval(function () {
                    try {
                        // Check if the payment window is still open and if the payment has been completed
                        if (paymentWindow.closed) {
                            // The payment window has been closed, which means payment was successful or canceled
                            const paymentSuccess = true;

                            if (paymentSuccess) {
                                // Store a flag in localStorage to indicate successful payment
                                localStorage.setItem('paymentSuccess', 'true');

                                // Close the payment window instantly
                                paymentWindow.close();

                                // Redirect the parent window to the homepage
                                window.location.href = "{{ url('/') }}"; // Redirect to homepage or checkout page

                            } else {
                                // If payment failed, show an error message (in the parent tab)
                                alert('Payment failed. Please try again.');
                            }

                            // Clear the interval once the payment is processed
                            clearInterval(checkPaymentStatus);
                        }
                    } catch (error) {
                        // Handle any errors that occur while checking the payment window
                        console.error('Error checking payment status: ', error);
                    }
                }, 500); // Check every second
            });
        </script>

        <div class="checkout--cart--items--side">
            <div class="checkout--cart--items--wrapper">
                <!-- new -->
                <div class="toggle--order--summery--btn">
                    <span>Order Summary</span>
                    <span class="show---icon--container">
                        <span>Show</span>
                        <div class="show--arrow--down--icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16"
                                 fill="none">
                                <path d="M13 5.5L8 10.5L3 5.5" stroke="black" stroke-width="2" stroke-linecap="square"
                                      stroke-linejoin="round" />
                            </svg>
                        </div>
                    </span>
                </div>
                @if(Auth::check())
                    <div class="cart--items--container--checkout hide">
                        @foreach ($carts as $cart)
                            <!-- item -->
                            <div class="single--checkout--cart">
                                <div class="checkout-cart--img">
                                    <span class="cart--item--quantity--checkout">{{ $cart->quantity }}</span>
                                    @foreach ($cart->product->images->take(1) as $image)
                                        <img src="{{ asset($image->image) }}" alt=""
                                             srcset="{{ asset($image->image) }}">
                                    @endforeach
                                </div>
                                <div class="checkout--cart--info">
                                    <div class="cart--item--name">{{ $cart->product->name }}</div>
                                    <div class="cart--item--size--color">
                                        <span>{{ $cart->color_id ? $cart->color->color : 'N/A' }}</span>
                                        <span>/ {{ $cart->size_id ? $cart->size->size : 'N/A' }}</span>
                                    </div>
                                </div>
                                @php
                                    $product_sum = $cart->product->selling_price * $cart->quantity;
                                @endphp

                                <span class="total--price--item">{{ number_format($product_sum, 2) }}</span>
                            </div>
                        @endforeach

                    </div>
                    <div class="subtotal--calculation--screen">
                        @php
                            $sum = $carts->sum(function ($cart) {
                                return $cart->product->selling_price * $cart->quantity;
                            });
                        @endphp
                        <p class="subtotal--price"><span>Subtotal • {{ $carts->count() }}
                            items</span><span>${{ number_format($sum, 2) }}</span></p>
                        <p class="shipping--text--checkout"><span>Shipping</span><span>FREE</span></p>
                        <input type="hidden" name="total" value="{{ $sum }}">
                        <p class="checkout--total--price"><span>Total</span><span>${{ number_format($sum, 2) }}</span></p>
                    </div>
                @else
                    <div class="cart--items--container--checkout hide">
                            <?php
                            // Retrieve the cart items from the session
                            $cartItems = session()->get('cart_' . session()->getId(), []);
                            ?>
                        @if(count($cartItems) > 0)
                            @foreach($cartItems as $itemKey => $item)
                            <!-- item -->
                            <div class="single--checkout--cart">
                                <div class="checkout-cart--img">
                                    <span class="cart--item--quantity--checkout">{{ $item['quantity'] }}</span>
                                    @if(!empty($item['images']) && count($item['images']) > 0)
                                        <img src="{{ asset($item['images'][0]) }}" alt="{{ $item['product']['name'] ?? 'N/A' }}"
                                             srcset="{{ asset($item['images'][0]) }}">
                                    @endif
                                </div>
                                <div class="checkout--cart--info">
                                    <div class="cart--item--name">{{ $item['product']['name'] ?? 'N/A' }}</div>
                                    <div class="cart--item--size--color">
                                        <span>{{ $item['color']->color ?? 'N/A' }}</span>
                                        <span>/ {{ $item['size']->size ?? 'N/A' }}</span>
                                    </div>
                                </div>
                                @php
                                    $product_sum = $item['selling_price'] * $item['quantity'];
                                @endphp

                                <span class="total--price--item">{{ number_format($product_sum, 2) }}</span>
                            </div>
                            @endforeach
                        @endif

                    </div>
                    <div class="subtotal--calculation--screen">
                        @php
                            $sum = 0;

                            // Calculate total price
                            foreach ($cartItems as $item) {
                                $sum += $item['selling_price'] * $item['quantity'];
                            }
                        @endphp
                        <p class="subtotal--price"><span>Subtotal • {{ count($cartItems) }}
                            items</span><span>${{ number_format($sum, 2) }}</span></p>
                        <p class="shipping--text--checkout"><span>Shipping</span><span>FREE</span></p>
                        <input type="hidden" name="total" value="{{ $sum }}">
                        <p class="checkout--total--price"><span>Total</span><span>${{ number_format($sum, 2) }}</span></p>
                    </div>
                @endif

            </div>
        </div>

    </div>

@endsection


@push('scripts')
    <script>
        function showToast(message, isSuccess = true) {
            Toastify({
                text: message,
                duration: 3000,
                gravity: "top",
                position: 'right',
                backgroundColor: isSuccess ? "#28232D" : "#FE0000", // green for success, red for error
                color: "#FFFFFF",
                stopOnFocus: true
            }).showToast();
        }
    </script>
@endpush
