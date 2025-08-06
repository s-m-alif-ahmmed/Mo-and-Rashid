<!-- show carts items sidebar -->
<aside class="cart-items--sidebar">
    <div class="cart--items--wrapper use-rotate cart-wishlist-tab" id="cart-wishlist-tab">
        <div class="cart--items-sidebar--header">
            <!-- tab buttons -->
            <div class="skltbs-tab-group">

                <li class="skltbs-tab-item">
                    <a class="skltbs-tab">Your Cart</a>
                </li>
                <li class="skltbs-tab-item">
                    <a class="skltbs-tab">Wishlist</a>
                </li>

            </div>

            <span class="cart-items--close">
        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none">
          <path d="M6 18L18 6M6 6L18 18" stroke="black" stroke-width="2" stroke-linecap="round"
                stroke-linejoin="round" />
        </svg>
      </span>

        </div>
        <!-- content -->
        <div class="skltbs-panel-group">

            <!-- for cart items -->
            <div class="skltbs-panel">
                <form action="" method="POST" class="cart--items--lists--wrapper">

                    <div class="cart--items--lists" id="cart-container">

                        @if(Auth::check())

                            <!--get cart item-->
                                <?php
                                // Retrieve cart items for the authenticated user, including related product, color, and size information
                                $carts = \App\Models\Cart::where('user_id', auth()->user()->id)
                                    ->with(['product', 'color', 'size'])
                                    ->get();
                                ?>

                                <!-- Initialize total price variable -->
                                <?php $totalPrice = 0; ?>

                                <!-- Check if there are cart items -->
                            @if($carts->isEmpty())
                                <!-- if no cart item -->
                                <div class="no--items--found" id="no-items-message">
                                    <span>No items found.</span>
                                </div>
                            @else

                                <!-- Loop through each cart item and display the information -->
                                @foreach($carts as $cart)
                                    <div class="cart--item--card" data-id="{{ $cart->id }}">
                                        <div class="cart--item--img">
                                            @foreach($cart->product->images->take(1) as $image)
                                                <img src="{{ asset($image->image) }}" alt="{{ $cart->product->name }}">
                                            @endforeach
                                        </div>
                                        <div class="cart--item--info">
                                            <h4 class="cart--item--name">{{ $cart->product->name }}</h4>
                                            <p class="cart--item--price">${{ number_format($cart->product->selling_price, 2) }}</p>
                                            @if($cart->color_id)
                                                <div class="cart--item--color">
                                                    <span>Color</span>
                                                    <span>:</span>
                                                    <span>{{ $cart->color->color  }}</span>
                                                </div>
                                            @else
                                            @endif
                                            @if($cart->size_id)
                                                <div class="cart--item--size">
                                                    <span>Size</span>
                                                    <span>:</span>
                                                    <span>{{ $cart->size->size  }}</span>
                                                </div>
                                            @else
                                            @endif

                                            <a href="{{ route('product.wishlist', ['productID' => $cart->product->id, 'color_id' => '', 'size_id' => ''] )  }}"
                                               data-cart-id="{{ $cart->id }}" data-cart-product-id="{{ $cart->product->id }}"
                                               id="wishlist-toggle-cart" class="remove--cart--btn">Move to Wishlist</a>
                                            <a href="#" class="remove--cart--btn" onclick="removeCartItem(this)">Remove</a>
                                        </div>

                                        <input type="number" data-cart-id="{{ $cart->id }}" data-product-id="{{ $cart->product->id }}" name="quantity" class="cart--item--quantity--input" min="1" value="{{ $cart->quantity ?? 1 }}" data-previous-quantity="{{ $cart->quantity }}" data-available-stock="{{ $cart->product->quantity }}" />

                                    </div>
                                @endforeach
                            @endif
                        @elseif(!Auth::check() && session()->has('cart_' . session()->getId()))

                                <?php
                                // Retrieve the cart items from the session
                                $cartItems = session()->get('cart_' . session()->getId(), []);
                                ?>

                                <!-- Check if there are any cart items -->
                            @if(count($cartItems) > 0)
                                @foreach($cartItems as $itemKey => $item)

                                    <!-- Ensure the product exists before displaying its data -->
                                    <div class="cart--item--card" data-id="{{ $item['cartId'] }}">
                                        <div class="cart--item--img">
                                            @if(!empty($item['images']) && count($item['images']) > 0)
                                                <img src="{{ asset($item['images'][0]) }}" alt="{{ $item['product']['name'] }}">
                                            @endif
                                        </div>
                                        <div class="cart--item--info">
                                            <h4 class="cart--item--name">{{ $item['product']['name'] ?? 'N/A' }}</h4>
                                            <p class="cart--item--price">${{ number_format($item['selling_price'], 2) }}</p>

                                            <!-- Display Color if available -->
                                            @if(!empty($item['color']) && isset($item['color']->color))
                                                <div class="cart--item--color">
                                                    <span>Color</span>:
                                                    <span>{{ $item['color']->color ?? 'N/A' }}</span>
                                                </div>
                                            @endif

                                            <!-- Display Size if available -->
                                            @if(!empty($item['size']) && isset($item['size']->size))
                                                <div class="cart--item--size">
                                                    <span>Size</span>:
                                                    <span>{{ $item['size']->size ?? 'N/A' }}</span>
                                                </div>
                                            @endif

                                            <!-- Links for 'Move to Wishlist' & 'Remove from Cart' -->
                                            <a href="#" data-cart-id="{{ $itemKey }}" data-product-id="{{ $item['product']['id'] }}" data-color-id="{{ $item['color'] }}" data-size-id="{{ $item['size'] }}"
                                               class="remove--cart--btn" id="move-to-wishlist">Move to Wishlist</a>

                                            <a href="#" class="remove--cart--btn" onclick="removeGuestCartItem(this, '{{ $itemKey }}')">Remove</a>
                                        </div>

                                        <input type="number" name="quantity" class="cart--item--quantity--input--guest"
                                               data-cart-id="{{ $itemKey }}" data-product-id="{{ $item['product']['id'] }}"
                                               min="1" data-color-id="{{ $item['color']['id'] ?? null }}" data-size-id="{{ $item['size']['id'] ?? null }}"
                                               value="{{ $item['quantity'] ?? 1 }}" data-previous-quantity="{{ $item['quantity'] }}"
                                               data-available-stock="{{ \App\Models\Product::find($item['product']['id'])->quantity }}">
                                    </div>
                                @endforeach
                            @else
                                <!-- Display a message when there are no cart items -->
                                <div class="no--items--found" id="no-items-message">
                                    <span>No items found.</span>
                                </div>
                            @endif
                        @else
                            <!-- Display a message when there are no cart items or user is authenticated -->
                            <div class="no--items--found" id="no-items-message">
                                <span>No items found.</span>
                            </div>
                        @endif

                    </div>

                    @if(Auth::check())

                        @php
                            // Retrieve cart items for the authenticated user, including related product, color, and size information
                            $carts = \App\Models\Cart::where('user_id', auth()->user()->id)
                                ->with(['product', 'color', 'size'])
                                ->get();

                            // Initialize total price
                            $totalPrice = 0;

                            // Initialize total price variable
                            $totalPrice = $carts->sum(function ($cart) {
                                return $cart->quantity * $cart->product->selling_price;
                            });
                        @endphp

                        @if($carts->isNotEmpty())

                            <div class="cart--items--footer" id="checkout-box" style="display: block;">
                                <div class="subtotal-wrapper">
                                    <span>Subtotal</span>
                                    <b id="subtotal-amount">${{number_format($totalPrice, 2)}}</b>
                                </div>

                                <a href="{{ route('checkout') }}" class="continue--checkout--btn">Continue to Checkout</a>
                            </div>

                            <script>
                                function updateCheckoutButtonVisibility() {
                                    const cartItems = document.querySelectorAll('#cart-container .cart--item--card');
                                    const checkoutBox = document.getElementById('checkout-box');

                                    if (cartItems.length > 0) {
                                        checkoutBox.style.display = 'block'; // Show Checkout box
                                    } else {
                                        checkoutBox.style.display = 'none'; // Hide Checkout box
                                    }
                                }
                            </script>

                        @else
                            <div class="cart--items--footer" id="checkout-box" style="display: none;">
                                <div class="subtotal-wrapper">
                                    <span>Subtotal</span>
                                    <b id="subtotal-amount">${{number_format($totalPrice)}}</b>
                                </div>

                                <a href="{{ route('checkout') }}" class="continue--checkout--btn" disabled>Continue to Checkout</a>
                            </div>

                            <script>
                                function updateCheckoutButtonVisibility() {
                                    const cartItems = document.querySelectorAll('#cart-container .cart--item--card');
                                    const checkoutBox = document.getElementById('checkout-box');

                                    if (cartItems.length > 0) {
                                        checkoutBox.style.display = 'block'; // Show Checkout box
                                    } else {
                                        checkoutBox.style.display = 'none'; // Hide Checkout box
                                    }
                                }
                            </script>

                        @endif
                    @else
                        <?php
                        // Retrieve the cart items from the session
                        $cartItems = session()->get('cart_' . session()->getId(), []);
                        // Initialize total price
                        $totalPrice = 0;

                        // Calculate total price
                        foreach ($cartItems as $item) {
                            $totalPrice += $item['selling_price'] * $item['quantity'];
                        }
                        ?>

                        <div class="cart--items--footer" id="checkout-box-guest" style="display: {{ count($cartItems) > 0 ? 'block' : 'none' }};" >
                            <div class="subtotal-wrapper">
                                <span>Subtotal</span>
                                <b id="subtotal-amount-guest">${{number_format($totalPrice, 2)}}</b>
                            </div>

                            <a href="{{ route('checkout.guest') }}" class="continue--checkout--btn" >Continue to Checkout</a>
                        </div>

                        <script>
                            function updateCheckoutButtonVisibilityGuest() {
                                const cartItems = document.querySelectorAll('#cart-container .cart--item--card');
                                const checkoutBox = document.getElementById('checkout-box-guest');

                                if (cartItems.length > 0) {
                                    checkoutBox.style.display = 'block'; // Show Checkout box
                                } else {
                                    checkoutBox.style.display = 'none'; // Hide Checkout box
                                }
                            }
                        </script>

                    @endif

                </form>
            </div>

            <!-- for wishlist items -->
            <div class="skltbs-panel">
                <form class="cart--items--lists--wrapper">
                    <div class="cart--items--lists wishlist-container">

                        @if(Auth::check())
                            @php
                                $wishlists = \App\Models\Wishlist::with(['product', 'color', 'size'])
                                            ->where('user_id', \Illuminate\Support\Facades\Auth::user()->id)
                                            ->latest()
                                            ->get();
                            @endphp

                            @if($wishlists->isEmpty())
                                <!-- if no cart item -->
                                <div class="no--items--found" id="wishlist-no-product">
                                    <span>No items found.</span>
                                </div>
                            @else
                                @foreach($wishlists as $wishlist)
                                    <!-- wishlist items -->
                                    <div class="cart--item--card" data-wishlist-id="{{ $wishlist->id }}">
                                        <div class="cart--item--img">
                                            @if($wishlist->product->images && $wishlist->product->images->isNotEmpty())
                                                @foreach($wishlist->product->images->take(1) as $image)
                                                    <img src="{{ asset($image->image) }}" alt="">
                                                @endforeach
                                            @else
                                                <img src="{{ asset('assets/images/default-product.png') }}" alt="Default Image">
                                            @endif
                                        </div>
                                        <div class="cart--item--info">
                                            <h4 class="cart--item--name">{{ $wishlist->product->name }}</h4>
                                            <p class="cart--item--price">${{ $wishlist->product->selling_price }}</p>
                                            @if($wishlist->color)
                                            <div class="cart--item--color">
                                                <span>Color</span>
                                                <span>:</span>
                                                <span>{{ $wishlist->color->color }}</span>
                                            </div>
                                            @endif
                                            @if($wishlist->size)
                                            <div class="cart--item--size">
                                                <span>Size</span>
                                                <span>:</span>
                                                <span>{{ $wishlist->size->size }}</span>
                                            </div>
                                            @endif
                                            <a href="#"
                                               data-wishlist-id="{{ $wishlist->id }}" data-wishlist-product-id="{{ $wishlist->product->id }}"
                                               id="cart-toggle-wishlist" class="remove--cart--btn">Move to Cart</a>
                                            <a href="#" class="remove--cart--btn remove-wishlist-btn" onclick="removeWishlistItem(this)">Remove</a>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        @elseif(!Auth::check() && session()->has('wishlist_' . session()->getId()))
                                <?php
                                // Retrieve the wishlist items from the session
                                $wishlistItems = session()->get('wishlist_' . session()->getId(), []);
                                ?>

                                <!-- Check if there are any wishlist items -->
                            @if(count($wishlistItems) > 0)
                                @foreach($wishlistItems as $itemKey => $wishlist)

                                    <!-- wishlist items -->
                                    <div class="cart--item--card" data-wishlist-id="{{ $wishlist['wishlistId'] }}">
                                        <div class="cart--item--img">
                                            @if(!empty($wishlist['images']) && count($wishlist['images']) > 0)
                                                <img src="{{ asset($wishlist['images'][0]) }}" alt="{{ $wishlist['product']['name'] }}">
                                            @endif
                                        </div>
                                        <div class="cart--item--info">
                                            <h4 class="cart--item--name">{{ $wishlist['product']['name'] }}</h4>
                                            <p class="cart--item--price">${{ $wishlist['selling_price'] }}</p>
                                            @if($wishlist['color'])
                                                <div class="cart--item--color">
                                                    <span>Color</span>
                                                    <span>:</span>
                                                    <span>{{ $wishlist['color']->color ?? 'N/A' }}</span>
                                                </div>
                                            @endif
                                            @if($wishlist['size'])
                                                <div class="cart--item--size">
                                                    <span>Size</span>
                                                    <span>:</span>
                                                    <span>{{ $wishlist['size']->size }}</span>
                                                </div>
                                            @endif
                                            <a href="#"
                                               data-wishlist-id="{{ $wishlist['wishlistId'] }}" data-wishlist-product-id="{{ $wishlist['product']['id'] }}" data-color-id="{{ $wishlist['color'] }}" data-size-id="{{ $wishlist['size'] }}"
                                               id="cart-toggle-wishlist-guest" class="remove--cart--btn-guest">Move to Cart</a>
                                            <a href="#" class="remove--cart--btn remove-wishlist-btn" onclick="removeGuestWishlistItemGuest(this, '{{ $itemKey }}')">Remove</a>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <!-- Display a message when there are no cart items -->
                                <div class="no--items--found" id="no-items-message">
                                    <span>No items found.</span>
                                </div>
                            @endif
                        @else
                            <!-- if no cart item -->
                            <div class="no--items--found" id="wishlist-no-product">
                                <span>No items found.</span>
                            </div>
                        @endif
                    </div>

                    @if(Auth::check())
                        @if($wishlists->isNotEmpty())

                            @php
                                // Retrieve cart items for the authenticated user, including related product, color, and size information
                                $wishlists = \App\Models\Wishlist::where('user_id', auth()->user()->id)
                                    ->with(['product', 'color', 'size'])
                                    ->get();
                            @endphp

                            <div class="cart--items--footer wishlist" id="wishlist-box" style="display: block;">
                                <button type="submit" class="continue--checkout--btn wishlist wishlist-button">Add all to Cart</button>
                            </div>

                            <script>
                                function updateCheckoutButtonVisibility() {
                                    const wishlistItems = document.querySelectorAll('.wishlist-container .cart--item--card');
                                    const wishlistBox = document.getElementById('wishlist-box');

                                    if (wishlistItems.length > 0) {
                                        wishlistBox.style.display = 'block'; // Show wishlistBox
                                    } else {
                                        wishlistBox.style.display = 'none'; // Hide wishlistBox
                                    }
                                }
                            </script>

                        @else
                            <div class="cart--items--footer wishlist" id="wishlist-box" style="display: none;">
                                <button type="submit" class="continue--checkout--btn wishlist wishlist-button">Add all to Cart</button>
                            </div>

                            <script>
                                function updateCheckoutButtonVisibility() {
                                    const wishlistItems = document.querySelectorAll('.wishlist-container .cart--item--card');
                                    const wishlistBox = document.getElementById('wishlist-box');

                                    if (wishlistItems.length > 0) {
                                        wishlistBox.style.display = 'block'; // Show wishlistBox
                                    } else {
                                        wishlistBox.style.display = 'none'; // Hide wishlistBox
                                    }
                                }
                            </script>

                        @endif
                    @else

                            <?php
                            // Retrieve the wishlist items from the session
                            $wishlistItems = session()->get('wishlist_' . session()->getId(), []);
                            ?>

                        <div class="cart--items--footer wishlist" id="wishlist-box" style="display: {{ count($wishlistItems) > 0 ? 'block' : 'none' }};">
                            <button type="submit" class="continue--checkout--btn wishlist wishlist-button" id="add-all-to-cart">Add all to Cart</button>
                        </div>

                        <script>
                            function updateWishlistButtonVisibilityGuest() {
                                const wishlistItems = document.querySelectorAll('.wishlist-container .cart--item--card');
                                const wishlistBox = document.getElementById('wishlist-box');

                                if (wishlistItems.length > 0) {
                                    wishlistBox.style.display = 'block'; // Show wishlistBox
                                } else {
                                    wishlistBox.style.display = 'none'; // Hide wishlistBox
                                }
                            }
                        </script>
                    @endif

                </form>
            </div>

        </div>

    </div>
