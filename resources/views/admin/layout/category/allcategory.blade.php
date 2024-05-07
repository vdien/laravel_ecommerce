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
    <link rel="stylesheet" href="{{ asset('dashboard/vendor/libs/toastr/toastr.css') }}" />
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
    <script src="{{ asset('dashboard/vendor/libs/toastr/toastr.js') }} "></script>


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
                                <th class="text-nowrap text-sm-end">Total Subcategory </th>
                                <th class="text-nowrap text-sm-center">STATUS </th>
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

                <div class="offcanvas-body border-top">
                    <form id="addCategoryForm" class="pt-0 needs-validation" enctype="multipart/form-data" novalidate>
                        @csrf
                        <!-- Title -->
                        <div class="mb-3">
                            <label class="form-label" for="category_name">Category Name</label>
                            <input type="text" class="form-control" name="category_name"
                                placeholder="Enter category name" aria-label="category name" required />
                            <div class="invalid-feedback">
                                Please select a category name.
                            </div>
                        </div>

                        <!-- Slug -->
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce_category_slug">Slug</label>
                            <input type="text" id="ecommerce_category_slug" name="ecommerce_category_slug"
                                class="form-control" placeholder="Enter slug" aria-label="slug" name="slug" required />
                            <div class="invalid-feedback">
                                Please select a category slug.
                            </div>
                        </div>
                        <!-- Image -->
                        <div class="mb-3">
                            <label class="form-label" for="ecommerce_category_image">Image</label>
                            <input class="form-control" type="file" id="ecommerce_category_image"
                                name="ecommerce_category_image" required />
                            <div id="image_category_preview"></div>
                            <div class="invalid-feedback">
                                Please select a category image.
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="editCategoryDetail" class="form-label">Category Description</label>
                            <textarea class="form-control" name="ecommerce_category_description" id="ecommerce_category_description_input" required></textarea>
                            <div class="invalid-feedback">
                                Please select a category description.
                            </div>
                        </div>
                        <!-- Status -->
                        <div class="mb-4 ecommerce-select2-dropdown">
                            <label class="form-label">Select category status</label>
                            <select id="ecommerce_category_status" name="ecommerce_category_status" class="form-select"
                                data-placeholder="Select category status" required>
                                <option selected disabled value="">Select category status</option>
                                <option value="Scheduled">Scheduled</option>
                                <option value="Publish">Publish</option>
                                <option value="Inactive">Inactive</option>
                            </select>
                            <div class="invalid-feedback">
                                Please select a category status.
                            </div>
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
                            <form id="editCategoryForm" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="edit_category_id" id="edit_category_id">
                                <!-- Category Name -->
                                <div class="mb-3">
                                    <label class="form-label" for="edit_category_name">Category Name</label>
                                    <input type="text" class="form-control" id="edit_category_name"
                                        name="edit_category_name" placeholder="Enter category name"
                                        aria-label="Category Name" />
                                </div>
                                <!-- Slug -->
                                <div class="mb-3">
                                    <label class="form-label" for="edit_ecommerce_category_slug">Slug</label>
                                    <input type="text" id="edit_ecommerce_category_slug"
                                        name="edit_ecommerce_category_slug" class="form-control" placeholder="Enter slug"
                                        aria-label="Slug" />
                                </div>
                                <!-- Image Upload -->
                                <div class="mb-3">
                                    <label class="form-label" for="edit_ecommerce_category_image">Attachment</label>
                                    <input class="form-control" type="file" id="edit_ecommerce_category_image"
                                        name="edit_ecommerce_category_image" />
                                    <div id="edit_image_category_preview"></div>
                                </div>
                                <!-- Category Description -->
                                <div class="mb-3">
                                    <label for="edit_ecommerce_category_description" class="form-label">Category
                                        Description</label>
                                    <textarea class="form-control" name="edit_ecommerce_category_description"
                                        id="edit_ecommerce_category_description_input"></textarea>
                                </div>
                                <!-- Category Status -->
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
                                    <button type="button" class="btn btn-secondary"
                                        data-bs-dismiss="modal">Close</button>
                                    <button type="submit" class="btn btn-primary" id="saveChangesBtn">Save
                                        changes</button>
                                </div>
                                <!-- Confirm Modal -->
                                <div class="modal fade" id="confirmModal" tabindex="-1"
                                    aria-labelledby="confirmModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="confirmModalLabel">Confirm Action</h5>

                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to save changes?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">No</button>
                                                <button type="submit" class="btn btn-primary"
                                                    id="confirmSaveChanges">Yes</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Confirm Delete Category Modal -->
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
