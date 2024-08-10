@extends('user.layouts.template')
@section('main-content')
    <!-- ##### Welcome Area Start ##### -->
    <section class="welcome_area bg-img background-overlay"
    style="background-image: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)), url({{ asset('home/img/bg-img/SNEAKER_GUIDE_OPENER.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="hero-content text-center">
                    <h5 style="color: white;">Chào mừng đến với cửa hàng của chúng tôi</h5>
                    <h2 style="color: white; font-weight: bold;">Khám phá sản phẩm mới nhất</h2>
                    <p style="color: white; margin-bottom: 30px;">Khám phá sản phẩm của chúng tôi và tìm phong cách hoàn hảo cho bạn.</p>
                    <a href="#" class="btn essence-btn">Mua Ngay</a>
                </div>
            </div>
        </div>
    </div>
</section>


    {{-- {{-- <!-- ##### Top Catagory Area Start ##### --> --}}
    {{-- <div class="top_catagory_area section-padding-80 clearfix">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img"
                        style="background-image: url({{ asset('home/img/bg-img/bg-2.jpg') }});">
                        <div class="catagory-content">
                            <a href="#">Clothing</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img"
                        style="background-image: url({{ asset('home/img/bg-img/bg-3.jpg') }});">
                        <div class="catagory-content">
                            <a href="#">Shoes</a>
                        </div>
                    </div>
                </div>
                <!-- Single Catagory -->
                <div class="col-12 col-sm-6 col-md-4">
                    <div class="single_catagory_area d-flex align-items-center justify-content-center bg-img"
                        style="background-image: url({{ asset('home/img/bg-img/bg-4.jpg') }});">
                        <div class="catagory-content">
                            <a href="#">Accessories</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- ##### Top Catagory Area End ##### -->

    <!-- ##### CTA Area Start ##### -->
    {{-- <div class="cta-area">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="cta-content bg-img background-overlay"
                        style="background-image: url({{ asset('home/img/bg-img/bg-5.jpg') }});">
                        <div class="h-100 d-flex align-items-center justify-content-end">
                            <div class="cta--text">
                                <h6>-60%</h6>
                                <h2>Global Sale</h2>
                                <a href="#" class="btn essence-btn">Buy Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> --}}
    <!-- ##### CTA Area End ##### -->
    <!-- ##### New Arrivals Area Start ##### -->
    <section class="new_arrivals_area section-padding-80 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="section-heading text-center">
                        <h2>Sản phẩm nổi bật</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="popular-products-slides owl-carousel">
                        @foreach ($popular_product as $product)
                            <!-- Single Product -->
                            <div class="single-product-wrapper">
                                <!-- Product Image -->
                                <a href="{{ route('singleproduct', [$product->id, $product->slug]) }}">
                                    <div class="product-img">

                                        <img src="{{  asset('/dashboard/img/ecommerce-product-images/product/' . $product->product_img) }}" alt="">
                                        <img class="hover-img" src="{{ asset('/dashboard/img/ecommerce-product-images/product/' . $product->product_img) }}" alt="">

                                        <!-- Hover Thumb -->
                                        <!-- Favourite -->

                                    </div>
                                    @php
                                        $product_price = number_format($product->price, 0, '.', ',')
                                    @endphp
                                    <!-- Product Description -->
                                    <div class="product-description">
                                        <span>{{ $product->product_subcategory_name }}</span>
                                        <h6>{{ $product->product_name }}</h6>
                                        <p class="product-price">{{ $product_price }}đ</p>
                                    </div>
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- ##### New Arrivals Area End ##### -->

    <!-- ##### Brands Area Start ##### -->
    {{-- <div class="brands-area d-flex align-items-center justify-content-between">
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="{{ asset('home/img/core-img/brand1.png') }}" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="{{ asset('home/img/core-img/brand2.png') }}" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="{{ asset('home/img/core-img/brand3.png') }}" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="{{ asset('home/img/core-img/brand4.png') }}" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="{{ asset('home/img/core-img/brand5.png') }}" alt="">
        </div>
        <!-- Brand Logo -->
        <div class="single-brands-logo">
            <img src="{{ asset('home/img/core-img/brand6.png') }}" alt="">
        </div>
    </div> --}}
    <!-- ##### Brands Area End ##### -->
@endsection
