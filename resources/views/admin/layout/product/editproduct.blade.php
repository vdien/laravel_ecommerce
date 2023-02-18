@extends('admin.layout.template')
@section('page_title')
    EditProduct-Lnvdien
@endsection
@section('content')
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Pages/</span> Add Product</h4>
        <div class="col-xxl">
            <div class="card mb-4">
                <div class="card-header d-flex align-items-center justify-content-between">
                    <h5 class="mb-0">Edit Product</h5>
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
                    <form action="{{ route('updateproduct') }}" method="POST" >
                        @csrf
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
                              value="{{ $product_info->price }}"/>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Product Short
                                Description</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" id="product_short_description" name="product_short_description"
                             >{{ $product_info->product_short_des }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Product Long Description</label>
                            <div class="col-sm-10">
                                <textarea type="text" class="form-control" id="product_long_description" name="product_long_description"
                                 >{{ $product_info->product_long_des }}</textarea>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Select Category</label>
                            <div class="col-sm-10">
                                <select id="product_category_id" name="product_category_id" class="form-select">
                                    <option value="{{$product_info->product_category_id}}" selected>{{  $product_info->product_category_name}}</option>
                                  @foreach ($categories as $category)
                                    @if ("{{$product_info->product_category_name}}" !== "{{$category->category_name}}");
                                        <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Select Sub Category</label>
                            <div class="col-sm-10">
                                <select id="product_subcategory_id" name="product_subcategory_id" class="form-select">
                                     <option value="{{$product_info->product_subcategory_id}}" selected>{{  $product_info->product_subcategory_name}}</option>
                                  @foreach ($subcategories as $subcategory)
                                    @if ("{{$product_info->product_subcategory_name}}" !== "{{$subcategory->subcategory_name}}");
                                        <option value="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</option>
                                    @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label class="col-sm-2 col-form-label" for="basic-default-name">Product Quantity</label>
                            <div class="col-sm-10">
                                <input type="number" class="form-control" id="product_quantity" name="product_quantity"
                                    value="{{ $product_info->quantity }}" />
                            </div>
                        </div>
                        <div class="row justify-content-end">
                            <div class="col-sm-10">
                                <button type="submit" class="btn btn-primary">Update Product</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
