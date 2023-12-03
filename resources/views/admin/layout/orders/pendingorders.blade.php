@extends('admin.layout.template')
@section('page_title')
    PendingOrders-Lnvdien
@endsection
@section('content')
<hr class="my-5">
    <div class="container">

        <div class="card">
            <h5 class="card-header">Đơn hàng đang xử lý</h5>
            <div class="table-responsive text-break">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Mã Đơn Hàng</th>
                            <th>Tên người đặt</th>
                            <th>Số Điện Thoại</th>
                            <th class="col-3">Địa chỉ</th>
                            <th>Trạng thái</th>
                            <th>Tổng tiền</th>
                            <th>Chỉnh sửa</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($orders as $order)
                        <tr>
                            <td><i class="fab fa-angular fa-lg text-danger me-3"></i> <strong>{{$order->id}}</strong></td>
                            <td>{{$order->name}}</td>
                            <td>{{$order->phone}}</td>
                            <td class="col-3"><span class="text-break">{{$order->address}}</span></span></td>
                            @if ($order->status === 'Chờ xác nhận')
                            <td><span class="badge bg-label-primary me-1">{{$order->status}}</span></td>
                            @endif
                            @if ($order->status === 'Đã đóng gói' || $order->status === 'Đang vận chuyển')
                            <td><span class="badge bg-label-warning me-1">{{$order->status}}</span></td>
                            @endif
                            @if ($order->status === 'Thành công')
                            <td><span class="badge bg-label-success me-1">{{$order->status}}</span></td>
                            @endif
                            @if ($order->status === 'Hủy')
                            <td><span class="badge bg-label-danger me-1">{{$order->status}}</span></td>
                            @endif
                            <td><span class="badge bg-label-primary me-1">{{$order->subtotal}}</span></td>
                            <td>
                                <div class="dropdown">
                                    <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                        data-bs-toggle="dropdown">
                                        <i class="bx bx-dots-vertical-rounded"></i>
                                    </button>
                                    <div class="dropdown-menu">
                                        <a class="dropdown-item" href="{{route("orderdetail",$order->id)}}"><i
                                                class="bx bx-edit-alt me-1"></i> Chỉnh sửa</a>
                                    </div>
                                </div>
                            </td>
                        </tr>

                           @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endsection
