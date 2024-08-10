@extends('user.layouts.template')

@section('main-content')
    <div class="breadcumb_area bg-img" style="background-image: url({{ asset('home/img/bg-img/breadcumb.jpg') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Giỏ hàng</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="checkout_area section-padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="checkout_details_area clearfix">
                        <div class="order-details-confirmation mb-30">
                            <div class="cart-page-heading">
                                <h5>Giỏ hàng của bạn</h5>
                                <p>Chi tiết</p>
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
                    <div class="order-details-confirmation mb-30">
                        <div class="cart-page-heading mb-30">
                            <h5>Tổng</h5>
                        </div>
                        <ul class="order-details-form mb-4">
                            <li><span>Tổng tiền:</span> <span name="subtotal">$0</span></li>
                            <li><span>Phí vận chuyển:</span> <span name="shipping">Free</span></li>
                            <li><span>Giảm giá:</span> <span name="discount">-0%</span></li>
                            <li><span>Tổng cộng:</span> <span name="totalCart">0</span></li>
                        </ul>
                    </div>

                    @auth
                        <a class="btn essence-btn"  id="checkout-button">Thanh toán</a>
                    @else
                        <button class="btn essence-btn" data-toggle="modal" data-target="#loginModal">Thanh toán</button>
                    @endauth

                </div>
            </div>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1" role="dialog" aria-labelledby="loginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="loginModalLabel">Bạn cần đăng nhập trước khi đặt hàng</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Vui lòng đăng nhập trước khi đặt hàng để dễ dàng cập nhật trạng thái đơn hàng và hưởng các ưu đãi từ
                    chúng tôi </div>
                <div class="modal-footer">
                    <a href="{{ route('login') }}" class="btn btn-primary">Đăng nhập</a>
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                </div>
            </div>
        </div>
    </div>
@endsection
