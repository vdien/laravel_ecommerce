@extends('user.layouts.template')

@section('main-content')
    <div class="breadcumb_area bg-img" style="background-image: url(
        {{ asset('home/img/bg-img/breadcumb.jpg') }}
        );">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>{{ $product_info->product_name }}</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <section class="single_product_details_area d-flex align-items-center mt-4">

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
                <p class="product-price"><span class="old-price">${{ $product_info->price }}</span>
                    ${{ $product_info->price }}
                </p>
                <p class="product-desc"> {{ $product_info->product_long_des }}</p>

                <!-- Form -->
                <style>
                    .btn-outline-dark.focus,
                    .btn-outline-dark:focus {
                        box-shadow: 0 0 0 0.5px rgb(0 0 0 / 100%);
                    }
                </style>
                <!-- Cart & Favourite Box -->
                <div class="cart-fav-box d-flex align-items-center">
                    <!-- Cart -->
                    <form class="cart-form clearfix" name="add-to-cart-form" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $product_info->id }}" name="product_id">
                        <div class="select-box d-flex mt-50 mb-30">
                            <select name="size" id="productSize" class="mr-5">
                                <option value="36">Size: 36</option>
                                <option value="37">Size: 37</option>
                                <option value="38">Size: 38</option>
                                <option value="39">Size: 39</option>
                            </select>
                            <select name="quantity" id="productColor">
                                <option value="1">Quantity: 1</option>
                                <option value="2">Quantity: 2</option>
                                <option value="3">Quantity: 3</option>
                                <option value="4">Quantity: 4</option>
                            </select>
                        </div>
                        <input type="submit" name="addtocart" class="btn essence-btn" value="Add to cart" />
                    </form>
                    <!-- Favourite -->
                </div>
            </div>

        </section>
    </div>
   
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
                            <a href="{{ route('singleproduct', [$product->id, $product->slug]) }}">
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

                                </div>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
  
    <!-- ##### Single Product Details Area End ##### -->
@endsection
