<?php
namespace App\Http\Controllers;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index()
    {
        $product_info = Product::findOrFail(1);
        $cartItems = Session::get('cart', []);
        return view('cart.index', compact('cartItems','product_info'));

    }

    public function addToCart(Request $request)
    {
        $productId = $request->product_id; // You should validate and sanitize the input data
        $product = Product::findOrFail($productId);
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
            'product_subcategory'=> $product->product_subcategory_name,
            'product_id' => $product->id,
            'product_img' => $product->product_img,
            'name' => $product->product_name,
            'price' => $product->price,
            'quantity' => $request->quantity,
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

    return response()->json(['success' => false, 'message' => 'Cart item not found.']);
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
    

}
