<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="description" content="">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- The above 4 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css"
        integrity="sha512-3pIirOrwegjM6erE5gPSwkUzO+3cTjpnV9lexlNZqvupR64iZBnOOTiiLPb9M36zpMScbmUNIcHUqKD47M719g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- Title  -->
    <title>Essence - Shoes Ecommerce</title>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/css/nice-select.min.css">
    <script src="{{ asset('home/js/jquery/jquery-2.2.4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-nice-select/1.1.0/js/jquery.nice-select.min.js"></script>
    <!-- Favicon  -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>

    <link rel="icon" href="{{ asset('home/img/core-img/favicon.ico') }}">
    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('home/css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('home/style.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>


    <style>
        .nice-select .list {
            border-radius: 0px;
            height: 200px;
            overflow-y: auto;

        }
    </style>
</head>

<body>
    <!-- ##### Header Area Start ##### -->
    <header class="header_area">

        <div class="classy-nav-container breakpoint-off d-flex align-items-center justify-content-between">
            <!-- Classy Menu -->
            <nav class="classy-navbar" id="essenceNav">
                <!-- Logo -->
                <a class="nav-brand" href="{{ route('Home') }}"><img src="{{ asset('home/img/core-img/logo.png') }}"
                        alt=""></a>
                <!-- Navbar Toggler -->
                <div class="classy-navbar-toggler">
                    <span class="navbarToggler"><span></span><span></span><span></span></span>
                </div>
                <!-- Menu -->
                <div class="classy-menu">
                    <!-- close btn -->
                    <div class="classycloseIcon">
                        <div class="cross-wrap"><span class="top"></span><span class="bottom"></span></div>
                    </div>
                    <!-- Nav Start -->
                    <div class="classynav">
                        <ul>
                            <li><a href="{{ route('shop') }}">Sản phẩm</a>
                                <div class="megamenu">
                                    @php
                                        $categories = App\Models\Category::latest()->get();
                                    @endphp
                                    @foreach ($categories as $category)
                                        <ul class="single-mega cn-col-3">
                                            <li class="title"><a
                                                    href="{{ route('category', [$category->id, $category->slug]) }}">{{ $category->category_name }}</a>
                                            </li>
                                            @php
                                                $subcategories = App\Models\Subcategory::where(
                                                    'category_id',
                                                    $category->id,
                                                )
                                                    ->latest()
                                                    ->get();
                                            @endphp
                                            @foreach ($subcategories as $subcategory)
                                                <li><a
                                                        href="{{ route('subcategory', [$subcategory->id, $subcategory->slug]) }}">{{ $subcategory->subcategory_name }}</a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @endforeach
                                </div>
                            </li>
                            <li><a href="{{route('blog')}}">Bài viết</a></li>
                            <li><a href="{{route('contact')}}">Liên hệ</a></li>
                        </ul>
                    </div>

                    <!-- Nav End -->
                </div>
            </nav>

            <!-- Header Meta Data -->
            <div class="header-meta d-flex clearfix justify-content-end">
                <!-- Search Area -->
                <div class="search-area">
                    <form action="#" method="post">
                        <input type="search" name="search" id="headerSearch" placeholder="Tìm sản phẩm"  >
                        <i class="fa fa-search mr-4" aria-hidden="true"></i>
                    </form>
                    <!-- Search results container -->
                    <div id="searchResults" style="display: none;">
                        <!-- AJAX results will be appended here -->
                    </div>
                </div>
                <!-- Favourite Area -->
                <div class="favourite-area">
                    <a href="{{ route('profile.edit') }}"><img src="{{ asset('home/img/core-img/user.svg') }}"
                            alt=""></a>
                </div>
                <!-- User Login Info -->

                <!-- Cart Area -->
                <div class="cart-area">
                    <a href="#" id="essenceCartBtn"><img src="{{ asset('home/img/core-img/bag.svg') }}"
                            alt=""> <span name="countCart">{{ session('cart_count', 0) }}</span></a>
                </div>
            </div>

        </div>
    </header>
    <!-- ##### Header Area End ##### -->

    <!-- ##### Right Side Cart Area ##### -->
    <div class="cart-bg-overlay"></div>

    <div class="right-side-cart-area">

        <!-- Cart Button -->
        <div class="cart-button">
            <a href="#" id="rightSideCart"><img src="{{ asset('home/img/core-img/bag.svg') }}" alt="">
                <span name="countCart">{{ session('cart_count', 0) }}</span>
        </div>

        <div class="cart-content d-flex">

            <!-- Cart List Area -->
            <div class="cart-list">

            </div>

            <!-- Cart Summary -->
            <div class="cart-amount-summary">
                <h2>Tóm tắt</h2>
                <ul class="summary-table">
                    <li><span>Tổng tiền:</span> <span name="subtotal">0đ</span></li>
                    <li><span>Phí vận chuyển:</span> <span name=shipping>Miễn phí</span></li>
                    <li><span>Giảm giá:</span> <span name="discount">-0%</span></li>
                    <li><span>Tổng cộng:</span> <span name="totalCart"></span></li>
                </ul>
                <div class="checkout-btn mt-100">
                    <a href="{{ route('cartpage') }}" class="btn essence-btn">Xem giỏ hàng</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Right Side Cart End ##### -->

    <!-- ##### Welcome Area Start ##### -->

    @yield('breadcumb')
    @yield('main-content')


    <!-- ##### Breadcumb Area End ##### -->


    <!-- ##### Welcome Area End ##### -->

    <!-- ##### Footer Area Start ##### -->
    <footer class="footer_area clearfix">
        <div class="container">
            <div class="row">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area d-flex mb-30">
                        <!-- Logo -->
                        <div class="footer-logo mr-50">
                            <a href="#"><img src="{{ asset('home/img/core-img/logo2.png') }}" alt=""></a>
                        </div>
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <ul>
                                <li><a href="{{route('shop')}}">Cửa hàng</a></li>
                                <li><a href="{{route('blog')}}">Bài viết</a></li>
                                <li><a href="{{route('contact')}}">Liên hệ</a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>

            <div class="row align-items-end">
                <!-- Single Widget Area -->

                <!-- Single Widget Area -->
                <div class="col-6 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_social_area">
                            <a href="#" data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Instagram"><i class="fa fa-instagram"
                                    aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Pinterest"><i class="fa fa-pinterest"
                                    aria-hidden="true"></i></a>
                            <a href="#" data-toggle="tooltip" data-placement="top" title=""
                                data-original-title="Youtube"><i class="fa fa-youtube-play"
                                    aria-hidden="true"></i></a>
                        </div>
                    </div>
                </div>


            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script> All rights reserved | Made with <i class="fa fa-heart-o"
                            aria-hidden="true"></i> by <a href="#" target="_blank">lnvdien</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>
        </div>
        </div>
    </footer>

    @yield('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.21.1/axios.min.js"></script>


    <!-- Popper js -->

    <script src="{{ asset('home/js/popper.min.js') }}"></script>
    <!-- Bootstrap js -->
    <script src="{{ asset('home/js/bootstrap.min.js') }}"></script>
    <!-- Plugins js -->
    <script src="{{ asset('home/js/plugins.js') }}"></script>
    <!-- Classy Nav js -->
    <script src="{{ asset('home/js/classy-nav.min.js') }}"></script>
    <!-- Active js -->
    <script src="{{ asset('home/js/active.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"
        integrity="sha512-VEd+nq25CkR676O+pLBnDW09R7VQX9Mdiij052gVCp5yVH3jGtH70Ho/UUv4mJDsEdTvqRCFZg0NKGiojGnUCw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="{{ asset('home/js/toast.js') }}"></script>
    <script>
        $(document).ready(function() {
    let debounceTimer;

    $('#headerSearch').on('keyup', function() {
        clearTimeout(debounceTimer);

        const query = $(this).val();

        // Nếu ô tìm kiếm trống, không thực hiện tìm kiếm
        if (query.length > 0) {
            debounceTimer = setTimeout(function() {
                $.ajax({
                    url: '{{ route('searchproduct') }}',
                    method: 'POST',
                    data: {
                        search: query,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        $('#searchResults').html(response.html).show();
                    },
                    error: function(xhr) {
                        console.error('An error occurred:', xhr.responseText);
                    }
                });
            }, 300); // Thời gian debounce (300ms)
        } else {
            $('#searchResults').hide(); // Ẩn kết quả nếu ô tìm kiếm trống
        }
    });

    // Ẩn kết quả khi nhấp ra ngoài
    $(document).click(function(event) {
        if (!$(event.target).closest('#searchForm, #searchResults').length) {
            $('#searchResults').hide();
        }
    });
});

    </script>
    <script>
        var cartGet = "{{ route('cart.get') }}";
        var cartAdd = "{{ route('cart.add') }}";
        var cartUpdateQuantity = "{{ route('cart.update_quantity') }}";
        var cartRemove = "{{ route('cart.remove') }}";
        var cartCheckout = "{{ route('cart.checkout') }}";
        var cartThanks = "{{ route('cart.thanks') }}";
    </script>
    <script src="{{ asset('home/js/cart.js') }}"></script>
    <script src="{{ asset('home/js/checkout.js') }}"></script>
    <script src="{{ asset('home/js/shop.js') }}"></script>

</body>

</html>
