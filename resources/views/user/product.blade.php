@extends('user.layouts.template')
@section('main-content')
    <div class="breadcumb_area bg-img"
        style="background-image: url(
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
                <div class="product_thumbnail_slides owl-carousel">

                    <img src="{{ asset($product_info->product_img) }}" alt="">

                    @foreach (json_decode($product_info->product_img_child) as $oldImage)
                        <img src="{{ asset($oldImage) }}" alt="">
                    @endforeach
                </div>
            </div>

            <!-- Single Product Description -->
            <div class="single_product_desc clearfix">
                <span>{{ $product_info->product_subcategory_name }}</span>
                <a href="cart.html">
                    <h2>{{ $product_info->product_name }}</h2>
                </a>
                @php
                    $product_price = number_format($product_info->price, 0, '.', ',');

                @endphp
                <p class="product-price">
                    {{ $product_price }} đ
                </p>
                @php
                    $des = htmlspecialchars_decode($product_info->product_long_des);
                    echo $des;
                @endphp


                <!-- Form -->
                <style>
                    .button {
                        float: left;
                        margin: 0 5px 0 0;
                        width: 100px;
                        height: 50px;
                        position: relative;

                    }

                    .button label,
                    .button input {
                        cursor: pointer;

                        display: block;
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                        border: gray solid 1px;
                    }

                    .button input[type="radio"] {
                        opacity: 0.011;
                        z-index: 100;
                    }

                    .button input[type="radio"]:checked+label {
                        box-shadow: 0 0 0 0.5px rgb(0 0 0 / 100%);
                        border-radius: 0px;
                    }

                    .button label {
                        cursor: pointer;
                        z-index: 90;
                        line-height: 1.8em;
                    }
                </style>
                <!-- Cart & Favourite Box -->
                <div class="cart-fav-box d-flex align-items-center">
                    <!-- Cart -->
                    <form class="cart-form clearfix" name="add-to-cart-form" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $product_info->id }}" name="product_id">

                            @foreach ($sizes as $size)
                            @if ($size->quantity > 0)

                            <div class="button">
                                <input type="radio" id="size{{ $size->size }}" name="size" value="{{ $size->size }}" />
                                <label class="btn btn-default" for="sizz{{ $size->size }}">{{ 'Size: ' . $size->size }}</label>
                            </div>
                            @endif

                            @endforeach
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

                                <img src="{{ asset($product_info->product_img) }}" alt="">
                                <img class="hover-img" src="{{ asset($product_info->product_img) }}" alt="">
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
