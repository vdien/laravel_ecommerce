<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    //
    public function Index()
    {
        // Lấy tất cả các đơn hàng và kèm theo thông tin user
        $orders = Order::latest()->with('user')->get();

        // Đếm số lượng order của mỗi user
        $userOrderCounts = Order::select('user_id')
            ->selectRaw('count(*) as order_count')
            ->groupBy('user_id')
            ->pluck('order_count', 'user_id');

        // Thêm số lượng order vào mỗi order
        $ordersWithCount = $orders->map(function ($order) use ($userOrderCounts) {
            $order->user_order_count = $userOrderCounts[$order->user_id] ?? 0;
            return $order;
        });

        return response()->json(['data' => $ordersWithCount]);
    }
    public function CompeleteOrder()
    {

        $orders = Order::latest()->get();
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
    public function updateOrderStatus(Request $request){

        // Mảng ánh xạ status đến title và class
        $statusObj = [
            1 => ['title' => 'Chờ xử lý', 'class' => 'bg-label-warning'],
            2 => ['title' => 'Đã xác nhận', 'class' => 'bg-label-primary'],
            3 => ['title' => 'Đang giao hàng', 'class' => 'bg-label-info'],
            4 => ['title' => 'Thành Công', 'class' => 'bg-label-success'],
            5 => ['title' => 'Trả hàng', 'class' => 'bg-label-danger'],
            6 => ['title' => 'Đã hủy', 'class' => 'bg-label-secondary']

        ];

        $order = Order::find($request->order_id);
        if ($request->status == 4) {
            $order->payment_status = 1; // Cập nhật trạng thái thanh toán
        }

        if (($request->status == 5 || $request->status == 6) && $order->payment_method == "COD") {
            $order->payment_status = 4; // Cập nhật trạng thái thanh toán
        }
        $order->status = $request->status;
        $order->shipping_brand = $request->shipping_brand;
        $order->tracking_number = $request->tracking_number;
        $order->save();

        // Cập nhật log hoạt động vận chuyển
        $shippingActivity = json_decode($order->shipping_activity, true);
        $shippingActivity[] = [
            'event' => $statusObj[$request->status]['title'],
            'timestamp' => Carbon::now()->toDateTimeString()
        ];

        $order->shipping_activity = json_encode($shippingActivity);
        $order->save();

        $orders = Order::latest()->with('user')->get();

        // Đếm số lượng order của mỗi user
        $userOrderCounts = Order::select('user_id')
            ->selectRaw('count(*) as order_count')
            ->groupBy('user_id')
            ->pluck('order_count', 'user_id');

        // Thêm số lượng order vào mỗi order
        $ordersWithCount = $orders->map(function ($order) use ($userOrderCounts) {
            $order->user_order_count = $userOrderCounts[$order->user_id] ?? 0;
            return $order;
        });

        return response()->json(['data' => $ordersWithCount]);
    }
}
