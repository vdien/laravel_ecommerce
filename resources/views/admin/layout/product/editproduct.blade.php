
            <div class="modal-body onboarding-horizontal p-0">
                <div class="container-xxl flex-grow-1 container-p-y">
                    <h4 class="py-3 mb-0">
                        <span class="text-muted fw-light">eCommerce /</span><span class="fw-medium"> Edit Product</span>
                    </h4>

                    <div class="app-ecommerce">
                        <!-- Edit Product -->
                        <form id="formEditProduct" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="edit_product_id" name="edit_product_id">
                            <div class="row">
                                <!-- First column-->
                                <div class="col-12 col-lg-8">
                                    <!-- Product Information -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-tile mb-0">Product information</h5>
                                        </div>
                                        <input type="hidden" name="edit_product_id" id="edit_product_id">
                                        <div class="card-body">
                                            <div class="row mb-3">
                                                <div class="col">
                                                    <label class="form-label" for="edit_product_name">Name</label>
                                                    <input type="text" class="form-control" id="edit_product_name"
                                                        placeholder="Product Name" name="edit_product_name"
                                                        aria-label="Product name" />
                                                </div>
                                                <div class="col">
                                                    <label class="form-label" for="edit-product-sku">SKU</label>
                                                    <input type="number" class="form-control"
                                                        id="edit-product-sku" placeholder="SKU" name="edit_productSku"
                                                        aria-label="Product SKU" />
                                                </div>
                                            </div>
                                            <!-- Description -->
                                            <div class="mb-3">
                                                <label class="form-label">Short Description</label>
                                                <div class="form-control p-0 pt-1">
                                                    <div class="edit-comment-short border-0 border-bottom">
                                                        <div class="d-flex justify-content-start">
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
                                                    <div class="edit-short-description border-0 pb-4"
                                                        id="edit-short-description">

                                                    </div>
                                                    <input type="hidden" name="edit-short-description-input"
                                                        id="edit-short-description-input">

                                                </div>
                                            </div>
                                            <div>
                                                <label class="form-label">Long Description</label>
                                                <div class="form-control p-0 pt-1">
                                                    <div class="edit-comment-long border-0 border-bottom">
                                                        <div class="d-flex justify-content-start">
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
                                                    <div class="edit-long-description border-0 pb-4"
                                                        id="edit-long-description">
                                                    </div>
                                                    <input type="hidden" name="edit-long-description-input"
                                                        id="edit-long-description-input">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Product Information -->
                                    <!-- Media -->

                                    <div class="row">
                                        <div class="mb-4 col-md-6">
                                            <div class="card">
                                                <div
                                                    class="card-header d-flex justify-content-between align-items-center">
                                                    <h5 class="mb-0 card-title">Ảnh chính</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <div class="preview-images">
                                                            <div class="row" id="editImagePreview">
                                                                <!-- Image previews will be Edited here dynamically -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="file" class="form-control"
                                                            id="edit_product_images" name="edit_product_images[]"
                                                            accept="image/*" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mb-4 col-md-6">
                                            <div class="card">
                                                <div
                                                    class="card-header d-flex justify-content-between align-items-center">
                                                    <h5 class="mb-0 card-title">Ảnh phụ</h5>
                                                </div>
                                                <div class="card-body">
                                                    <div class="mb-3">
                                                        <div class="preview-images">
                                                            <div class="row" id="editImagePreviewRowChild">
                                                                <!-- Image previews will be Edited here dynamically -->
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <input type="file" class="form-control"
                                                            id="edit_product_images_child" name="edit_product_images_child[]"
                                                            multiple accept="image/*" />
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                    <!-- /Media -->
                                    <!-- Variants -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Variants</h5>
                                        </div>
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <div class="row">
                                                    <label class="col-sm-3 col-form-label" for="basic-default-name">Size and
                                                        quantity:</label>
                                                    <div class="col-sm-9">
                                                        <div id="edit-size-quantity">
                                                            <!-- Size and quantity input fields will be added here dynamically -->
                                                        </div>
                                                        <button type="button" class="btn btn-primary"
                                                            onclick="editSizeQuantityField()">Add Size</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Variants -->

                                </div>
                                <!-- /Second column -->

                                <!-- Second column -->
                                <div class="col-12 col-lg-4">
                                    <!-- Pricing Card -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Pricing</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Base Price -->
                                            <div class="mb-3">
                                                <label class="form-label" for="product_price">Base Price</label>
                                                <input type="number" class="form-control" id="edit_product_price"
                                                    placeholder="Price" name="edit_product_price"
                                                    aria-label="Product price" />
                                            </div>
                                            <!-- Discounted Price -->
                                            <div class="mb-3">
                                                <label class="form-label" for="product_discount_price">Discounted
                                                    Price</label>
                                                <input type="number" class="form-control"
                                                    id="edit_product_discount_price" placeholder="Discounted Price"
                                                    name="edit_product_discount_price"
                                                    aria-label="Product discounted price" />
                                            </div>
                                            <!-- Instock switch -->
                                            <div
                                                class="d-flex justify-content-between align-items-center border-top pt-3">
                                                <h6 class="mb-0">In stock</h6>
                                                <div class="w-25 d-flex justify-content-end">
                                                    <label class="switch switch-primary switch-sm me-4 pe-2">
                                                        <input type="checkbox" class="switch-input"
                                                            id="editInStockSwitch"/>
                                                        <span class="switch-toggle-slider">
                                                            <span class="switch-on">
                                                                <span class="switch-off"></span>
                                                            </span>
                                                        </span>
                                                    </label>
                                                </div>
                                            </div>
                                            <!-- Hidden input to store the stock status -->
                                            <input type="hidden" name="edit_product_stock" id="editProductStock" value="1">
                                        </div>
                                    </div>
                                    <!-- /Pricing Card -->
                                    <!-- Organize Card -->
                                    <div class="card mb-4">
                                        <div class="card-header">
                                            <h5 class="card-title mb-0">Organize</h5>
                                        </div>
                                        <div class="card-body">
                                            <!-- Category -->
                                            <div class="mb-3 col ecommerce-select2-dropdown">
                                                <label
                                                    class="form-label mb-1 d-flex justify-content-between align-items-center"
                                                    for="subcategory">
                                                    <span>Category</span><a href="{{ route('allsubcategory') }}"
                                                        class="fw-medium">Add new
                                                        category</a>
                                                </label>
                                                <select id="edit_subcategory_product" name="edit_subcategory_product" class="form-select"
                                                    data-placeholder="Select Category">
                                                    <option value="">Select Category</option>
                                                    @foreach ($subCategory as $subcategories)
                                                        <option value={{$subcategories->id}}>
                                                            {{ $subcategories->subcategory_name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <!-- Status -->
                                            <div class="mb-3 col ecommerce-select2-dropdown">
                                                <label class="form-label mb-1" for="product_status">Status </label>
                                                <select id="edit_product_status" name="edit_product_status"
                                                    class="select2 form-select" data-placeholder="Published">
                                                    <option value="Published">Published</option>
                                                    <option value="Scheduled">Scheduled</option>
                                                    <option value="Inactive">Inactive</option>
                                                </select>
                                            </div>
                                            <!-- Tags -->
                                            <div class="mb-3">
                                                <label for="ecommerce_product_tags"
                                                    class="form-label mb-1">Tags</label>
                                                <input id="edit_product_tags" class="form-control"
                                                    name="edit_product_tags" aria-label="Product Tags" />
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /Organize Card -->
                                </div>
                                <!-- /Second column -->
                            </div>
                        </form>
                    </div>
                </div>
                <!-- / Content -->
            </div>


<div class="content-backdrop fade"></div>
