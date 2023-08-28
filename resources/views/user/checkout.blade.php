@extends('user.layouts.template')


@section('main-content')
    <div class="breadcumb_area bg-img" style="background-image: url(
    {{ asset('home/img/bg-img/breadcumb.jpg') }}
    );">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>THANH TOÁN</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="checkout_area section-padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="checkout_details_area mt-50 clearfix">

                        <div class="cart-page-heading mb-30">
                            <h5>THÔNG TIN NHẬN HÀNG</h5>
                        </div>

                        <form action="#" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-12 mb-3">
                                    <label for="name_order">Họ và tên <span>*</span></label>
                                    <input type="text" class="form-control" id="name_order" value="" required>
                                </div>

                                <div class="col-12 mb-3">
                                    <label for="phone_order">Số điện thoại<span>*</span></label>
                                    <input type="text" class="form-control" id="phone_order" value="" required>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="city">Tỉnh thành:</label>
                                    <select class="form-control form-control-sm mb-3 w-100" id="cityCheckout">
                                        <option value="" selected>Chọn tỉnh thành</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="district">Quận huyện:</label>
                                    <select class="form-control form-control-sm mb-3 w-100" id="districtCheckout">
                                        <option value="" selected>Chọn quận huyện</option>
                                    </select>
                                </div>

                                <div class="col-md-6 mb-3">
                                    <label for="ward">Phường xã:</label>
                                    <select class="form-control form-control-sm w-100" id="wardCheckout">
                                        <option value="" selected>Chọn phường xã</option>
                                    </select>
                                </div>
                                <div class="col-12 mb-3">
                                    <label for="adress_order">Địa chỉ:</label>
                                    <input type="text" class="form-control" id="adressCheckout" value="">
                                </div>

                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-12 col-md-6 col-lg-5 ml-lg-auto">

                    <div class="order-details-confirmation  mb-30">
                        <div class="cart-page-heading mb-30">
                            <h5>TỔNG TIỀN</h5>
                        </div>
                        <!-- Shopping cart table -->
                        <ul class="order-details-form mb-4">
                            <li><span>subtotal:</span> <span name="subtotal">$0</span></li>
                            <li><span>delivery:</span> <span name=shipping>Free</span></li>
                            <li><span>discount:</span> <span name="discount">-0%</span></li>
                            <li><span>total:</span> <span name="totalCart">0</span></li>
                        </ul>


                    </div>
                    <div class="cart-page-heading mb-30">
                        <h5>PHƯƠNG THỨC THANH TOÁN</h5>
                    </div>
                    <div class="form-check mb-4">
                        <input class="form-check-input" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                        <label class="form-check-label" for="exampleRadios1">
                          Thanh toán khi nhận hàng
                        </label>
                      </div>

                    <a href="#" class="btn essence-btn" id="checkout-btn">Đặt Hàng</a>

                </div>
            </div>
        </div>
    </div>
@endsection
