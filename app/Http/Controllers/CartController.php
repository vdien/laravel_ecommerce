<?php
namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Subcategory;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $product_info = Product::findOrFail(1);
        $cartItems = Session::get('cart', []);
        return view('cart.index', compact('cartItems', 'product_info'));

    }

    public function addToCart(Request $request)
    {
        $productId = $request->product_id; // You should validate and sanitize the input data
        $product = Product::findOrFail($productId);
        $subcategory = Subcategory::findOrFail($product->product_subcategory_id);
        $cart = Session::get('cart', []);
        if (!$product) {
            // Handle the case where the product is not found
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }
        // Check if the product with the same product_id and size already exists in the cart
        $existingCartItemKey = null;

        foreach ($cart as $key => $cartItem) {
            if ($cartItem['product_id'] == $product->id && $cartItem['size'] == $request->size) {
                $existingCartItemKey = $key;
                break;
            }
        }
        if ($existingCartItemKey !== null) {
            // Product with the same product_id and size already exists in the cart
            // Update the quantity of the existing item
            $cart[$existingCartItemKey]['quantity'] += $request->quantity;
        } else {
            $cartItem = [
                'product_subcategory' => $subcategory->subcategory_name,
                'product_id' => $product->id,
                'product_img' => $product->product_img,
                'name' => $product->product_name,
                'price' => $product->price,
                'quantity' => 1,
                'size' => $request->size
                // Add other details you need
            ];
            $cart[] = $cartItem;
        }

        Session::put('cart', $cart);
        $cartItems = Session::get('cart', []);
        session(['cart_count' => count($cartItems)]);
        return response()->json(['success' => true, 'cart_count' => session('cart_count', 0)]);
    }
    public function updateQuantity(Request $request)
{
    $productId = $request->product_id;
    $size = $request->size;
    $newQuantity = $request->quantity;

    // Fetch the product by ID
    $product = Product::findOrFail($productId);

    // Fetch the specific size for the product
    $productSize = $product->sizes()->where('size', $size)->first();

    if (!$productSize) {
        return response()->json([
            'success' => false,
            'message' => 'Size not found for this product.'
        ]);
    }

    // Check if the requested quantity exceeds the available product size quantity
    if ($productSize->quantity < $newQuantity) {
        return response()->json([
            'success' => false,
            'message' => 'Requested quantity exceeds available stock for this size.'
        ]);
    }

    // Update the quantity of the cart item
    $cart = Session::get('cart', []);

    foreach ($cart as $key => $cartItem) {
        if ($cartItem['product_id'] == $productId && $cartItem['size'] == $size) {
            // If the new quantity is 0 or less, remove the cart item
            if ($newQuantity <= 0) {
                unset($cart[$key]);
            } else {
                $cart[$key]['quantity'] = $newQuantity;
            }

            // Reindex the array keys
            $cart = array_values($cart);

            // Save the updated cart back to the session
            Session::put('cart', $cart);

            // Return the updated cart data
            return response()->json([
                'success' => true,
                'message' => 'Quantity updated.',
                'cart_items' => $cart,
                'cart_count' => count($cart) // Update the cart_count
            ]);
        }
    }

    return response()->json([
        'success' => false,
        'message' => 'Cart item not found.'
    ]);
}

    public function getCartItems()
    {
        $cartItems = Session::get('cart', []);


        // Return the cart items as a JSON response
        return response()->json([
            'success' => true,
            'cart_items' => $cartItems,
            'cart_count' => count($cartItems)
        ]);
    }
    public function calculateSubtotal()
    {
        $cart = Session::get('cart', []);
        $subtotal = 0;

        foreach ($cart as $cartItem) {
            $subtotal += $cartItem['quantity'] * $cartItem['price'];
        }

        return $subtotal;
    }

    public function removeCartItem(Request $request)
    {
        $productId = $request->input('product_id');
        $size = $request->input('size');

        $cart = Session::get('cart', []);

        foreach ($cart as $key => $cartItem) {
            if ($cartItem['product_id'] == $productId && $cartItem['size'] == $size) {
                unset($cart[$key]);
                break;
            }
        }
        $cart = array_values($cart);

        Session::put('cart', $cart);

        $cartCount = count($cart);

        return response()->json([
            'success' => true,
            'message' => 'Item removed from cart.',
            'cart_count' => $cartCount,
        ]);
    }

    public function processCheckout(Request $request)
    {
        // Validate the request data if needed

        $cartItemsData = Session::get('cart', []);
        $subtotal = 0;

        $shippingActivity[] = [
            'event' => "Chờ xử lý",
            'timestamp' => Carbon::now()->toDateTimeString()
        ];
        foreach ($cartItemsData as $cartItem) {
            $subtotal += $cartItem['quantity'] * $cartItem['price'];
        }
        $order = new Order([
            'user_id' =>  auth()->user()->id,
            'name' => $request->input('name'),
            'phone' => $request->input('phone'),
            'shipping_activity'=> json_encode($shippingActivity),
            'payment_method'=>"COD",
            'payment_status'=>2,
            'address' => $request->input('address') . " " . $request->input('ward') . " " . $request->input('district') . " " . $request->input('city'),
            'cart_items' => $cartItemsData,
            'subtotal' => $subtotal,
            'status' => 1
        ]);
        $order->save();
          // Update product sizes' quantities
        foreach ($cartItemsData as $cartItem) {
        $product = Product::findOrFail($cartItem['product_id']);
        $productSize = $product->sizes()->where('size', $cartItem['size'])->first();

        if ($productSize) {
            $updatedQuantity = $productSize->quantity - $cartItem['quantity'];
            $productSize->update(['quantity' => $updatedQuantity]);
        }
    }
        session(['cart_count' => 0]);
        session(['cart' => []]);

        return response()->json(['success' => true]);
    }
    public function thankyou()
    {
        return view('user.thankyou');
    }
    public function findOrders()
    {
        return view('user.findorders');

    }
    public function findOrderByPhone(Request $request)
    {
        $phoneNumber = $request->input('phone');
        $orders = Order::where('phone', $phoneNumber)->latest()->get();
        return response()->json(['orders' => $orders]);
    }
}
