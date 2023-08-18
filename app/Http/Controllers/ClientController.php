<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ClientController extends Controller
{
    //
    public function Shop()
    {
        $products = Product::latest()->get();
        return view('user.shop', compact('products'));
    }
    public function CategoryPage($id)
    {
        $category = Category::findOrFail($id);
        $products = Product::where('product_category_id', $id)->latest()->get();
        return view('user.category', compact('category', 'products'),);
    }
    public function SubCategoryPage($id)
    {
        $subcategory = Subcategory::findOrFail($id);
        $products = Product::where('product_subcategory_id', $id)->latest()->get();
        return view('user.subcategory', compact('subcategory', 'products'),);
    }
    public function SingleProduct($id)
    {
        $popular_product = Product::latest()->get();
        $product_info = Product::findOrFail($id);
        return view('user.product', compact('product_info', 'popular_product'));
    }
    
    public function Cart()
    {
        return view('user.cart');
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
}
