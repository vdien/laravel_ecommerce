@extends('admin.layout.template')
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

    <script src="{{ asset('dashboard/js/app-ecommerce-subcategory-list.js') }}"></script>
@endsection
@section('page_title')
    AllSubCategory-Lnvdien
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
                                <th class="text-nowrap text-sm-end">Total Products &nbsp;</th>
                                <th class="text-nowrap text-sm-end">Total Earning</th>
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
                <div class="offcanvas-body border-top">
                    <form class="pt-0" id="eCommerceCategoryListForm" onsubmit="return true">
                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce-category-title">Title</label>
                            <input type="text" class="form-control" id="ecommerce-category-title"
                                placeholder="Enter category title" name="categoryTitle" aria-label="category title" />
                        </div>
                        <!-- Slug -->
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce-category-slug">Slug</label>
                            <input type="text" id="ecommerce-category-slug" class="form-control" placeholder="Enter slug"
                                aria-label="slug" name="slug" />
                        </div>
                        <!-- Image -->
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce-category-image">Attachment</label>
                            <input class="form-control" type="file" id="ecommerce-category-image" />
                        </div>
                        <!-- Parent category -->
                        <div class="mb-3 ecommerce-select2-dropdown">
                            <label class="form-label" for="ecommerce-category-parent-category">Parent category</label>
                            <select id="ecommerce-category-parent-category" class="select2 form-select"
                                data-placeholder="Select parent category">
                                <option value="">Select parent Category</option>
                                <option value="Household">Household</option>
                                <option value="Management">Management</option>
                                <option value="Electronics">Electronics</option>
                                <option value="Office">Office</option>
                                <option value="Automotive">Automotive</option>
                            </select>
                        </div>
                        <!-- Description -->
                        <div class="mb-3">
                            <label class="form-label">Description</label>
                            <div class="form-control p-0 py-1">
                                <div class="comment-editor border-0" id="ecommerce-category-description"></div>
                                <div class="comment-toolbar border-0">
                                    <div class="d-flex justify-content-end">
                                        <span class="ql-formats me-0">
                                            <button class="ql-bold"></button>
                                            <button class="ql-italic"></button>
                                            <button class="ql-underline"></button>
                                            <button class="ql-list" value="ordered"></button>
                                            <button class="ql-list" value="bullet"></button>
                                            <button class="ql-link"></button>
                                            <button class="ql-image"></button>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- Status -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">Select category status</label>
                            <select id="ecommerce-category-status" class="select2 form-select"
                                data-placeholder="Select category status">
                                <option value="">Select category status</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Publish">Publish</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                        </div>
                        <!-- Submit and reset -->
                        <div class="mb-3">
                            <button type="submit" class="btn btn-primary me-sm-3 me-1 data-submit">Add</button>
                            <button type="reset" class="btn bg-label-danger"
                                data-bs-dismiss="offcanvas">Discard</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pages/</span> All Sub Category</h4>
        <div class="card">
            <h5 class="card-header">Available Sub Category Information </h5>
            @if (@session()->has('message'))
                <div class="alert alert-success">
                    {{ session()->get('message') }}
                </div>
            @endif
            <div class="table-responsive text-nowrap">
                <table class="table">
                    <thead class="table-light">
                        <tr>

                            <th>Id</th>
                            <th>Sub Category Name</th>
                            <th>Slug</th>
                            <th>Product</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody class="table-border-bottom-0">
                        @foreach ($subcategories as $subcategory)
                            <tr>
                                <td>{{ $subcategory->id }}</td>
                                <td>{{ $subcategory->subcategory_name }}</td>
                                <td>{{ $subcategory->category_name }}</td>
                                <td>{{ $subcategory->product_count }}</td>
                                <td>
                                    <a href="{{ route('editsubcategory', $subcategory->id) }}"
                                        class="btn btn-primary">Edit</a>
                                    <a href="{{ route('deletesubcategory', $subcategory->id) }}"
                                        class="btn btn-warning">Delete</a>
                                </td>
                            </tr>
                        @endforeach

                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
