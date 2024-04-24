<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function Index()
    {
        $orders = Order::latest()->where('status', '!=', 'Hủy')->where('status', '!=', 'Thành công')->get();
        return view('admin.layout.orders.pendingorders', compact('orders'));
    }
    public function CompeleteOrder()
    {
        $orders = Order::latest()->where('status', 'Thành công')->get();
        return view('admin.layout.orders.pendingorders', compact('orders'));
    }
    public function CancelOrder()
    {
        $orders = Order::latest()->where('status', 'Hủy')->get();
        return view('admin.layout.orders.pendingorders', compact('orders'));
    }
    public function orderDetail($id)
    {
        $order = Order::findOrFail($id);
        $cart_items = $order->cart_items;

        return view('admin.layout.orders.orderdetail', compact('order', 'cart_items'));
    }
    public function updateStatus(Request $request)
    {
        // Validate the request data (you can add more validation rules as needed)
        $request->validate([
            'order_id' => 'required|exists:orders,id',
            'status' => 'required|in:Đã đóng gói,Đang vận chuyển,Thành công,Hủy,Chờ xác nhận',
        ]);

        // Update the order status
        $order = Order::find($request->input('order_id'));
        $oldStatus = $order->status;
        $newStatus = $request->input('status');

        // If the status is changing to "cancel" from a previous status
        if ($newStatus === 'Hủy' && $oldStatus !== 'Hủy') {
            // Get cart items from the order
            $cartItems = $order->cart_items;

            foreach ($cartItems as $cartItem) {
                $product = Product::findOrFail($cartItem['product_id']);
                $productSize = $product->sizes()->where('size', $cartItem['size'])->first();

                if ($productSize) {
                    // Increase the quantity for the respective size
                    $updatedQuantity = $productSize->quantity + $cartItem['quantity'];
                    $productSize->update(['quantity' => $updatedQuantity]);
                }
            }
        }

        // Update the order status
        $order->status = $newStatus;
        $order->save();

        // Return a response (you can customize this as needed)
        return response()->json(['message' => 'Order status updated successfully']);
    }


}
