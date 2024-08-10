    // Function to fetch the cart items from the server and update the cart list
    function fetchAndRenderCart() {
        $.ajax({
            url: cartGet, // Replace this with the route to fetch cart items
            method: "GET",
            success: function (response) {
                if (response.success) {
                    updateCartCount(response.cart_count)
                    updateCartList(response.cart_items);
                    updateSubtotal(response.cart_items);
                    updateCartCheckout(response.cart_items)
                } else {
                    toastr.error('Đã xảy ra lỗi khi tải các mục giỏ hàng.', 'Lỗi');
                }
            },
            error: function () {
                toastr.error('Đã xảy ra lỗi khi tải các mục giỏ hàng.', 'Lỗi');
            }
        });
    }
    $(function () {
        $('[name=add-to-cart-form]').on('submit', function (event) {
            event.preventDefault();

            // Check if a size is selected
            var selectedSize = $('[name="size"]:checked').val();
            if (!selectedSize) {
                toastr.error('Vui lòng chọn một kích cỡ trước khi thêm vào giỏ hàng.', 'Lỗi');
                return;
            }

            $.ajax({
                url: cartAdd,
                method: "POST",
                data: $(this).serialize(),
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function (response) {
                    if (response.success) {
                        // Update the cart count in the button
                        $('[name="countCart"]').text(response.cart_count);
                        document.getElementById("rightSideCart").click();
                        fetchAndRenderCart();
                        toastr.success('Đã thêm sản phẩm vào giỏ hàng.', 'Thành công');
                    } else {
                        toastr.error('Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng.', 'Lỗi');
                    }
                },
                error: function () {
                    toastr.error('Đã xảy ra lỗi khi thêm sản phẩm vào giỏ hàng.', 'Lỗi');
                }
            });
        });
    });

    function updateCartList(cartItems) {
        var cartList = $('.cart-list');
        cartList.empty();

        if (cartItems.length === 0) {
            // Show an empty cart message
            cartList.append('<p>Không có sản phẩm trong giỏ hàng.</p>');
            return;
        }

        // Loop through the cart items and add them to the cart list
        for (var i = 0; i < cartItems.length; i++) {
            var cartItem = cartItems[i];
            var itemHTML = `
            <div class="single-cart-item">
                <a href="#" class="product-image">
                    <img class="hover-img" src="http://127.0.0.1:8000/dashboard/img/ecommerce-product-images/product/${cartItem.product_img}" alt="">
                    <!-- Cart Item Desc -->
                    <div class="cart-item-desc">
                        <span class="product-remove remove-cart-item" data-product-id="${cartItem.product_id}" data-size="${cartItem.size}"><i class="fa fa-close" aria-hidden="true"></i></span>
                        <span class="badge">${cartItem.product_subcategory}<span>
                        <h6 style="width: 100%; overflow: visible; white-space: normal; word-wrap: break-word;">${cartItem.name}</h6>
                        <p class="size">Size: ${cartItem.size}</p>
                        <p class="color">Số lượng:${cartItem.quantity}</p>
                        <p class="price">${cartItem.price.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}</p>
                    </div>
                </a>
            </div>
        `;
            cartList.append(itemHTML);
        }
    }

    function updateCartCheckout(cartItems) {

        var cartList = $('.cart-list-checkout');
        cartList.empty();

        if (cartItems.length === 0) {
            // Show an empty cart message
            cartList.append('<p>Không có sản phẩm trong giỏ hàng.</p>');
            return;
        }

        // Loop through the cart items and add them to the cart list
        for (var i = 0; i < cartItems.length; i++) {
            var cartItem = cartItems[i];
            var itemHTML = `
                <tr>
    <th scope="row">
        <div class="p-2 d-flex align-items-center" style="flex-wrap: nowrap;">
            <img src="http://127.0.0.1:8000/dashboard/img/ecommerce-product-images/product/${cartItem.product_img}" alt="" width="70" class="img-fluid rounded shadow-sm">
            <div class="ml-3 d-inline-block" style="flex: 1;">
                <h5 class="mb-0" style="width: 100%; overflow: visible; white-space: normal; word-wrap: break-word;">
                    <a href="#" class="text-dark d-inline-block">${cartItem.name}</a>
                </h5>
                <span class="text-muted font-weight-normal font-italic">Size: ${cartItem.size}</span>
            </div>
        </div>
    </th>
    <td class="align-middle">
                    <div class="p-2 d-flex align-items-center" style="flex-wrap: nowrap;">

        <span class="quantity-decrease" name="quantity-decrease" style="cursor: pointer;" data-product-id="${cartItem.product_id}" data-size="${cartItem.size}" data-quantity="${cartItem.quantity}">-</span>
        <strong><span class="quantity">${cartItem.quantity}</span></strong>
        <input type="number" class="quantity-input" data-product-id="${cartItem.product_id}" data-size="${cartItem.size}" value="${cartItem.quantity}" hidden>
        <span class="quantity-increase" style="cursor: pointer;" data-product-id="${cartItem.product_id}" data-size="${cartItem.size}">+</span>
        </div>
    </td>
    <td class="align-middle"><strong>${(cartItem.price * cartItem.quantity).toLocaleString('vi-VN', { style: 'currency', currency: 'VND' })}<strong></td>
    <td class="align-middle"><a href="#" class="text-dark remove-cart-item" data-product-id="${cartItem.product_id}" data-size="${cartItem.size}"><i class="fa fa-trash"></i></a></td>
</tr>

                 `;
            cartList.append(itemHTML);
        }
    }

    function updateCartItemQuantity(productId, size, newQuantity) {
        $.ajax({
            url: cartUpdateQuantity,
            method: "POST",
            data: {
                product_id: productId,
                size: size,
                quantity: newQuantity
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    fetchAndRenderCart(); // Update the cart list
                    updateCartCount(response.cart_count); // Update the cart_count
                    toastr.success(response.message, 'Success');
                } else {
                    toastr.error(response.message, 'Error');
                }
            },
            error: function () {
                toastr.error('An error occurred while updating quantity.', 'Error');
            }
        });
    }

    function updateSubtotal(cartItems) {
        var subtotal = 0;
        var discount = 0;
        var Shipping = 0;
        for (var i = 0; i < cartItems.length; i++) {
            subtotal += cartItems[i].quantity * cartItems[i].price;
        }
        var total = subtotal * (100 - discount) / 100 + Shipping

        $("[name='subtotal']").text(subtotal.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));
        Shipping = 0 ? $("[name='shipping']").text('Miễn phí') : $("[name='shipping']").text(Shipping.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }))
        $("[name='totalCart']").text(total.toLocaleString('vi-VN', { style: 'currency', currency: 'VND' }));

    }
    function updateCartCount(count) {
        $("[name='countCart']").text(count);
    }

    function removeCartItem(productId, size) {
        $.ajax({
            url: cartRemove, // Replace with your route to remove cart item
            method: "POST",
            data: {
                product_id: productId,
                size: size
            },
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function (response) {
                if (response.success) {
                    // Update the cart list and other UI elements
                    fetchAndRenderCart();
                    updateCartCount(response.cart_count); // Update the cart_count
                    toastr.success('Xóa sản phảm thành công.', 'Thành công');
                } else {
                    toastr.error('Đã xảy ra lỗi khi xóa sản phẩm ra khỏi giỏ hàng.', 'Lỗi');
                }
            },
            error: function () {
                toastr.error('Đã xảy ra lỗi khi xóa sản phẩm ra khỏi giỏ hàng.', 'Lỗi');
            }
        });
    }
    $(document).ready(function () {
        // Event listener for decrease span
        $(document).on('click', '.quantity-decrease', function () {
            var productId = $(this).data('product-id');
            var size = $(this).data('size');
            var inputElement = $(this).siblings('.quantity-input');
            var newQuantity = parseInt(inputElement.val()) - 1;

            updateCartItemQuantity(productId, size, newQuantity);
        });

        // Event listener for increase span
        $(document).on('click', '.quantity-increase', function () {
            var productId = $(this).data('product-id');
            var size = $(this).data('size');
            var inputElement = $(this).siblings('.quantity-input');
            var newQuantity = parseInt(inputElement.val()) + 1;

            updateCartItemQuantity(productId, size, newQuantity);
        });

        // Event listener for quantity input change
        $(document).on('change', '.quantity-input', function () {
            var productId = $(this).data('product-id');
            var size = $(this).data('size');
            var newQuantity = parseInt($(this).val());

            updateCartItemQuantity(productId, size, newQuantity);
        });
        $(document).on('click', '.remove-cart-item', function () {
            var productId = $(this).data('product-id');
            var size = $(this).data('size');

            removeCartItem(productId, size);
        });
        $(document).ready(function () {
            // Event listener for the checkout button
            $('#checkout-button').on('click', function (e) {
                e.preventDefault();

                // Check if the cart is empty
                if ($('.cart-list-checkout tr').length === 0) {
                    toastr.error('Giỏ hàng của bạn rỗng, vui lòng thêm sản phẩm', 'Lỗi');
                    return;
                }

                // Redirect to the checkout page
                window.location.href = '/checkout'; // Thay thế bằng route checkout chính xác
            });

            // Existing code
        });

        fetchAndRenderCart()
    });

