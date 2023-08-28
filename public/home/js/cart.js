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
                    toastr.error('Failed to fetch cart items.', 'Error');
                }
            },
            error: function () {
                toastr.error('An error occurred while fetching cart items.', 'Error');
            }
        });
    }
    $(function () {
        $('[name=add-to-cart-form]').on('submit', function (event) {
            event.preventDefault();
    
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
                        toastr.success('Product added to cart.', 'success');
                    } else {
                        toastr.success('Failed to add product to cart.', 'error');
                    }
                },
                error: function () {
                    toastr.success('An error occurred while adding the product to cart.',
                        'error');
                }
            });
        });
    });
    function updateCartList(cartItems) {
        var cartList = $('.cart-list');
        cartList.empty();
    
        if (cartItems.length === 0) {
            // Show an empty cart message
            cartList.append('<span>Your cart is empty.</span>');
            return;
        }
    
        // Loop through the cart items and add them to the cart list
        for (var i = 0; i < cartItems.length; i++) {
            var cartItem = cartItems[i];
            var itemHTML = `
            <div class="single-cart-item">
                <a href="#" class="product-image">
                    <img class="hover-img" src="http://127.0.0.1:8000/${cartItem.product_img}" alt="">
                    <!-- Cart Item Desc -->
                    <div class="cart-item-desc">
                        <span class="product-remove remove-cart-item" data-product-id="${cartItem.product_id}" data-size="${cartItem.size}"><i class="fa fa-close" aria-hidden="true"></i></span>
                        <span class="badge">${cartItem.product_subcategory}<span>
                        <h6>${cartItem.name}</h6>
                        <p class="size">Size: ${cartItem.size}</p>
                        <p class="color">Quantity:${cartItem.quantity}</p>
                        <p class="price">$${cartItem.price}</p>
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
            cartList.append('<span>Your cart is empty.</span>');
            return;
        }
    
        // Loop through the cart items and add them to the cart list
        for (var i = 0; i < cartItems.length; i++) {
            var cartItem = cartItems[i];
            var itemHTML = `
                <tr>
                    <th scope="row">
                        <div class="p-2">
                            <img src="http://127.0.0.1:8000/${cartItem.product_img}"
                                alt="" width="70" class="img-fluid rounded shadow-sm">
                            <div class="ml-3 d-inline-block align-middle">
                                <h5 class="mb-0"> <a href="#"
                                        class="text-dark d-inline-block">${cartItem.name}</a>
                                </h5>
                                <span class="text-muted font-weight-normal font-italic">Size:
                                    ${cartItem.size}</span>
                            </div>
                        </div>
                    
                    <td class="align-middle">
                    <span class="quantity-decrease" name="quantity-decrease" style="cursor: pointer;"data-product-id="${cartItem.product_id}" data-size="${cartItem.size}" data-quantity="${cartItem.quantity}">-</span>
                    <strong><span class="quantity">${cartItem.quantity}</span></strong>
                    <input type="number" class="quantity-input" data-product-id="${cartItem.product_id}" data-size="${cartItem.size}" value="${cartItem.quantity}" hidden>
    
                 <span class="quantity-increase"  style="cursor: pointer;"data-product-id="${cartItem.product_id}" data-size="${cartItem.size}" >+</span>
                                </div>
                    </td>
                    <td class="align-middle"><strong>$${cartItem.price * cartItem.quantity}<strong></td>
                    <td class="align-middle"><a href="#" class="text-dark remove-cart-item" data-product-id="${cartItem.product_id}" data-size="${cartItem.size}" ><i
                                class="fa fa-trash"></i></a>
                    </td>
                </tr>
                 `;
            cartList.append(itemHTML);
        }
    }
    
    function updateCartItemQuantity(productId, size, newQuantity) {
        $.ajax({
            url: cartUpdatequantity,
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
                    toastr.success('Quantity updated.', 'Success');
                } else {
                    toastr.error('Failed to update quantity.', 'Error');
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
    
        $("[name='subtotal']").text('$' + subtotal.toFixed(2));
        Shipping = 0 ? $("[name='shipping']").text('FREE') : $("[name='shipping']").text('$' + Shipping.toFixed(2))
        $("[name='totalCart']").text('$' + total.toFixed(2));
    
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
                    toastr.success('Item removed from cart.', 'Success');
                } else {
                    toastr.error('Failed to remove item from cart.', 'Error');
                }
            },
            error: function () {
                toastr.error('An error occurred while removing the item from cart.', 'Error');
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
        fetchAndRenderCart()
    });
    
   