@extends('user.layouts.template')
@section('main-content')
    <section style="background-color: #eee;">
        <div class="container py-5">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card mb-4">
                        <div class="card-body">
                            @include('profile.partials.update-profile-information-form')
                        </div>
                    </div>

                    <div class="card mb-4 ">
                        <div class="card-body ">
                            @include('profile.partials.update-password-form')
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <h3 class="mb-4">Lịch sử mua hàng</h3>
                            <!-- Bộ lọc trạng thái -->
                            <div class="mb-4">
                                <div class="d-flex flex-wrap">
                                    <button type="button" class="btn btn-outline-primary btn-sm mr-2 mb-2"
                                        data-status="all">Tất cả</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm mr-2 mb-2"
                                        data-status="1">Chờ xử lý</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm mr-2 mb-2"
                                        data-status="2">Đã xác nhận</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm mr-2 mb-2"
                                        data-status="3">Đang vận chuyển</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm mr-2 mb-2"
                                        data-status="6">Đã hủy</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm mr-2 mb-2"
                                        data-status="4">Thành công</button>
                                    <button type="button" class="btn btn-outline-secondary btn-sm mb-2" data-status="5">Trả
                                        hàng</button>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- Danh sách đơn hàng -->


                    <div id="orderList">
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger btn-sm float-right mt-2">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                    <!-- Các đơn hàng sẽ được chèn vào đây bằng AJAX -->


                    <!-- Thêm các đơn hàng khác ở đây -->
                </div>

            </div>

        </div>
        </div>
    </section>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}

        </h2>
    </x-slot>
@endsection
@section('scripts')
    <script>
        $(document).ready(function() {
            const statusObj = {
                1: {
                    title: 'Chờ xử lý',
                    class: 'badge-warning'
                },
                2: {
                    title: 'Đã xác nhận',
                    class: 'badge-primary'
                },
                3: {
                    title: 'Đang giao hàng',
                    class: 'badge-info'
                },
                4: {
                    title: 'Thành công',
                    class: 'badge-success'
                },
                5: {
                    title: 'Trả hàng',
                    class: 'badge-danger'
                },
                6: {
                    title: 'Đã hủy',
                    class: 'badge-secondary'
                }
            };

            function loadOrders(status) {
                $.ajax({
                    url: '/orders-by-status',
                    type: 'GET',
                    data: {
                        status: status
                    },
                    success: function(response) {
                        $('#orderList').html(response.html);
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching orders:', error);
                    }
                });
            }

            // Gọi loadOrders với 'all' để lấy tất cả đơn hàng khi trang được tải
            loadOrders('all');

            // Xử lý sự kiện nhấp chuột trên các nút lọc


            // Xử lý sự kiện nhấp chuột trên các nút lọc
            $('.btn[data-status]').click(function() {

                var selectedStatus = $(this).data('status');
                loadOrders(selectedStatus);
                // Cập nhật kiểu nút (đổi màu hoặc kiểu để hiện trạng thái hiện tại)
                $('.btn[data-status]').removeClass('btn-outline-primary').addClass('btn-outline-secondary');
                $(this).removeClass('btn-outline-secondary').addClass('btn-outline-primary');

                loadOrders(selectedStatus);
            });
        });
    </script>
@endsection
