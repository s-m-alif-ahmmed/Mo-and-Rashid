@forelse ($products as $product)
    <div class="product-page-product-card">
        <!-- product images wrapper -->
        <div class="product-images--wrapper">
            @php
                if ($brand_slug != null) {
                    $route = route('product.detail', ['brand' => $brand_slug, 'product_slug' => $product['product_slug']]);
                } elseif ($category_slug != null) {
                    $route = route('product.detail', ['category' => $category_slug, 'product_slug' => $product->product_slug]);
                }else {
                    $route = route('product.detail', ['product_slug' => $product->product_slug]);
                }
            @endphp
            <a href="{{ $route }}" class="product-details--wrapper">
                <!-- image on hover -->
                @foreach ($product->images->take(2) as $image)
                    <img src="{{ asset($image->image) }}" alt="" srcset="">
                @endforeach
            </a>

            <!-- on sale or sold out -->
            @if ($product->quantity <= 0)
                <span class="product-status sold-out">Sold Out</span>
            @else
                <span class="product-status on-sale">On Sale</span>
            @endif

        </div>
        <!-- product details -->
        <div class="product-details--wrapper">
            <p class="product-name">{{ $product->name }}</p>
            <p class="product-price">$ {{ number_format($product->selling_price, 2) }}</p>
        </div>

    </div>
@empty
    <div class="no--products--screen" >
        No items found.
    </div>
@endforelse
