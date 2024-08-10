@foreach ($products as $product)
    @php
        $product_price = number_format($product->price, 0, '.', ',');
    @endphp
    <div class="col-12 col-sm-6 col-lg-4">
        <a href="{{ route('singleproduct', [$product->id, $product->slug]) }}">
            <div class="single-product-wrapper">
                <!-- Product Image -->
                <div class="product-img">
                    <img src="{{ asset('/dashboard/img/ecommerce-product-images/product/' . $product->product_img) }}" alt="">
                    <!-- Hover Thumb -->
                    <img class="hover-img" src="{{ asset('/dashboard/img/ecommerce-product-images/product/' . $product->product_img) }}" alt="">
                    <!-- Product Badge -->
                    <!-- Favourite -->
                    <div class="product-favourite">
                        <a href="#" class="favme fa fa-heart"></a>
                    </div>
                </div>
                <!-- Product Description -->
                <div class="product-description">
                    <span>{{ $product->product_subcategory_name }}</span>
                    <a href="{{ route('singleproduct', [$product->id, $product->slug]) }}">
                        <h6>{{ $product->product_name }}</h6>
                    </a>
                    <p class="product-price">{{ $product_price }}</p>
                </div>
            </div>
        </a>
    </div>
@endforeach
<!-- Pagination -->
<nav aria-label="navigation">
    {{ $products->appends(request()->input())->links('vendor.pagination.custom-pagination') }}
</nav>
