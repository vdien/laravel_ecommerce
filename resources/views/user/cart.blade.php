@extends('user.layouts.template')


@section('main-content')
    <div class="breadcumb_area bg-img" style="background-image: url(
    {{ asset('home/img/bg-img/breadcumb.jpg') }}
    );">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="checkout_area section-padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="checkout_details_area  clearfix">
                        <div class="order-details-confirmation  mb-30">
                            <div class="cart-page-heading">
                                <h5>Your Cart</h5>
                                <p>The Details</p>
                            </div>

                            <div class="table-responsive">
                                <table class="table">
                                    <tbody class="cart-list-checkout">
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">

                    <div class="order-details-confirmation  mb-30">
                        <div class="cart-page-heading mb-30">
                            <h5>SUBTOTAL</h5>
                        </div>
                        <!-- Shopping cart table -->
                        <ul class="order-details-form mb-4">
                            <li><span>subtotal:</span> <span name="subtotal">$0</span></li>
                            <li><span>delivery:</span> <span name=shipping>Free</span></li>
                            <li><span>discount:</span> <span name="discount">-0%</span></li>
                            <li><span>total:</span> <span name="totalCart">0</span></li>
                        </ul>


                    </div>
                    <a href="#" class="btn essence-btn">Check out</a>
                
                </div>
            </div>
        </div>
    </div>
@endsection
