@extends('user.layouts.template')

@section('main-content')
<div class="breadcumb_area bg-img" style="background-image: url({{ asset('home/img/bg-img/breadcumb.jpg') }});">
    <div class="container h-100">
        <div class="row h-100 align-items-center">
            <div class="col-12">
                <div class="page-title text-center">
                    <h2>Kiểm tra đơn hàng</h2>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="row d-flex justify-content-center mt-5">
        <div class="col-lg-8">
            <div class="form-group">
                <label for="phone">Số điện thoại đặt hàng</label>
                <div class="input-group">
                    <input type="text" name="phone" id="phone" class="form-control" required>
                    <div class="input-group-append">
                        <button type="button" id="searchBtn" class="btn btn-primary">Search</button>
                    </div>
                </div>
            </div>

            <div id="results">
                <!-- Results will be appended here using AJAX -->
            </div>
        </div>
    </div>
</div>

<!-- JavaScript to format date and handle AJAX response -->
<script>
    function formatDate(dateString) {
        var date = new Date(dateString);
        return date.toLocaleDateString() + ' ' + date.toLocaleTimeString();
    }

    $(document).ready(function () {
        $('#searchBtn').click(function () {
            var phoneNumber = $('#phone').val();

            $.ajax({
                url: '{{ route('find.order.by.phone') }}',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    phone: phoneNumber
                },
                success: function (response) {
                    var orders = response.orders;
                    var resultsDiv = $('#results');
                    resultsDiv.empty();

                    $.each(orders, function (index, order) {
                        var orderHTML = `
                            <div class="card mb-3">
                                <div class="card-body">
                                    <h6 class="card-title">Mã đơn hàng: ${order.id}</h6>
                                    <p class="card-text float-right">Ngày đặt: ${formatDate(order.created_at)}</p>

                                    <h6 class="card-subtitle mb-2 text-muted">Thông tin sản phẩm:</h6>
                                    <div class="col-12 row">
                                    <div class="col-6">
                                        <ul >
                                            ${generateCartItemsHTML(order.cart_items)}
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        <ul class="order-details-form mb-4 ">
                                            <span>Họ và tên:  ${order.name}</li>
                                            <li>Số điện thoại:  ${order.phone}</li>
                                            <li>Địa chỉ: ${order.address}</li>
                                            <li>Tổng tiền thanh toán:  ${order.subtotal}</li>
                                            <li>Tình trạng đơn hàng:  ${order.status}</li>
                                        </ul>
                                    </div>
                                    <h7 class="mt-5">Mọi vấn đề về đơn hàng vui lòng liên hệ qua số điện thoại: 0353225457</h7>
                                </div>
                                </div>
                            </div>
                        `;
                        resultsDiv.append(orderHTML);
                    });
                }
            });
        });

        function generateCartItemsHTML(cartItems) {
        var cartItemsHTML = '';
        $.each(cartItems, function (index, cartItem) {
            var subtotal = cartItem.price * cartItem.quantity;

            cartItemsHTML += `
                <li>
                    <div class="p-2">
                        <div class="col-12">
                            <img src="http://127.0.0.1:8000/${cartItem.product_img}" alt="" width="70"
                            class="img-fluid rounded shadow-sm">
                        <div class="ml-3 d-inline-block align-middle">
                            <h5 class="mb-0"> <a href="#" class="text-dark d-inline-block">${cartItem.name}</a></h5>
                            <span class="text-muted font-weight-normal font-italic">Size: ${cartItem.size}</span>
                        </div>
                        <span class="text-muted font-weight-normal font-italic ml-1"> x${cartItem.quantity}</span>
                    </div>
                </li>
            `;
        });
            return cartItemsHTML;
        }
    });
</script>
@endsection
