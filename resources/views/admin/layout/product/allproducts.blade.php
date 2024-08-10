@extends('admin.layout.template')

@section('page_head')
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/node-waves/node-waves.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/typeahead-js/typeahead.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/select2/select2.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/quill/typography.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/quill/katex.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/quill/editor.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/flatpickr/flatpickr.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/tagify/tagify.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/toastr/toastr.css') }}" />
@endsection
@section('page_script')
    <script src="{{ asset('dashboard/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }} "></script>
    <script src="{{ asset('dashboard/vendor/libs/select2/select2.js') }} "></script>
    <!-- Main JS -->
    <script src="{{ asset('dashboard/js/main.js') }} "></script>
    {{-- Page JS --}}
    <script src="{{ asset('dashboard/vendor/libs/quill/katex.js') }} "></script>
    <script src="{{ asset('dashboard/vendor/libs/toastr/toastr.js') }} "></script>
    <script src="{{ asset('dashboard/vendor/libs/quill/quill.js') }} "></script>
    <script src="{{ asset('dashboard/vendor/libs/tagify/tagify.js') }}"></script>
    <script src="{{ asset('dashboard/js/app-ecommerce-product-list.js') }}"></script>
    <script src="{{ asset('dashboard/js/app-ecommerce-product-edit.js') }}"></script>
    <script src="{{ asset('dashboard/js/app-ecommerce-product-add.js') }}"></script>
@endsection

@section('page_title')
    AllProduct-Lnvdien
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-4"><span class="text-muted fw-light">eCommerce /</span> Product List</h4>
        <!-- Product List Widget -->
        <div class="card mb-4">
            <div class="card-widget-separator-wrapper">
                <div class="card-body card-widget-separator">
                    <div class="row gy-4 gy-sm-1">
                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-1 border-end pb-3 pb-sm-0">
                                <div>
                                    <h6 class="mb-2">In-store Sales</h6>
                                    <h4 class="mb-2">$5,345.43</h4>
                                    <p class="mb-0">
                                        <span class="text-muted me-2">5k orders</span><span
                                            class="badge bg-label-success">+5.7%</span>
                                    </p>
                                </div>
                                <span class="avatar me-sm-4">
                                    <span class="avatar-initial bg-label-secondary rounded"><i
                                            class="ti-md ti ti-smart-home text-body"></i></span>
                                </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none me-4" />
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="d-flex justify-content-between align-items-start card-widget-2 border-end pb-3 pb-sm-0">
                                <div>
                                    <h6 class="mb-2">Website Sales</h6>
                                    <h4 class="mb-2">$674,347.12</h4>
                                    <p class="mb-0">
                                        <span class="text-muted me-2">21k orders</span><span
                                            class="badge bg-label-success">+12.4%</span>
                                    </p>
                                </div>
                                <span class="avatar p-2 me-lg-4">
                                    <span class="avatar-initial bg-label-secondary rounded"><i
                                            class="ti-md ti ti-device-laptop text-body"></i></span>
                                </span>
                            </div>
                            <hr class="d-none d-sm-block d-lg-none" />
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div
                                class="d-flex justify-content-between align-items-start border-end pb-3 pb-sm-0 card-widget-3">
                                <div>
                                    <h6 class="mb-2">Discount</h6>
                                    <h4 class="mb-2">$14,235.12</h4>
                                    <p class="mb-0 text-muted">6k orders</p>
                                </div>
                                <span class="avatar p-2 me-sm-4">
                                    <span class="avatar-initial bg-label-secondary rounded"><i
                                            class="ti-md ti ti-gift text-body"></i></span>
                                </span>
                            </div>
                        </div>
                        <div class="col-sm-6 col-lg-3">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-2">Affiliate</h6>
                                    <h4 class="mb-2">$8,345.23</h4>
                                    <p class="mb-0">
                                        <span class="text-muted me-2">150 orders</span><span
                                            class="badge bg-label-danger">-3.5%</span>
                                    </p>
                                </div>
                                <span class="avatar p-2">
                                    <span class="avatar-initial bg-label-secondary rounded"><i
                                            class="ti-md ti ti-wallet text-body"></i></span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Product List Table -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">Filter</h5>
                <div class="d-flex justify-content-between align-items-center row py-3 gap-3 gap-md-0">
                    <div class="col-md-4 product_status"></div>
                    <div class="col-md-4 product_category"></div>
                </div>
            </div>
            <div class="card-datatable table-responsive">
                <table class="datatables-products table">
                    <thead class="border-top">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>product</th>
                            <th>category</th>
                            <th>stock</th>
                            <th>sku</th>
                            <th>price</th>
                            <th>qty</th>
                            <th>status</th>
                            <th>actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
        <div class="modal-onboarding modal fade animate__animated" id="addProductModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header border-0">
                        <a class="text-muted close-label" href="javascript:void(0);" data-bs-dismiss="modal">Skip Intro</a>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body onboarding-horizontal p-0">
                        @include('admin.layout.product.addproduct')
                    </div>
                    <div class="modal-footer border-0">
                        <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="button" class="btn btn-primary" id="addProductBtn">Submit</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="modal-onboarding modal fade animate__animated" id="editProductModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header border-0">
                    <a class="text-muted close-label" href="javascript:void(0);" data-bs-dismiss="modal">Skip Intro</a>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body onboarding-horizontal p-0">
                    @include('admin.layout.product.editproduct')
                </div>
                <div class="modal-footer border-0">
                    <button type="button" class="btn btn-label-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="button" class="btn btn-primary" id="editProductSubmit">Submit</button>
                </div>
            </div>
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
                    <button type="submit" class="btn btn-primary" id="confirmEditProductBtn">Yes</button>
                </div>
            </div>
        </div>

    </div>
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmDeleteModalLabel">Confirm Delete</h5>
                    </div>
                    <div class="modal-body">
                        Are you sure you want to delete this record?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">No</button>
                        <button type="button" class="btn btn-danger" id="confirmDelete">Yes, Delete</button>
                    </div>
                </div>
            </div>
        </div>
@endsection
