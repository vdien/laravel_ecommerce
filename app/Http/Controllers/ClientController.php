<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Size;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClientController extends Controller
{
    //
    public function Shop(Request $request)
{
    $categories = Category::with('subcategories')->get();
    $query = Product::query();

    // Apply category filter if provided
    if ($request->has('category_id') && !empty($request->input('category_id'))) {
        $categoryId = $request->input('category_id');
        $subcategoriesIds = Subcategory::where('category_id', $categoryId)->pluck('id');
        $query->whereIn('product_subcategory_id', $subcategoriesIds);
    }

    // Apply subcategory filter if provided
    if ($request->has('subcategory_id') && !empty($request->input('subcategory_id'))) {
        $subcategoryId = $request->input('subcategory_id');
        $query->where('product_subcategory_id', $subcategoryId);
    }

    // Apply size filter
    if ($request->has('size') && !empty($request->input('size'))) {
        $size = $request->input('size');
        $productIds = Size::where('size', $size)->pluck('product_id');
        $query->whereIn('id', $productIds);
    }

    // Apply sorting
    if ($request->has('sort_by') && !empty($request->input('sort_by'))) {
        switch ($request->input('sort_by')) {
            case 'latest':
                $query->orderBy('created_at', 'desc');
                break;
            case 'price-asc':
                $query->orderBy('price', 'asc');
                break;
            case 'price-desc':
                $query->orderBy('price', 'desc');
                break;
        }
    }

    $products = $query->paginate(9); // Pagination

    if ($request->ajax()) {
        return view('partials.product-list', compact('products'));
    }

    return view('user.shop', compact('products', 'categories'));
}


    public function SingleProduct($id)
    {
        $popular_product = Product::latest()->get();
        $product_info = Product::findOrFail($id);
        $sizes = Size::where('product_id', $product_info->id)->get();
        return view('user.product', compact('product_info', 'popular_product', 'sizes'));
    }

    public function Cart()
    {
        return view('user.cart');
    }
    public function Checkout()
    {
        return view('user.checkout');
    }
    public function Contact()
    {
        return view('user.contact');
    }
    public function Blog()
    {
        return view('user.blog');
    }
    public function UserProfile()
    {
        return view('user.userprofile');
    }
    public function NewRelease()
    {
        return view('user.newrelease');
    }
    public function TodayDeal()
    {
        return view('user.todaysdeal');
    }
    public function CustomerService()
    {
        return view('user.customerservice');
    }
    public function getOrdersByStatus(Request $request)
{
    $userId = auth()->id();
    $status = $request->status;
    $orders = Order::where('user_id', $userId)->latest();

    if ($status !== 'all') {
        $orders->where('status', $status);
    }

    $orders = $orders->get();
    $html = '';

    $statusObj = [
        1 => ['title' => 'Chờ xử lý', 'class' => 'badge-warning'],
        2 => ['title' => 'Đã xác nhận', 'class' => 'badge-primary'],
        3 => ['title' => 'Đang giao hàng', 'class' => 'badge-info'],
        4 => ['title' => 'Thành công', 'class' => 'badge-success'],
        5 => ['title' => 'Trả hàng', 'class' => 'badge-danger'],
        6 => ['title' => 'Đã hủy', 'class' => 'badge-secondary'],
    ];

    foreach ($orders as $order) {
        $orderStatus = $statusObj[$order->status] ?? ['title' => 'Unknown', 'class' => ''];

        $html .= '
        <div class="card mt-4">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <div>
                                <div class="order-id">
                                    <strong>Đơn hàng:</strong> <span>#' . $order->id . '</span>
                                    <span class="deliverytime ml-2">Đặt lúc: ' . $order->created_at->format('H:i - l (d/m)') . '</span>
                                </div>
                            </div>
                            <span class="badge ' . $orderStatus['class'] . '">' . $orderStatus['title'] . '</span>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <strong>Danh sách sản phẩm</strong>
                                <div class="row">';

        foreach ($order->cart_items as $item) {
            $html .= '
                <div class="col-md-4">
                    <a href="/lich-su-mua-hang/don-hang-' . $order->id . '">
                        <img class="img-fluid mb-4" style="width:90px;" src="' . asset('/dashboard/img/ecommerce-product-images/product/' . $item['product_img']) . '" alt="Sản phẩm">
                    </a>
                </div>
                <div class="col-md-8">
                    <a href="#" class="text-dark" style="font-size: 12pt">' . $item['name'] . '<span style="font-size: 10pt;color: gray;"> (size:' . $item['size'] . ')</span></a>
                    <p class="mb-0">Giá: <span class="">' . number_format($item['price']) . '₫</span></p>
                    <p>Số lượng: <span class="">' . $item['quantity'] . '</span></p>
                </div>';
        }

        $html .= '
                                </div>
                            </div>
                            <div class="col-md-6">
                                <strong>Thông tin liên hệ</strong>
                                <p class="mb-0">Tên: <span class="">' . $order->name . '</span></p>
                                <p class="mb-0">Số điện thoại: <span class="">' . $order->phone . '</span></p>
                                <p class="mb-0">Địa chỉ: <span class="">' . $order->address . '</span></p>
                                <p class="mb-0">Tổng tiền thanh toán: <span class="">' . number_format($order->subtotal). 'đ</span></p>
                                <p class="mb-0">Phương thức thanh toán: <span class="">' .$order->payment_method . '</span></p>

                                <p class="mb-0">Tình trạng thanh toán: <span class="">' . ($order->payment_status == 1 ? "Đã thanh toán" : "Chưa thanh toán") . '</span></p>';

        if ($order->shipping_brand || $order->tracking_number) {
            $html .= '
                <div style="margin-top: 10px;">
                    <strong>Thông tin vận chuyển</strong>';
            if ($order->shipping_brand) {
                $html .= '<p class="mb-0">Đơn vị vận chuyển: ' . $order->shipping_brand . '</p>';
            }
            if ($order->tracking_number) {
                $html .= '<p>Mã vận đơn: ' . $order->tracking_number . '</p>';
            }
            $html .= '</div>';
        }

        $html .= '
                                <strong>Hoạt động đơn hàng</strong>
                                <ul class="timeline" style="list-style-type: none; padding: 0;">';

        foreach (json_decode($order->shipping_activity) as $activity) {
            $html .= '
                <li style="margin-bottom: 10px;">
                    <span class="badge badge-info" style="margin-right: 10px;">' . $activity->event . '</span>
                    <span>' . date('H:i - d/m/Y', strtotime($activity->timestamp)) . '</span>
                </li>';
        }

        $html .= '
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>';
    }

    return response()->json(['html' => $html]);
}

    // Controller method
    public function searchProduct(Request $request)
    {
        $searchTerm = $request->input('search');
        $products = Product::where('product_name', 'like', '%' . $searchTerm . '%')->limit(5)->get();

        $output = '
    <div class="search-results-container overflow-auto" style="max-height: 400px;">'; // Tạo container với thanh cuộn

        if ($products->count() > 0) {
            foreach ($products as $product) {
                $output .= '
            <div class="d-flex mb-3 border rounded p-2 bg-white text-decoration-none text-dark">
                <a href="' . route('singleproduct', [$product->id, $product->slug]) . '" class="d-flex w-100 text-decoration-none text-dark">
                    <div class="me-3 flex-shrink-0 mr-3">
                        <img src="' . asset('/dashboard/img/ecommerce-product-images/product/' . $product->product_img) . '" style="width: 100px; height: 100px; object-fit: cover;" alt="">
                    </div>
                    <div class="d-flex flex-column justify-content-center">
                        <h5 class="mb-1 fs-6">' . $product->product_name . '</h5>
                        <p class="mb-0 text-muted">' . number_format($product->price, 0, '.', ',') . ' VND</p>
                    </div>
                </a>
            </div>';
            }
        } else {
            $output .= '<p>No products found.</p>';
        }

        $output .= '</div>'; // Đóng container

        return response()->json(['html' => $output]);
    }



}
