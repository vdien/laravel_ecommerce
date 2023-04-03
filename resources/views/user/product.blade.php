@extends('user.layouts.template')

@section('main-content')
    <div class="container">
        <section class="single_product_details_area d-flex align-items-center" style="min-height:90vh">
            <!-- Single Product Thumb -->
            <div class="single_product_thumb clearfix">
                {{-- <div class="product_thumbnail_slides owl-carousel"> --}}
                <img src="{{ asset($product_info->product_img) }}" alt="">
                {{-- </div> --}}
            </div>

            <!-- Single Product Description -->
            <div class="single_product_desc clearfix">
                <span>{{ $product_info->product_subcategory_name }}</span>
                <a href="cart.html">
                    <h2>{{ $product_info->product_name }}</h2>
                </a>
                <p class="product-price"><span class="old-price">{{ $product_info->price }}</span> {{ $product_info->price }}
                </p>
                <p class="product-desc"> {{ $product_info->product_long_des }}</p>
                <p>Số lượng còn lại: {{ $product_info->quantity }}</p>
                <!-- Form -->

                <!-- Cart & Favourite Box -->
                <div class="cart-fav-box d-flex align-items-center">
                    <!-- Cart -->
                    <form class="cart-form clearfix" action="{{ route('addproducttocart', $product_info->id) }}"
                        method="POST">
                        <input type="hidden" value="{{ $product->id }}" name="product_id">
                        @csrf
                        <div class="form-group ">
                            <label for="Quantity">Quantity</label>
                            <input class="form-control mb-2" type="number" name="quantity"min="1">
                        </div>
                        <input type="submit" name="addtocart" class="btn essence-btn" value="Add to cart" />
                    </form>
                    <!-- Favourite -->
                </div>

            </div>

        </section>
    </div>
    <div class="row">
        <div class="col-12">
            <div class="container">
                <div class="col-12">
                    <div class="section-heading text-center">
                        <h2>Popular Products</h2>
                    </div>
                </div>
                <div class="popular-products-slides owl-carousel">
                    @foreach ($popular_product as $product)
                        <!-- Single Product -->
                        <div class="single-product-wrapper">
                            <!-- Product Image -->
                            <div class="product-img">
                                <img src="{{ asset($product->product_img) }}" alt="">
                                <!-- Hover Thumb -->
                                <img class="hover-img" src="{{ asset($product->product_img) }}" alt="">
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
                                <p class="product-price">{{ $product->price }}</p>

                                <!-- Hover Content -->
                                <div class="hover-content">
                                    <!-- Add to Cart -->
                                    <div class="add-to-cart-btn">
                                        <a href="#" class="btn essence-btn">Add to Cart</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Single Product Details Area End ##### -->
@endsection
