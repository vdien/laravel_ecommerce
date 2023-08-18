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
        $products = Product::latest()->get();
        return view('admin.layout.product.allproducts', compact('products'));
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
            'product_img' => 'required|image|max:2048',
        ]);

        $image = $request->product_img;
        $img_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $request->product_img->move(public_path('upload'), $img_name);
        $img_url = 'upload/' . $img_name;

        $category_id = $request->product_category_id;
        $subcategory_id = $request->product_subcategory_id;

        $category_name = Category::where('id', $category_id)->value('category_name');
        $subcategory_name = Subcategory::where('id', $subcategory_id)->value('subcategory_name');
        Product::create([
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
            'slug' => strtolower(str_replace(' ', '-', $request->product_name)),
        ]);
        Category::where('id', $category_id)->increment('product_count', 1);
        Subcategory::where('id', $subcategory_id)->increment('product_count', 1);
        return redirect(route('allproducts'))->with('message', 'Product Added Successfully!');
    }

    public function EditProductImg($id)
    {
        $product_info = Product::findOrFail($id);
        return view('admin.layout.product.editproductimg', compact('product_info'));
    }
    public function UpdateProductImg(Request $request)
    {
        $request->validate(
            [
                'product_img' => 'required|image|max:2048',
            ]
        );
        $id = $request->product_id;
        $image = $request->product_img;
        $img_name = hexdec(uniqid()) . '.' . $image->getClientOriginalExtension();
        $request->product_img->move(public_path('upload'), $img_name);
        $img_url = 'upload/' . $img_name;
        Product::findOrFail($id)->update([
            'product_img' => $img_url,
        ]);
        return redirect(route('allproducts'))->with('message', 'Product Update Successfully!');
    }

    public function EditProduct($id)
    {
        $product_info = Product::findOrFail($id);
        $categories = Category::latest()->get();
        $subcategories = Subcategory::latest()->get();
        return view('admin.layout.product.editproduct', compact('product_info', 'categories', 'subcategories'));
    }
    public function UpdateProduct(Request $request)
    {

        $id = $request->product_id;
        $category_id = $request->product_category_id;
        $subcategory_id = $request->product_subcategory_id;
        $category_name = Category::where('id', $category_id)->value('category_name');
        $subcategory_name = Subcategory::where('id', $subcategory_id)->value('subcategory_name');
        Product::findOrFail($id)->update([
            'product_name' => $request->product_name,
            'product_short_des' => $request->product_short_description,
            'product_long_des' => $request->product_long_description,
            'price' => $request->product_price,
            'product_category_name' => $category_name,
            'product_subcategory_name' => $subcategory_name,
            'product_category_id' => $category_id,
            'product_subcategory_id' => $subcategory_id,
            'quantity' => $request->product_quantity,
            'slug' => strtolower(str_replace(' ', '-', $request->product_name)),
        ]);
        return redirect(route('allproducts'))->with('message', 'Product Updated Successfully!');
    }
    public function DeleteProduct($id)
    {
        $img = Product::where('id', $id)->value('product_img');
        unlink($img);
        $category_id = Product::where('id', $id)->value('product_category_id');
        $subcategory_id = Product::where('id', $id)->value('product_subcategory_id');
        Product::findOrFail($id)->delete();
        Category::where('id', $category_id)->decrement('product_count', 1);
        Subcategory::where('id', $subcategory_id)->decrement('product_count', 1);
        return redirect()->route('allproducts')->with('message', 'Product Deleted Successfully!');
    }
}
