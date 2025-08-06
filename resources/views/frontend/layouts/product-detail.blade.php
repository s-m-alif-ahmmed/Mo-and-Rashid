@extends('frontend.app')

@section('title')
    {{ $product->name }} - mo&rashids
@endsection

@section('content')

    @include('frontend.partials.cart-sidebar')

    <!-- Inject the app URL into a global JavaScript variable -->
    <script>
        window.appUrl = "{{ url('/') }}";  // Set the base URL of your app
    </script>

    <!-- write review modal starts -->
    <div class="modal fade" id="write-review-modal" tabindex="-1" aria-labelledby="write-review-modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title">Ratings & Reviews</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                @if(Auth::check())
                    <form action="{{ route('user.product.review.store', $product->id) }}" method="POST" id="reviewForm" enctype="multipart/form-data" class="modal-body">
                        @csrf

                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                        <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}" />

                        <!-- product image and rating -->
                        <div class="review--product---rating--row">
                            <!-- product--image  -->
                            <div class="reviewed--product--img">
                                @foreach($product->images->take(1) as $image)
                                    <img src="{{ asset($image->image) }}" alt="" />
                                @endforeach
                            </div>
                            <!-- rating -->
                            <div class="reviewed--product--rating--wrapper">
                                <div class="reviewed--product---name">
                                    {{ $product->name }}
                                </div>
                                <div class="rating">
                                    <input type="radio" id="star1" name="rating" value="5" required/>
                                    <label for="star1">
                                        <svg class="star" width="35" height="31">
                                            <path
                                                d="M12 .587l3.668 7.431 8.215 1.187-5.935 5.773 1.4 8.151L12 18.897l-7.348 3.865 1.4-8.151-5.935-5.773 8.215-1.187z" />
                                        </svg></label>

                                    <input type="radio" id="star2" name="rating" value="4" required/>
                                    <label for="star2"><svg class="star" width="35" height="31">
                                            <path
                                                d="M12 .587l3.668 7.431 8.215 1.187-5.935 5.773 1.4 8.151L12 18.897l-7.348 3.865 1.4-8.151-5.935-5.773 8.215-1.187z" />
                                        </svg></label>

                                    <input type="radio" id="star3" name="rating" value="3" required/>
                                    <label for="star3"><svg class="star" width="35" height="31">
                                            <path
                                                d="M12 .587l3.668 7.431 8.215 1.187-5.935 5.773 1.4 8.151L12 18.897l-7.348 3.865 1.4-8.151-5.935-5.773 8.215-1.187z" />
                                        </svg></label>

                                    <input type="radio" id="star4" name="rating" value="2" required/>
                                    <label for="star4"><svg class="star" width="35" height="31">
                                            <path
                                                d="M12 .587l3.668 7.431 8.215 1.187-5.935 5.773 1.4 8.151L12 18.897l-7.348 3.865 1.4-8.151-5.935-5.773 8.215-1.187z" />
                                        </svg></label>

                                    <input type="radio" id="star5" name="rating" value="1" required/>
                                    <label for="star5"><svg class="star" width="35" height="31">
                                            <path
                                                d="M12 .587l3.668 7.431 8.215 1.187-5.935 5.773 1.4 8.151L12 18.897l-7.348 3.865 1.4-8.151-5.935-5.773 8.215-1.187z" />
                                        </svg></label>
                                </div>
                                <!-- error--msg -->
                                <div class="error--msg--review--modal">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.00002 3C7.41423 3.00001 7.75001 3.3358 7.75 3.75001L7.74994 7.25001C7.74994 7.66423 7.41414 8.00001 6.99993 8C6.58572 7.99999 6.24994 7.6642 6.24994 7.24999L6.25 3.74999C6.25001 3.33577 6.5858 2.99999 7.00002 3Z"
                                            fill="#8E1F0B"></path>
                                        <path
                                            d="M8 10C8 10.5523 7.55228 11 7 11C6.44772 11 6 10.5523 6 10C6 9.44772 6.44772 9 7 9C7.55228 9 8 9.44772 8 10Z"
                                            fill="#8E1F0B"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M14 7C14 10.866 10.866 14 7 14C3.13401 14 0 10.866 0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7ZM12.5 7C12.5 10.0376 10.0376 12.5 7 12.5C3.96243 12.5 1.5 10.0376 1.5 7C1.5 3.96243 3.96243 1.5 7 1.5C10.0376 1.5 12.5 3.96243 12.5 7Z"
                                              fill="#8E1F0B"></path>
                                    </svg>
                                    @if ($errors->has('rating'))
                                        <span>{{ $errors->first('rating') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- review title -->
                        <div class="common--review--input--wrapper">
                            <label class="common--review--lable" for="title">
                                <span>Review Title</span>
                                <span class="counter"> 100/100 </span>
                            </label>
                            <input class="common--review--input" placeholder="Example: Easy to use" type="text" name="title" id="title"
                                   maxlength="100" required />
                            <!-- error--msg -->
                            <div class="error--msg--review--modal">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.00002 3C7.41423 3.00001 7.75001 3.3358 7.75 3.75001L7.74994 7.25001C7.74994 7.66423 7.41414 8.00001 6.99993 8C6.58572 7.99999 6.24994 7.6642 6.24994 7.24999L6.25 3.74999C6.25001 3.33577 6.5858 2.99999 7.00002 3Z"
                                        fill="#8E1F0B"></path>
                                    <path
                                        d="M8 10C8 10.5523 7.55228 11 7 11C6.44772 11 6 10.5523 6 10C6 9.44772 6.44772 9 7 9C7.55228 9 8 9.44772 8 10Z"
                                        fill="#8E1F0B"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M14 7C14 10.866 10.866 14 7 14C3.13401 14 0 10.866 0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7ZM12.5 7C12.5 10.0376 10.0376 12.5 7 12.5C3.96243 12.5 1.5 10.0376 1.5 7C1.5 3.96243 3.96243 1.5 7 1.5C10.0376 1.5 12.5 3.96243 12.5 7Z"
                                          fill="#8E1F0B"></path>
                                </svg>
                                @if ($errors->has('title'))
                                    <span>{{ $errors->first('title') }}</span>
                                @endif
                            </div>

                        </div>
                        <!-- review details -->
                        <div class="common--review--input--wrapper">
                            <label class="common--review--lable" for="details">
                                <span>Product Review</span>
                                <span class="counter"> 2000/2000 </span>
                            </label>
                            <textarea class="common--review--input textarea"
                                      placeholder="Example: Since i bought this a month ago, it has been used a lot. What i like best this product is..."
                                      name="review" maxlength="2000" id="details" required></textarea>
                            <!-- error--msg -->
                            <div class="error--msg--review--modal">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.00002 3C7.41423 3.00001 7.75001 3.3358 7.75 3.75001L7.74994 7.25001C7.74994 7.66423 7.41414 8.00001 6.99993 8C6.58572 7.99999 6.24994 7.6642 6.24994 7.24999L6.25 3.74999C6.25001 3.33577 6.5858 2.99999 7.00002 3Z"
                                        fill="#8E1F0B"></path>
                                    <path
                                        d="M8 10C8 10.5523 7.55228 11 7 11C6.44772 11 6 10.5523 6 10C6 9.44772 6.44772 9 7 9C7.55228 9 8 9.44772 8 10Z"
                                        fill="#8E1F0B"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M14 7C14 10.866 10.866 14 7 14C3.13401 14 0 10.866 0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7ZM12.5 7C12.5 10.0376 10.0376 12.5 7 12.5C3.96243 12.5 1.5 10.0376 1.5 7C1.5 3.96243 3.96243 1.5 7 1.5C10.0376 1.5 12.5 3.96243 12.5 7Z"
                                          fill="#8E1F0B"></path>
                                </svg>
                                @if ($errors->has('review'))
                                    <span>{{ $errors->first('review') }}</span>
                                @endif
                            </div>
                        </div>
                        <!-- image upload wrapper -->
                        <div class="review-image--upload--wrapper">
                            <div class="uploaded--images--wrapper">
                                <!-- Image uploader input -->
                                <label for="review-image" class="common--image--box add--image--box">
                                    <div class="upload-icon">
                                        <img src="{{ asset('/frontend/assets/images/upload_image_icon.svg') }}" alt="Upload Icon">
                                    </div>
                                    <div class="image--load--count">
                                        <span>Photo</span>
                                        <span class="remaining--image">(5/5)</span> <!-- Dynamic count -->
                                    </div>
                                    <input type="file" hidden name="image[]" id="review-image" multiple accept=".jpeg, .jpg, .png">
                                </label>
                            </div>

                            <div class="upload--state--bar"></div>
                        </div>
                        <!-- name -->
                        <div class="common--review--input--wrapper">
                            <label class="common--review--lable">
                                <span>Customer Name</span>
                                <span class="name--format--wrapper">
                            <span class="name-display">
                              <span>Name display format</span>
                              <span class="name-selected" id="name-format-display">(John Smith)</span>
                            </span>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                              <path d="M5.5 10L8 12.5L10.5 10M5.5 6L8 3.5L10.5 6" stroke="#9E9E9E" stroke-width="1.5"
                                    stroke-linecap="round" stroke-linejoin="round" />
                            </svg>

                                    <!-- format types -->
                            <div class="name--formats--container">
                              <input type="radio" checked name="name_format" id="format_1" value="John Smith" />
                              <label for="format_1">John Smith</label>
                              <input type="radio" name="name_format" id="format_2" value="John S." />
                              <label for="format_2">John S.</label>
                              <input type="radio" name="name_format" id="format_3" value="J.S." />
                              <label for="format_3">J.S.</label>
                              <input type="radio" name="name_format" id="format_4" value="Anonymous" />
                              <label for="format_4">Anonymous</label>
                            </div>
                          </span>
                            </label>
                            <input class="common--review--input" placeholder="Type your name here" type="name" value="{{ Auth::user()->name }}" name="name" id="name" />

                            <!-- error--msg -->
                            <div class="error--msg--review--modal">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.00002 3C7.41423 3.00001 7.75001 3.3358 7.75 3.75001L7.74994 7.25001C7.74994 7.66423 7.41414 8.00001 6.99993 8C6.58572 7.99999 6.24994 7.6642 6.24994 7.24999L6.25 3.74999C6.25001 3.33577 6.5858 2.99999 7.00002 3Z"
                                        fill="#8E1F0B"></path>
                                    <path
                                        d="M8 10C8 10.5523 7.55228 11 7 11C6.44772 11 6 10.5523 6 10C6 9.44772 6.44772 9 7 9C7.55228 9 8 9.44772 8 10Z"
                                        fill="#8E1F0B"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M14 7C14 10.866 10.866 14 7 14C3.13401 14 0 10.866 0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7ZM12.5 7C12.5 10.0376 10.0376 12.5 7 12.5C3.96243 12.5 1.5 10.0376 1.5 7C1.5 3.96243 3.96243 1.5 7 1.5C10.0376 1.5 12.5 3.96243 12.5 7Z"
                                          fill="#8E1F0B"></path>
                                </svg>
                                @if ($errors->has('name'))
                                    <span>{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <!-- email -->
                        <div class="common--review--input--wrapper">
                            <label class="common--review--lable" for="email">
                                <span>Customer Email</span>
                            </label>
                                <input class="common--review--input"
                                       placeholder="Your email is private and is used to send you discount vouchers" type="email" name="email"
                                       id="email" value="{{ Auth::user()->email }}" />

                            <!-- error--msg -->
                            <div class="error--msg--review--modal">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.00002 3C7.41423 3.00001 7.75001 3.3358 7.75 3.75001L7.74994 7.25001C7.74994 7.66423 7.41414 8.00001 6.99993 8C6.58572 7.99999 6.24994 7.6642 6.24994 7.24999L6.25 3.74999C6.25001 3.33577 6.5858 2.99999 7.00002 3Z"
                                        fill="#8E1F0B"></path>
                                    <path
                                        d="M8 10C8 10.5523 7.55228 11 7 11C6.44772 11 6 10.5523 6 10C6 9.44772 6.44772 9 7 9C7.55228 9 8 9.44772 8 10Z"
                                        fill="#8E1F0B"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M14 7C14 10.866 10.866 14 7 14C3.13401 14 0 10.866 0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7ZM12.5 7C12.5 10.0376 10.0376 12.5 7 12.5C3.96243 12.5 1.5 10.0376 1.5 7C1.5 3.96243 3.96243 1.5 7 1.5C10.0376 1.5 12.5 3.96243 12.5 7Z"
                                          fill="#8E1F0B"></path>
                                </svg>
                                @if ($errors->has('email'))
                                    <span>{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <!-- submit -->
                        <button type="submit" class="review-submit--btn">Submit Review</button>

                    </form>
                @else
                    <form action="{{ route('product.review.store', $product->id) }}" method="POST" id="reviewForm" enctype="multipart/form-data" class="modal-body">
                        @csrf

                        <input type="hidden" name="user_id" value="" />
                        <input type="hidden" id="product_id" name="product_id" value="{{ $product->id }}" />

                        <!-- product image and rating -->
                        <div class="review--product---rating--row">
                            <!-- product--image  -->
                            <div class="reviewed--product--img">
                                @foreach($product->images->take(1) as $image)
                                    <img src="{{ asset($image->image) }}" alt="" />
                                @endforeach
                            </div>
                            <!-- rating -->
                            <div class="reviewed--product--rating--wrapper">
                                <div class="reviewed--product---name">
                                    {{ $product->name }}
                                </div>
                                <div class="rating">
                                    <input type="radio" id="star1" name="rating" value="5" required/>
                                    <label for="star1">
                                        <svg class="star" width="35" height="31">
                                            <path
                                                d="M12 .587l3.668 7.431 8.215 1.187-5.935 5.773 1.4 8.151L12 18.897l-7.348 3.865 1.4-8.151-5.935-5.773 8.215-1.187z" />
                                        </svg></label>

                                    <input type="radio" id="star2" name="rating" value="4" required/>
                                    <label for="star2"><svg class="star" width="35" height="31">
                                            <path
                                                d="M12 .587l3.668 7.431 8.215 1.187-5.935 5.773 1.4 8.151L12 18.897l-7.348 3.865 1.4-8.151-5.935-5.773 8.215-1.187z" />
                                        </svg></label>

                                    <input type="radio" id="star3" name="rating" value="3" required/>
                                    <label for="star3"><svg class="star" width="35" height="31">
                                            <path
                                                d="M12 .587l3.668 7.431 8.215 1.187-5.935 5.773 1.4 8.151L12 18.897l-7.348 3.865 1.4-8.151-5.935-5.773 8.215-1.187z" />
                                        </svg></label>

                                    <input type="radio" id="star4" name="rating" value="2" required/>
                                    <label for="star4"><svg class="star" width="35" height="31">
                                            <path
                                                d="M12 .587l3.668 7.431 8.215 1.187-5.935 5.773 1.4 8.151L12 18.897l-7.348 3.865 1.4-8.151-5.935-5.773 8.215-1.187z" />
                                        </svg></label>

                                    <input type="radio" id="star5" name="rating" value="1" required/>
                                    <label for="star5"><svg class="star" width="35" height="31">
                                            <path
                                                d="M12 .587l3.668 7.431 8.215 1.187-5.935 5.773 1.4 8.151L12 18.897l-7.348 3.865 1.4-8.151-5.935-5.773 8.215-1.187z" />
                                        </svg></label>
                                </div>
                                <!-- error--msg -->
                                <div class="error--msg--review--modal">
                                    <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M7.00002 3C7.41423 3.00001 7.75001 3.3358 7.75 3.75001L7.74994 7.25001C7.74994 7.66423 7.41414 8.00001 6.99993 8C6.58572 7.99999 6.24994 7.6642 6.24994 7.24999L6.25 3.74999C6.25001 3.33577 6.5858 2.99999 7.00002 3Z"
                                            fill="#8E1F0B"></path>
                                        <path
                                            d="M8 10C8 10.5523 7.55228 11 7 11C6.44772 11 6 10.5523 6 10C6 9.44772 6.44772 9 7 9C7.55228 9 8 9.44772 8 10Z"
                                            fill="#8E1F0B"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                              d="M14 7C14 10.866 10.866 14 7 14C3.13401 14 0 10.866 0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7ZM12.5 7C12.5 10.0376 10.0376 12.5 7 12.5C3.96243 12.5 1.5 10.0376 1.5 7C1.5 3.96243 3.96243 1.5 7 1.5C10.0376 1.5 12.5 3.96243 12.5 7Z"
                                              fill="#8E1F0B"></path>
                                    </svg>
                                    @if ($errors->has('rating'))
                                        <span>{{ $errors->first('rating') }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <!-- review title -->
                        <div class="common--review--input--wrapper">
                            <label class="common--review--lable" for="title">
                                <span>Review Title</span>
                                <span class="counter"> 100/100 </span>
                            </label>
                            <input class="common--review--input" placeholder="Example: Easy to use" type="text" name="title" id="title"
                                   maxlength="100" required />
                            <!-- error--msg -->
                            <div class="error--msg--review--modal">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.00002 3C7.41423 3.00001 7.75001 3.3358 7.75 3.75001L7.74994 7.25001C7.74994 7.66423 7.41414 8.00001 6.99993 8C6.58572 7.99999 6.24994 7.6642 6.24994 7.24999L6.25 3.74999C6.25001 3.33577 6.5858 2.99999 7.00002 3Z"
                                        fill="#8E1F0B"></path>
                                    <path
                                        d="M8 10C8 10.5523 7.55228 11 7 11C6.44772 11 6 10.5523 6 10C6 9.44772 6.44772 9 7 9C7.55228 9 8 9.44772 8 10Z"
                                        fill="#8E1F0B"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M14 7C14 10.866 10.866 14 7 14C3.13401 14 0 10.866 0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7ZM12.5 7C12.5 10.0376 10.0376 12.5 7 12.5C3.96243 12.5 1.5 10.0376 1.5 7C1.5 3.96243 3.96243 1.5 7 1.5C10.0376 1.5 12.5 3.96243 12.5 7Z"
                                          fill="#8E1F0B"></path>
                                </svg>
                                @if ($errors->has('title'))
                                    <span>{{ $errors->first('title') }}</span>
                                @endif
                            </div>

                        </div>
                        <!-- review details -->
                        <div class="common--review--input--wrapper">
                            <label class="common--review--lable" for="details">
                                <span>Product Review</span>
                                <span class="counter"> 2000/2000 </span>
                            </label>
                            <textarea class="common--review--input textarea"
                                      placeholder="Example: Since i bought this a month ago, it has been used a lot. What i like best this product is..."
                                      name="review" maxlength="2000" id="details" required></textarea>
                            <!-- error--msg -->
                            <div class="error--msg--review--modal">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.00002 3C7.41423 3.00001 7.75001 3.3358 7.75 3.75001L7.74994 7.25001C7.74994 7.66423 7.41414 8.00001 6.99993 8C6.58572 7.99999 6.24994 7.6642 6.24994 7.24999L6.25 3.74999C6.25001 3.33577 6.5858 2.99999 7.00002 3Z"
                                        fill="#8E1F0B"></path>
                                    <path
                                        d="M8 10C8 10.5523 7.55228 11 7 11C6.44772 11 6 10.5523 6 10C6 9.44772 6.44772 9 7 9C7.55228 9 8 9.44772 8 10Z"
                                        fill="#8E1F0B"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M14 7C14 10.866 10.866 14 7 14C3.13401 14 0 10.866 0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7ZM12.5 7C12.5 10.0376 10.0376 12.5 7 12.5C3.96243 12.5 1.5 10.0376 1.5 7C1.5 3.96243 3.96243 1.5 7 1.5C10.0376 1.5 12.5 3.96243 12.5 7Z"
                                          fill="#8E1F0B"></path>
                                </svg>
                                @if ($errors->has('review'))
                                    <span>{{ $errors->first('review') }}</span>
                                @endif
                            </div>
                        </div>
                        <!-- image upload wrapper -->
                        <div class="review-image--upload--wrapper">
                            <div class="uploaded--images--wrapper">
                                <!-- Image uploader input -->
                                <label for="review-image" class="common--image--box add--image--box">
                                    <div class="upload-icon">
                                        <img src="{{ asset('/frontend/assets/images/upload_image_icon.svg') }}" alt="Upload Icon">
                                    </div>
                                    <div class="image--load--count">
                                        <span>Photo</span>
                                        <span class="remaining--image">(5/5)</span> <!-- Dynamic count -->
                                    </div>
                                    <input type="file" hidden name="image[]" id="review-image" multiple accept=".jpeg, .jpg, .png">
                                </label>
                            </div>

                            <div class="upload--state--bar"></div>
                        </div>
                        <!-- name -->
                        <div class="common--review--input--wrapper">
                            <label class="common--review--lable">
                                <span>Customer Name</span>
                                <span class="name--format--wrapper">
                                <span class="name-display">
                                  <span>Name display format</span>
                                  <span class="name-selected" id="name-format-display">(John Smith)</span>
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                  <path d="M5.5 10L8 12.5L10.5 10M5.5 6L8 3.5L10.5 6" stroke="#9E9E9E" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>

                                    <!-- format types -->
                                <div class="name--formats--container">
                                  <input type="radio" checked name="name_format" id="format_1" value="John Smith" />
                                  <label for="format_1">John Smith</label>
                                  <input type="radio" name="name_format" id="format_2" value="John S." />
                                  <label for="format_2">John S.</label>
                                  <input type="radio" name="name_format" id="format_3" value="J.S." />
                                  <label for="format_3">J.S.</label>
                                  <input type="radio" name="name_format" id="format_4" value="Anonymous" />
                                  <label for="format_4">Anonymous</label>
                                </div>
                              </span>
                            </label>
                            <input class="common--review--input" placeholder="Type your name here" type="name" name="name" id="name" />
                            <!-- error--msg -->
                            <div class="error--msg--review--modal">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.00002 3C7.41423 3.00001 7.75001 3.3358 7.75 3.75001L7.74994 7.25001C7.74994 7.66423 7.41414 8.00001 6.99993 8C6.58572 7.99999 6.24994 7.6642 6.24994 7.24999L6.25 3.74999C6.25001 3.33577 6.5858 2.99999 7.00002 3Z"
                                        fill="#8E1F0B"></path>
                                    <path
                                        d="M8 10C8 10.5523 7.55228 11 7 11C6.44772 11 6 10.5523 6 10C6 9.44772 6.44772 9 7 9C7.55228 9 8 9.44772 8 10Z"
                                        fill="#8E1F0B"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M14 7C14 10.866 10.866 14 7 14C3.13401 14 0 10.866 0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7ZM12.5 7C12.5 10.0376 10.0376 12.5 7 12.5C3.96243 12.5 1.5 10.0376 1.5 7C1.5 3.96243 3.96243 1.5 7 1.5C10.0376 1.5 12.5 3.96243 12.5 7Z"
                                          fill="#8E1F0B"></path>
                                </svg>
                                @if ($errors->has('name'))
                                    <span>{{ $errors->first('name') }}</span>
                                @endif
                            </div>
                        </div>
                        <!-- email -->
                        <div class="common--review--input--wrapper">
                            <label class="common--review--lable" for="email">
                                <span>Customer Email</span>
                            </label>
                                <input class="common--review--input"
                                       placeholder="Your email is private and is used to send you discount vouchers" type="email" name="email"
                                       id="email" />

                            <!-- error--msg -->
                            <div class="error--msg--review--modal">
                                <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M7.00002 3C7.41423 3.00001 7.75001 3.3358 7.75 3.75001L7.74994 7.25001C7.74994 7.66423 7.41414 8.00001 6.99993 8C6.58572 7.99999 6.24994 7.6642 6.24994 7.24999L6.25 3.74999C6.25001 3.33577 6.5858 2.99999 7.00002 3Z"
                                        fill="#8E1F0B"></path>
                                    <path
                                        d="M8 10C8 10.5523 7.55228 11 7 11C6.44772 11 6 10.5523 6 10C6 9.44772 6.44772 9 7 9C7.55228 9 8 9.44772 8 10Z"
                                        fill="#8E1F0B"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M14 7C14 10.866 10.866 14 7 14C3.13401 14 0 10.866 0 7C0 3.13401 3.13401 0 7 0C10.866 0 14 3.13401 14 7ZM12.5 7C12.5 10.0376 10.0376 12.5 7 12.5C3.96243 12.5 1.5 10.0376 1.5 7C1.5 3.96243 3.96243 1.5 7 1.5C10.0376 1.5 12.5 3.96243 12.5 7Z"
                                          fill="#8E1F0B"></path>
                                </svg>
                                @if ($errors->has('email'))
                                    <span>{{ $errors->first('email') }}</span>
                                @endif
                            </div>
                        </div>
                        <!-- submit -->
                        <button type="submit" class="review-submit--btn">Submit Review</button>

                    </form>
                @endif
            </div>
        </div>
    </div>
    <!-- write review modal ends -->

    <!-- review submit success modal starts -->
    @if(session('success'))
        @if(Auth::check())
            <!-- review submit success modal starts -->
            <div class="modal fade show" id="success-modal" tabindex="-1" aria-labelledby="write-review-modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h3 class="success-modal--title">Review submitted successfully!</h3>
                            <p class="success-modal--subtitle">
                                Thank you for spending time sharing your experience and leaving feedback,
                                it will be very beneficial for other customers.
                            </p>
                            <div class="success--icon">
                                <img src="{{ asset('/frontend/assets/images/success-icon.svg') }}" alt="">
                            </div>

                            @if(session('review'))
                                @php
                                    $review = session('review');
                                @endphp
                                <div class="reviewed--details--box">
                                    <div class="reviewed--details--header">
                                        <div class="reviewed--details---image">
                                            @foreach($product->images->take(1) as $image)
                                                <img src="{{asset($image->image) }}" alt="">
                                            @endforeach
                                        </div>
                                        <div class="reviewed--details---names">
                                            <div class="reviewed---product--name">{{ $product->name }}</div>
                                            <div class="reviewed---product--total--star">
                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                @endfor
                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="reviewed---title">{{ $review['title'] }}</div>
                                    <div class="reviewed---subtitle">{{ $review['review'] }}</div>
                                    <div class="reviewed--email">
                                        <span class="reviewed--user--name">{{ $review['name'] }}</span>
                                        <span class="reviewed--user--email">{{ $review['email'] }}</span>
                                    </div>
                                </div>
                            @endif

                            <form id="clear-session-form-user" action="{{ route('user.clear.session') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                            <button type="button" class="review-submit--btn ok--success" data-bs-dismiss="modal" onclick="document.getElementById('clear-session-form-user').submit();">Ok</button>

                        </div>
                    </div>
                </div>
            </div>
            <!-- review submit success modal ends -->
        @else
            <!-- review submit success modal starts -->
            <div class="modal fade show" id="success-modal" tabindex="-1" aria-labelledby="write-review-modal" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-body">
                            <h3 class="success-modal--title">Review submitted successfully!</h3>
                            <p class="success-modal--subtitle">
                                Thank you for spending time sharing your experience and leaving feedback,
                                it will be very beneficial for other customers.
                            </p>
                            <div class="success--icon">
                                <img src="{{ asset('/frontend/assets/images/success-icon.svg') }}" alt="">
                            </div>

                            @if(session('review'))
                                @php
                                    $review = session('review');
                                @endphp
                                <div class="reviewed--details--box">
                                    <div class="reviewed--details--header">
                                        <div class="reviewed--details---image">
                                            @foreach($product->images->take(1) as $image)
                                                <img src="{{asset($image->image) }}" alt="">
                                            @endforeach
                                        </div>
                                        <div class="reviewed--details---names">
                                            <div class="reviewed---product--name">{{ $product->name }}</div>
                                            <div class="reviewed---product--total--star">
                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                @endfor
                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                @endfor
                                            </div>
                                        </div>
                                    </div>
                                    <div class="reviewed---title">{{ $review['title'] }}</div>
                                    <div class="reviewed---subtitle">{{ $review['review'] }}</div>
                                    <div class="reviewed--email">
                                        <span class="reviewed--user--name">{{ $review['name'] }}</span>
                                        <span class="reviewed--user--email">{{ $review['email'] }}</span>
                                    </div>
                                </div>
                            @endif

                            <form id="clear-session-form" action="{{ route('clear.session') }}" method="POST" style="display: none;">
                                @csrf
                            </form>

                            <button type="button" class="review-submit--btn ok--success" data-bs-dismiss="modal" onclick="document.getElementById('clear-session-form').submit();">Ok</button>

                        </div>
                    </div>
                </div>
            </div>
            <!-- review submit success modal ends -->
        @endif
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            @if(session('success'))
            var successModal = new bootstrap.Modal(document.getElementById('success-modal'));
            successModal.show();
            @endif
        });
    </script>

{{--    Report Review modal--}}
    @foreach($reviews as $review)
    <!-- report review modal starts  -->
    <div class="modal fade" id="report--review--modal{{ $review->id }}" tabindex="-1" aria-labelledby="report--review--modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <h2 class="report--review--title">Report this review</h2>
                    <h3 class="report--review--subtitle">Thank you for taking the time to help <b>be5c79-59</b>.
                        Your report is anonymous.</h3>
                    <form action="{{ route('user.product.review.report.store', $review->id) }}" method="POST" class="report--review--form">
                        @csrf

                        <input type="hidden" name="user_id" value="{{ Auth::user()->id ?? null }}" />
                        <input type="hidden" name="product_id" value="{{ $product->id }}" />
                        <input type="hidden" name="review_id" value="{{ $review->id }}" />

                        <!-- report one  -->
                        <div class="report--review--input--wrapper">
                            <input type="radio" class="report--review--radio" value="Review contains private information." id="report--one" name="report" />
                            <label class="report--review--label" for="report--one">Review contains private information.</label>
                        </div>
                        <!-- report two -->
                        <div class="report--review--input--wrapper">
                            <input type="radio" class="report--review--radio" value="Review contains objectionable language." id="report--two" name="report" />
                            <label class="report--review--label" for="report--two">Review contains objectionable language.</label>
                        </div>
                        <!-- report three -->
                        <div class="report--review--input--wrapper">
                            <input type="radio" class="report--review--radio" value="Review contains advertising or spam." id="report--three" name="report" />
                            <label class="report--review--label" for="report--three">Review contains advertising or spam.</label>
                        </div>
                        <!-- report four -->
                        <div class="report--review--input--wrapper">
                            <input type="radio" class="report--review--radio" value="Review contains violent and disgusting content." id="report--four" name="report" />
                            <label class="report--review--label" for="report--four">Review contains violent and disgusting content.</label>
                        </div>

                        <!-- report five -->
                        <div class="report--review--input--wrapper">
                            <input type="radio" class="report--review--radio" value="Other violations." id="report--five" name="report" />
                            <label class="report--review--label" for="report--five">Other violations.</label>
                        </div>

                        <button type="submit" class="review-submit--btn align-self-center mt-4">Report this review</>
                    </form>

                </div>

            </div>
        </div>
    </div>
    <!-- report review modal ends -->
    @endforeach

{{--    Review Report --}}
    <script>
        $(document).ready(function() {
            // Handle form submission
            $(document).on('submit', '.report--review--form', function(e) {
                e.preventDefault(); // Prevent the default form submission

                const form = $(this); // Reference to the form being submitted
                const url = form.attr('action'); // Get the action URL from the form
                const formData = form.serialize(); // Serialize the form data

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData, // Send serialized form data
                    success: function(response) {
                        if (response.success) {
                            // Optionally, close the modal
                            form.closest('.modal').modal('hide');
                            // Show the success modal
                            $('#report--review--success--modal').modal('show');
                        } else {
                            // Handle errors or validation messages
                            showErrorToast(response.message);
                        }
                    },
                    error: function(xhr) {
                        // Handle AJAX errors
                        showErrorToast(xhr.responseJSON.message);
                    }
                });
            });
        });
    </script>

    <!-- report review success  modal starts -->
    @if(session('success', true))
    <div class="modal fade" id="report--review--success--modal" tabindex="-1" aria-labelledby="report--review--success--modal" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="report-done--img">
                        <img src="{{ asset('/frontend/assets/images/report-done.svg') }}" alt="" srcset="">
                    </div>
                    <h3 class="report--review--subtitle">Thank you for taking the time to help <b>be5c79-59</b>.
                        Your report is anonymous.</h3>
                    <button class="review-submit--btn align-self-center mt-2" type="submit" data-bs-dismiss="modal">Done</button>
                </div>

            </div>
        </div>
    </div>
    @endif
    <!-- report review success  modal ends -->

    @foreach($reviews as $review)
    <!-- show review images modal with review starts -->
    <div class="modal fade common--modal--comment--box show--review--image--comment--box--modal " id="show--review--image--comment--box--modal{{$review->id}}" tabindex="-1" aria-labelledby="show--review--image--comment--box--modal{{ $review->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>

                <div class="modal-body">
                    <div class="show-review--modal--left--side">
                        @foreach($review->images->take(1) as $image)
                            <img src="{{ asset( $image->image ) }}" alt="" srcset="">
                        @endforeach
                    </div>
                    <div class="show-review--modal--right--side">
                        <a class="open--comments--image--gllery--btn" data-bs-toggle="modal" data-bs-target="#show--review--image--gallery--comment--box--modal{{ $review->id }}" >
                            <svg width="16" height="17" viewBox="0 0 16 17" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M8.68247 7.8001H16V3.19392C16 1.40366 15.0963 0.5 13.2798 0.5H8.68247V7.8001ZM7.32643 7.8001V0.5H2.72915C0.921458 0.5 0 1.39513 0 3.19392V7.8001H7.32643ZM8.68247 16.4996H13.2798C15.0963 16.4996 16 15.596 16 13.8057V9.1732H8.68247V16.4996ZM2.72915 16.4996H7.32643V9.1732H0.000370781V13.8061C0.000370781 15.6049 0.921458 16.5 2.72952 16.5" fill="#4A4A4A"></path>
                            </svg>
                            <span>All photos</span>
                        </a>
                        <div class="reviewed---box--in--modal">

                            <h3 class="review--title mt-1">Image from this review</h3>
                            <div class="reviewed--images--in--modal">
                                <div class="reviewed--image--in--modal">
                                    @foreach($review->images->take(1) as $image)
                                        <img src="{{ asset( $image->image ) }}" alt="" srcset="">
                                    @endforeach
                                </div>
                            </div>
                            <!-- review user -->
                            <div class="review-user--info--in--modal">
                                <div class="review-user--img--modal">
                                    @php
                                        // Get the first letter of each word in the user's name
                                        $nameParts = explode(' ', $review->name);
                                        $initials = '';
                                        foreach ($nameParts as $part) {
                                            $initials .= strtoupper(substr($part, 0, 1));
                                        }
                                    @endphp
                                    {{ $initials }}
                                </div>
                                <div class="review-user--img--modal--info">
                                    <h3 class="review-user--name--in--modal">

                                        @if($review->name_format === 'Anonymous')
                                            Anonymous
                                        @elseif($review->name_format === 'John Smith')
                                            {{ $review->name }}
                                        @elseif($review->name_format === 'John S.')
                                            @php
                                                $nameParts = explode(' ', $review->name);
                                            @endphp
                                            {{ $nameParts[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}  {{-- Format: Jhonathan A. --}}
                                        @elseif($review->name_format === 'J.S.')
                                            @php
                                                $nameParts = explode(' ', $review->name);
                                            @endphp
                                            {{ (isset($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) . '.' : '') . ' ' .
                                               (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') . ' ' .
                                               (isset($nameParts[2]) ? strtoupper(substr($nameParts[2], 0, 1)) . '.' : '') }}  {{-- Format: J. A. M. --}}
                                        @endif

                                    </h3>
                                    <span class="review-user--date--in--modal">Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                </div>
                            </div>
                            <!-- stars -->
                            <div class="review-stars--in--modal">
                                @for ($i = 0; $i < $review['rating']; $i++)
                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                @endfor
                                @for ($i = $review['rating']; $i < 5; $i++)
                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                @endfor
                            </div>
                            <P class="reviewed--in--modal--text fw-bolder">{{ $review->title }} </P>
                            <P class="reviewed--in--modal--text">{{ $review->review }}</P>
                            <hr>
                            <h3 class="review--title">Purchased item:</h3>
                            <a href="{{ route('product.detail', $product->product_slug) }}" class="reviewed--product---in--modal">
                                <div class="reviewed--in--modal--product--img">
                                    @foreach($product->images->take(1) as $image)
                                        <img src="{{ asset($image->image) }}" alt="" srcset="">
                                    @endforeach
                                </div>
                                <div class="reviewed--in--modal--product--info">
                                    <p class="reviewed--in--modal--product--name">
                                        {{ $product->name }}
                                    </p>
                                    <p class="reviewed--in--modal--product--price">
                                        <span class="fw-bolder">${{ $product->selling_price }}</span>
                                        @if($product->discount_price)
                                            <del>${{ $product->discount_price }}</del>
                                        @endif
                                    </p>
                                </div>
                            </a>


                            <div class="comment-like--btns">
                                @php
                                    $like_count = $review->likes->count();
                                    if(Auth::check()) {
                                    $userLiked = $review->likes->contains('user_id', Auth::user()->id);
                                    }else{
                                        $userLiked = false;
                                    }
                                    $isLoggedIn = Auth::check();
                                @endphp
                                @if($userLiked)
                                    <button class="comment-like-btn" disabled>
                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                        <span>({{ $like_count }})</span>
                                    </button>
                                @else
                                    @if(Auth::check())
                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                            <input type="hidden" name="likes" value="1" />
                                            <button class="comment-like-btn" type="submit">
                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                <span class="like-count">({{ $like_count }})</span>
                                            </button>
                                        </form>
                                    @else
                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                            <span>({{ $like_count }})</span>
                                        </button>
                                    @endif

                                @endif
                                <span class="button-separator"></span>

                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- show review images modal with review ends -->

    <!-- show review images gallery modal with review starts -->
    <div class="modal fade common--modal--comment--box gallery--images--tab" id="show--review--image--gallery--comment--box--modal{{ $review->id }}" tabindex="-1" aria-labelledby="show--review--image--comment--box--modal{{ $review->id }}" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                <div class="modal-body">
                    <h1 class="reviews--gallery--modal--title">Reviews Gallery</h1>

                    <div class="all--reviewed--images--gallery--wrapper use-fade-scale reviewed--images--gallery" id="reviewed--images--gallery">

                        <ul class="skltbs-tab-group">
                            <li class="skltbs-tab-item">
                                <button class="skltbs-tab">All</button>
                            </li>
                            <li class="skltbs-tab-item">
                                <button class="skltbs-tab">Images</button>
                            </li>
                            <li class="skltbs-tab-item">
                                <button class="skltbs-tab">
                                    <span>★</span><span>5</span>
                                </button>
                            </li>
                            <li class="skltbs-tab-item">
                                <button class="skltbs-tab">
                                    <span>★</span><span>4</span>
                                </button>
                            </li>
                            <li class="skltbs-tab-item">
                                <button class="skltbs-tab">
                                    <span>★</span><span>3</span>
                                </button>
                            </li>
                            <li class="skltbs-tab-item">
                                <button class="skltbs-tab">
                                    <span>★</span><span>2</span>
                                </button>
                            </li>
                            <li class="skltbs-tab-item">
                                <button class="skltbs-tab">
                                    <span>★</span><span>1</span>
                                </button>
                            </li>
                        </ul>

                        <div class="skltbs-panel-group">

                            @php
                                $product_review_images = \App\Models\ProductReviewImage::where('product_id',$product->id)->get();

                                // Get 5-star active reviews
                                $five_star_reviews = \App\Models\ProductReview::where('product_id', $product->id)
                                    ->where('status', 'active')
                                    ->where('rating', 5)
                                    ->get();

                                // Get images for 5-star reviews
                                $five_star_review_images = \App\Models\ProductReviewImage::whereIn('product_review_id', $five_star_reviews->pluck('id'))->get();

                                // Get 4-star active reviews
                                $four_star_reviews = \App\Models\ProductReview::where('product_id', $product->id)
                                    ->where('status', 'active')
                                    ->where('rating', 4)
                                    ->get();

                                // Get images for 4-star reviews
                                $four_star_review_images = \App\Models\ProductReviewImage::whereIn('product_review_id', $four_star_reviews->pluck('id'))->get();

                                // Get 3-star active reviews
                                $three_star_reviews = \App\Models\ProductReview::where('product_id', $product->id)
                                    ->where('status', 'active')
                                    ->where('rating', 3)
                                    ->get();

                                // Get images for 3-star reviews
                                $three_star_review_images = \App\Models\ProductReviewImage::whereIn('product_review_id', $three_star_reviews->pluck('id'))->get();

                                // Get 2-star active reviews
                                $two_star_reviews = \App\Models\ProductReview::where('product_id', $product->id)
                                    ->where('status', 'active')
                                    ->where('rating', 2)
                                    ->get();

                                // Get images for 2-star reviews
                                $two_star_review_images = \App\Models\ProductReviewImage::whereIn('product_review_id', $two_star_reviews->pluck('id'))->get();

                                // Get 1-star active reviews
                                $one_star_reviews = \App\Models\ProductReview::where('product_id', $product->id)
                                    ->where('status', 'active')
                                    ->where('rating', 1)
                                    ->get();

                                // Get images for 1-star reviews
                                $one_star_review_images = \App\Models\ProductReviewImage::whereIn('product_review_id', $one_star_reviews->pluck('id'))->get();
                            @endphp

{{--                            All--}}
                            <div class="skltbs-panel">
                                <!-- if review images available comments available of this type -->
                                <div class="reviews---gallery--wrapper">
                                    @foreach($product_review_images as $image)
                                        <div class="reviews--images--in--gallery">
                                            <img src="{{ asset($image->image) }}" alt="" srcset="">
                                        </div>
                                    @endforeach
                                </div>

                            </div>
{{--                             Images--}}
                            <div class="skltbs-panel">
                                @if($product_review_images->isNotEmpty())
                                    <!-- if review images available comments available of this type -->
                                    <div class="reviews---gallery--wrapper">
                                        @foreach($product_review_images as $image)
                                            <div class="reviews--images--in--gallery">
                                                <img src="{{ asset($image->image) }}" alt="" srcset="">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- if no comments available of this type -->
                                    <div class="no--comments--available">
                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                        <div class="no-review-emoji">
                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                        </div>
                                    </div>
                                @endif
                            </div>

{{--                              5--}}
                            <div class="skltbs-panel">
                                @if($five_star_review_images->isNotEmpty())
                                    <!-- if review images available comments available of this type -->
                                    <div class="reviews---gallery--wrapper">
                                        @foreach($five_star_review_images as $image)
                                            <div class="reviews--images--in--gallery">
                                                <img src="{{ asset($image->image) }}" alt="" srcset="">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- if no comments available of this type -->
                                    <div class="no--comments--available">
                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                        <div class="no-review-emoji">
                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                        </div>
                                    </div>
                                @endif
                            </div>
{{--                             4--}}
                            <div class="skltbs-panel">
                                @if($four_star_review_images->isNotEmpty())
                                    <!-- if review images available comments available of this type -->
                                    <div class="reviews---gallery--wrapper">
                                        @foreach($four_star_review_images as $image)
                                            <div class="reviews--images--in--gallery">
                                                <img src="{{ asset($image->image) }}" alt="" srcset="">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- if no comments available of this type -->
                                    <div class="no--comments--available">
                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                        <div class="no-review-emoji">
                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                        </div>
                                    </div>
                                @endif
                            </div>
{{--                             3--}}
                            <div class="skltbs-panel">
                                @if($three_star_review_images->isNotEmpty())
                                    <!-- if review images available comments available of this type -->
                                    <div class="reviews---gallery--wrapper">
                                        @foreach($three_star_review_images as $image)
                                            <div class="reviews--images--in--gallery">
                                                <img src="{{ asset($image->image) }}" alt="" srcset="">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- if no comments available of this type -->
                                    <div class="no--comments--available">
                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                        <div class="no-review-emoji">
                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                        </div>
                                    </div>
                                @endif
                            </div>
{{--                             2--}}
                            <div class="skltbs-panel">
                                @if($two_star_review_images->isNotEmpty())
                                    <!-- if review images available comments available of this type -->
                                    <div class="reviews---gallery--wrapper">
                                        @foreach($two_star_review_images as $image)
                                            <div class="reviews--images--in--gallery">
                                                <img src="{{ asset($image->image) }}" alt="" srcset="">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- if no comments available of this type -->
                                    <div class="no--comments--available">
                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                        <div class="no-review-emoji">
                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                        </div>
                                    </div>
                                @endif
                            </div>
{{--                             1--}}
                            <div class="skltbs-panel">
                                @if($one_star_review_images->isNotEmpty())
                                    <!-- if review images available comments available of this type -->
                                    <div class="reviews---gallery--wrapper">
                                        @foreach($one_star_review_images as $image)
                                            <div class="reviews--images--in--gallery">
                                                <img src="{{ asset($image->image) }}" alt="" srcset="">
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- if no comments available of this type -->
                                    <div class="no--comments--available">
                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                        <div class="no-review-emoji">
                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                        </div>
                                    </div>
                                @endif
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- show review images gallery modal with review ends -->
    @endforeach

    <!-- Canvas for confetti -->
    <canvas id="confetti-canvas"></canvas>

    <!-- header area starts -->
    <header class="marquee-header">
        <div data-speed="180" data-direction="left" class='marquee-text'>Free Shipping Worldwide!</div>
    </header>
    <!-- header area starts -->

    <div class="product-details--page-wrapper">

        <!-- icon header -->
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

        <div class="container product-details--page--container">
            <div class="product-details--container">
                <div class="product-details--time-cart-logo">
                    <!-- logo -->
                    <a href="{{ route('home') }}" class="product-details-page-logo">
                        <img src="{{ asset('/frontend/assets/images/transparent-background--black-gif.gif') }}" alt="" srcset="" />
                    </a>
                    <!-- time -->
                    <div class="home-time-and-date margin-time">
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
                        <span class="show-cart-item">Cart</span>
                        <span class="cart-count--product-details">{{ $cart_count}}</span>
                    </div>
                </div>
                <!-- product details -->

                <div class="product-details--content---container">
                    <div class="product-preview--container">
                        @foreach($product->images as $image)
                            <img id="zoom-image" src="{{ asset($image->image) }}" alt="" srcset="" />
                        @endforeach
                    </div>
                    <div class="product-details--info">

                        @if($product->quantity <= 0)
                            <span class="product-status--product--details on-sale">Sold Out</span>
                        @else
                            <span class="product-status--product--details on-sale">On Sale</span>
                        @endif

                        <!-- name and description -->
                        <div class="product-details--name---des">
                            <h1 class="product-name--product--details">
                                {{ $product->name }}
                            </h1>
                            <div class="product-description--product--details">
                                {!! $product->description !!}
                            </div>
                        </div>
                        <!-- thumb-image -->
                        <div class="thumb-image--box" >
                            @foreach($product->images as $image)
                                <div class="thumb--item">
                                    <img src="{{ asset($image->image) }}" alt="" srcset="" />
                                </div>
                            @endforeach
                        </div>
                        <!-- price section -->
                        <div class="product-details--price--section">
                            <p class="current-price">${{ $product->selling_price }}</p>
                            <div class="previous-price">
                                <span>Was: </span><del>${{ $product->discount_price }}</del>
                            </div>
                        </div>
                        <!-- color and size  -->
                        <form class="product-details--color---size---section">

                            <!-- Color -->
                            <div class="size-and--next">
                                @if($product->productColors && count($product->productColors) > 0)
                                    <select class="m-right" name="color_id" id="color" required>
                                        @foreach($product->productColors as $color)
                                            @if($color->color)
                                                <option value="{{ $color->color->id }}">{{ $color->color->color }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select class="m-right" name="color_id" id="color" required>
                                        <option value="">No Color</option>
                                    </select>
                                @endif
                                @if(Auth::check())
                                    @php
                                        $wishlist = \App\Models\Wishlist::where('user_id', Auth::user()->id)->where('product_id', $product->id)->first();
                                    @endphp
                                    @if(!$wishlist)
                                        <a href="{{ route('product.wishlist', ['productID' => $product->id, 'color_id' => '', 'size_id' => ''] )  }}" data-product-id="{{ $product->id }}" id="wishlist-toggle" class="wishlist-add next-item--btn red-background--route show-cart-item">
                                            <span id="wishlist-button-text">Add to Wishlist</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M8.54654 3.72001L7.99988 4.26801L7.45054 3.71867C6.77849 3.0467 5.86701 2.66923 4.91664 2.66929C3.96627 2.66935 3.05485 3.04695 2.38288 3.719C1.71091 4.39106 1.33343 5.30254 1.3335 6.25291C1.33356 7.20328 1.71115 8.1147 2.38321 8.78667L7.64654 14.05C7.7403 14.1436 7.86738 14.1962 7.99988 14.1962C8.13238 14.1962 8.25946 14.1436 8.35321 14.05L13.6212 8.78534C14.2925 8.11322 14.6695 7.20211 14.6693 6.2522C14.6692 5.30229 14.292 4.39128 13.6205 3.71934C13.2875 3.38603 12.892 3.12163 12.4567 2.94123C12.0213 2.76083 11.5548 2.66798 11.0835 2.66798C10.6123 2.66798 10.1457 2.76083 9.71044 2.94123C9.27513 3.12163 8.87963 3.3867 8.54654 3.72001ZM12.9119 8.07934L7.99988 12.99L3.08988 8.08001C2.8479 7.84059 2.65562 7.5557 2.5241 7.24173C2.39258 6.92776 2.32441 6.5909 2.3235 6.25049C2.3226 5.91009 2.38898 5.57286 2.51882 5.2582C2.64867 4.94353 2.83943 4.65763 3.08013 4.41693C3.32084 4.17623 3.60674 3.98547 3.9214 3.85562C4.23607 3.72577 4.57329 3.65939 4.9137 3.6603C5.2541 3.6612 5.59097 3.72937 5.90494 3.86089C6.21891 3.99242 6.50379 4.18469 6.74321 4.42667L7.64854 5.33134C7.69565 5.3785 7.7517 5.41576 7.81341 5.44094C7.87513 5.46612 7.94125 5.47871 8.0079 5.47796C8.07454 5.47721 8.14037 5.46315 8.2015 5.4366C8.26263 5.41005 8.31784 5.37154 8.36388 5.32334L9.25321 4.42667C9.74342 3.97039 10.3915 3.72201 11.0611 3.73379C11.7307 3.74558 12.3696 4.0166 12.8435 4.48984C13.3173 4.96309 13.5891 5.60167 13.6018 6.27125C13.6144 6.94083 13.3675 7.58855 12.9119 8.07934Z" fill="#23282D"/>
                                            </svg>
                                        </a>
                                    @else
                                        <a href="{{ route('product.wishlist', ['productID' => $product->id, 'color_id' => '', 'size_id' => ''] )  }}" id="wishlist-toggle" class="wishlist-add next-item--btn red-background--route show-cart-item">
                                            <span id="wishlist-text">Remove from Wishlist</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                                <path d="M8.54654 3.72001L7.99988 4.26801L7.45054 3.71867C6.77849 3.0467 5.86701 2.66923 4.91664 2.66929C3.96627 2.66935 3.05485 3.04695 2.38288 3.719C1.71091 4.39106 1.33343 5.30254 1.3335 6.25291C1.33356 7.20328 1.71115 8.1147 2.38321 8.78667L7.64654 14.05C7.7403 14.1436 7.86738 14.1962 7.99988 14.1962C8.13238 14.1962 8.25946 14.1436 8.35321 14.05L13.6212 8.78534C14.2925 8.11322 14.6695 7.20211 14.6693 6.2522C14.6692 5.30229 14.292 4.39128 13.6205 3.71934C13.2875 3.38603 12.892 3.12163 12.4567 2.94123C12.0213 2.76083 11.5548 2.66798 11.0835 2.66798C10.6123 2.66798 10.1457 2.76083 9.71044 2.94123C9.27513 3.12163 8.87963 3.3867 8.54654 3.72001ZM12.9119 8.07934L7.99988 12.99L3.08988 8.08001C2.8479 7.84059 2.65562 7.5557 2.5241 7.24173C2.39258 6.92776 2.32441 6.5909 2.3235 6.25049C2.3226 5.91009 2.38898 5.57286 2.51882 5.2582C2.64867 4.94353 2.83943 4.65763 3.08013 4.41693C3.32084 4.17623 3.60674 3.98547 3.9214 3.85562C4.23607 3.72577 4.57329 3.65939 4.9137 3.6603C5.2541 3.6612 5.59097 3.72937 5.90494 3.86089C6.21891 3.99242 6.50379 4.18469 6.74321 4.42667L7.64854 5.33134C7.69565 5.3785 7.7517 5.41576 7.81341 5.44094C7.87513 5.46612 7.94125 5.47871 8.0079 5.47796C8.07454 5.47721 8.14037 5.46315 8.2015 5.4366C8.26263 5.41005 8.31784 5.37154 8.36388 5.32334L9.25321 4.42667C9.74342 3.97039 10.3915 3.72201 11.0611 3.73379C11.7307 3.74558 12.3696 4.0166 12.8435 4.48984C13.3173 4.96309 13.5891 5.60167 13.6018 6.27125C13.6144 6.94083 13.3675 7.58855 12.9119 8.07934Z" fill="#23282D"/>
                                            </svg>
                                        </a>
                                    @endif
                                @else
{{--                                    <a href="#" onclick="checkAuthentication()" class="next-item--btn red-background--route">--}}
{{--                                        <span >Add to Wishlist</span>--}}
{{--                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">--}}
{{--                                            <path d="M8.54654 3.72001L7.99988 4.26801L7.45054 3.71867C6.77849 3.0467 5.86701 2.66923 4.91664 2.66929C3.96627 2.66935 3.05485 3.04695 2.38288 3.719C1.71091 4.39106 1.33343 5.30254 1.3335 6.25291C1.33356 7.20328 1.71115 8.1147 2.38321 8.78667L7.64654 14.05C7.7403 14.1436 7.86738 14.1962 7.99988 14.1962C8.13238 14.1962 8.25946 14.1436 8.35321 14.05L13.6212 8.78534C14.2925 8.11322 14.6695 7.20211 14.6693 6.2522C14.6692 5.30229 14.292 4.39128 13.6205 3.71934C13.2875 3.38603 12.892 3.12163 12.4567 2.94123C12.0213 2.76083 11.5548 2.66798 11.0835 2.66798C10.6123 2.66798 10.1457 2.76083 9.71044 2.94123C9.27513 3.12163 8.87963 3.3867 8.54654 3.72001ZM12.9119 8.07934L7.99988 12.99L3.08988 8.08001C2.8479 7.84059 2.65562 7.5557 2.5241 7.24173C2.39258 6.92776 2.32441 6.5909 2.3235 6.25049C2.3226 5.91009 2.38898 5.57286 2.51882 5.2582C2.64867 4.94353 2.83943 4.65763 3.08013 4.41693C3.32084 4.17623 3.60674 3.98547 3.9214 3.85562C4.23607 3.72577 4.57329 3.65939 4.9137 3.6603C5.2541 3.6612 5.59097 3.72937 5.90494 3.86089C6.21891 3.99242 6.50379 4.18469 6.74321 4.42667L7.64854 5.33134C7.69565 5.3785 7.7517 5.41576 7.81341 5.44094C7.87513 5.46612 7.94125 5.47871 8.0079 5.47796C8.07454 5.47721 8.14037 5.46315 8.2015 5.4366C8.26263 5.41005 8.31784 5.37154 8.36388 5.32334L9.25321 4.42667C9.74342 3.97039 10.3915 3.72201 11.0611 3.73379C11.7307 3.74558 12.3696 4.0166 12.8435 4.48984C13.3173 4.96309 13.5891 5.60167 13.6018 6.27125C13.6144 6.94083 13.3675 7.58855 12.9119 8.07934Z" fill="#23282D"/>--}}
{{--                                        </svg>--}}
{{--                                    </a>--}}

                                        @php
                                            // Get the current wishlist from session
                                            $wishlistSessionKey = 'wishlist_' . session()->getId();
                                            $wishlistItems = session()->get($wishlistSessionKey, []);

                                            // Check if the current product is in the wishlist
                                            $productID = $product->id;
                                            $colorID = request()->input('color_id');
                                            $sizeID = request()->input('size_id');
                                            $existingItemKey = "{$productID}_{$colorID}_{$sizeID}";
                                        @endphp

                                        <a href="javascript:void(0);" data-product-id="{{ $product->id }}" id="wishlist-toggle-guest" class="next-item--btn red-background--route">
                                        <span id="wishlist-button-text">
                                            @if(array_key_exists($existingItemKey, $wishlistItems))
                                                Remove from Wishlist
                                            @else
                                                Add to Wishlist
                                            @endif</span>
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 16 16" fill="none">
                                            <path d="M8.54654 3.72001L7.99988 4.26801L7.45054 3.71867C6.77849 3.0467 5.86701 2.66923 4.91664 2.66929C3.96627 2.66935 3.05485 3.04695 2.38288 3.719C1.71091 4.39106 1.33343 5.30254 1.3335 6.25291C1.33356 7.20328 1.71115 8.1147 2.38321 8.78667L7.64654 14.05C7.7403 14.1436 7.86738 14.1962 7.99988 14.1962C8.13238 14.1962 8.25946 14.1436 8.35321 14.05L13.6212 8.78534C14.2925 8.11322 14.6695 7.20211 14.6693 6.2522C14.6692 5.30229 14.292 4.39128 13.6205 3.71934C13.2875 3.38603 12.892 3.12163 12.4567 2.94123C12.0213 2.76083 11.5548 2.66798 11.0835 2.66798C10.6123 2.66798 10.1457 2.76083 9.71044 2.94123C9.27513 3.12163 8.87963 3.3867 8.54654 3.72001ZM12.9119 8.07934L7.99988 12.99L3.08988 8.08001C2.8479 7.84059 2.65562 7.5557 2.5241 7.24173C2.39258 6.92776 2.32441 6.5909 2.3235 6.25049C2.3226 5.91009 2.38898 5.57286 2.51882 5.2582C2.64867 4.94353 2.83943 4.65763 3.08013 4.41693C3.32084 4.17623 3.60674 3.98547 3.9214 3.85562C4.23607 3.72577 4.57329 3.65939 4.9137 3.6603C5.2541 3.6612 5.59097 3.72937 5.90494 3.86089C6.21891 3.99242 6.50379 4.18469 6.74321 4.42667L7.64854 5.33134C7.69565 5.3785 7.7517 5.41576 7.81341 5.44094C7.87513 5.46612 7.94125 5.47871 8.0079 5.47796C8.07454 5.47721 8.14037 5.46315 8.2015 5.4366C8.26263 5.41005 8.31784 5.37154 8.36388 5.32334L9.25321 4.42667C9.74342 3.97039 10.3915 3.72201 11.0611 3.73379C11.7307 3.74558 12.3696 4.0166 12.8435 4.48984C13.3173 4.96309 13.5891 5.60167 13.6018 6.27125C13.6144 6.94083 13.3675 7.58855 12.9119 8.07934Z" fill="#23282D"/>
                                        </svg>
                                    </a>
                                @endif
                            </div>

                            <script>
                                $(document).ready(function() {
                                    // User Add or Remove Wishlist
                                    $(document).on('click', '#wishlist-toggle', function(e) {
                                        e.preventDefault();
                                        const productID = $(this).data('product-id');
                                        const colorID = document.getElementById('color') ? document.getElementById('color').value : '';
                                        const sizeID = document.getElementById('size') ? document.getElementById('size').value : '';
                                        const url = `{{ url('/product/wishlist') }}/${productID}`;

                                        $.ajax({
                                            url: url,
                                            type: 'POST',
                                            data: {
                                                _token: '{{ csrf_token() }}', // Include CSRF token for security
                                                color_id: colorID,
                                                size_id: sizeID
                                            },
                                            success: function(response) {
                                                if (response.success) {
                                                    // Handle adding to wishlist
                                                    $('#wishlist-button-text').text("Remove from Wishlist");
                                                    // Optionally, you can show a success message
                                                    updateWishlistDisplay(response); // Pass the updated wishlist item data

                                                } else {
                                                    // Handle removing from wishlist
                                                    $('#wishlist-button-text').text("Add to Wishlist");
                                                    console.log();
                                                    updateWishlistDisplay(response); // Update display to show no items
                                                }

                                            },
                                            error: function(xhr) {
                                                showErrorToast(xhr.responseJSON.message);
                                            }
                                        });
                                    });
                                });

                                $(document).ready(function() {
                                    // Function to update the button text based on the current wishlist state
                                    function updateWishlistButtonText() {
                                        const productID = $('#wishlist-toggle-guest').data('product-id');
                                        const colorID = $('#color').length ? $('#color').val() : ''; // Get color ID if it exists
                                        const sizeID = $('#size').length ? $('#size').val() : ''; // Get size ID if it exists

                                        // Create the key for this product in the wishlist
                                        const itemKey = `${productID}_${colorID}_${sizeID}`;

                                        // Get wishlist from sessionStorage (or an empty object if none exists)
                                        const wishlistItems = JSON.parse(sessionStorage.getItem('wishlistItem')) || {};

                                        // Check if this product is in sessionStorage
                                        if (wishlistItems.hasOwnProperty(itemKey)) {
                                            // If item is in wishlist, show "Remove from Wishlist"
                                            $('#wishlist-button-text').text('Remove from Wishlist');
                                        } else {
                                            // If item is NOT in wishlist, show "Add to Wishlist"
                                            $('#wishlist-button-text').text('Add to Wishlist');
                                        }
                                    }

                                    // Call the function to check wishlist on page load
                                    updateWishlistButtonText();

                                    // Listen for clicks to toggle wishlist
                                    $(document).on('click', '#wishlist-toggle-guest', function(e) {
                                        e.preventDefault();

                                        const productID = $(this).data('product-id');
                                        const colorID = $('#color').length ? $('#color').val() : ''; // Get color ID if it exists
                                        const sizeID = $('#size').length ? $('#size').val() : ''; // Get size ID if it exists
                                        const itemKey = `${productID}_${colorID}_${sizeID}`;

                                        // Fetch current wishlist from sessionStorage (or an empty object if none exists)
                                        let wishlistItems = JSON.parse(sessionStorage.getItem('wishlistItem') || '[]');

                                        // Toggle the wishlist item in sessionStorage
                                        if (wishlistItems.hasOwnProperty(itemKey)) {
                                            // Item exists in wishlist, remove it
                                            delete wishlistItems[itemKey];
                                        } else {
                                            // Item doesn't exist in wishlist, add it
                                            wishlistItems[itemKey] = {
                                                wishlistId: itemKey,
                                                product_id: productID,
                                                color: colorID,
                                                size: sizeID
                                            };
                                        }

                                        // Save the updated wishlist back to sessionStorage
                                        sessionStorage.setItem('wishlistItem', JSON.stringify(wishlistItems));

                                        // Update the button text based on the new state
                                        updateWishlistButtonText();
                                    });
                                });

                                // User
                                function updateWishlistDisplay(data) {
                                    console.log(data);
                                    const wishlistContainer = document.querySelector('.wishlist-container');
                                    const noItemsMessage = document.querySelector('.wishlist-container #wishlist-no-product'); // Ensure you reference the no items message correctly

                                    if (data.success) {
                                        data = data.wishlistItem;
                                        // Create color and size HTML if they exist
                                        let colorHTML = '';
                                        if (data.color) {
                                            colorHTML = `
                                            <div class="cart--item--color">
                                                <span>Color</span>: <span>${data.color.color}</span>
                                            </div>`;
                                        }

                                        let sizeHTML = '';
                                        if (data.size) {
                                            sizeHTML = `
                                            <div class="cart--item--size">
                                                <span>Size</span>: <span>${data.size.size}</span>
                                            </div>`;
                                        }

                                        // If data is provided, render the new wishlist item
                                        const newItemHTML = `
                                        <div class="cart--item--card" data-id="${data.id}" data-wishlist-id="${data.wishlistId}">
                                            <div class="cart--item--img">
                                                <img src="{{ url('/') }}/${data.image}" alt="${data.name}">
                                            </div>
                                            <div class="cart--item--info">
                                                <h4 class="cart--item--name">${data.name}</h4>
                                                <p class="cart--item--price">$${data.price}</p>
                                                ${colorHTML}
                                                ${sizeHTML}
                                                <a href="#" data-wishlist-id="${data.wishlistId}" data-wishlist-product-id="${data.id}" id="cart-toggle-wishlist" class="remove--cart--btn">Move to Cart</a>
                                                <a class="remove--cart--btn remove-wishlist-btn" href="#" onclick="removeWishlistItem(this)">Remove</a>
                                            </div>
                                        </div>
                                    `;
                                        wishlistContainer.insertAdjacentHTML('beforeend', newItemHTML);
                                        noItemsMessage.style.display = 'none';

                                        updateWishlistButtonVisibility()
                                    } else {
                                        data = data.wishlistItem;
                                        noItemsMessage.style.display = ''; // Show the message if no items
                                        // Remove the item from the wishlist
                                        $(`.cart--item--card[data-wishlist-id="${data.wishlistId}"]`).remove();

                                        updateWishlistButtonVisibility()
                                    }
                                }

                                // Session Guest
                                function updateWishlistDisplayGuest(data) {
                                    console.log(data);
                                    const wishlistContainer = document.querySelector('.wishlist-container');
                                    const noItemsMessage = document.querySelector('.wishlist-container #wishlist-no-product'); // Ensure you reference the no items message correctly

                                    if (data.success) {
                                        data = data.wishlistItem;
                                        // Create color and size HTML if they exist
                                        let colorHTML = '';
                                        if (data.color) {
                                            colorHTML = `
                                            <div class="cart--item--color">
                                                <span>Color</span>: <span>${data.color.color}</span>
                                            </div>`;
                                        }

                                        let sizeHTML = '';
                                        if (data.size) {
                                            sizeHTML = `
                                            <div class="cart--item--size">
                                                <span>Size</span>: <span>${data.size.size}</span>
                                            </div>`;
                                        }

                                        // If data is provided, render the new wishlist item
                                        const newItemHTML = `
                                        <div class="cart--item--card" data-id="${data.id}" data-wishlist-id="${data.wishlistId}">
                                            <div class="cart--item--img">
                                                <img src="{{ url('/') }}/${data.image}" alt="${data.name}">
                                            </div>
                                            <div class="cart--item--info">
                                                <h4 class="cart--item--name">${data.name}</h4>
                                                <p class="cart--item--price">$${data.price}</p>
                                                ${colorHTML}
                                                ${sizeHTML}
                                                <a href="#" data-wishlist-id="${data.wishlistId}" data-wishlist-product-id="${data.id}" id="cart-toggle-wishlist" class="remove--cart--btn">Move to Cart</a>
                                                <a class="remove--cart--btn remove-wishlist-btn" href="#" onclick="removeWishlistItem(this)">Remove</a>
                                            </div>
                                        </div>
                                    `;
                                        wishlistContainer.insertAdjacentHTML('beforeend', newItemHTML);
                                        noItemsMessage.style.display = 'none';

                                        updateWishlistButtonVisibility()
                                    } else {
                                        data = data.wishlistItem;
                                        noItemsMessage.style.display = ''; // Show the message if no items
                                        // Remove the item from the wishlist
                                        $(`.cart--item--card[data-wishlist-id="${data.wishlistId}"]`).remove();

                                        updateWishlistButtonVisibility()
                                    }
                                }

                            </script>

                            <div class="size-and--next">
                                @if($product->productSizes && count($product->productSizes) > 0)
                                    <select  name="size_id" id="size" required>
                                        @foreach($product->productSizes as $size)
                                            @if($size->size)
                                                <option value="{{ $size->size->id }}">{{ $size->size->size }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                @else
                                    <select name="size_id" id="size" required>
                                        <option value="">No Size</option>
                                    </select>
                                @endif

                                <a href="{{ $nextProduct ? route('product.detail', $nextProduct->product_slug) : '#' }}"
                                   class="next-item--btn red-background--route" {{ $nextProduct ? '' : 'disabled' }}>
                                    <span>{{ $nextProduct ? 'Next Item' : 'Not Found' }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 15 15" fill="none">
                                        <path d="M3 2L7.6875 6.6875L3 11.375" stroke="#23282D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </a>

                            </div>

                            <!-- buttons -->
                            <div class="product-details--btns">

                                <input type="hidden" name="product_id" value="{{$product->id}}">
                                <input type="hidden" name="selling_price" id="selling-price" value="{{$product->selling_price}}">
                                <input type="hidden" name="discount_price" id="discount-price" value="{{$product->discount_price}}">

                                @if(Auth::check())
                                    <button class="common-product--info--btn show-cart-item" id="add-to-cart-btn">
                                        Add to Cart
                                    </button>
                                @else
{{--                                    <a class="common-product--info--btn" onclick="checkAuthentication()" href="#">--}}
{{--                                        Add to Cart--}}
{{--                                    </a>--}}
                                    <button class="common-product--info--btn show-cart-item" id="add-to-cart-btn-user">
                                        Add to Cart
                                    </button>
                                @endif


                                <a href="{{ route('collections.catalog.all') }}" class="common-product--info--btn">
                                    Keep Shopping
                                </a>
                            </div>
                        </form>
                        <!-- accordion -->
                        <div class="accordion" id="care-instruction-accordion">
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="headingOne">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                            data-bs-target="#CareInstruction" aria-expanded="false">
                                        Care Instruction
                                    </button>
                                </h2>
                                <div id="CareInstruction" class="accordion-collapse collapse" aria-labelledby="headingOne"
                                     data-bs-parent="#care-instruction-accordion">
                                    <div class="accordion-body">
                                        <div class="instruction">
                                            <b>Washing:</b> Please follow the specific washing
                                            instructions provided on the product label to preserve
                                            color and fabric quality.
                                        </div>
                                        <div class="instruction">
                                            <b>Handling:</b> Handle delicate items with care to
                                            avoid snags, tears, or stretching.
                                        </div>
                                        <div class="instruction">
                                            <b>Ironing:</b> If ironing is necessary, use a low
                                            heat setting and iron inside-out to protect any
                                            printed or embellished designs.
                                        </div>
                                        <div class="instruction">
                                            <b>Dry Cleaning:</b> Certain items may require
                                            professional dry cleaning. Please refer to the care
                                            label for guidance.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

        <!-- middle section starts -->
        <div class="product-details--page--middle">
            <div class="container">
                <div class="delivery-free--shipping">
                    <!-- item 1 -->
                    <div class="delivery-shipping--box">
                        <img src="{{ asset('/frontend/assets/images/truck.svg') }}" alt="" srcset="" />
                        <h2 class="title">Free Shipping</h2>
                        <p class="subtitle">Free Worldwide Delivery!</p>
                    </div>
                    <!-- item 2 -->
                    <div class="delivery-shipping--box">
                        <img src="{{ asset('/frontend/assets/images/order.svg') }}" alt="" srcset="" />
                        <h2 class="title">Shipped with Care</h2>
                        <p class="subtitle">All Orders Packed & Shipped with Care</p>
                    </div>
                    <!-- item 3 -->
                    <div class="delivery-shipping--box">
                        <img src="{{ asset('/frontend/assets/images/verified.svg') }}" alt="" srcset="" />
                        <h2 class="title">Secure Checkout</h2>
                        <p class="subtitle">Secure Payment with 3DS</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- middle section starts -->

        <!-- related products section starts -->
        @if($relatedProducts->isNotEmpty())
            <div class="related--products--section">
                <div class="container">
                    <div class="related--products--container">
                        <h2 class="section--title">Related Products</h2>
                        <div class="related-products--wrapper">
                            @foreach($relatedProducts as $product)
                                <!-- product 1 -->
                                <a href="{{ route('product.detail', $product->product_slug) }}" class="related-product">
                                    <div class="related-product-image">
                                        @foreach($product->images->take(1) as $image)
                                            <img src="{{ asset($image->image) }}" alt="" srcset="" />
                                        @endforeach
                                    </div>
                                    <div  class="related-product--info">
                                        <p class="related--product--name">
                                            {{ $product->name }}
                                        </p>
                                        <p class="related--product--price">${{ $product->selling_price }}</p>
                                    </div>
                                </a>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>
        @else
            <div class="related--products--section">
                <div class="container">
                    <div class="related--products--container">
                        <h2 class="section--title">Related Products</h2>
                        <div class="related-products--wrapper">
                            <!-- if no comments available of this type -->
                            <div class="no--comments--available">
                                <!-- <p class="no--comments--text">No Comments Available</p> -->
                                <div class="no-review-emoji">
                                    <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- related products section ends -->

        <!-- customer review  starts -->
        <div class="customer-review--section">
            <div class="container">
                @if($reviews->isNotEmpty())
                    <!-- when review available -->
                    <div class="customer-review--container--with--review">
                        <h2 class="section-title">Customer Reviews</h2>
                        <div class="customer-reviews--and--comments--wrapper">
                            <!-- review progress -->
                            <div class="customer-review--box">
                                <!-- overall-review -->
                                <div class="overall-rating">
                                    <span>{{ $averageRating }}</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="26" height="24" viewBox="0 0 26 24" fill="none">
                                        <path
                                            d="M11.5734 1.39057C12.0224 0.00860596 13.9776 0.00861001 14.4266 1.39058L16.2555 7.01925C16.4563 7.63729 17.0322 8.05573 17.682 8.05573H23.6004C25.0535 8.05573 25.6576 9.91515 24.4821 10.7693L19.694 14.248C19.1683 14.6299 18.9483 15.307 19.1491 15.925L20.978 21.5537C21.427 22.9357 19.8453 24.0848 18.6697 23.2307L13.8817 19.752C13.3559 19.3701 12.6441 19.3701 12.1183 19.752L7.33028 23.2307C6.15471 24.0849 4.57299 22.9357 5.02202 21.5537L6.85089 15.925C7.0517 15.307 6.83171 14.6299 6.30598 14.248L1.51794 10.7693C0.34237 9.91515 0.946536 8.05573 2.39962 8.05573H8.31796C8.9678 8.05573 9.54374 7.63729 9.74455 7.01925L11.5734 1.39057Z"
                                            fill="#FFB400" />
                                    </svg>
                                </div>
                                <!-- overall review -->
                                <p class="overall-review">{{ $count_reviews }} Review</p>

                                <!-- progress container -->
                                <div class="review-progress--container">
                                    @for ($rating = 5; $rating >= 1; $rating--)
                                        <!-- row 1 -->
                                        <div class="progress--row">
                                            <!-- rating -->
                                            <div class="progress--rating">
                                                <span>{{ $rating }}</span>
                                                <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13" fill="none">
                                                    <path
                                                        d="M6.52447 0.463524C6.67415 0.00286841 7.32585 0.00286996 7.47553 0.463525L8.68386 4.18237C8.75079 4.38838 8.94277 4.52786 9.15938 4.52786H13.0696C13.554 4.52786 13.7554 5.14767 13.3635 5.43237L10.2001 7.73075C10.0248 7.85807 9.95149 8.08375 10.0184 8.28976L11.2268 12.0086C11.3764 12.4693 10.8492 12.8523 10.4573 12.5676L7.29389 10.2693C7.11865 10.1419 6.88135 10.1419 6.70611 10.2693L3.54267 12.5676C3.15081 12.8523 2.62357 12.4693 2.77325 12.0086L3.98157 8.28976C4.04851 8.08375 3.97518 7.85807 3.79994 7.73075L0.636495 5.43237C0.244639 5.14767 0.446028 4.52786 0.93039 4.52786H4.84062C5.05723 4.52786 5.24921 4.38838 5.31614 4.18237L6.52447 0.463524Z"
                                                        fill="#FFB400" />
                                                </svg>
                                            </div>
                                            <!-- bar -->
                                            <div class="progress-bar">
                                                <div class="progress" data-percent="{{ $percentages[$rating] ?? 0 }}" data-color="#FFB400" style="width: {{ $percentages[$rating] ?? 0 }}%;"></div>
                                            </div>
                                            <!-- percentage -->
                                            <span class="percentage--text">{{ number_format($percentages[$rating] ?? 0) }}%</span>
                                        </div>
                                    @endfor

                                </div>

                                <hr />

                                <p class="customer-review--box--title">Review this product</p>
                                <p class="customer-review--box--subtitle">
                                    Share your thoughts with other customers
                                </p>
                                <button class="common-write-review-btn rating--box" data-bs-toggle="modal"
                                        data-bs-target="#write-review-modal">
                                    Write review
                                </button>
                            </div>
                            <!-- comments  -->
                            <div class="customer-comment--box">
                                <h2 class="title">Review with comments</h2>

                                <!-- all reviews -->
                                <div class="comments-wrapper use-fade-scale" id="comments--tab">
                                    <!-- tabs  -->
                                    <ul class="skltbs-tab-group">
                                        <li class="skltbs-tab-item">
                                            <button class="skltbs-tab">All</button>
                                        </li>
                                        <li class="skltbs-tab-item">
                                            <button class="skltbs-tab">Most helpful</button>
                                        </li>
                                        <li class="skltbs-tab-item">
                                            <button class="skltbs-tab">Highest rating</button>
                                        </li>
                                        <li class="skltbs-tab-item">
                                            <button class="skltbs-tab">Lowest rating</button>
                                        </li>
                                        <li class="skltbs-tab-item">
                                            <button class="skltbs-tab">Oldest</button>
                                        </li>
                                        <li class="skltbs-tab-item">
                                            <button class="skltbs-tab">Newest</button>
                                        </li>
                                        <li class="skltbs-tab-item">
                                            <button class="skltbs-tab">Review with photos</button>
                                        </li>
                                        <li class="skltbs-tab-item">
                                            <button class="skltbs-tab">
                                                <span>★</span><span>5</span>
                                            </button>
                                        </li>
                                        <li class="skltbs-tab-item">
                                            <button class="skltbs-tab">
                                                <span>★</span><span>4</span>
                                            </button>
                                        </li>
                                        <li class="skltbs-tab-item">
                                            <button class="skltbs-tab">
                                                <span>★</span><span>3</span>
                                            </button>
                                        </li>
                                        <li class="skltbs-tab-item">
                                            <button class="skltbs-tab">
                                                <span>★</span><span>2</span>
                                            </button>
                                        </li>
                                        <li class="skltbs-tab-item">
                                            <button class="skltbs-tab">
                                                <span>★</span><span>1</span>
                                            </button>
                                        </li>
                                    </ul>
                                    <!-- contents -->
                                    <div class="skltbs-panel-group">
                                        {{--   all reviews--}}
                                        <div class="skltbs-panel">
                                            <!-- if comments available of this type -->
                                            <div class="all-comments--container">
                                                <!-- comment 1 -->
                                                @if($reviews->isNotEmpty())
                                                    @foreach($reviews as $review)
                                                        <div class="single-comment--box">
                                                            <!-- user info -->
                                                            <div class="commented-user--info">
                                                                <div class="commented-user--img">
                                                                    @php
                                                                        // Get the first letter of each word in the user's name
                                                                        $nameParts = explode(' ', $review->name);
                                                                        $initials = '';
                                                                        foreach ($nameParts as $part) {
                                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                                        }
                                                                    @endphp
                                                                    {{ $initials }} <!-- Display initials -->
                                                                </div>
                                                                <div class="commented-user-name--date">
                                                                    <p class="commented-user--name">
                                                                        @if($review->name_format === 'Anonymous')
                                                                            Anonymous
                                                                        @elseif($review->name_format === 'John Smith')
                                                                            {{ $review->name }}
                                                                        @elseif($review->name_format === 'John S.')
                                                                            {{ explode(' ', $review->name)[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}
                                                                        @elseif($review->name_format === 'J.S.')
                                                                            {{ implode(' ', array_map(fn($part) => strtoupper(substr($part, 0, 1)) . '.', array_slice($nameParts, 0, 3))) }}
                                                                        @endif
                                                                    </p>
                                                                    <div class="commented-user--date">
                                                                        <span class="comment-update--btn">
                                                                            <img src="{{ asset('/frontend/assets/images/pen.svg') }}" alt="" />
                                                                        </span>
                                                                        <span>Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- comment-user--stars -->
                                                            <div class="comment--total--stars">
                                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                                @endfor
                                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                                @endfor
                                                            </div>
                                                            <!-- title -->
                                                            <p class="comment-title">{{ $review->title }}</p>
                                                            <!-- description -->
                                                            <p class="comment-subtitle">{{ $review->review }}</p>
                                                            <!-- images of that review -->
                                                            <div class="reviewed--images--in--comments">
                                                                @foreach($review->images as $image)
                                                                    <div class="reviewed--image--in--comments" data-bs-toggle="modal" data-bs-target="#show--review--image--comment--box--modal{{ $review->id }}">
                                                                        <img src="{{ asset($image->image) }}" alt="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- action btns -->
                                                            <div class="comment-like--btns">
                                                                @php
                                                                    $like_count = $review->likes->count();
                                                                    $userLiked = Auth::check() && $review->likes->contains('user_id', Auth::user()->id);
                                                                @endphp
                                                                @if($userLiked)
                                                                    <button class="comment-like-btn" disabled>
                                                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                                                        <span>({{ $like_count }})</span>
                                                                    </button>
                                                                @else
                                                                    @if(Auth::check())
                                                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                                                            <input type="hidden" name="likes" value="1" />
                                                                            <button class="comment-like-btn" type="submit">
                                                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                                <span class="like-count">({{ $like_count }})</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                            <span>({{ $like_count }})</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                <span class="button-separator"></span>
                                                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <p>No reviews available.</p>
                                                @endif

                                            </div>
                                        </div>

                                        {{--   most helpful reviews--}}
                                        <div class="skltbs-panel">
                                            <!-- if comments available of this type -->
                                            <div class="all-comments--container">
                                                @if($highest_star_reviews->isNotEmpty())
                                                    @foreach($highest_star_reviews as $review)
                                                        <!-- comment 1 -->
                                                        <div class="single-comment--box">
                                                            <!-- user info -->
                                                            <div class="commented-user--info">
                                                                <div class="commented-user--img">
                                                                    @php
                                                                        // Get the first letter of each word in the user's name
                                                                        $nameParts = explode(' ', $review->name);
                                                                        $initials = '';
                                                                        foreach ($nameParts as $part) {
                                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                                        }
                                                                    @endphp
                                                                    {{ $initials }} <!-- Display initials -->
                                                                </div>
                                                                <div class="commented-user-name--date">
                                                                    <p class="commented-user--name">
                                                                        @if($review->name_format === 'Anonymous')
                                                                            Anonymous
                                                                        @elseif($review->name_format === 'John Smith')
                                                                            {{ $review->name }}
                                                                        @elseif($review->name_format === 'John S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ $nameParts[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}  {{-- Format: Jhonathan A. --}}
                                                                        @elseif($review->name_format === 'J.S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ (isset($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[2]) ? strtoupper(substr($nameParts[2], 0, 1)) . '.' : '') }}  {{-- Format: J. A. M. --}}
                                                                        @endif
                                                                    </p>
                                                                    <div class="commented-user--date">
                                                                <span class="comment-update--btn">
                                                                  <img src="{{ asset('/frontend/assets/images/pen.svg') }}" alt="" srcset="" />
                                                                </span>
                                                                        <span>Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- comment-user--stars -->
                                                            <div class="comment--total--stars">
                                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                                @endfor
                                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                                @endfor
                                                            </div>
                                                            <!-- title -->
                                                            <p class="comment-title">{{ $review->title }}</p>
                                                            <!-- description -->
                                                            <p class="comment-subtitle">
                                                                {{ $review->review }}
                                                            </p>
                                                            <div class="reviewed--images--in--comments">
                                                                @foreach($review->images as $image)
                                                                    <div class="reviewed--image--in--comments" data-bs-toggle="modal" data-bs-target="#show--review--image--comment--box--modal{{ $review->id }}" >
                                                                        <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- action btns -->
                                                            <div class="comment-like--btns">
                                                                @php
                                                                    $like_count = $review->likes->count();
                                                                    $userLiked = Auth::check() && $review->likes->contains('user_id', Auth::user()->id);
                                                                @endphp
                                                                @if($userLiked)
                                                                    <button class="comment-like-btn" disabled>
                                                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                                                        <span>({{ $like_count }})</span>
                                                                    </button>
                                                                @else
                                                                    @if(Auth::check())
                                                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                                                            <input type="hidden" name="likes" value="1" />
                                                                            <button class="comment-like-btn" type="submit">
                                                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                                <span class="like-count">({{ $like_count }})</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                            <span>({{ $like_count }})</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                <span class="button-separator"></span>
                                                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- if no comments available of this type -->
                                                    <div class="no--comments--available">
                                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                                        <div class="no-review-emoji">
                                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                        {{--   highest rating reviews--}}
                                        <div class="skltbs-panel">
                                            <!-- if comments available of this type -->
                                            <div class="all-comments--container">
                                                @if($highest_star_reviews->isNotEmpty())
                                                    @foreach($highest_star_reviews as $review)
                                                        <!-- comment 1 -->
                                                        <div class="single-comment--box">
                                                            <!-- user info -->
                                                            <div class="commented-user--info">
                                                                <div class="commented-user--img">
                                                                    @php
                                                                        // Get the first letter of each word in the user's name
                                                                        $nameParts = explode(' ', $review->name);
                                                                        $initials = '';
                                                                        foreach ($nameParts as $part) {
                                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                                        }
                                                                    @endphp
                                                                    {{ $initials }} <!-- Display initials -->
                                                                </div>
                                                                <div class="commented-user-name--date">
                                                                    <p class="commented-user--name">
                                                                        @if($review->name_format === 'Anonymous')
                                                                            Anonymous
                                                                        @elseif($review->name_format === 'John Smith')
                                                                            {{ $review->name }}
                                                                        @elseif($review->name_format === 'John S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ $nameParts[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}  {{-- Format: Jhonathan A. --}}
                                                                        @elseif($review->name_format === 'J.S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ (isset($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[2]) ? strtoupper(substr($nameParts[2], 0, 1)) . '.' : '') }}  {{-- Format: J. A. M. --}}
                                                                        @endif
                                                                    </p>
                                                                    <div class="commented-user--date">
                                                                    <span class="comment-update--btn">
                                                                      <img src="{{ asset('/frontend/assets/images/pen.svg') }}" alt="" srcset="" />
                                                                    </span>
                                                                        <span>Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- comment-user--stars -->
                                                            <div class="comment--total--stars">
                                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                                @endfor
                                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                                @endfor
                                                            </div>
                                                            <!-- title -->
                                                            <p class="comment-title">{{ $review->title }}</p>
                                                            <!-- description -->
                                                            <p class="comment-subtitle">
                                                                {{ $review->review }}
                                                            </p>
                                                            <div class="reviewed--images--in--comments">
                                                                @foreach($review->images as $image)
                                                                    <div class="reviewed--image--in--comments" data-bs-toggle="modal" data-bs-target="#show--review--image--comment--box--modal{{ $review->id }}" >
                                                                        <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- action btns -->
                                                            <div class="comment-like--btns">
                                                                @php
                                                                    $like_count = $review->likes->count();
                                                                    $userLiked = Auth::check() && $review->likes->contains('user_id', Auth::user()->id);
                                                                @endphp
                                                                @if($userLiked)
                                                                    <button class="comment-like-btn" disabled>
                                                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                                                        <span>({{ $like_count }})</span>
                                                                    </button>
                                                                @else
                                                                    @if(Auth::check())
                                                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                                                            <input type="hidden" name="likes" value="1" />
                                                                            <button class="comment-like-btn" type="submit">
                                                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                                <span class="like-count">({{ $like_count }})</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                            <span>({{ $like_count }})</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                <span class="button-separator"></span>
                                                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- if no comments available of this type -->
                                                    <div class="no--comments--available">
                                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                                        <div class="no-review-emoji">
                                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                                        </div>
                                                    </div>
                                                @endif

                                            </div>
                                        </div>
                                        {{--   lowest rating reviews--}}
                                        <div class="skltbs-panel">
                                            <!-- if comments available of this type -->
                                            <div class="all-comments--container">
                                                @if($lowest_star_reviews->isNotEmpty())
                                                    @foreach($lowest_star_reviews as $review)
                                                        <!-- comment 1 -->
                                                        <div class="single-comment--box">
                                                            <!-- user info -->
                                                            <div class="commented-user--info">
                                                                <div class="commented-user--img">
                                                                    @php
                                                                        // Get the first letter of each word in the user's name
                                                                        $nameParts = explode(' ', $review->name);
                                                                        $initials = '';
                                                                        foreach ($nameParts as $part) {
                                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                                        }
                                                                    @endphp
                                                                    {{ $initials }} <!-- Display initials -->
                                                                </div>
                                                                <div class="commented-user-name--date">
                                                                    <p class="commented-user--name">
                                                                        @if($review->name_format === 'Anonymous')
                                                                            Anonymous
                                                                        @elseif($review->name_format === 'John Smith')
                                                                            {{ $review->name }}
                                                                        @elseif($review->name_format === 'John S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ $nameParts[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}  {{-- Format: Jhonathan A. --}}
                                                                        @elseif($review->name_format === 'J.S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ (isset($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[2]) ? strtoupper(substr($nameParts[2], 0, 1)) . '.' : '') }}  {{-- Format: J. A. M. --}}
                                                                        @endif
                                                                    </p>
                                                                    <div class="commented-user--date">
                                                                        <span class="comment-update--btn">
                                                                          <img src="{{ asset('/frontend/assets/images/pen.svg') }}" alt="" srcset="" />
                                                                        </span>
                                                                        <span>Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- comment-user--stars -->
                                                            <div class="comment--total--stars">
                                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                                @endfor
                                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                                @endfor
                                                            </div>
                                                            <!-- title -->
                                                            <p class="comment-title">{{ $review->title }}</p>
                                                            <!-- description -->
                                                            <p class="comment-subtitle">
                                                                {{ $review->review }}
                                                            </p>
                                                            <div class="reviewed--images--in--comments">
                                                                @foreach($review->images as $image)
                                                                    <div class="reviewed--image--in--comments" data-bs-toggle="modal" data-bs-target="#show--review--image--comment--box--modal{{ $review->id }}" >
                                                                        <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- action btns -->
                                                            <div class="comment-like--btns">
                                                                @php
                                                                    $like_count = $review->likes->count();
                                                                    $userLiked = Auth::check() && $review->likes->contains('user_id', Auth::user()->id);
                                                                @endphp
                                                                @if($userLiked)
                                                                    <button class="comment-like-btn" disabled>
                                                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                                                        <span>({{ $like_count }})</span>
                                                                    </button>
                                                                @else
                                                                    @if(Auth::check())
                                                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                                                            <input type="hidden" name="likes" value="1" />
                                                                            <button class="comment-like-btn" type="submit">
                                                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                                <span class="like-count">({{ $like_count }})</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                            <span>({{ $like_count }})</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                <span class="button-separator"></span>
                                                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- if no comments available of this type -->
                                                    <div class="no--comments--available">
                                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                                        <div class="no-review-emoji">
                                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{--   oldest reviews--}}
                                        <div class="skltbs-panel">
                                            <!-- if comments available of this type -->
                                            <div class="all-comments--container">
                                                @if($oldest_reviews->isNotEmpty())
                                                    @foreach($oldest_reviews as $review)
                                                        <!-- comment 1 -->
                                                        <div class="single-comment--box">
                                                            <!-- user info -->
                                                            <div class="commented-user--info">
                                                                <div class="commented-user--img">
                                                                    @php
                                                                        // Get the first letter of each word in the user's name
                                                                        $nameParts = explode(' ', $review->name);
                                                                        $initials = '';
                                                                        foreach ($nameParts as $part) {
                                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                                        }
                                                                    @endphp
                                                                    {{ $initials }} <!-- Display initials -->
                                                                </div>
                                                                <div class="commented-user-name--date">
                                                                    <p class="commented-user--name">
                                                                        @if($review->name_format === 'Anonymous')
                                                                            Anonymous
                                                                        @elseif($review->name_format === 'John Smith')
                                                                            {{ $review->name }}
                                                                        @elseif($review->name_format === 'John S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ $nameParts[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}  {{-- Format: Jhonathan A. --}}
                                                                        @elseif($review->name_format === 'J.S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ (isset($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[2]) ? strtoupper(substr($nameParts[2], 0, 1)) . '.' : '') }}  {{-- Format: J. A. M. --}}
                                                                        @endif
                                                                    </p>
                                                                    <div class="commented-user--date">
                                                                        <span class="comment-update--btn">
                                                                          <img src="{{ asset('/frontend/assets/images/pen.svg') }}" alt="" srcset="" />
                                                                        </span>
                                                                        <span>Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- comment-user--stars -->
                                                            <div class="comment--total--stars">
                                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                                @endfor
                                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                                @endfor
                                                            </div>
                                                            <!-- title -->
                                                            <p class="comment-title">{{ $review->title }}</p>
                                                            <!-- description -->
                                                            <p class="comment-subtitle">
                                                                {{ $review->review }}
                                                            </p>
                                                            <div class="reviewed--images--in--comments">
                                                                @foreach($review->images as $image)
                                                                    <div class="reviewed--image--in--comments" data-bs-toggle="modal" data-bs-target="#show--review--image--comment--box--modal{{ $review->id }}" >
                                                                        <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- action btns -->
                                                            <div class="comment-like--btns">
                                                                @php
                                                                    $like_count = $review->likes->count();
                                                                    $userLiked = Auth::check() && $review->likes->contains('user_id', Auth::user()->id);
                                                                @endphp
                                                                @if($userLiked)
                                                                    <button class="comment-like-btn" disabled>
                                                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                                                        <span>({{ $like_count }})</span>
                                                                    </button>
                                                                @else
                                                                    @if(Auth::check())
                                                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                                                            <input type="hidden" name="likes" value="1" />
                                                                            <button class="comment-like-btn" type="submit">
                                                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                                <span class="like-count">({{ $like_count }})</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                            <span>({{ $like_count }})</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                <span class="button-separator"></span>
                                                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- if no comments available of this type -->
                                                    <div class="no--comments--available">
                                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                                        <div class="no-review-emoji">
                                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{--   newest reviews--}}
                                        <div class="skltbs-panel">
                                            <!-- if comments available of this type -->
                                            <div class="all-comments--container">
                                                @if($latest_reviews->isNotEmpty())
                                                    @foreach($latest_reviews as $review)
                                                        <!-- comment 1 -->
                                                        <div class="single-comment--box">
                                                            <!-- user info -->
                                                            <div class="commented-user--info">
                                                                <div class="commented-user--img">
                                                                    @php
                                                                        // Get the first letter of each word in the user's name
                                                                        $nameParts = explode(' ', $review->name);
                                                                        $initials = '';
                                                                        foreach ($nameParts as $part) {
                                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                                        }
                                                                    @endphp
                                                                    {{ $initials }} <!-- Display initials -->
                                                                </div>
                                                                <div class="commented-user-name--date">
                                                                    <p class="commented-user--name">
                                                                        @if($review->name_format === 'Anonymous')
                                                                            Anonymous
                                                                        @elseif($review->name_format === 'John Smith')
                                                                            {{ $review->name }}
                                                                        @elseif($review->name_format === 'John S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ $nameParts[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}  {{-- Format: Jhonathan A. --}}
                                                                        @elseif($review->name_format === 'J.S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ (isset($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[2]) ? strtoupper(substr($nameParts[2], 0, 1)) . '.' : '') }}  {{-- Format: J. A. M. --}}
                                                                        @endif
                                                                    </p>
                                                                    <div class="commented-user--date">
                                                                        <span class="comment-update--btn">
                                                                          <img src="{{ asset('/frontend/assets/images/pen.svg') }}" alt="" srcset="" />
                                                                        </span>
                                                                        <span>Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- comment-user--stars -->
                                                            <div class="comment--total--stars">
                                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                                @endfor
                                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                                @endfor
                                                            </div>
                                                            <!-- title -->
                                                            <p class="comment-title">{{ $review->title }}</p>
                                                            <!-- description -->
                                                            <p class="comment-subtitle">
                                                                {{ $review->review }}
                                                            </p>
                                                            <div class="reviewed--images--in--comments">
                                                                @foreach($review->images as $image)
                                                                    <div class="reviewed--image--in--comments" data-bs-toggle="modal" data-bs-target="#show--review--image--comment--box--modal{{ $review->id }}" >
                                                                        <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- action btns -->
                                                            <div class="comment-like--btns">
                                                                @php
                                                                    $like_count = $review->likes->count();
                                                                    $userLiked = Auth::check() && $review->likes->contains('user_id', Auth::user()->id);
                                                                @endphp
                                                                @if($userLiked)
                                                                    <button class="comment-like-btn" disabled>
                                                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                                                        <span>({{ $like_count }})</span>
                                                                    </button>
                                                                @else
                                                                    @if(Auth::check())
                                                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                                                            <input type="hidden" name="likes" value="1" />
                                                                            <button class="comment-like-btn" type="submit">
                                                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                                <span class="like-count">({{ $like_count }})</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                            <span>({{ $like_count }})</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                <span class="button-separator"></span>
                                                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- if no comments available of this type -->
                                                    <div class="no--comments--available">
                                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                                        <div class="no-review-emoji">
                                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{--   review with image--}}
                                        <div class="skltbs-panel">
                                            <!-- if comments available of this type -->
                                            <div class="all-comments--container">
                                                @if($reviewsWithImages->isNotEmpty())
                                                    @foreach($reviewsWithImages as $review)
                                                        <!-- comment 1 -->
                                                        <div class="single-comment--box">
                                                            <!-- user info -->
                                                            <div class="commented-user--info">
                                                                <div class="commented-user--img">
                                                                    @php
                                                                        // Get the first letter of each word in the user's name
                                                                        $nameParts = explode(' ', $review->name);
                                                                        $initials = '';
                                                                        foreach ($nameParts as $part) {
                                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                                        }
                                                                    @endphp
                                                                    {{ $initials }} <!-- Display initials -->
                                                                </div>
                                                                <div class="commented-user-name--date">
                                                                    <p class="commented-user--name">
                                                                        @if($review->name_format === 'Anonymous')
                                                                            Anonymous
                                                                        @elseif($review->name_format === 'John Smith')
                                                                            {{ $review->name }}
                                                                        @elseif($review->name_format === 'John S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ $nameParts[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}  {{-- Format: Jhonathan A. --}}
                                                                        @elseif($review->name_format === 'J.S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ (isset($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[2]) ? strtoupper(substr($nameParts[2], 0, 1)) . '.' : '') }}  {{-- Format: J. A. M. --}}
                                                                        @endif
                                                                    </p>
                                                                    <div class="commented-user--date">
                                                                        <span class="comment-update--btn">
                                                                          <img src="{{ asset('/frontend/assets/images/pen.svg') }}" alt="" srcset="" />
                                                                        </span>
                                                                        <span>Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- comment-user--stars -->
                                                            <div class="comment--total--stars">
                                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                                @endfor
                                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                                @endfor
                                                            </div>
                                                            <!-- title -->
                                                            <p class="comment-title">{{ $review->title }}</p>
                                                            <!-- description -->
                                                            <p class="comment-subtitle">
                                                                {{ $review->review }}
                                                            </p>
                                                            <div class="reviewed--images--in--comments">
                                                                @foreach($review->images as $image)
                                                                    <div class="reviewed--image--in--comments" data-bs-toggle="modal" data-bs-target="#show--review--image--comment--box--modal{{ $review->id }}" >
                                                                        <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- action btns -->
                                                            <div class="comment-like--btns">
                                                                @php
                                                                    $like_count = $review->likes->count();
                                                                    $userLiked = Auth::check() && $review->likes->contains('user_id', Auth::user()->id);
                                                                @endphp
                                                                @if($userLiked)
                                                                    <button class="comment-like-btn" disabled>
                                                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                                                        <span>({{ $like_count }})</span>
                                                                    </button>
                                                                @else
                                                                    @if(Auth::check())
                                                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                                                            <input type="hidden" name="likes" value="1" />
                                                                            <button class="comment-like-btn" type="submit">
                                                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                                <span class="like-count">({{ $like_count }})</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                            <span>({{ $like_count }})</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                <span class="button-separator"></span>
                                                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- if no comments available of this type -->
                                                    <div class="no--comments--available">
                                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                                        <div class="no-review-emoji">
                                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{--   5 reviews--}}
                                        <div class="skltbs-panel">
                                            <!-- if comments available of this type -->
                                            <div class="all-comments--container">
                                                @if($five_star_reviews->isNotEmpty())
                                                    @foreach($five_star_reviews as $review)
                                                        <!-- comment 1 -->
                                                        <div class="single-comment--box">
                                                            <!-- user info -->
                                                            <div class="commented-user--info">
                                                                <div class="commented-user--img">
                                                                    @php
                                                                        // Get the first letter of each word in the user's name
                                                                        $nameParts = explode(' ', $review->name);
                                                                        $initials = '';
                                                                        foreach ($nameParts as $part) {
                                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                                        }
                                                                    @endphp
                                                                    {{ $initials }} <!-- Display initials -->
                                                                </div>
                                                                <div class="commented-user-name--date">
                                                                    <p class="commented-user--name">
                                                                        @if($review->name_format === 'Anonymous')
                                                                            Anonymous
                                                                        @elseif($review->name_format === 'John Smith')
                                                                            {{ $review->name }}
                                                                        @elseif($review->name_format === 'John S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ $nameParts[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}  {{-- Format: Jhonathan A. --}}
                                                                        @elseif($review->name_format === 'J.S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ (isset($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[2]) ? strtoupper(substr($nameParts[2], 0, 1)) . '.' : '') }}  {{-- Format: J. A. M. --}}
                                                                        @endif
                                                                    </p>
                                                                    <div class="commented-user--date">
                                                                        <span class="comment-update--btn">
                                                                          <img src="{{ asset('/frontend/assets/images/pen.svg') }}" alt="" srcset="" />
                                                                        </span>
                                                                        <span>Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- comment-user--stars -->
                                                            <div class="comment--total--stars">
                                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                                @endfor
                                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                                @endfor
                                                            </div>
                                                            <!-- title -->
                                                            <p class="comment-title">{{ $review->title }}</p>
                                                            <!-- description -->
                                                            <p class="comment-subtitle">
                                                                {{ $review->review }}
                                                            </p>
                                                            <div class="reviewed--images--in--comments">
                                                                @foreach($review->images as $image)
                                                                    <div class="reviewed--image--in--comments" data-bs-toggle="modal" data-bs-target="#show--review--image--comment--box--modal{{ $review->id }}" >
                                                                        <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- action btns -->
                                                            <div class="comment-like--btns">
                                                                @php
                                                                    $like_count = $review->likes->count();
                                                                    $userLiked = Auth::check() && $review->likes->contains('user_id', Auth::user()->id);
                                                                @endphp
                                                                @if($userLiked)
                                                                    <button class="comment-like-btn" disabled>
                                                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                                                        <span>({{ $like_count }})</span>
                                                                    </button>
                                                                @else
                                                                    @if(Auth::check())
                                                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                                                            <input type="hidden" name="likes" value="1" />
                                                                            <button class="comment-like-btn" type="submit">
                                                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                                <span class="like-count">({{ $like_count }})</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                            <span>({{ $like_count }})</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                <span class="button-separator"></span>
                                                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- if no comments available of this type -->
                                                    <div class="no--comments--available">
                                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                                        <div class="no-review-emoji">
                                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{--   4 reviews--}}
                                        <div class="skltbs-panel">
                                            <!-- if comments available of this type -->
                                            <div class="all-comments--container">
                                                @if($four_star_reviews->isNotEmpty())
                                                    @foreach($four_star_reviews as $review)
                                                        <!-- comment 1 -->
                                                        <div class="single-comment--box">
                                                            <!-- user info -->
                                                            <div class="commented-user--info">
                                                                <div class="commented-user--img">
                                                                    @php
                                                                        // Get the first letter of each word in the user's name
                                                                        $nameParts = explode(' ', $review->name);
                                                                        $initials = '';
                                                                        foreach ($nameParts as $part) {
                                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                                        }
                                                                    @endphp
                                                                    {{ $initials }} <!-- Display initials -->
                                                                </div>
                                                                <div class="commented-user-name--date">
                                                                    <p class="commented-user--name">
                                                                        @if($review->name_format === 'Anonymous')
                                                                            Anonymous
                                                                        @elseif($review->name_format === 'John Smith')
                                                                            {{ $review->name }}
                                                                        @elseif($review->name_format === 'John S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ $nameParts[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}  {{-- Format: Jhonathan A. --}}
                                                                        @elseif($review->name_format === 'J.S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ (isset($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[2]) ? strtoupper(substr($nameParts[2], 0, 1)) . '.' : '') }}  {{-- Format: J. A. M. --}}
                                                                        @endif
                                                                    </p>
                                                                    <div class="commented-user--date">
                                                                        <span class="comment-update--btn">
                                                                          <img src="{{ asset('/frontend/assets/images/pen.svg') }}" alt="" srcset="" />
                                                                        </span>
                                                                        <span>Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- comment-user--stars -->
                                                            <div class="comment--total--stars">
                                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                                @endfor
                                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                                @endfor
                                                            </div>
                                                            <!-- title -->
                                                            <p class="comment-title">{{ $review->title }}</p>
                                                            <!-- description -->
                                                            <p class="comment-subtitle">
                                                                {{ $review->review }}
                                                            </p>
                                                            <div class="reviewed--images--in--comments">
                                                                @foreach($review->images as $image)
                                                                    <div class="reviewed--image--in--comments" data-bs-toggle="modal" data-bs-target="#show--review--image--comment--box--modal{{ $review->id }}" >
                                                                        <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- action btns -->
                                                            <div class="comment-like--btns">
                                                                @php
                                                                    $like_count = $review->likes->count();
                                                                    $userLiked = Auth::check() && $review->likes->contains('user_id', Auth::user()->id);
                                                                @endphp
                                                                @if($userLiked)
                                                                    <button class="comment-like-btn" disabled>
                                                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                                                        <span>({{ $like_count }})</span>
                                                                    </button>
                                                                @else
                                                                    @if(Auth::check())
                                                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                                                            <input type="hidden" name="likes" value="1" />
                                                                            <button class="comment-like-btn" type="submit">
                                                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                                <span class="like-count">({{ $like_count }})</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                            <span>({{ $like_count }})</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                <span class="button-separator"></span>
                                                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- if no comments available of this type -->
                                                    <div class="no--comments--available">
                                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                                        <div class="no-review-emoji">
                                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{--  3 reviews--}}
                                        <div class="skltbs-panel">
                                            <!-- if comments available of this type -->
                                            <div class="all-comments--container">
                                                @if($three_star_reviews->isNotEmpty())
                                                    @foreach($three_star_reviews as $review)
                                                        <!-- comment 1 -->
                                                        <div class="single-comment--box">
                                                            <!-- user info -->
                                                            <div class="commented-user--info">
                                                                <div class="commented-user--img">
                                                                    @php
                                                                        // Get the first letter of each word in the user's name
                                                                        $nameParts = explode(' ', $review->name);
                                                                        $initials = '';
                                                                        foreach ($nameParts as $part) {
                                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                                        }
                                                                    @endphp
                                                                    {{ $initials }} <!-- Display initials -->
                                                                </div>
                                                                <div class="commented-user-name--date">
                                                                    <p class="commented-user--name">
                                                                        @if($review->name_format === 'Anonymous')
                                                                            Anonymous
                                                                        @elseif($review->name_format === 'John Smith')
                                                                            {{ $review->name }}
                                                                        @elseif($review->name_format === 'John S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ $nameParts[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}  {{-- Format: Jhonathan A. --}}
                                                                        @elseif($review->name_format === 'J.S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ (isset($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[2]) ? strtoupper(substr($nameParts[2], 0, 1)) . '.' : '') }}  {{-- Format: J. A. M. --}}
                                                                        @endif
                                                                    </p>
                                                                    <div class="commented-user--date">
                                                                        <span class="comment-update--btn">
                                                                          <img src="{{ asset('/frontend/assets/images/pen.svg') }}" alt="" srcset="" />
                                                                        </span>
                                                                        <span>Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- comment-user--stars -->
                                                            <div class="comment--total--stars">
                                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                                @endfor
                                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                                @endfor
                                                            </div>
                                                            <!-- title -->
                                                            <p class="comment-title">{{ $review->title }}</p>
                                                            <!-- description -->
                                                            <p class="comment-subtitle">
                                                                {{ $review->review }}
                                                            </p>
                                                            <div class="reviewed--images--in--comments">
                                                                @foreach($review->images as $image)
                                                                    <div class="reviewed--image--in--comments" data-bs-toggle="modal" data-bs-target="#show--review--image--comment--box--modal{{ $review->id }}" >
                                                                        <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- action btns -->
                                                            <div class="comment-like--btns">
                                                                @php
                                                                    $like_count = $review->likes->count();
                                                                    $userLiked = Auth::check() && $review->likes->contains('user_id', Auth::user()->id);
                                                                @endphp
                                                                @if($userLiked)
                                                                    <button class="comment-like-btn" disabled>
                                                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                                                        <span>({{ $like_count }})</span>
                                                                    </button>
                                                                @else
                                                                    @if(Auth::check())
                                                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                                                            <input type="hidden" name="likes" value="1" />
                                                                            <button class="comment-like-btn" type="submit">
                                                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                                <span class="like-count">({{ $like_count }})</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                            <span>({{ $like_count }})</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                <span class="button-separator"></span>
                                                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- if no comments available of this type -->
                                                    <div class="no--comments--available">
                                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                                        <div class="no-review-emoji">
                                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{--   2 reviews--}}
                                        <div class="skltbs-panel">
                                            <!-- if comments available of this type -->
                                            <div class="all-comments--container">
                                                @if($two_star_reviews->isNotEmpty())
                                                    @foreach($two_star_reviews as $review)
                                                        <!-- comment 1 -->
                                                        <div class="single-comment--box">
                                                            <!-- user info -->
                                                            <div class="commented-user--info">
                                                                <div class="commented-user--img">
                                                                    @php
                                                                        // Get the first letter of each word in the user's name
                                                                        $nameParts = explode(' ', $review->name);
                                                                        $initials = '';
                                                                        foreach ($nameParts as $part) {
                                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                                        }
                                                                    @endphp
                                                                    {{ $initials }} <!-- Display initials -->
                                                                </div>
                                                                <div class="commented-user-name--date">
                                                                    <p class="commented-user--name">
                                                                        @if($review->name_format === 'Anonymous')
                                                                            Anonymous
                                                                        @elseif($review->name_format === 'John Smith')
                                                                            {{ $review->name }}
                                                                        @elseif($review->name_format === 'John S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ $nameParts[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}  {{-- Format: Jhonathan A. --}}
                                                                        @elseif($review->name_format === 'J.S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ (isset($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[2]) ? strtoupper(substr($nameParts[2], 0, 1)) . '.' : '') }}  {{-- Format: J. A. M. --}}
                                                                        @endif
                                                                    </p>
                                                                    <div class="commented-user--date">
                                                                        <span class="comment-update--btn">
                                                                          <img src="{{ asset('/frontend/assets/images/pen.svg') }}" alt="" srcset="" />
                                                                        </span>
                                                                        <span>Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- comment-user--stars -->
                                                            <div class="comment--total--stars">
                                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                                @endfor
                                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                                @endfor
                                                            </div>
                                                            <!-- title -->
                                                            <p class="comment-title">{{ $review->title }}</p>
                                                            <!-- description -->
                                                            <p class="comment-subtitle">
                                                                {{ $review->review }}
                                                            </p>
                                                            <div class="reviewed--images--in--comments">
                                                                @foreach($review->images as $image)
                                                                    <div class="reviewed--image--in--comments" data-bs-toggle="modal" data-bs-target="#show--review--image--comment--box--modal{{ $review->id }}" >
                                                                        <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- action btns -->
                                                            <div class="comment-like--btns">
                                                                @php
                                                                    $like_count = $review->likes->count();
                                                                    $userLiked = Auth::check() && $review->likes->contains('user_id', Auth::user()->id);
                                                                @endphp
                                                                @if($userLiked)
                                                                    <button class="comment-like-btn" disabled>
                                                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                                                        <span>({{ $like_count }})</span>
                                                                    </button>
                                                                @else
                                                                    @if(Auth::check())
                                                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                                                            <input type="hidden" name="likes" value="1" />
                                                                            <button class="comment-like-btn" type="submit">
                                                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                                <span class="like-count">({{ $like_count }})</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                            <span>({{ $like_count }})</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                <span class="button-separator"></span>
                                                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- if no comments available of this type -->
                                                    <div class="no--comments--available">
                                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                                        <div class="no-review-emoji">
                                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                        {{--   1 reviews--}}
                                        <div class="skltbs-panel">
                                            <!-- if comments available of this type -->
                                            <div class="all-comments--container">
                                                @if($one_star_reviews->isNotEmpty())
                                                    @foreach($one_star_reviews as $review)
                                                        <!-- comment 1 -->
                                                        <div class="single-comment--box">
                                                            <!-- user info -->
                                                            <div class="commented-user--info">
                                                                <div class="commented-user--img">
                                                                    @php
                                                                        // Get the first letter of each word in the user's name
                                                                        $nameParts = explode(' ', $review->name);
                                                                        $initials = '';
                                                                        foreach ($nameParts as $part) {
                                                                            $initials .= strtoupper(substr($part, 0, 1));
                                                                        }
                                                                    @endphp
                                                                    {{ $initials }} <!-- Display initials -->
                                                                </div>
                                                                <div class="commented-user-name--date">
                                                                    <p class="commented-user--name">
                                                                        @if($review->name_format === 'Anonymous')
                                                                            Anonymous
                                                                        @elseif($review->name_format === 'John Smith')
                                                                            {{ $review->name }}
                                                                        @elseif($review->name_format === 'John S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ $nameParts[0] . ' ' . (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') }}  {{-- Format: Jhonathan A. --}}
                                                                        @elseif($review->name_format === 'J.S.')
                                                                            @php
                                                                                $nameParts = explode(' ', $review->name);
                                                                            @endphp
                                                                            {{ (isset($nameParts[0]) ? strtoupper(substr($nameParts[0], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[1]) ? strtoupper(substr($nameParts[1], 0, 1)) . '.' : '') . ' ' .
                                                                               (isset($nameParts[2]) ? strtoupper(substr($nameParts[2], 0, 1)) . '.' : '') }}  {{-- Format: J. A. M. --}}
                                                                        @endif
                                                                    </p>
                                                                    <div class="commented-user--date">
                                                                        <span class="comment-update--btn">
                                                                          <img src="{{ asset('/frontend/assets/images/pen.svg') }}" alt="" srcset="" />
                                                                        </span>
                                                                        <span>Review on {{ \Carbon\Carbon::parse($review->created_at)->format('M j, Y') }}</span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!-- comment-user--stars -->
                                                            <div class="comment--total--stars">
                                                                @for ($i = 0; $i < $review['rating']; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/Star 9.svg') }}" alt="">
                                                                @endfor
                                                                @for ($i = $review['rating']; $i < 5; $i++)
                                                                    <img src="{{ asset('/frontend/assets/images/star.svg') }}" alt="">
                                                                @endfor
                                                            </div>
                                                            <!-- title -->
                                                            <p class="comment-title">{{ $review->title }}</p>
                                                            <!-- description -->
                                                            <p class="comment-subtitle">
                                                                {{ $review->review }}
                                                            </p>
                                                            <div class="reviewed--images--in--comments">
                                                                @foreach($review->images as $image)
                                                                    <div class="reviewed--image--in--comments" data-bs-toggle="modal" data-bs-target="#show--review--image--comment--box--modal{{ $review->id }}" >
                                                                        <img src="{{ asset($image->image) }}" alt="" srcset="">
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                            <!-- action btns -->
                                                            <div class="comment-like--btns">
                                                                @php
                                                                    $like_count = $review->likes->count();
                                                                    $userLiked = Auth::check() && $review->likes->contains('user_id', Auth::user()->id);
                                                                @endphp
                                                                @if($userLiked)
                                                                    <button class="comment-like-btn" disabled>
                                                                        <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                                                        <span>({{ $like_count }})</span>
                                                                    </button>
                                                                @else
                                                                    @if(Auth::check())
                                                                        <form class="like-form" action="{{ route('save.like', $review->id) }}" method="POST">
                                                                            @csrf
                                                                            <input type="hidden" name="user_id" value="{{ Auth::user()->id }}" />
                                                                            <input type="hidden" name="product_id" value="{{ $product->id }}" />
                                                                            <input type="hidden" name="product_review_id" value="{{ $review->id }}" />
                                                                            <input type="hidden" name="likes" value="1" />
                                                                            <button class="comment-like-btn" type="submit">
                                                                                <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                                <span class="like-count">({{ $like_count }})</span>
                                                                            </button>
                                                                        </form>
                                                                    @else
                                                                        <button class="comment-like-btn" type="button" onclick="checkAuthentication()">
                                                                            <img src="{{ asset('/frontend/assets/images/like.svg') }}" alt="Like" />
                                                                            <span>({{ $like_count }})</span>
                                                                        </button>
                                                                    @endif
                                                                @endif
                                                                <span class="button-separator"></span>
                                                                <span class="report-btn" data-bs-toggle="modal" data-bs-target="#report--review--modal{{ $review->id }}">Report</span>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <!-- if no comments available of this type -->
                                                    <div class="no--comments--available">
                                                        <!-- <p class="no--comments--text">No Comments Available</p> -->
                                                        <div class="no-review-emoji">
                                                            <img src="{{ asset('/frontend/assets/images/no-review-img.png') }}" alt="" srcset="" />
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @else
                    <!-- when no review -->
                    <div class="customer-review--container---no-review">
                        <p class="title">Customer Review</p>
                        <p class="subtitle">No reviews yet. Any feedback? Let us know</p>
                        <button class="common-write-review-btn sm" data-bs-toggle="modal" data-bs-target="#write-review-modal">
                            Write review
                        </button>
                    </div>
                @endif
            </div>
        </div>
        <!-- customer review ends -->
    </div>

@endsection

<!-- add to cart  -->
@push('script')

    <script>
        function checkAuthentication() {
            $.ajax({
                url: '{{ route('user.check_authentication') }}',
                method: 'GET',
                success: function(response) {
                    if (response.authenticated) {
                        // Automatically submit like form for authenticated users
                        $('.like-form').first().submit(); // Adjust as needed to submit the correct form
                    } else {
                        $('#create-login-modal').modal('show'); // Show login modal if not authenticated
                    }
                },
                error: function() {
                    $('#create-login-modal').modal('show'); // Show modal on error
                }
            });
        }

        // Review Like
        $(document).ready(function() {
            // Handle form submission for each like form
            $(document).on('submit', '.like-form', function(e) {
                e.preventDefault(); // Prevent the default form submission

                const form = $(this); // Reference to the form being submitted
                const url = form.attr('action'); // Get the action URL from the form
                const formData = form.serialize(); // Serialize the form data

                // Disable the form to prevent multiple submissions
                form.find('button[type="submit"]').prop('disabled', true);

                $.ajax({
                    url: url,
                    type: 'POST',
                    data: formData, // Send serialized form data
                    success: function(response) {
                        if (response.success) {
                            // Update the like count
                            const likeCountElem = form.find('.like-count');
                            let currentCount = parseInt(likeCountElem.text().match(/\d+/)[0]);

                            showSuccessToast(response.message);

                            // Replace form with the new button and image
                            const newButtonHTML = `
                                <button class="comment-like-btn" disabled>
                                    <img src="{{ asset('/frontend/assets/images/like-blue.svg') }}" alt="Liked" />
                                    <span>(${currentCount + 1})</span>
                                </button>
                            `;
                            form.replaceWith(newButtonHTML);
                        } else {
                            showErrorToast(response.message);
                        }
                    },
                    error: function(xhr) {
                        const errorMessage = xhr.responseJSON && xhr.responseJSON.message
                            ? xhr.responseJSON.message
                            : 'An error occurred. Please try again.';
                        showErrorToast(errorMessage);
                    },
                    complete: function() {
                        // Re-enable the submit button after the request completes
                        form.find('button[type="submit"]').prop('disabled', false);
                    }
                });
            });
        });


        // Toaster
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

