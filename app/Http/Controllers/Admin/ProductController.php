<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function Index()
    {
        return view('admin.layout.product.allproducts');
    }
    public function AddProduct()
    {
        $categories = Category::latest()->get();
        $subcategories = Subcategory::latest()->get();
        return view('admin.layout.product.addproduct', compact('categories', 'subcategories'));
    }
    public function StoreProduct(Request $request)
    {
        $request->validate([
            'product_name' => 'required|unique:products',
            'product_price' => 'required',
            'product_quantity' => 'required',
            'product_long_description' => 'required',
            'product_short_description' => 'required',
            'product_category_id' => 'required',
            'product_subcategory_id' => 'required',
            'product_img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->product_img;
        $img_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $request->product_img->move(public_path('upload'), $img_name);
        $img_url = 'upload/' . $img_name;

        $category_id = $request->product_category_id;
        $subcategory_id = $request->product_subcategory_id;

        $category_name = Category::where('id', $category_id)->value('category_name');
        $subcategory_name = Subcategory::where('id', $subcategory_id)->value('subcategory_name');
        Product::insert([
            'product_name' => $request->product_name,
            'product_short_des' => $request->product_short_description,
            'product_long_des' => $request->product_long_description,
            'price' => $request->product_price,
            'product_category_name' => $category_name,
            'product_subcategory_name' => $subcategory_name,
            'product_category_id' => $category_id,
            'product_subcategory_id' => $subcategory_id,
            'product_img' => $img_url,
            'quantity' => $request->product_quantity,
            'slug' => strtolower(str_replace('', '-', $request->subcategory_name)),
        ]);
        Category::where('id', $category_id)->increment('product_count', 1);
        Subcategory::where('id', $subcategory_id)->increment('product_count', 1);
        return redirect(route('allproducts'))->with('message', 'Product Added Successfully!');
    }
}
