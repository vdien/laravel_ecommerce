@extends('user.layouts.template')

@section('main-content')
<div class="breadcumb_area bg-img" style="background-image: url(
    {{ asset('home/img/bg-img/breadcumb.jpg') }}
    );">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Cảm ơn bạn đã đặt hàng!! </h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="alert alert-success mt-3">
            Chúng tôi sẽ liên hệ với bạn để xác nhận thông tin đơn hàng trong thời gian sớm nhất!

        </div>
        <p>
            Bạn có thể xem lại thông tin đơn hàng  <a href="#" class="text-dark"> tại đây</a>
        </p>
    <a class="btn essence-btn mb-5" href="{{route('shop')}}">Tiếp tục mua sắm</a>
    </div>
@endsection