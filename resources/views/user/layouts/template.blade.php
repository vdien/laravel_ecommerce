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

    <!-- Favicon  -->
    <link rel="icon" href="{{ asset('home/img/core-img/favicon.ico') }}">
    <!-- Core Style CSS -->
    <link rel="stylesheet" href="{{ asset('home/css/core-style.css') }}">
    <link rel="stylesheet" href="{{ asset('home/style.css') }}">
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
                            <li><a href="{{ route('shop') }}">Shop</a>
                                <div class="megamenu">
                                    @php
                                        $categories = App\Models\Category::latest()->get();
                                    @endphp
                                    @foreach ($categories as $category)
                                        <ul class="single-mega cn-col-4">
                                            <li class="title"><a
                                                    href="{{ route('category', [$category->id, $category->slug]) }}">{{ $category->category_name }}</a>
                                            </li>
                                            @php
                                                $subcategories = App\Models\Subcategory::where('category_id', $category->id)
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

                                    <div class="single-mega cn-col-4">
                                        <img src="{{ asset('home/img/bg-img/bg-6.jpg') }}" alt="">
                                    </div>
                                </div>
                            </li>
                            <li><a href="#">Pages</a>
                                <ul class="dropdown">
                                    <li><a href="index.html">Home</a></li>
                                    <li><a href="{{ route('shop') }}">Shop</a></li>
                                    <li><a href="single-product-details.html">Product Details</a></li>
                                    <li><a href="checkout.html">Checkout</a></li>
                                    <li><a href="blog.html">Blog</a></li>
                                    <li><a href="single-blog.html">Single Blog</a></li>
                                    <li><a href="regular-page.html">Regular Page</a></li>
                                    <li><a href="contact.html">Contact</a></li>
                                </ul>
                            </li>
                            <li><a href="blog.html">Blog</a></li>
                            <li><a href="contact.html">Contact</a></li>
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
                        <input type="search" name="search" id="headerSearch" placeholder="Type for search">
                        <button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
                    </form>
                </div>
                <!-- Favourite Area -->
                <div class="favourite-area">
                    <a href="#"><img src="{{ asset('home/img/core-img/heart.svg') }}" alt=""></a>
                </div>
                <!-- User Login Info -->
                <div class="user-login-info">
                    <a href="{{ route('profile.edit') }}"><img src="{{ asset('home/img/core-img/user.svg') }}"
                            alt=""></a>
                </div>
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

                <div class="single-cart-item">
                    <a href="#" class="product-image">
                        <img src="img/product-img/product-3.jpg" class="cart-thumb" alt="">
                        <!-- Cart Item Desc -->
                        <div class="cart-item-desc">
                            <span class="product-remove"><i class="fa fa-close" aria-hidden="true"></i></span>
                            <span class="badge">Mango</span>
                            <h6>Button Through Strap Mini Dress</h6>
                            <p class="size">Size: S</p>
                            <p class="color">Color: Red</p>
                            <p class="price">$45.00</p>
                        </div>
                    </a>
                </div>
            </div>

            <!-- Cart Summary -->
            <div class="cart-amount-summary">

                <h2>Summary</h2>
                <ul class="summary-table">
                    <li><span>subtotal:</span> <span name="subtotal">$0</span></li>
                    <li><span>delivery:</span> <span name=shipping>Free</span></li>
                    <li><span>discount:</span> <span name="discount">-0%</span></li>
                    <li><span>total:</span> <span name="totalCart">0</span></li>
                </ul>
                <div class="checkout-btn mt-100">
                    <a href="{{ route('cartpage') }}" class="btn essence-btn">View Cart</a>
                </div>
            </div>
        </div>
    </div>
    <!-- ##### Right Side Cart End ##### -->

    <!-- ##### Welcome Area Start ##### -->
    @yield('main-content')
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
                            <a href="#"><img src="img/core-img/logo2.png" alt=""></a>
                        </div>
                        <!-- Footer Menu -->
                        <div class="footer_menu">
                            <ul>
                                <li><a href="shop.html">Shop</a></li>
                                <li><a href="blog.html">Blog</a></li>
                                <li><a href="contact.html">Contact</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area mb-30">
                        <ul class="footer_widget_menu">
                            <li><a href="#">Order Status</a></li>
                            <li><a href="#">Payment Options</a></li>
                            <li><a href="#">Shipping and Delivery</a></li>
                            <li><a href="#">Guides</a></li>
                            <li><a href="#">Privacy Policy</a></li>
                            <li><a href="#">Terms of Use</a></li>
                        </ul>
                    </div>
                </div>
            </div>

            <div class="row align-items-end">
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
                    <div class="single_widget_area">
                        <div class="footer_heading mb-30">
                            <h6>Subscribe</h6>
                        </div>
                        <div class="subscribtion_form">
                            <form action="#" method="post">
                                <input type="email" name="mail" class="mail" placeholder="Your email here">
                                <button type="submit" class="submit"><i class="fa fa-long-arrow-right"
                                        aria-hidden="true"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- Single Widget Area -->
                <div class="col-12 col-md-6">
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
            </div>

            <div class="row mt-5">
                <div class="col-md-12 text-center">
                    <p>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                        Copyright ©
                        <script>
                            document.write(new Date().getFullYear());
                        </script>2023 All rights reserved | Made with <i class="fa fa-heart-o"
                            aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank">Colorlib</a>,
                        distributed by <a href="https://themewagon.com/" target="_blank">ThemeWagon</a>
                        <!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
                    </p>
                </div>
            </div>

        </div>
    </footer>
    <!-- ##### Footer Area End ##### -->

    <!-- jQuery (Necessary for All JavaScript Plugins) -->
    <script src="{{ asset('home/js/jquery/jquery-2.2.4.min.js') }}"></script>
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
    <script src="{{ asset('home/js/cart.js') }}"></script>
    <script>
        var cartGet = {{ route('cart.get') }}
        var cartAdd = {{route('cart.add')}}
        var cartUpdateQuantity = {{route('cart.update_quantity')}}
        var cartRemove = {{ route('cart.remove') }}
    </script>
</body>

</html>
