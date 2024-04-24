@extends('admin.layout.template')
@section('page_title')
    AllCategory-Lnvdien
@endsection
@section('page_head')
    <!-- Vendors CSS -->
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/node-waves/node-waves.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/typeahead-js/typeahead.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-bs5/datatables.bootstrap5.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-responsive-bs5/responsive.bootstrap5.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/datatables-buttons-bs5/buttons.bootstrap5.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/select2/select2.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/@form-validation/form-validation.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/quill/typography.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/quill/katex.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/quill/editor.css') }} " />
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/css/pages/app-ecommerce.css') }}" />
@endsection
@section('page_script')
    <script src="{{ asset('dashboard/vendor/libs/moment/moment.js') }} "></script>
    <script src="{{ asset('dashboard/vendor/libs/datatables-bs5/datatables-bootstrap5.js') }} "></script>
    <script src="{{ asset('dashboard/vendor/libs/select2/select2.js') }} "></script>
    <script src="{{ asset('dashboard/vendor/libs/@form-validation/popular.js') }} "></script>
    <script src="{{ asset('dashboard/vendor/libs/@form-validation/bootstrap5.js') }} "></script>
    <script src="{{ asset('dashboard/vendor/libs/@form-validation/auto-focus.js') }} "></script>
    <script src="{{ asset('dashboard/vendor/libs/quill/katex.js') }} "></script>
    <script src="{{ asset('dashboard/vendor/libs/quill/quill.js') }} "></script>
    <!-- Page JS -->
    <script src="{{ asset('dashboard/js/main.js') }} "></script>
    <script src="{{ asset('dashboard/js/app-ecommerce-category-list.js') }}"></script>
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="py-3 mb-2"><span class="text-muted fw-light">eCommerce /</span> Category List</h4>
        <div class="app-ecommerce-category">
            <!-- Category List Table -->
            <div class="card">
                <div class="card-datatable table-responsive">
                    <table class="datatables-category-list table border-top">
                        <thead>
                            <tr>
                                <th></th>
                                <th></th>
                                <th>Categories</th>
                                <th class="text-nowrap text-sm-end">Total Subcategory &nbsp;</th>
                                <th class="text-lg-center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
            <!-- Offcanvas to add new customer -->
            <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasEcommerceCategoryList"
                aria-labelledby="offcanvasEcommerceCategoryListLabel">
                <!-- Offcanvas Header -->
                <div class="offcanvas-header py-4">
                    <h5 id="offcanvasEcommerceCategoryListLabel" class="offcanvas-title">Add Category</h5>
                    <button type="button" class="btn-close bg-label-secondary text-reset" data-bs-dismiss="offcanvas"
                        aria-label="Close"></button>
                </div>
                <!-- Offcanvas Body -->
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="offcanvas-body border-top">
                    <form class="pt-0" action="{{ route('storecategory') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label" for="category_name">Category Name</label>
                            <input type="text" class="form-control" name="category_name"
                                placeholder="Enter category name" aria-label="category name" />
                        </div>
                        <!-- Slug -->
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce_category_slug">Slug</label>
                            <input type="text" id="ecommerce_category_slug" name="ecommerce_category_slug"
                                class="form-control" placeholder="Enter slug" aria-label="slug" name="slug" />
                        </div>
                        <!-- Image -->
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce_category_image">Attachment</label>
                            <input class="form-control" type="file" id="ecommerce_category_image"
                                name="ecommerce_category_image" />
                            <div id="image_category_preview"></div>

                        </div>
                        <div class="mb-3">
                            <label for="editCategoryDetail" class="form-label">Category Detail</label>
                            <textarea class="form-control" name="ecommerce_category_description" id="ecommerce_category_description_input"></textarea>
                        </div>
                        <!-- Status -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">Select category status</label>
                            <select id="ecommerce_category_status" name="ecommerce_category_status"
                                class="select2 form-select" data-placeholder="Select category status">
                                <option value="">Select category status</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Publish">Publish</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <!-- Submit and reset -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Add</button>
                            <button type="reset" class="btn bg-label-danger" data-bs-dismiss="offcanvas">Discard</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Edit Category Modal -->
            <div class="modal fade" id="editCategoryModal" tabindex="-1" aria-labelledby="editCategoryModalLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="editCategoryModalLabel">Edit Category</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Form fields for editing category -->
                            <form id="editCategoryForm">
                                <div class="mb-3">
                                    <label class="form-label" for="category_name">Category Name</label>
                                    <input type="text" class="form-control" id="edit_category_name" name="edit_category_name"
                                        placeholder="Enter category name" aria-label="category name" />
                                </div>
                                <!-- Slug -->
                                <div class="mb-3">
                                    <label class="form-label" for="ecommerce_category_slug">Slug</label>
                                    <input type="text" id="edit_ecommerce_category_slug" name="edit_ecommerce_category_slug"
                                        class="form-control" placeholder="Enter slug" aria-label="slug" name="slug" />
                                </div>
                                <!-- Image -->
                                <div class="mb-3">
                                    <label class="form-label" for="ecommerce_category_image">Attachment</label>
                                    <input class="form-control" type="file" id="edit_ecommerce_category_image"
                                        name="edit_ecommerce_category_image" />
                                    <div id="edit_image_category_preview"></div>

                                </div>
                                <div class="mb-3">
                                    <label for="editCategoryDetail" class="form-label">Category Description</label>
                                    <textarea class="form-control" name="edit_ecommerce_category_description" id="edit_ecommerce_category_description_input"></textarea>

                                </div>
                                <!-- Status -->
                                <div class="mb-4 ecommerce-select2-dropdown">
                                    <label class="form-label">Select category status</label>
                                    <select id="edit_ecommerce_category_status" name="edit_ecommerce_category_status"
                                        class="select2 form-select" data-placeholder="Select category status">
                                        <option value="">Select category status</option>
                                        <option value="Scheduled">Scheduled</option>
                                        <option value="Publish">Publish</option>
                                        <option value="Inactive">Inactive</option>
                                    </select>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    <button type="button" class="btn btn-primary" id="saveChangesBtn">Save changes</button>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
