@extends('user.layouts.template')

@section('breadcumb')
    <div class="breadcumb_area bg-img" style="background-image: url({{ asset('home/img/bg-img/breadcumb.jpg') }});">
        <div class="container h-100">
            <div class="row h-100 align-items-center">
                <div class="col-12">
                    <div class="page-title text-center">
                        <h2>Cửa hàng</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('main-content')
    <section class="shop_grid_area section-padding-80">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-4 col-lg-3">
                    <div class="shop_sidebar_area">
                        <!-- ##### Single Widget ##### -->
                        <div class="widget catagory mb-50">
                            <!-- Widget Title -->
                            <h6 class="widget-title mb-30">Categories</h6>
                            <!-- Categories -->
                            <div class="catagories-menu">
                                <ul id="menu-content2" class="menu-content">
                                    @foreach ($categories as $category)
                                        <li>
                                            <a href="#" class="filter-category"
                                                data-category-id="{{ $category->id }}">{{ $category->category_name }}</a>
                                            <ul class="sub-menu">
                                                @foreach ($category->subcategories as $subcategory)
                                                    <li>
                                                        <a href="#" class="filter-subcategory"
                                                            data-subcategory-id="{{ $subcategory->id }}">{{ $subcategory->subcategory_name }}</a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-8 col-lg-9">
                    <div class="shop_grid_product_area">
                        <div class="row">
                            <div class="col-12">
                                <div class="product-topbar d-flex align-items-center justify-content-between">
                                    <!-- Sorting -->
                                    <div class="total-products">
                                        <p><span>{{ $products->total() }}</span> products found</p>
                                    </div>
                                    <div class="product-sorting d-flex">
                                        <p>Sort by:</p>
                                        <select name="sort_by" id="sortByselect" class="nice-select">
                                            <option value="latest"{{ request('sort_by') == 'latest' ? ' selected' : '' }}>
                                                Sản phẩm mới nhất
                                            </option>
                                            <option
                                                value="price-asc"{{ request('sort_by') == 'price-asc' ? ' selected' : '' }}>
                                                Giá: Thấp đến cao
                                            </option>
                                            <option
                                                value="price-desc"{{ request('sort_by') == 'price-desc' ? ' selected' : '' }}>
                                                Giá: Cao đến thấp
                                            </option>
                                        </select>
                                    </div>
                                    <div class="product-sorting d-flex">
                                        <p>Size:</p>
                                        <select name="size" id="sizeFilter" class="nice-select">
                                            <option value="">Tất cả Size</option>
                                            @for ($i = 36; $i <= 46; $i++)
                                                <option
                                                    value="{{ $i }}"{{ request('size') == $i ? ' selected' : '' }}>
                                                    Size: {{ $i }}
                                                </option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="productList">
                            @include('partials.product-list', ['products' => $products])
                        </div>
                        <!-- Pagination -->
                        <!-- Pagination -->
                        {{-- <nav aria-label="navigation">
                            {{ $products->appends(request()->input())->links() }}
                        </nav> --}}
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        $(document).ready(function() {
            function fetchProducts() {
                $.ajax({
                    url: "{{ url('shop') }}",
                    type: "GET",
                    data: {
                        sort_by: $('#sortByselect').val(),
                        size: $('#sizeFilter').val(),
                        category_id: $('.filter-category.active').data('category-id'),
                        subcategory_id: $('.filter-subcategory.active').data('subcategory-id')
                    },
                    success: function(response) {
                        $('#productList').html(response);
                    }
                });
            }

            // Event handler for category filter
            $('a.filter-category').on('click', function(e) {
                e.preventDefault();
                // Toggle active class
                $(this).toggleClass('active');
                $('.filter-subcategory').not(this).removeClass('active');
                // Remove active class from other category links
                $('.filter-category').not(this).removeClass('active');
                // Fetch products
                fetchProducts();
            });

            // Event handler for subcategory filter
            $('a.filter-subcategory').on('click', function(e) {
                e.preventDefault();
                // Toggle active class
                $(this).toggleClass('active');
                // Remove active class from other subcategory links
                $('.filter-subcategory').not(this).removeClass('active');
                // Fetch products
                fetchProducts();
            });

            // Event handler for sorting
            $('#sortByselect').on('change', function() {
                fetchProducts();
            });

            // Event handler for size filter
            $('#sizeFilter').on('change', function() {
                fetchProducts();
            });
        });
    </script>
@endsection
