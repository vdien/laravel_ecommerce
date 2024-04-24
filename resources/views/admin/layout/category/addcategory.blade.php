@extends('admin.layout.template')
@section('page_title')
    Add Category-Lnvdien
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
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pages/</span> Add Category</h4>
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Add Category</h5>
                    <small class="text-muted float-end">Input Information</small>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('storecategory') }}" method="POST">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Category Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="category_name" name="category_name"
                                    placeholder="Electronic" />
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Add Category</button>
                            </div>
                        </div>
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
                            <div id="image-category-preview"></div>

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
@endsection
