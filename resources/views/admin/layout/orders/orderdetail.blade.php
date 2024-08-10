<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="py-3 mb-2"><span class="text-muted fw-light">eCommerce /</span> Order Details</h4>

    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center mb-3">
        <div class="d-flex flex-column justify-content-center gap-2 gap-sm-0">
            <h5 class="mb-1 mt-3 d-flex flex-wrap gap-2 align-items-end">
                Order <span id="order_detail_id"></span> <span id="detail_payment_status"> </span>
                <span id="detail_status"></span>
            </h5>
            <p class="text-body" id="detail_order_time"></p>
        </div>
    </div>

    <!-- Order Details Table -->

    <div class="row">
        <div class="col-12 col-lg-8">
            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title m-0">Order details</h5>
                </div>
                <input type="hidden" id="orderId">
                <div class="card-datatable table-responsive">
                    <table class="datatables-order-details table border-top" id="products_order">
                        <thead>
                            <tr>
                                <th class="w-50">products</th>
                                <th class="w-25">price</th>
                                <th class="w-25">qty</th>
                                <th>total</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>

                    <div class="d-flex justify-content-end align-items-center m-3 mb-2 p-1">
                        <div class="order-calculations">
                            <div class="d-flex justify-content-between mb-2">
                                <span class="w-px-100 text-heading">Subtotal:</span>
                                <h6 class="mb-0" id="orderSubtotal"></h6>
                            </div>
                            <div class="d-flex justify-content-between mb-2">
                                <span class="w-px-100 text-heading">Discount:</span>
                                <h6 class="mb-0">$0</h6>
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="w-px-100 mb-0">Total:</h6>
                                <h6 class="mb-0" id="totalOrder"></h6>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">



                <div class="card-body">
                    <ul class="timeline pb-0 mb-0" id="shippingTimeline">
                        <!-- Timeline items will be injected here by jQuery -->
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-12 col-lg-4">
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title m-0">Customer details</h6>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-start align-items-center mb-4">
                        <div class="avatar me-2">
                            <img src="{{ asset('dashboard/assets/img/avatars/1.png') }}" alt="Avatar"
                                class="rounded-circle" />
                        </div>
                        <div class="d-flex flex-column">
                            <a href="app-user-view-account.html" class="text-body text-nowrap">
                                <h6 class="mb-0" id="userName">Shamus Tuttle</h6>
                            </a>
                            <small class="text-muted">Customer ID: #<span id="userId"></span></small>
                        </div>
                    </div>
                    <div class="d-flex justify-content-start align-items-center mb-4">
                        <span
                            class="avatar rounded-circle bg-label-success me-2 d-flex align-items-center justify-content-center"><i
                                class="ti ti-shopping-cart ti-sm"></i></span>
                        <h6 class="text-body text-nowrap mb-0" id="totalUserOrder"></h6>
                    </div>
                    <div class="d-flex justify-content-between">
                        <h6>Contact info</h6>

                    </div>
                    <p class="mb-1">Email: <span id="userEmail"></span></p>
                    <p class="mb-0">Mobile: <span id="userPhone"></span></p>
                </div>
            </div>


            <div class="card mb-4">
                <div class="card-header d-flex justify-content-between">
                    <h6 class="card-title m-0">Địa chỉ thanh toán</h6>

                </div>
                <div class="card-body">
                    <p class="mb-4" id="orderAddress"></p>
                    <h6 class="mb-0 pb-2">Phương thức thanh toán: <span id="paymentMethod"></span></h6>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title m-0 mb-2">Cập nhật trạng thái</h6>
                    <div class="form-group">
                        <select class="form-control" id="statusSelect">

                            <!-- Options will be injected here by jQuery -->
                        </select>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="card-title m-0 mb-2">Đơn vị vận chuyển</h6>
                    <div class="form-group">
                        <select class="form-control mb-2" id="shippingBrand">
                            <option>Chọn đơn vị vận chuyển</option>
                            <option value="GHN">Giao hàng nhanh</option>
                            <option value="SPX">Shopee Express</option>
                            <option value="Grab">Grab</option>
                            <option value="Ahamove">Ahamove</option>
                        </select>
                        <input type="hidden" name="shipping_brand_hidden" id="shippingBrandHidden">

                    </div>
                    <input type="text" class="form-control" placeholder="Mã đơn hàng" id="trackingNumber">
                    <input type="hidden" name="tracking_number_hidden" id="trackingNumberHidden">

                </div>
            </div>

        </div>
    </div>

</div>
<!-- / Content -->
