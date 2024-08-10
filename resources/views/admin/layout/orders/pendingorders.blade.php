@extends('admin.layout.template')
@section('page_title')
    PendingOrders-Lnvdien
@endsection
@section('page_head')
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/node-waves/node-waves.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/typeahead-js/typeahead.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }} " />
@endsection
@section('page_script')
    <script src="{{ asset('dashboard/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }} "></script>
    <script src="{{ asset('dashboard/vendor/libs/select2/select2.js') }} "></script>
    <!-- Main JS -->
    <script src="{{ asset('dashboard/js/main.js') }} "></script>
    {{-- Page JS --}}
    <script src="{{ asset('dashboard/vendor/libs/toastr/toastr.js') }} "></script>
    <script src="{{ asset('dashboard/js/app-ecommerce-order-list.js') }}"></script>
@endsection
@section('content')
    <div class="layout-wrapper layout-content-navbar">
        <div class="layout-container">
            <!-- Menu -->
            <!-- / Navbar -->

            <!-- Content wrapper -->
            <div class="content-wrapper">
                <!-- Content -->

                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="py-3 mb-2"><span class="text-muted fw-light">eCommerce /</span> Order List</h4>

                    <!-- Order List Widget -->

                    <div class="card mb-4">
                        <div class="card-widget-separator-wrapper">
                            <div class="card-body card-widget-separator">
                                <div class="row gy-4 gy-sm-1">
                                    <div class="col-sm-6 col-lg-3">
                                        <div
                                            class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                            <div>
                                                <h4 class="mb-2">56</h4>
                                                <p class="mb-0 fw-medium">Pending Payment</p>
                                            </div>
                                            <span class="avatar me-sm-4">
                                                <span class="avatar-initial bg-label-secondary rounded">
                                                    <i class="ti-md ti ti-calendar-stats text-body"></i>
                                                </span>
                                            </span>
                                        </div>
                                        <hr class="d-none d-sm-block d-lg-none me-4" />
                                    </div>
                                    <div class="col-sm-6 col-lg-3">
                                        <div
                                            class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                            <div>
                                                <h4 class="mb-2">12,689</h4>
                                                <p class="mb-0 fw-medium">Completed</p>
                                            </div>
                                            <span class="avatar p-2 me-lg-4">
                                                <span class="avatar-initial bg-label-secondary rounded"><i
                                                        class="ti-md ti ti-checks text-body"></i></span>
                                            </span>
                                        </div>
                                        <hr class="d-none d-sm-block d-lg-none" />
                                    </div>
                                    <div class="col-sm-6 col-lg-3">
                                        <div
                                            class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                            <div>
                                                <h4 class="mb-2">124</h4>
                                                <p class="mb-0 fw-medium">Refunded</p>
                                            </div>
                                            <span class="avatar p-2 me-sm-4">
                                                <span class="avatar-initial bg-label-secondary rounded"><i
                                                        class="ti-md ti ti-wallet text-body"></i></span>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col-sm-6 col-lg-3">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h4 class="mb-2">32</h4>
                                                <p class="mb-0 fw-medium">Failed</p>
                                            </div>
                                            <span class="avatar p-2">
                                                <span class="avatar-initial bg-label-secondary rounded"><i
                                                        class="ti-md ti ti-alert-octagon text-body"></i></span>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Order List Table -->
                    <div class="card">
                        <div class="card-datatable table-responsive">
                            <table class="datatables-order table border-top">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th>order</th>
                                        <th>date</th>
                                        <th>customers</th>
                                        <th>payment</th>
                                        <th>status</th>
                                        <th>method</th>
                                        <th>actions</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                <!-- / Content -->
                <div class="modal-onboarding modal fade animate__animated" id="editOrderModal" tabindex="-1"
                    aria-hidden="true">
                    <div class="modal-dialog modal-xl" role="document">
                        <div class="modal-content">
                            <form id="formEditOrder">
                                @csrf
                            <div class="modal-header border-0">
                                <a class="text-muted close-label" href="javascript:void(0);" data-bs-dismiss="modal">Skip
                                    Intro</a>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                                <div class="modal-body onboarding-horizontal p-0">
                                    @include('admin.layout.orders.orderdetail')
                                </div>
                                <div class="modal-footer border-0">
                                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                                        Close
                                    </button>
                                    <button type="button" class="btn btn-primary" id="updateStatusBtn">Submit</button>
                                </div>
                            </form>
                        </div>
                    </div>

                </div>
                <!-- Confirm Modal -->
                <div class="modal fade" id="confirmEditProduct" tabindex="-1" aria-labelledby="confirmModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>
                            </div>
                            <div class="modal-body">
                                Are you sure you want to save changes?
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                                <button type="submit" class="btn btn-primary" id="confirmOrderProductBtn">Yes</button>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- Footer -->

                <!-- / Footer -->

                <div class="content-backdrop fade"></div>
            </div>

            <!-- Overlay -->
            <div class="layout-overlay layout-menu-toggle"></div>

            <!-- Drag Target Area To SlideIn Menu On Small Screens -->
            <div class="drag-target"></div>
        </div>
    @endsection
