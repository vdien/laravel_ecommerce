<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'Index')->name('Home');
});
Route::controller(ClientController::class)->group(function () {
    Route::get('/shop', 'Shop')->name('shop');
    Route::get('/shop', [ClientController::class, 'Shop'])->name('shop');
    Route::get('/shop/category/{categoryId}', [HomeController::class, 'filterByCategory'])->name('category');
    Route::get('/shop/subcategory/{subcategoryId}', [HomeController::class, 'filterBySubcategory'])->name('subcategory');
    Route::get('/single-product/{id}/{slug}', 'SingleProduct')->name('singleproduct');
    Route::get('/cartpage', 'Cart')->name('cartpage');
    Route::get('/user-profile', 'UserProfile')->name('userprofile');
    Route::get('/todays-deal;', 'TodaysDeal')->name('todaysdeal');
    Route::get('/customer-service', 'CustomerService')->name('customerservice');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout')->middleware('auth');
    Route::get('/contact', 'Contact')->name('contact');
    Route::get('/blog', 'Blog')->name('blog');
    Route::post('/search-product', 'searchProduct')->name('searchproduct');
    Route::get('/orders-by-status', [ClientController::class, 'getOrdersByStatus']);

});
Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/cart/add', 'addToCart')->name('cart.add');
    Route::get('/cart/get', [CartController::class, 'getCartItems'])->name('cart.get');
    Route::get('/cart/subtotal', [CartController::class, 'calculateSubtotal'])->name('cart.subtotal');
    Route::post('/cart/update_quantity', [CartController::class, 'updateQuantity'])->name('cart.update_quantity');
    Route::post('/cart/remove', [CartController::class, 'removeCartItem'])->name('cart.remove');
    Route::post('/cart/checkout', [CartController::class, 'processCheckout'])->name('cart.checkout');
    Route::get('/cart/thankyou', [CartController::class, 'thankyou'])->name('cart.thanks');
    Route::post('/orders/find', [CartController::class, 'findOrderByPhone'])->name('find.order.by.phone');
    Route::get('/orders/find', [CartController::class, 'findOrders'])->name('findorders');
});




Route::middleware(['auth',])->group(function () {

});
Route::get('/dashboard', function () {
})->middleware(['auth', 'verified', "role:user"])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/admin/dashboard', 'Index')->name("admindashboard");
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/admin/all-category', 'Index')->name("allcategory");
        Route::get('/admin/get-category-json', 'GetCategoryJson')->name("getcategoryjson");
        Route::post('/admin/store-category', 'StoreCategory')->name('storecategory');
        Route::post('/admin/update-category', 'UpdateCategory')->name('updatecategory');
        Route::get('/admin/delete-category/{id}', 'DeleteCategory')->name('deletecategory');
    });
    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/admin/all-subcategory', 'Index')->name("allsubcategory");
        Route::get('/admin/get-subcategory-json', 'GetSubCategoryJson')->name("getsubcategoryjson");
        Route::post('/admin/store-subcategory', 'StoreSubCategory')->name('storesubcategory');
        Route::post('/admin/update-subcategory', 'UpdateSubCategory')->name('updatesubcategory');
        Route::get('/admin/delete-subcategory/{id}', 'DeleteSubCategory')->name('deletesubcategory');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::get('/admin/all-products', 'Index')->name("allproducts");
        Route::get('/admin/all-products-json', 'getProductJson')->name("allproductsjson");
        Route::get('/admin/add-product', 'AddProduct')->name("addproduct");
        Route::post('/admin/store-product', 'StoreProduct')->name('storeproduct');
        Route::post('/admin/update-product', 'UpdateProduct')->name('updateproduct');
        Route::get('/admin/delete-product/{id}', 'DeleteProduct')->name('deleteproduct');
    });
    Route::controller(OrderController::class)->group(function () {
        Route::get('/admin/orders', 'Index')->name("allorders");
        Route::get('/admin/compelete-orders', 'CompeleteOrder')->name("completeOrder");
        Route::post('/update-status', 'updateOrderStatus')->name("updateStatus");
        Route::get('/admin/cancel-orders', 'CancelOrder')->name("cancelOrder");
        Route::get('/admin/order/{id}', 'orderDetail')->name("orderdetail");
        Route::post('/update-order-status', 'updateStatus')->name('update.order.status');



    });
});

require __DIR__ . '/auth.php';
