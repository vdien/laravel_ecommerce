@extends('admin.layout.template')
@section('page_title')
    AddProduct-Lnvdien
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pages/</span> Add Product</h4>
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Add New Product</h5>
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
                    <form action="{{ route('storeproduct') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Product Name</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" id="product_name" name="product_name"
                                    placeholder="Electronic" />
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Product Price</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="product_price" name="product_price"
                                    placeholder="12" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                    <div class="mb-3">
                                        <label for="product_images" class="form-label">Ảnh chính</label>
                                        <input type="file" class="form-control" id="product_images" name="product_images[]"
                                            accept="image/*" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Image Preview</label>
                                        <div class="preview-images">
                                            <div class="row" id="imagePreviewRow">
                                                <!-- Image previews will be added here dynamically -->
                                            </div>
                                        </div>
                                    </div>
                            </div>
                            <div class="col-6">
                                    <div class="mb-3">
                                        <label for="product_images" class="form-label">Ảnh phụ</label>
                                        <input type="file" class="form-control" id="product_images_child" name="product_images_child[]"
                                            multiple accept="image/*" />
                                    </div>
                                    <div class="mb-3">
                                        <label class="form-label">Image Preview</label>
                                        <div class="preview-images">
                                            <div class="row" id="imagePreviewRowChild">
                                                <!-- Image previews will be added here dynamically -->
                                            </div>
                                        </div>
                                    </div>

                            </div>
                        </div>

                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Select Category</label>
                            <div class="col-sm-10">
                                <select id="product_category_id" name="product_category_id" class="form-select">
                                    <option>Select Product Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Select Sub Category</label>
                            <div class="col-sm-10">
                                <select id="product_subcategory_id" name="product_subcategory_id" class="form-select">
                                    <option>Select Product Subcategory</option>
                                    @foreach ($subcategories as $subcategory)
                                        <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <!-- Size and Quantity Fields -->
                        <div class="mb-3">
                            <div class="row">

                                <label class="col-sm-2 col-form-label" for="basic-default-name">Size and Quantity</label>
                                <div class="col-sm-10">

                                    <div id="size-quantity-container">
                                        <!-- Size and quantity input fields will be added here dynamically -->
                                    </div>
                                    <button type="button" class="btn btn-secondary" onclick="addSizeQuantityField()">Add
                                        Size and Quantity</button>

                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Product Short
                                Description</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" id="product_short_description" name="product_short_description"
                                    placeholder="Electronic"> </textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Product Long Description</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" id="product_long_description" name="product_long_description"
                                    placeholder="Electronic"> </textarea>
                            </div>
                        </div>

                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Add Product</button>
                            </div>
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
            newRow.className = 'row mb-3';

            newRow.innerHTML = `
                <div class="col-sm-4">
                    <input type="text" class="form-control" name="size[]" placeholder="Size">
                </div>
                <div class="col-sm-4">
                    <input type="number" class="form-control" name="quantity[]" placeholder="Quantity">
                </div>
                <div class="col-sm-4">
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