</aside>

<script>

    // User cart add update
    $(document).ready(function() {

        // add to cart btn function
        $('#add-to-cart-btn').on('click', function(e) {
            e.preventDefault();
            const productID = $('#product_id').val();
            const colorID = $('#color').val() || null;
            const sizeID = $('#size').val() || null;
            const url = '{{ route('cart.add') }}';

            let totalCartQuantity = 0;
            $('.cart--item--quantity--input').each(function() {
                totalCartQuantity += parseInt($(this).val());
            });

            const availableStock = parseInt($('#available-stock').val());

            if (totalCartQuantity + 1 > availableStock) {
                showErrorToast('Cannot add more than available stock.');
                return;
            }
            // Construct the data object conditionally
            const data = {
                product_id: productID
            };
            if (colorID) {
                data.color_id = colorID; // Include color_id only if it has a value
            }
            if (sizeID) {
                data.size_id = sizeID; // Include size_id only if it has a value
            }

            $.ajax({
                url: url,
                type: 'POST',
                contentType: 'application/json',
                data: JSON.stringify(data),
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    addCartDisplay(response.cart);
                    updateCheckoutButtonVisibility();
                    updateTotalPrice();
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'An error occurred';
                    showErrorToast(errorMessage);
                }
            });
        });

        // event handler for quantity input change
        $(document).on('change', '.cart--item--quantity--input', function() {
            const quantityInput = $(this);
            let quantityInputVal = quantityInput.val();
            const cartId = quantityInput.data('cart-id');

            if (quantityInputVal == NaN){
                quantityInputVal = 1;
            }
            const newQuantity = parseInt(quantityInputVal);

            if (quantityInputVal < 1) {
                quantityInput.val(1);
                return;
            }

            $.ajax({
                url: '{{ route('cart.update') }}',
                type: 'POST',
                data: {
                    id: cartId,
                    quantity: newQuantity,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    updateCartDisplay(data.cart);
                    updateTotalPrice();
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'An error occurred while updating the cart.';
                    showErrorToast(errorMessage);
                    quantityInput.val(quantityInput.data('previous-quantity')); // Reset to previous quantity on error
                }
            });
        });
    });

    // Session guest cart add update
    $(document).ready(function () {
        // Retrieve cart data from sessionStorage
        const cartItem = JSON.parse(sessionStorage.getItem('cartItem') || '[]');

        if (cartItem && cartItem.length > 0) {
            // If there's cart data, update the cart display
            updateGuestCartDisplay(cartItem);
            updateGuestTotalPrice(); // Update the total price after loading the cart
        }

        // Event handler for quantity input change guest
        $(document).on('change', '.cart--item--quantity--input--guest', function() {
            const quantityInput = $(this);
            let quantityInputVal = parseInt(quantityInput.val());
            const cartId = quantityInput.data('cart-id');
            const productId = quantityInput.data('product-id');
            const colorId = quantityInput.data('color-id'); // Ensure this is available
            const sizeId = quantityInput.data('size-id');   // Ensure this is available

            if (isNaN(quantityInputVal) || quantityInputVal < 1) {
                quantityInput.val(1);  // Reset to 1 if invalid
                return;
            }

            // Update the cart in sessionStorage
            let cartItems = JSON.parse(sessionStorage.getItem('cartItem') || '[]');

            // Find the item in the array and update the quantity
            const updatedCartItems = cartItems.map(item => {
                if (item.cartId === cartId) {
                    item.quantity = quantityInputVal;  // Update quantity
                }
                return item;
            });


            // Save the updated cart back to sessionStorage
            sessionStorage.setItem('cartItem', JSON.stringify(updatedCartItems));

            // Perform the AJAX request to update cart on server (optional, if needed)
            $.ajax({
                url: '{{ route('cart.update.guest') }}',
                type: 'POST',
                data: {
                    product_id: productId,
                    color_id: colorId,
                    size_id: sizeId,
                    quantity: quantityInputVal,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.success) {
                        // Update the cart display with new data
                        updateGuestCartDisplay(data.cartItem);
                        updateGuestTotalPrice(); // Update the total price on the cart
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'An error occurred while updating the cart.';
                    showErrorToast(errorMessage);
                    quantityInput.val(quantityInput.data('previous-quantity')); // Reset to previous quantity on error
                }
            });
        });

        // Session Add to cart button click event
        $('#add-to-cart-btn-user').on('click', function(e) {
            e.preventDefault();

            // Gather data
            const productID = $('#product_id').val();
            const colorID = $('#color').val() || null;
            const sizeID = $('#size').val() || null;
            const url = '{{ route('cart.add.guest') }}';

            let totalCartQuantity = 0;
            $('.cart--item--quantity--input').each(function() {
                totalCartQuantity += parseInt($(this).val());
            });

            const availableStock = parseInt($('#available-stock').val());

            // Check if the total quantity exceeds available stock
            if (totalCartQuantity + 1 > availableStock) {
                showErrorToast('Cannot add more than available stock.');
                return;
            }

            // Prepare data for GET request (using query parameters)
            const data = {
                product_id: productID,
                color_id: colorID,
                size_id: sizeID,
            };

            // Perform the AJAX request
            $.ajax({
                url: url,
                type: 'GET',
                data: data,  // Send data as query parameters
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        // Retrieve existing cart items from sessionStorage
                        let cartItems = JSON.parse(sessionStorage.getItem('cartItem') || '[]');

                        // Check if the product already exists in the cart
                        let productExists = false;

                        // Iterate through the cart items to check if this product is already in the cart
                        cartItems = cartItems.map(item => {
                            const colorMatch = item.color ? item.color.id === colorID : colorID === null;
                            const sizeMatch = item.size ? item.size.id === sizeID : sizeID === null;

                            if (item.product.id === response.cartItem.product.id && colorMatch && sizeMatch) {
                                // If it exists, update the quantity
                                item.quantity += 1;
                                productExists = true;
                            }
                            return item;
                        });

                        // If the product doesn't exist in the cart, add it
                        if (!productExists) {
                            cartItems.push(response.cartItem);
                        }

                        // Save the updated cart items back to sessionStorage
                        sessionStorage.setItem('cartItem', JSON.stringify(cartItems));

                        // Update the cart display
                        sessionAddCartDisplay(response.cartItem);
                        updateCheckoutButtonVisibilityGuest();
                        updateGuestTotalPrice();
                    }
                },
                error: function(xhr) {
                    const errorMessage = xhr.responseJSON?.message || 'An error occurred';
                    showErrorToast(errorMessage);
                }
            });
        });

        // Retrieve cart data from sessionStorage and display
        const cart = JSON.parse(sessionStorage.getItem('cartItem'));
        if (cart) {
            sessionAddCartDisplay(cart);
        }
    });

    // Session guest Cart display update
    function updateGuestCartDisplay(cartItem) {
        const cartContainer = document.querySelector('#cart-container'); // Your cart container element
        const existingItem = cartContainer.querySelector(`.cart--item--card[data-id="${cartItem.cartId}"]`); // Use the unique key to find the item

        if (existingItem) {
            // Update existing item quantity
            const quantityInput = existingItem.querySelector('.cart--item--quantity--input--guest');
            quantityInput.value = cartItem.quantity;

        } else {
            // If the item does not exist, you may want to handle that case
            console.warn('Cart item not found in the display for update');
        }
    }

    // Update user cart display function
    function updateCartDisplay(cart) {
        const cartContainer = document.querySelector('#cart-container');
        const existingItem = cartContainer.querySelector(`.cart--item--card[data-id="${cart.id}"]`);

        if (existingItem) {
            // Update existing item
            const quantityInput = existingItem.querySelector('.cart--item--quantity--input');
            quantityInput.value = cart.quantity; // Update quantity
        } else {

            // Create a new item HTML structure
            let colorHTML = '';
            if (cart.color && cart.color.color) {
                colorHTML = `
            <div class="cart--item--color">
                <span>Color</span>: <span>${cart.color.color}</span>
            </div>`;
            }
            // Create a new item HTML structure
            let sizeHTML = '';
            if (cart.size && cart.size.size) {
                sizeHTML = `
            <div class="cart--item--size">
                <span>Size</span>: <span>${cart.size.size}</span>
            </div>`;
            }

            // If the item doesn't exist, create a new item (this should not typically happen in an update scenario)
            const newItemHTML = `
            <div class="cart--item--card" data-id="${cart.id}">
                <div class="cart--item--img">
                    <img src="${cart.product.image}" alt="${cart.product.name}">
                </div>
                <div class="cart--item--info">
                    <h4 class="cart--item--name">${cart.product.name}</h4>
                    <p class="cart--item--price">Tk ${Number(cart.product.selling_price).toFixed(2)}</p>
                    $(colorHTML)
                    $(sizeHTML)
                    <a class="remove--cart--btn" href="#" onclick="removeCartItem(this)">Remove</a>
                </div>
                <input type="number" data-cart-id="${cart.id}" name="quantity" class="cart--item--quantity--input" min="1" value="${cart.quantity}" />
            </div>
        `;
            cartContainer.insertAdjacentHTML('beforeend', newItemHTML);
        }
    }

    // Session Guest cart Remove
    function removeGuestCartItem(element, cartId) {
        const url = '{{ route('cart.remove.guest') }}'; // Route for removing item

        // Perform AJAX request to remove the item from the server
        $.ajax({
            url: url,
            type: 'POST', // Use POST for deletion
            data: {
                cart_id: cartId,
                _token: '{{ csrf_token() }}', // CSRF token for security
            },
            success: function(response) {
                if (response.success) {
                    // Retrieve the cart items from sessionStorage as an array
                    let cartItems = JSON.parse(sessionStorage.getItem('cartItem') || '[]');

                    // Remove the cart item with the specific cartId from the array
                    cartItems = cartItems.filter(item => item.cartId !== cartId);

                    // Save the updated cart back to sessionStorage
                    sessionStorage.setItem('cartItem', JSON.stringify(cartItems));

                    // Remove the item from the DOM
                    const cartItemElement = document.querySelector(`.cart--item--card[data-id="${cartId}"]`);
                    if (cartItemElement) {
                        cartItemElement.remove();
                    }

                    // Check if there are any items left in the cart
                    if (cartItems.length === 0) {
                        // Show no items found message
                        $('#cart-container').html(`
                        <div class="no--items--found" id="no-items-message">
                            <span>No items found.</span>
                        </div>
                    `);
                    }

                    // Update total price and checkout button visibility
                    updateGuestTotalPrice();
                    updateCheckoutButtonVisibilityGuest();
                }
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'An error occurred while removing the item from the cart.';
                showErrorToast(errorMessage);
            }
        });
    }

    // User cart remove
    function removeCartItem(element) {
        const cartItemId = $(element).closest('.cart--item--card').data('id');
        const url = "{{ route('cart.item.remove', ':id') }}".replace(':id', cartItemId);

        $.ajax({
            url: url,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                $(element).closest('.cart--item--card').remove();

                // Check if there are any items left in the cart
                if ($('#cart-container').children('.cart--item--card').length === 0) {
                    // Show no items found message
                    $('#cart-container').html(`
                    <div class="no--items--found" id="no-items-message">
                        <span>No items found.</span>
                    </div>
                `);
                }

                updateTotalPrice();
                updateCheckoutButtonVisibility();
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'Could not remove item from cart.';
                showErrorToast(errorMessage);
            }
        });
    }

    // user add cart display item
    function addCartDisplay(cart) {
        const cartContainer = document.querySelector('#cart-container');
        const existingItem = cartContainer.querySelector(`.cart--item--card[data-id="${cart.id}"]`);

        if (existingItem) {
            // Update existing item quantity
            const quantityInput = existingItem.querySelector('.cart--item--quantity--input');
            quantityInput.value = cart.quantity;
            $(quantityInput).trigger('change'); // This will call the existing change handler
        } else {
            // Create a new item HTML structure
            let colorHTML = '';
            if (cart.color && cart.color.color) {
                colorHTML = `
                <div class="cart--item--color">
                    <span>Color</span>: <span>${cart.color.color}</span>
                </div>`;
            }
            // Create a new item HTML structure
            let sizeHTML = '';
            if (cart.size && cart.size.size) {
                sizeHTML = `
                <div class="cart--item--size">
                    <span>Size</span>: <span>${cart.size.size}</span>
                </div>`;
            }

            // Create a new item HTML structure
            const newItemHTML = `
            <div class="cart--item--card" data-id="${cart.id}">
                <div class="cart--item--img">
                    <img src="${cart.product.image}" alt="${cart.product.name}">
                </div>
                <div class="cart--item--info">
                    <h4 class="cart--item--name">${cart.product.name}</h4>
                    <p class="cart--item--price">$${Number(cart.product.selling_price).toFixed(2)}</p>
                    ${colorHTML}
                    ${sizeHTML}
                    <a href="#" data-cart-id="${cart.id}" id="wishlist-toggle-cart" class="remove--cart--btn">Move to Wishlist</a>
                    <a class="remove--cart--btn" href="#" onclick="removeCartItem(this)">Remove</a>
                </div>
                <input type="number" data-cart-id="${cart.id}" name="quantity" class="cart--item--quantity--input" min="1" value="${cart.quantity}" data-previous-quantity="${ cart.quantity }" data-available-stock="${ cart.product.quantity }" />
            </div>`;

            cartContainer.insertAdjacentHTML('beforeend', newItemHTML);
            updateTotalPrice();
        }

        const noItemsMessage = document.getElementById('no-items-message');
        if (noItemsMessage) {
            noItemsMessage.style.display = 'none'; // Hide the message
        }else{
            noItemsMessage.style.display = '';
        }
    }

    // session guest add cart display item
    function sessionAddCartDisplay(cart) {
        // Check if the user is logged in (this can be based on a cookie, localStorage, etc.)
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }};

        // If logged in, do not display session cart items
        if (isLoggedIn) {
        }else{
            const cartContainer = document.querySelector('#cart-container');
            const existingItem = cartContainer.querySelector(`.cart--item--card[data-id="${cart.cartId}"]`);

            if (existingItem) {
                // Update existing item quantity
                const quantityInput = existingItem.querySelector('.cart--item--quantity--input--guest');
                quantityInput.value = cart.quantity;
                $(quantityInput).trigger('change'); // Trigger change event to update the cart UI
            } else {
                // Create new item HTML structure
                let colorHTML = '';
                if (cart.color !== null) { // Check if color object is available
                    colorHTML = `
                    <div class="cart--item--color">
                        <span>Color</span>: <span>${cart.color.color}</span>
                    </div>`;
                }

                let sizeHTML = '';
                if (cart.size !== null) { // Check if size object is available
                    sizeHTML = `
                    <div class="cart--item--size">
                        <span>Size</span>: <span>${cart.size.size}</span>
                    </div>`;
                }

                // Create the image HTML with a conditional check
                let imageHTML = '';
                if (cart.images && cart.images.length > 0) {
                    imageHTML = `
                    <div class="cart--item--img">
                    <img src="{{ asset('/${cart.images[0]}') }}" alt="${cart.product.name}">
                    </div>`;
                }

                // Create a new item HTML structure
                const newItemHTML = `
            <div class="cart--item--card" data-id="${cart.cartId}">
                ${imageHTML}
                <div class="cart--item--info">
                    <h4 class="cart--item--name">${cart.product.name}</h4>
                    <p class="cart--item--price">$${Number(cart.selling_price).toFixed(2)}</p>
                    ${colorHTML}
                    ${sizeHTML}
                    <a href="#" data-cart-id="${cart.cartId}" data-product-id="${cart.product.id}" data-color-id="${cart.color}" data-size-id="${cart.size}" id="move-to-wishlist" class="remove--cart--btn">Move to Wishlist</a>
                    <a href="#" class="remove--cart--btn" onclick="removeGuestCartItem(this, '${cart.cartId}')">Remove</a>
                </div>
                <input type="number" data-cart-id="${cart.id}" data-product-id="${cart.product.id}" data-color-id="${cart.color ? cart.color.id : ''}" data-size-id="${cart.size ? cart.size.id : ''}" name="quantity" class="cart--item--quantity--input--guest" min="1" value="${cart.quantity}" data-available-stock="${cart.product.quantity}" />
            </div>`;

                // Add the new item HTML to the cart container
                cartContainer.insertAdjacentHTML('beforeend', newItemHTML);
            }

            // Hide "No items found" message when cart is not empty
            const noItemsMessage = document.getElementById('no-items-message');
            if (noItemsMessage) {
                noItemsMessage.style.display = 'none';
            }

        }

    }

    // session guest update total price (called whenever cart is modified)
    function updateGuestTotalPrice() {
        let totalPrice = 0;

        // Loop through all cart items
        $('#cart-container .cart--item--card').each(function() {
            // Get quantity of each product
            const quantity = parseInt($(this).find('.cart--item--quantity--input--guest').val());

            // Get price of each product (strip $ and parse to float)
            const priceText = $(this).find('.cart--item--price').text().replace('$', '').trim();
            const price = parseFloat(removeComma(priceText)); // Ensure this function removes commas if present

            // Only add to total if quantity and price are valid
            if (!isNaN(quantity) && !isNaN(price)) {
                totalPrice += quantity * price;  // Calculate the total price for the cart
            }
        });

        // Format and update the subtotal amount
        const formattedPrice = formatPrice(totalPrice);
        $('.subtotal-wrapper #subtotal-amount-guest').text(formattedPrice);  // Update the display with the formatted price
    }

    // user Update Total Price (called whenever cart is modified)
    function updateTotalPrice() {
        let totalPrice = 0;

        // Loop through all cart items
        $('#cart-container .cart--item--card').each(function() {
            // Get quantity of each product
            const quantity = parseInt($(this).find('.cart--item--quantity--input').val());

            // Get price of each product (strip $ and parse to float)
            const priceText = $(this).find('.cart--item--price').text().replace('$', '').trim();
            const price = parseFloat(removeComma(priceText));
            console.log(price);

            // Only add to total if quantity and price are valid
            if (!isNaN(quantity) && !isNaN(price)) {
                totalPrice += quantity * price;  // Calculate the total price for the cart
            }

        });

        // Format and update the subtotal amount

        const formattedPrice = formatPrice(totalPrice);
        $('.subtotal-wrapper b').text(formattedPrice);  // Update the display with the formatted price
    }

    // Remove comma from price
    function removeComma(input) {
        return parseFloat(input.replace(/,/g, ''));
    }

    // display Price format
    function formatPrice(amount) {
        return `$${amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}`;
    }

    // cart checkout button and price show and hide
    function updateCheckoutButtonVisibility() {
        const cartItems = document.querySelectorAll('#cart-container .cart--item--card');
        const checkoutBox = document.getElementById('checkout-box');
        const checkoutButton = document.querySelector('.checkout-button');

        if (cartItems.length > 0) {
            checkoutBox.style.display = 'block'; // Show Checkout box
            if (checkoutButton) {
                checkoutButton.style.display = 'block'; // Show Checkout button
            }
        } else {
            checkoutBox.style.display = 'none'; // Hide Checkout box
            if (checkoutButton) {
                checkoutButton.style.display = 'none'; // Hide Checkout button
            }
        }
        // Call the function on page load
        document.addEventListener('DOMContentLoaded', updateCheckoutButtonVisibility);
    }

    // session guest cart checkout button and price show and hide
    function updateCheckoutButtonVisibilityGuest() {
        const cartItems = document.querySelectorAll('#cart-container .cart--item--card');
        const checkoutBox = document.getElementById('checkout-box-guest');
        const checkoutButton = document.querySelector('.checkout-button');

        if (cartItems.length > 0) {
            checkoutBox.style.display = 'block'; // Show Checkout box
            if (checkoutButton) {
                checkoutButton.style.display = 'block'; // Show Checkout button
            }
        } else {
            checkoutBox.style.display = 'none'; // Hide Checkout box
            if (checkoutButton) {
                checkoutButton.style.display = 'none'; // Hide Checkout button
            }
        }
        // Call the function on page load
        document.addEventListener('DOMContentLoaded', updateCheckoutButtonVisibility);
    }

    // wishlist add all to cart button show and hide
    function updateWishlistButtonVisibility() {
        const wishlistItems = document.querySelectorAll('.wishlist-container .cart--item--card');
        const wishlistBox = document.getElementById('wishlist-box');
        const wishlistMessage = document.getElementById('no-items-message');
        const wishlistButton = document.querySelector('.wishlist-button');

        console.log('Wishlist items count:', wishlistItems.length); // Debugging line

        if (wishlistItems.length > 0) {
            wishlistBox.style.display = 'block'; // Show Checkout box
            wishlistMessage.style.display = 'none'; // Show Checkout box
            if (wishlistButton) {
                wishlistButton.style.display = 'block'; // Show Checkout button
            }
            if (wishlistMessage) {
                wishlistMessage.style.display = 'none'; // Show Checkout button
            }
        } else {
            wishlistBox.style.display = 'none'; // Hide Checkout box
            wishlistMessage.style.display = 'block'; // Hide Checkout box
        }
    }

    // Session guest wishlist button show and hide
    function updateWishlistButtonVisibilityGuest() {
        const wishlistItems = $('.wishlist-container .cart--item--card');
        const wishlistBox = $('#wishlist-box');

        if (wishlistItems.length > 0) {
            wishlistBox.show();
        } else {
            wishlistBox.hide();
            if ($('.wishlist-container').find('.no--items--found').length === 0) {
                $('.wishlist-container').append(`
                <div class="no--items--found" id="wishlist-no-product">
                    <span>No items found.</span>
                </div>
            `);
            }
        }
    }

    // User Move single product cart To Wishlist
    $(document).on('click', '.remove--cart--btn#wishlist-toggle-cart', function(e) {
        e.preventDefault();
        const cartItemId = $(this).data('cart-id');
        const url = `/cart/move-to-wishlist/${cartItemId}`; // Adjust URL according to your routes

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            },
            success: function(response) {

                // Create color and size HTML if they exist
                let colorHTML = '';
                if (response.wishlistItem.color) {
                    colorHTML = `
                    <div class="cart--item--color">
                        <span>Color</span>: <span>${response.wishlistItem.color}</span>
                    </div>`;
                }

                let sizeHTML = '';
                if (response.wishlistItem.size) {
                    sizeHTML = `
                    <div class="cart--item--size">
                        <span>Size</span>: <span>${response.wishlistItem.size}</span>
                    </div>`;
                }

                // Update the wishlist display
                const wishlistItemHTML = `
                <div class="cart--item--card" data-wishlist-id="${response.wishlistItem.wishlistId}">
                    <div class="cart--item--img">
                        <img src="${response.wishlistItem.image}" alt="${response.wishlistItem.name}">
                    </div>
                    <div class="cart--item--info">
                        <h4 class="cart--item--name">${response.wishlistItem.name}</h4>
                        <p class="cart--item--price">$${response.wishlistItem.price}</p>
                        ${colorHTML}
                        ${sizeHTML}
                        <a href="#" data-wishlist-id="${response.wishlistItem.wishlistId}" data-wishlist-product-id="${response.wishlistItem.id}" id="cart-toggle-wishlist" class="remove--cart--btn">Move to Cart</a>
                        <a class="remove--cart--btn remove-wishlist-btn" href="#" onclick="removeWishlistItem(this)">Remove</a>
                    </div>
                </div>`;

                // Append the new item to the wishlist container
                $('.wishlist-container').append(wishlistItemHTML);

                // Check if the wishlist was previously empty
                if ($('.wishlist-container .cart--item--card').length > 0) {
                    $('.wishlist-container').find('.no--items--found').remove(); // Remove no items message
                }

                // Remove the cart item from the display
                $(`.cart--item--card[data-id="${cartItemId}"]`).remove();

                // Check if the cart is empty and update the message
                if ($('#cart-container').children('.cart--item--card').length === 0) {
                    $('#cart-container').html(`
                        <div class="no--items--found" id="no-items-message">
                            <span>No items found.</span>
                        </div>
                    `);
                }

                $('#wishlist-button-text').text("Remove from Wishlist");

                updateTotalPrice(); // Update total price if needed
                updateCheckoutButtonVisibility();
                updateWishlistButtonVisibility()

            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'An error occurred while moving to wishlist.';
                showErrorToast(errorMessage);
            }
        });
    });

    // Session guest Move single product cart To Wishlist
    $(document).on('click', '#move-to-wishlist', function(e) {
        e.preventDefault();

        const cartId = $(this).data('cart-id'); // Get the cart item ID
        const url = '/guest/cart/move-to-wishlist'; // Adjust URL according to your routes

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Include CSRF token for security
                cartItemId: cartId // Send the cart item ID
            },
            success: function(response) {
                if (response.success) {

                    // Step 1: Retrieve the current wishlist from sessionStorage (or an empty array if none)
                    let wishlistItems = JSON.parse(sessionStorage.getItem('wishlistItem') || '[]');

                    // Step 2: Add the new item to the wishlist
                    wishlistItems.push(response.wishlistItem); // response.wishlistItem should be the moved item

                    // Step 3: Save the updated wishlist back to sessionStorage
                    sessionStorage.setItem('wishlistItem', JSON.stringify(wishlistItems));

                    // Step 4: Retrieve the current cart items from sessionStorage (or an empty array if none)
                    let cartItems = JSON.parse(sessionStorage.getItem('cartItem') || '[]');

                    // Ensure cartItems is an array, in case the sessionStorage has corrupted data
                    if (!Array.isArray(cartItems)) {
                        cartItems = []; // If it's not an array, reset to empty array
                    }

                    // Step 5: Find and remove the moved item from cartItems
                    // This removes only the item with the matching cartId
                    const updatedCartItems = cartItems.filter(item => item.cartId !== cartId);

                    // Step 6: Save the updated cart back to sessionStorage without resetting the entire array
                    sessionStorage.setItem('cartItem', JSON.stringify(updatedCartItems));

                    // Step 7: Remove the cart item from the DOM using its cartId
                    const cartItem = document.querySelector(`.cart--item--card[data-id="${cartId}"]`);
                    if (cartItem) {
                        cartItem.remove(); // Remove the item from the DOM
                    }

                    // Update the DOM
                    wishlistItemDisplayGuest(response);

                    // Step 8: Check if there are any items left in the cart
                    if (updatedCartItems.length === 0) {
                        // Show the "No items found" message if the cart is empty
                        $('#cart-container').html(`
                            <div class="no--items--found" id="no-items-message">
                                <span>No items found.</span>
                            </div>
                        `);
                    }

                    $('#wishlist-button-text').text("Remove from Wishlist");

                } else {
                    showErrorToast(response.message); // Show error if product is already in wishlist
                }
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'An error occurred while moving to wishlist.';
                showErrorToast(errorMessage);
            }
        });
    });

    // Session guest Move single product cart To Wishlist Display
    function wishlistItemDisplayGuest(response) {

        // Remove the "No items found" message first if any
        const noItemsMessage = $('.wishlist-container').find('.no--items--found');
        if (noItemsMessage.length > 0) {
            noItemsMessage.remove(); // Remove the message if it's there
        }

        let colorHTML = '';
        if (response.wishlistItem.color) {
            colorHTML = `
            <div class="cart--item--color">
                <span>Color</span>: <span>${response.wishlistItem.color.color}</span>
            </div>`;
        }

        let sizeHTML = '';
        if (response.wishlistItem.size) {
            sizeHTML = `
            <div class="cart--item--size">
                <span>Size</span>: <span>${response.wishlistItem.size.size}</span>
            </div>`;
        }

        // Create the image HTML with a conditional check
        let imageHTML = '';
        if (response.wishlistItem.images && response.wishlistItem.images.length > 0) {
            imageHTML = `
                    <div class="cart--item--img">
                    <img src="{{ asset('/${response.wishlistItem.images[0]}') }}" alt="${response.wishlistItem.product.name}">
                    </div>`;
        }

        const wishlistItemHTML = `
        <div class="cart--item--card" data-wishlist-id="${response.wishlistItem.wishlistId}">
            ${imageHTML}
            <div class="cart--item--info">
                <h4 class="cart--item--name">${response.wishlistItem.product.name}</h4>
                <p class="cart--item--price">$${response.wishlistItem.selling_price}</p>
                ${colorHTML}
                ${sizeHTML}
                <a href="#" data-wishlist-id="${response.wishlistItem.wishlistId}"
                data-wishlist-product-id="${response.wishlistItem.product.id}"
                data-color-id="${response.wishlistItem.color.id}"
                data-size-id="${response.wishlistItem.size.id}"
                id="cart-toggle-wishlist-guest" class="remove--cart--btn-guest">Move to Cart</a>
                <a href="#" class="remove--cart--btn remove-wishlist-btn" onclick="removeGuestWishlistItemGuest(this, '${response.wishlistItem.wishlistId}')">Remove</a>
            </div>
        </div>`;

        // Append the new item to the wishlist container
        $('.wishlist-container').append(wishlistItemHTML);
        updateCheckoutButtonVisibilityGuest();
        updateWishlistButtonVisibilityGuest();
    }

    // User Move single product wishlist To cart
    $(document).on('click', '.remove--cart--btn#cart-toggle-wishlist', function(e) {
        e.preventDefault();
        const wishlistItemId = $(this).data('wishlist-id');
        const url = `/wishlist/move-to-cart/${wishlistItemId}`; // Adjust URL according to your routes

        $.ajax({
            url: url,
            type: 'GET',
            data: {
                _token: '{{ csrf_token() }}' // Include CSRF token for security
            },
            success: function(response) {
                if (response.success) {
                    // Create color and size HTML if they exist
                    let colorHTML = '';
                    if (response.cartItem.color) {
                        colorHTML = `
                        <div class="cart--item--color">
                            <span>Color</span>: <span>${response.cartItem.color}</span>
                        </div>`;
                    }

                    let sizeHTML = '';
                    if (response.cartItem.size) {
                        sizeHTML = `
                    <div class="cart--item--size">
                        <span>Size</span>: <span>${response.cartItem.size}</span>
                    </div>`;
                    }

                    // Update the cart display
                    const cartItemHTML = `
                <div class="cart--item--card" data-id="${response.cartItem.cartId}">
                    <div class="cart--item--img">
                        <img src="${response.cartItem.image}" alt="${response.cartItem.name}">
                    </div>
                    <div class="cart--item--info">
                        <h4 class="cart--item--name">${response.cartItem.name}</h4>
                        <p class="cart--item--price">$${response.cartItem.price}</p>
                        ${colorHTML}
                        ${sizeHTML}
                        <a href="#" data-cart-id="${response.cartItem.cartId}" id="wishlist-toggle-cart" class="remove--cart--btn">Move to Wishlist</a>
                        <a class="remove--cart--btn" href="#" onclick="removeCartItem(this)">Remove</a>
                    </div>
                    <input type="number" data-cart-id="${response.cartItem.cartId}" name="quantity" class="cart--item--quantity--input" min="1" value="1" />
                </div>`;

                    // Append the new item to the cart container
                    $('#cart-container').append(cartItemHTML);

                    // Check if the cart was previously empty
                    if ($('#cart-container .cart--item--card').length > 0) {
                        $('#cart-container').find('.no--items--found').remove(); // Remove no items message
                    }

                    // Remove the item from the wishlist
                    $(`.cart--item--card[data-wishlist-id="${wishlistItemId}"]`).remove();

                    // Check if the wishlist is empty and update the message
                    if ($('.wishlist-container').children('.cart--item--card').length === 0) {
                        $('.wishlist-container').html(`
                        <div class="no--items--found" id="no-items-message">
                            <span>No items found.</span>
                        </div>
                    `);
                    }

                    $('#wishlist-button-text').text("Add to Wishlist");

                    updateTotalPrice(); // Update total price if needed
                    updateCheckoutButtonVisibility();
                    updateWishlistButtonVisibility();

                } else {
                    showErrorToast(response.message);
                }
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'An error occurred while moving to wishlist.';
                showErrorToast(errorMessage);
            }
        });
    });

    // Session Guest Move single product wishlist To cart
    $(document).on('click', '.remove--cart--btn-guest#cart-toggle-wishlist-guest', function(e) {
        e.preventDefault();

        const wishlistId = $(this).data('wishlist-id'); // Get the wishlist item ID
        const url = '/guest/wishlist/move-to-cart'; // Adjust URL according to route

        $.ajax({
            url: url,
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}', // Include CSRF token for security
                wishlistItemId: wishlistId // Send the cart item ID
            },
            success: function(response) {
                if (response.success) {

                    // Step 1: Retrieve the current cart from sessionStorage (or an empty array if none)
                    let cartItems = JSON.parse(sessionStorage.getItem('cartItem') || '[]');

                    // Step 2: Add the new item to the cart
                    cartItems.push(response.cartItem); // response.cartItem should be the moved item

                    // Step 3: Save the updated cart back to sessionStorage
                    sessionStorage.setItem('cartItem', JSON.stringify(cartItems));

                    // Step 4: Retrieve the current wishlist items from sessionStorage (or an empty array if none)
                    let wishlistItems = JSON.parse(sessionStorage.getItem('wishlistItem') || '[]');

                    // Ensure wishlistItems is an array, in case the sessionStorage has corrupted data
                    if (!Array.isArray(wishlistItems)) {
                        wishlistItems = []; // If it's not an array, reset to empty array
                    }

                    // Step 5: Find and remove the moved item from wishlistItems
                    // This removes only the item with the matching wishlistId
                    const updatedwishlistItems = wishlistItems.filter(item => item.wishlistId !== wishlistId);

                    // Step 6: Save the updated cart back to sessionStorage without resetting the entire array
                    sessionStorage.setItem('wishlistItem', JSON.stringify(updatedwishlistItems));

                    // Step 7: Remove the cart item from the DOM using its wishlistId
                    const wishlistItem = document.querySelector(`.cart--item--card[data-wishlist-id="${wishlistId}"]`);
                    if (wishlistItem) {
                        wishlistItem.remove(); // Remove the item from the DOM
                    }

                    // Step 8: Check if there are any items left in the wishlist
                    if (updatedwishlistItems.length === 0) {
                        // Show the "No items found" message if the wishlist is empty
                        $('.wishlist-container').html(`
                            <div class="no--items--found" id="no-items-message">
                                <span>No items found.</span>
                            </div>
                        `);
                    }

                    // Update the DOM
                    sessionMoveWishlistToCartDisplay(cartItems);

                    $('#wishlist-button-text').text("Add to Wishlist");

                } else {
                    showErrorToast(response.message); // Show error if product is already in cart
                }
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'An error occurred while moving to wishlist.';
                showErrorToast(errorMessage);
            }
        });
    });

    // session guest move wishlist to cart display item
    function sessionMoveWishlistToCartDisplay(cartItems) {
        const isLoggedIn = {{ Auth::check() ? 'true' : 'false' }}; // Check if the user is logged in

        // If logged in, do not display session cart items
        if (isLoggedIn) return;

        const cartContainer = document.querySelector('#cart-container');

        // Clear existing cart items before updating the display
        cartContainer.innerHTML = '';

        // Step 1: Loop over each cart item and display it
        cartItems.forEach(item => {
            const existingItem = cartContainer.querySelector(`.cart--item--card[data-id="${item.cartId}"]`);

            // If item already exists, don't render it again
            if (existingItem) return;

            let colorHTML = '';
            if (item.color !== null) { // Check if color object is available
                colorHTML = `
                    <div class="cart--item--color">
                        <span>Color</span>: <span>${item.color.color}</span>
                    </div>`;
            }

            let sizeHTML = '';
            if (item.size !== null) { // Check if size object is available
                sizeHTML = `
                    <div class="cart--item--size">
                        <span>Size</span>: <span>${item.size.size}</span>
                    </div>`;
            }

            // Image HTML for cart item
            let imageHTML = '';
            if (item.images && item.images.length > 0) {
                imageHTML = `
                <div class="cart--item--img">
                    <img src="{{ asset('/${item.images[0]}') }}" alt="${item.product.name}">
                </div>
            `;
            }

            // Create the new cart item HTML structure
            const newItemHTML = `
            <div class="cart--item--card" data-id="${item.cartId}" data-wishlist-id="${item.wishlistId || ''}">
                ${imageHTML}
                <div class="cart--item--info">
                    <h4 class="cart--item--name">${item.product.name}</h4>
                    <p class="cart--item--price">$${Number(item.selling_price).toFixed(2)}</p>
                    ${colorHTML}
                    ${sizeHTML}
                    <a href="#" data-cart-id="${item.cartId}" data-product-id="${item.product.id}" data-color-id="${item.color}" data-size-id="${item.size}" id="move-to-wishlist" class="remove--cart--btn">Move to Wishlist</a>
                    <a href="#" class="remove--cart--btn" onclick="removeGuestCartItem(this, '${item.cartId}')">Remove</a>
                </div>
                <input type="number" data-cart-id="${item.cartId}" data-product-id="${item.product.id}" data-color-id="${item.color ? item.color.id : ''}" data-size-id="${item.size ? item.size.id : ''}" name="quantity" class="cart--item--quantity--input--guest" min="1" value="${item.quantity}" data-available-stock="${item.product.quantity}" />
            </div>
        `;

            // Add the new item HTML to the cart container
            cartContainer.insertAdjacentHTML('beforeend', newItemHTML);
        });

        // Update cart UI with the latest data
        updateCheckoutButtonVisibilityGuest();
        updateGuestTotalPrice();
        updateWishlistButtonVisibilityGuest();
    }

    // User move all products wishlist to cart javascript code
    document.querySelector('.wishlist-button').addEventListener('click', function(e) {
        e.preventDefault();

        // Send AJAX request to move all wishlist items to the cart
        fetch("{{ route('wishlist.move.all.cart') }}", {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            body: JSON.stringify({}) // Send an empty body if no additional data is needed
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Check if there are moved items and iterate over them
                    if (data.movedItems && data.movedItems.length > 0) {

                        // Select the #no-items-message inside #cart-container and hide it
                        const noItemsMessage = document.querySelector('#cart-container .no--items--found');
                        if (noItemsMessage) {
                            noItemsMessage.style.display = 'none'; // Hide the "No items found" message
                        }

                        // Loop through each moved item and generate HTML
                        data.movedItems.forEach(cart => {
                            let colorHTML = '';
                            if (cart.color && cart.color) {
                                colorHTML = `
                            <div class="cart--item--color">
                                <span>Color</span>: <span>${cart.color}</span>
                            </div>`;
                            }

                            let sizeHTML = '';
                            if (cart.size && cart.size) {
                                sizeHTML = `
                            <div class="cart--item--size">
                                <span>Size</span>: <span>${cart.size}</span>
                            </div>`;
                            }

                            // Create the HTML structure for each cart item
                            const newItemHTML = `
                            <div class="cart--item--card" data-id="${cart.cartId}">
                                <div class="cart--item--img">
                                    <img src="${cart.image}" alt="${cart.name}">
                                </div>
                                <div class="cart--item--info">
                                    <h4 class="cart--item--name">${cart.name}</h4>
                                    <p class="cart--item--price">$${Number(cart.price).toFixed(2)}</p>
                                    ${colorHTML}
                                    ${sizeHTML}
                                    <a href="#" data-cart-id="${cart.cartId}" id="wishlist-toggle-cart" class="remove--cart--btn">Move to Wishlist</a>
                                    <a href="#" class="remove--cart--btn" onclick="removeCartItem(this)">Remove</a>
                                </div>
                                <input type="number" data-cart-id="${cart.cartId}" name="quantity" class="cart--item--quantity--input" min="1" value="${cart.quantity}" data-previous-quantity="${cart.quantity}" data-available-stock="${cart.availableStock}" />
                            </div>`;

                            // Insert the new cart item HTML into the container
                            document.querySelector('#cart-container').insertAdjacentHTML('beforeend', newItemHTML);

                        });

                        // Remove the corresponding item from the wishlist
                        data.movedItems.forEach(data => {
                            const wishlistItemElement = document.querySelector(`.wishlist-container .cart--item--card[data-wishlist-id="${data.wishlistId}"]`);
                            if (wishlistItemElement) {
                                wishlistItemElement.remove(); // Remove the item from the DOM
                            }
                        });

                        // After removing all items, check if there are any remaining items in the wishlist
                        const remainingWishlistItems = document.querySelectorAll('.wishlist-container .cart--item--card');
                        const noWishlistItemsMessage = document.querySelector('.wishlist-container #wishlist-no-product');

                        // Debugging: Log remaining items
                        console.log('Remaining Wishlist Items: ', remainingWishlistItems.length);

                        // If no items are left, show the "No items found" message
                        if (remainingWishlistItems.length === 0) {
                            console.log('No items left in wishlist. Showing message.');
                            if (noWishlistItemsMessage) {
                                noWishlistItemsMessage.style.display = ''; // Show the "No items found" message
                            }
                        } else {
                            console.log('There are still items in the wishlist.');
                            if (noWishlistItemsMessage) {
                                noWishlistItemsMessage.style.display = 'none'; // Hide the "No items found" message if there are items
                            }
                        }

                        $('#wishlist-button-text').text("Add to Wishlist");

                        // After adding all items to the cart, update the total price and visibility of buttons
                        updateTotalPrice();  // Update total price if needed
                        updateCheckoutButtonVisibility();  // Update checkout button visibility
                        updateWishlistButtonVisibility();  // Update wishlist button visibility

                    }

                } else {
                    // Use the updated wishlist data to check if the wishlist is empty
                    updateWishlistState(data.updatedWishlist);

                    // Select the #no-items-message inside #cart-container and hide it
                    const noWishlistItemsMessage = document.querySelector('.wishlist-container .no--items--found');
                    if (noWishlistItemsMessage) {
                        noWishlistItemsMessage.style.display = ''; // Hide the "No items found" message
                    }

                    // Handle failure (e.g., show message about already added items)
                    showErrorToast(data.message);
                }

            })
            .catch(error => {
                console.error('Error:', error);
                showErrorToast('Something went wrong, please try again.');
            });
    });

    {{--// Session guest move all wishlist item to cart by clicking 'Add all to Cart' button--}}
    {{--$(document).on('click', '#add-all-to-cart', function (e) {--}}
    {{--    e.preventDefault();--}}

    {{--    // Gather all the wishlist item IDs (for non-logged-in users, these will be from sessionStorage)--}}
    {{--    let wishlistItemIds = [];--}}
    {{--    let isLoggedIn = {{ Auth::check() ? 'true' : 'false' }}; // Check if user is logged in--}}

    {{--    if (isLoggedIn) {--}}
    {{--    } else {--}}
    {{--        // For guest users, fetch wishlist items from sessionStorage--}}
    {{--        const wishlistItems = JSON.parse(sessionStorage.getItem('wishlistItem') || '[]');--}}
    {{--        wishlistItems.forEach(function (item) {--}}
    {{--            wishlistItemIds.push(item.wishlistId);--}}
    {{--        });--}}
    {{--    }--}}

    {{--    // If there are no items to move, show an error message--}}
    {{--     if (wishlistItemIds.length === 0) {--}}
    {{--        return;--}}
    {{--    }--}}

    {{--    // Send an AJAX request to move all wishlist items to the cart--}}
    {{--    $.ajax({--}}
    {{--        url: '/guest/wishlist/move-all-to-cart', // Add the appropriate route for moving all items to the cart--}}
    {{--        type: 'POST',--}}
    {{--        data: {--}}
    {{--            _token: '{{ csrf_token() }}',  // Include CSRF token for security--}}
    {{--            wishlistItemIds: wishlistItemIds  // Send the list of wishlist item IDs--}}
    {{--        },--}}
    {{--        success: function (response) {--}}
    {{--            if (response.success) {--}}
    {{--                // On success, update the cart display--}}
    {{--                sessionMoveWishlistToCartDisplay(response.cartItems); // Pass the updated cart items--}}
    {{--                sessionStorage.setItem('cartItem', JSON.stringify(response.cartItems)); // Update session storage with new cart items--}}
    {{--                sessionStorage.setItem('wishlistItem', JSON.stringify([])); // Clear wishlist from session storage--}}

    {{--                // Clear the DOM for the wishlist and update the message--}}
    {{--                $('.wishlist-container').html(`--}}
    {{--                <div class="no--items--found" id="no-items-message">--}}
    {{--                    <span>No items found.</span>--}}
    {{--                </div>--}}
    {{--            `);--}}
    {{--            } else {--}}
    {{--                showErrorToast(response.message); // Show error message if the move was not successful--}}
    {{--            }--}}
    {{--        },--}}
    {{--        error: function (xhr) {--}}
    {{--            const errorMessage = xhr.responseJSON?.message || 'An error occurred while moving to cart.';--}}
    {{--            showErrorToast(errorMessage);  // Show an error toast if something goes wrong--}}
    {{--        }--}}
    {{--    });--}}
    {{--});--}}

    // wishlist no product found message show and hide
    function updateWishlistState(updatedWishlist) {
        const noItemsMessage = document.querySelector('.wishlist-container .no--items--found');
        const wishlistBox = document.getElementById('wishlist-box');

        // If wishlist is empty, show "No items found" message and hide "Add All to Cart" button
        if (updatedWishlist.length === 0) {
            noItemsMessage.style.display = 'block'; // Show the "No items found" message
            wishlistBox.style.display = 'none'; // Hide the "Add All to Cart" button
        } else {
            noItemsMessage.style.display = 'none'; // Hide the "No items found" message
            wishlistBox.style.display = 'block'; // Show the "Add All to Cart" button
        }
    }

    // User wishlist remove
    function removeWishlistItem(element) {
        const wishlistItemId = $(element).closest('.cart--item--card').data('wishlist-id');
        const url = "{{ route('wishlist.item.remove', ':id') }}".replace(':id', wishlistItemId);

        $.ajax({
            url: url,
            type: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            },
            success: function(response) {
                const $item = $(element).closest('.cart--item--card');
                $item.remove();

                // Check if there are any items left in the wishlist
                if ($('.wishlist-container').children('.cart--item--card').length === 0) {
                    // Show no items found message
                    $('.wishlist-container').html(`
                    <div class="no--items--found" id="wishlist-no-product">
                        <span>No items found.</span>
                    </div>
                `);
                }

                $('#wishlist-button-text').text("Add to Wishlist");

                updateWishlistButtonVisibility();
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'Could not remove item from wishlist.';
                showErrorToast(errorMessage);
            }
        });
    }

    // Session Guest wishlist Remove
    function removeGuestWishlistItemGuest(element, wishlistId) {
        const url = '{{ route('wishlist.item.remove.guest') }}'; // Route for removing item

        $.ajax({
            url: url,
            type: 'POST', // Use POST for deletion
            data: {
                wishlist_id: wishlistId, // Send the wishlist ID
                _token: '{{ csrf_token() }}', // CSRF token for security
            },
            success: function(response) {
                if (response.success) {
                    // Retrieve the wishlist items from sessionStorage as an array
                    let wishlistItems = JSON.parse(sessionStorage.getItem('wishlistItem') || '[]');

                    // Remove the wishlist item with the specific wishlistId from the array
                    wishlistItems = wishlistItems.filter(item => item.wishlistId !== wishlistId);

                    // Save the updated wishlist back to sessionStorage
                    sessionStorage.setItem('wishlistItem', JSON.stringify(wishlistItems));

                    // Remove the item from the DOM
                    const wishlistItemElement = document.querySelector(`.cart--item--card[data-wishlist-id="${wishlistId}"]`);
                    if (wishlistItemElement) {
                        wishlistItemElement.remove();
                    }

                    // Optional: Update button visibility
                    updateWishlistButtonVisibility();
                }
            },
            error: function(xhr) {
                const errorMessage = xhr.responseJSON?.message || 'An error occurred while removing the item from the wishlist.';
                showErrorToast(errorMessage);
            }
        });
    }

</script>


