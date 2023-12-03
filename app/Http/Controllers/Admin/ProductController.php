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
            'product_long_description' => 'required',
            'product_short_description' => 'required',
            'product_category_id' => 'required',
            'product_subcategory_id' => 'required',
        ]);

        // Get the uploaded images
        $images = $request->file('product_images');
        $images_child = $request->file('product_images_child');

        $imageUrls = [];
        $imageChildUrls = [];

            foreach ($images as $image) {
                // Generate a unique filename for each image
                $img_name = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                // Move each image to the public 'upload' directory
                $image->move(public_path('upload'), $img_name);
                // Construct the URL of each uploaded image
                $img_url = 'upload/' . $img_name;
                // Store each image URL in the array
                $imageUrls = $img_url;
            }
            // Update the product's image URLs in the database as a JSON array

            foreach ($images_child as $image) {
                // Generate a unique filename for each image
                $img_name = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                // Move each image to the public 'upload' directory
                $image->move(public_path('upload'), $img_name);
                // Construct the URL of each uploaded image
                $img_url = 'upload/' . $img_name;
                // Store each image URL in the array
                $imageChildUrls[] = $img_url;
            }
            // Update the product's image URLs in the database as a JSON array
        $category_id = $request->product_category_id;
        $subcategory_id = $request->product_subcategory_id;

        $category_name = Category::where('id', $category_id)->value('category_name');
        $subcategory_name = Subcategory::where('id', $subcategory_id)->value('subcategory_name');

        // Create the product and get its ID
        $product = Product::create([
            'product_name' => $request->product_name,
            'product_short_des' => $request->product_short_description,
            'product_long_des' => $request->product_long_description,
            'price' => $request->product_price,
            'product_category_name' => $category_name,
            'product_subcategory_name' => $subcategory_name,
            'product_category_id' => $category_id,
            'product_subcategory_id' => $subcategory_id,
            'product_img' => $imageUrls,
            'product_img_child' => json_encode($imageChildUrls),
            'slug' => strtolower(str_replace(' ', '-', $request->product_name)),
        ]);

        // Process the dynamically added size and quantity fields
        foreach ($request->input('size', []) as $key => $size) {
            $quantity = $request->input('quantity')[$key];

            // Create and associate the size and quantity with the product
            $product->sizes()->create([
                'size' => $size,
                'quantity' => $quantity,
            ]);
        }

        Category::where('id', $category_id)->increment('product_count', 1);
        Subcategory::where('id', $subcategory_id)->increment('product_count', 1);

        return redirect(route('allproducts/{}'))->with('message', 'Product Added Successfully!');
    }

    public function EditProduct($id)
    {

        $product_info = Product::findOrFail($id);
        $categories = Category::latest()->get();
        $sizes = $product_info->sizes; // Retrieve current sizes and quantities

        $subcategories = Subcategory::latest()->get();
        return view('admin.layout.product.editproduct', compact('product_info', 'categories', 'subcategories', 'sizes'));
    }
    public function UpdateProduct(Request $request)
    {
        $id = $request->product_id;
        $category_id = $request->product_category_id;
        $subcategory_id = $request->product_subcategory_id;
        $category_name = Category::where('id', $category_id)->value('category_name');
        $subcategory_name = Subcategory::where('id', $subcategory_id)->value('subcategory_name');
        $product = Product::findOrFail($id);
        $product->sizes()->delete();
        // Get the uploaded images
        $images = $request->file('product_images');
        $images_child = $request->file('product_images_child');


        $imageChildUrls = [];
        if ($images) {
            foreach ($images as $image) {
                // Generate a unique filename for each image
                $img_name = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                // Move each image to the public 'upload' directory
                $image->move(public_path('upload'), $img_name);
                // Construct the URL of each uploaded image
                $img_url = 'upload/' . $img_name;
                $imageUrls = $img_url;
            }
            // Update the product's image URLs in the database as a JSON array
        } else {
            $imageUrls = Product::where('id', $id)->value('product_img');
        }

        if ($images_child) {
            foreach ($images_child as $image) {
                // Generate a unique filename for each image
                $img_name = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                // Move each image to the public 'upload' directory
                $image->move(public_path('upload'), $img_name);
                // Construct the URL of each uploaded image
                $img_url = 'upload/' . $img_name;
                // Store each image URL in the array
                $imageChildUrls[] = $img_url;
            }
            // Update the product's image URLs in the database as a JSON array
        } else {
            $imageChildUrls = json_decode(Product::where('id', $id)->value('product_img_child'), true);
        }


        Product::findOrFail($id)->update([
            'product_img' => $imageUrls,
            'product_img_child' => json_encode($imageChildUrls),
            'product_name' => $request->product_name,
            'product_short_des' => $request->product_short_description,
            'product_long_des' => $request->product_long_description,
            'price' => $request->product_price,
            'product_category_name' => $category_name,
            'product_subcategory_name' => $subcategory_name,
            'product_category_id' => $category_id,
            'product_subcategory_id' => $subcategory_id,
            'slug' => strtolower(str_replace(' ', '-', $request->product_name)),
        ]);
        // Update sizes and quantities
        foreach ($request->input('size', []) as $key => $size) {
            $quantity = $request->input('quantity')[$key];

            // Create and associate the size and quantity with the product
            $product->sizes()->updateOrCreate([
                'size' => $size,
                'quantity' => $quantity,
            ]);
        }
        return redirect(route('editproduct', $id) )->with('message', 'Product Updated Successfully!');
    }
    public function DeleteProduct($id)
    {
        $img = Product::where('id', $id)->value('product_img');
        // unlink($img);
        $category_id = Product::where('id', $id)->value('product_category_id');
        $subcategory_id = Product::where('id', $id)->value('product_subcategory_id');
        Product::findOrFail($id)->delete();
        Category::where('id', $category_id)->decrement('product_count', 1);
        Subcategory::where('id', $subcategory_id)->decrement('product_count', 1);
        return redirect()->route('allproducts')->with('message', 'Product Deleted Successfully!');
    }
}
