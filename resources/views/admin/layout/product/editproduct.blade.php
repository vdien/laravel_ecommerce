@extends('admin.layout.template')
@section('page_title')
    Edit Product - Lnvdien
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pages/</span> Edit Product</h4>
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Product</h5>
                    <small class="text-muted float-end">Input Information</small>
                </div>
                <div class="card-body">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">{{ $error }}</div>
                        @endforeach
                    @endif
                    @if (@session()->has('message'))
                    <div class="alert alert-success">
                        {{ session()->get('message') }}
                    </div>
                    @endif
                    <!-- Toastr -->
                    @if (session('success'))
                        <script>
                            toastr.success('{{ session('success') }}');
                        </script>
                    @endif

                    <form action="{{ route('updateproduct') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">

                            <input type="hidden" value="{{ $product_info->id }}" name="product_id" id="product_id">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Product Name</label>
                                <div class="col-sm-10">
                                    <input type="text" class="form-control" id="product_name" name="product_name"
                                        value="{{ $product_info->product_name }}" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Product Price</label>
                                <div class="col-sm-10">
                                    <input type="number" class="form-control" id="product_price" name="product_price"
                                        value="{{ $product_info->price }}" />
                                </div>
                            </div>

                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Select Category</label>
                                <div class="col-sm-10">
                                    <select id="product_category_id" name="product_category_id" class="form-select">
                                        <option value="{{ $product_info->product_category_id }}" selected>
                                            {{ $product_info->product_category_name }}</option>
                                        @foreach ($categories as $category)
                                            @if ($product_info->product_category_name != $category->category_name)
                                                <option value="{{ $category->id }}">{{ $category->category_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Select Sub
                                    Category</label>
                                <div class="col-sm-10">
                                    <select id="product_subcategory_id" name="product_subcategory_id" class="form-select">
                                        <option value="{{ $product_info->product_subcategory_id }}" selected>
                                            {{ $product_info->product_subcategory_name }}</option>
                                        @foreach ($subcategories as $subcategory)
                                            @if ($product_info->product_subcategory_name !== $subcategory->subcategory_name)
                                                ;
                                                <option value="{{ $subcategory->id }}">
                                                    {{ $subcategory->subcategory_name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <!-- Size Quantities Table -->
                            <div class="mb-3">
                                <div class="row">
                                    <label class="col-sm-2 col-form-label" for="basic-default-name">Size and
                                        Quantity</label>
                                    <div class="col-sm-10">
                                        <div>
                                            @foreach ($sizes as $size)
                                                <div class="row mb-3 size-row align-items-end">
                                                    <div class="col-sm-5">
                                                        <label>Kích cỡ</label> <input type="text" name="size[]"
                                                            class="form-control" value="{{ $size->size }}">
                                                    </div>
                                                    <div class="col-sm-5">

                                                        Số lượng <input type="number" name="quantity[]"
                                                            class="form-control" value="{{ $size->quantity }}">
                                                    </div>
                                                    <div class="col-sm-2">

                                                        <button type="button" class="btn btn-danger" name="delete"
                                                            onclick="removeSizeQuantityField(this)">Remove</button>
                                                    </div>

                                                </div>
                                            @endforeach
                                        </div>
                                        <div id="size-quantity-container">

                                            <!-- Size and quantity input fields will be added here dynamically -->
                                        </div>
                                        <button type="button" class="btn btn-secondary"
                                            onclick="addSizeQuantityField()">Add
                                            Size and Quantity</button>

                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    @if ($product_info->product_img)
                                        <div class="mb-3">
                                            <label for="old_images" class="form-label">Ảnh chính</label>
                                            <div class="row">
                                                <img src="{{ asset($product_info->product_img) }}" alt="Old Product Image"
                                                    class="img-thumbnail col-4 mb-2">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="product_images" class="form-label">Upload New Images</label>
                                            <input type="file" class="form-control" id="product_images"
                                                name="product_images[]" accept="image/*" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Image Preview</label>
                                            <div class="preview-images">
                                                <div class="row" id="imagePreviewRow">
                                                    <!-- Image previews will be added here dynamically -->
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-6">
                                    @if ($product_info->product_img_child)
                                        <div class="mb-3">
                                            <label for="old_images" class="form-label">Ảnh phụ</label>
                                            <div class="thumbnail-container">
                                                <div class="row">
                                                    @foreach (json_decode($product_info->product_img_child) as $oldChildImage)
                                                        <img src="{{ asset($oldChildImage) }}" alt="Product Image"
                                                            class="img-thumbnail col-4 mb-2">
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="product_images" class="form-label">Upload New Images</label>
                                            <input type="file" class="form-control" id="product_images_child"
                                                name="product_images_child[]" multiple accept="image/*" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">Image Preview</label>
                                            <div class="preview-images">
                                                <div class="row" id="imagePreviewRowChild">
                                                    <!-- Image previews will be added here dynamically -->
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            </div>
                            <!-- Add an input for uploading new images -->
                        </div>

                        <div class="col-12">
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Product Short
                                    Description</label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control" id="product_short_description" name="product_short_description">{{ $product_info->product_short_des }}</textarea>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <label class="col-sm-2 col-form-label" for="basic-default-name">Product Long
                                    Description</label>
                                <div class="col-sm-10">
                                    <textarea type="text" class="form-control" id="product_long_description" name="product_long_description">{{ $product_info->product_long_des }}</textarea>
                                </div>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <button type="submit" class="btn btn-primary col-sm-2">Update Product</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function addSizeQuantityField() {
            const container = document.getElementById('size-quantity-container');
            const newRow = document.createElement('div');
            newRow.className = 'row mb-3 align-items-end';

            newRow.innerHTML = `
                <div class="col-sm-5">
                    <input type="text" class="form-control" name="size[]" placeholder="Size">
                </div>
                <div class="col-sm-5">
                    <input type="number" class="form-control" name="quantity[]" placeholder="Quantity">
                </div>
                <div class="col-sm-2">
                    <button type="button" class="btn btn-danger" onclick="removeSizeQuantityField(this)">Remove</button>
                </div>
            `;

            container.appendChild(newRow);
        }

        function removeSizeQuantityField(button) {
            const row = button.parentElement.parentElement;
            row.remove();
        }
    </script>
@endsection
