@extends('admin.layout.template')
@section('page_title')
    Order-detail
@endsection
@section('content')
    <div class="container">
        <div class="card">

            <div class="card-body">
                <h6 class="card-title">Mã đơn hàng: 17</h6>
                <p class="card-text float-right">Ngày đặt: 8/9/2023 23:15:49</p>

                <h6 class="card-subtitle mb-2 text-muted">Thông tin sản phẩm:</h6>
                <div class="col-12 row">
                    <div class="col-6">
                        <ul>
                            @foreach ($order->cart_items as $cart_item)
                                <div class="p-2">
                                    <div class="col-12">
                                        <img src="{{ asset($cart_item['product_img']) }}" alt="" width="70"
                                            class="img-fluid rounded shadow-sm">

                                        <div class="ml-3 d-inline-block align-middle col-6 ">
                                            <h6 class="mb-0"> <a href="#"
                                                    class="text-dark d-inline-block">{{ $cart_item['name'] }}</a></h6>
                                            <span class="text-muted font-weight-normal font-italic">Size:
                                                {{ $cart_item['size'] }}</span>
                                        </div>
                                        <span
                                            class="text-muted font-weight-normal font-italic ml-1">x{{ $cart_item['quantity'] }}</span>
                                    </div>
                                </div>
                            @endforeach
                        </ul>
                    </div>
                    <div class="col-6">
                        <ul class="order-details-form mb-4">
                            <input type="hidden" id="order_id" value="{{ $order->id }}">
                            <li>Họ và tên: {{ $order->name }} </li>
                            <li>Số điện thoại:{{ $order->phone }} c</li>
                            <li>Địa chỉ: {{ $order->address }}</li>
                            <li>Tổng tiền thanh toán: {{ $order->subtotal }}</li>
                            <div class="pt-4 pb-4">
                                Tình trạng đơn hàng:
                                <select class="form-select" id="orderStatus" name="orderStatus">
                                    @if ($order->status === 'Chờ xác nhận')
                                        <option value ="Chờ xác nhận" selected>Chờ xác nhận</option>
                                        <option value="Đã đóng gói">Đã Đóng gói</option>
                                        <option value="Đang vận chuyển">Đang vận chuyển</option>
                                        <option value="Thành công">Thành công</option>
                                        <option value="Trả hàng">Trả hàng</option>
                                        <option value="Hủy">Hủy</option>

                                    @endif
                                    @if ($order->status === 'Đã đóng gói')
                                        <option value="Đã đóng gói" selected>Đã Đóng gói</option>
                                        <option value="Đang vận chuyển">Đang vận chuyển</option>
                                        <option value="Thành công">Thành công</option>
                                        <option value="Trả hàng">Trả hàng</option>
                                    @endif
                                    @if ($order->status === 'Đang vận chuyển')
                                        <option value="Đang vận chuyển" selected>Đang vận chuyển</option>
                                        <option value="Thành công">Thành công</option>
                                        <option value="Trả hàng">Trả hàng</option>
                                    @endif
                                    @if ($order->status === 'Thành công')
                                        <option selected>Thành công</option>

                                    @endif

                                    @if ($order->status === 'Hủy')
                                        <option selected>Hủy</option>

                                    @endif
                                </select>
                            </div>

                            <button type="button" class="btn btn-primary " data-bs-toggle="modal"
                                data-bs-target="#modalToggle">
                                Cập nhật trạng thái
                            </button>
                            <!-- Modal 1-->
                            <div class="modal fade" id="modalToggle" aria-labelledby="modalToggleLabel" tabindex="-1"
                                style="display: none" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalToggleLabel">Xác nhận</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">Xác nhận thay đổi trạng thái đơn hàng
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn btn-primary" id="updateStatusButton">
                                                Đồng ý
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal 2-->

                    </div>
                </div>
                </ul>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script>
        var orderStatus = "{{ $order->status }}"
    </script>
@endsection
