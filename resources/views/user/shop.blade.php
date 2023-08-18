@extends('user.layouts.templateshop')
<!-- ##### Breadcumb Area Start ##### -->
@section('breadcumb')
    <h2>Shop</h2>
@endsection
<!-- ##### Breadcumb Area End ##### -->
@section('shop-content')
    <!-- ##### Shop Grid Area Start ##### -->
    @foreach ($products as $product)
        <div class="col-12 col-sm-6 col-lg-4">
            <a href="{{ route('singleproduct', [$product->id, $product->slug]) }}">
            <div class="single-product-wrapper">
                <!-- Product Image -->
                <div class="product-img">
                    <img src="{{ asset($product->product_img) }}" alt="">
                    <!-- Hover Thumb -->
                    <img class="hover-img" src="{{ asset($product->product_img) }}" alt="">

                    <!-- Product Badge -->
                    <div class="product-badge offer-badge">
                        <span>-30%</span>
                    </div>
                    <!-- Favourite -->
                    <div class="product-favourite">
                        <a href="#" class="favme fa fa-heart"></a>
                    </div>
                </div>

                <!-- Product Description -->
                <div class="product-description">
                    <span>{{$product->product_subcategory_name}}</span>
                    <a href="single-product-details.html">
                        <h6>{{$product->product_name}}</h6>
                    </a>
                    <p class="product-price"><span class="old-price">$75.00</span> {{$product->price}}.00</p>

                </div>
            </div>
        </a>
        </div>
    @endforeach
    </div>
    </div>
    <!-- Pagination -->
    <nav aria-label="navigation">
        <ul class="pagination mt-50 mb-70">
            <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-left"></i></a></li>
            <li class="page-item"><a class="page-link" href="#">1</a></li>
            <li class="page-item"><a class="page-link" href="#">2</a></li>
            <li class="page-item"><a class="page-link" href="#">3</a></li>
            <li class="page-item"><a class="page-link" href="#">...</a></li>
            <li class="page-item"><a class="page-link" href="#">21</a></li>
            <li class="page-item"><a class="page-link" href="#"><i class="fa fa-angle-right"></i></a></li>
        </ul>
    </nav>
    </div>
    </div>
    </div>
    </section>
    <!-- ##### Shop Grid Area End ##### -->
@endsection
