<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\SubCategoryController;
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
    Route::get('/shop/category/{id}/{slug}', 'CategoryPage')->name('category');
    Route::get('/shop/subcategory/{id}/{slug}', 'SubCategoryPage')->name('subcategory');
    Route::get('/single-product/{id}/{slug}', 'SingleProduct')->name('singleproduct');
    Route::get('/cartpage', 'Cart')->name('cartpage');
    Route::get('/user-profile', 'UserProfile')->name('userprofile');
    Route::get('/todays-deal;', 'TodaysDeal')->name('todaysdeal');
    Route::get('/customer-service', 'CustomerService')->name('customerservice');
});
Route::controller(CartController::class)->group(function () {
    Route::get('/cart', 'index')->name('cart.index');
    Route::post('/cart/add', 'addToCart')->name('cart.add');
    Route::get('/cart/get', [CartController::class, 'getCartItems'])->name('cart.get');
    Route::get('/cart/subtotal', [CartController::class, 'calculateSubtotal'])->name('cart.subtotal');
    Route::post('/cart/update_quantity', [CartController::class, 'updateQuantity'])->name('cart.update_quantity');
    Route::post('/cart/remove', [CartController::class, 'removeCartItem'])->name('cart.remove');

});




Route::middleware(['auth', ])->group(function () {
    Route::controller(ClientController::class)->group(function () {
        
    });
});
Route::get('/dashboard', function () {
})->middleware(['auth', 'verified', "role:user"])->name('dashboard');


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth', 'role:admin')->group(function () {
    Route::controller(DashboardController::class)->group(function () {
        Route::get('/admin/dashboard', 'Index')->name("admindashboard");
    });
    Route::controller(CategoryController::class)->group(function () {
        Route::get('/admin/all-category', 'Index')->name("allcategory");
        Route::get('/admin/add-category', 'AddCategory')->name("addcategory");
        Route::post('/admin/store-category', 'StoreCategory')->name('storecategory');
        route::get('/admin/edit-category/{id}', 'EditCategory')->name('editcategory');
        Route::post('/admin/update-category', 'UpdateCategory')->name('updatecategory');
        Route::get('/admin/delete-category/{id}', 'DeleteCategory')->name('deletecategory');
    });
    Route::controller(SubCategoryController::class)->group(function () {
        Route::get('/admin/all-subcategory', 'Index')->name("allsubcategory");
        Route::get('/admin/add-subcategory', 'AddSubCategory')->name("addsubcategory");
        Route::post('/admin/store-subcategory', 'StoreSubCategory')->name('storesubcategory');
        route::get('/admin/edit-subcategory/{id}', 'EditSubCategory')->name('editsubcategory');
        Route::post('/admin/update-subcategory', 'UpdateSubCategory')->name('updatesubcategory');
        Route::get('/admin/delete-subcategory/{id}', 'DeleteSubCategory')->name('deletesubcategory');
    });
    Route::controller(ProductController::class)->group(function () {
        Route::get('/admin/all-products', 'Index')->name("allproducts");
        Route::get('/admin/add-product', 'AddProduct')->name("addproduct");
        Route::post('/admin/store-product', 'StoreProduct')->name('storeproduct');
        route::get('/admin/edit-product-image/{id}', 'EditProductImg')->name('editproductimg');
        Route::post('/admin/update-product-image', 'UpdateProductImg')->name('updateproductimg');
        route::get('/admin/edit-product/{id}', 'EditProduct')->name('editproduct');
        Route::post('/admin/update-product', 'UpdateProduct')->name('updateproduct');
        Route::get('/admin/delete-product/{id}', 'DeleteProduct')->name('deleteproduct');
    });
    Route::controller(OrderController::class)->group(function () {
        Route::get('/admin/pending-orders', 'Index')->name("pendingorders");
    });
});
Route::middleware('auth', 'role:admin')->group(
    function () {
        Route::controller(DashboardController::class)->group(function () {
            Route::get('/admin/dashboard', 'Index')->name("admindashboard");
        });
    }
);
require __DIR__ . '/auth.php';
