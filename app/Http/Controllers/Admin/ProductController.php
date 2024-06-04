<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class ProductController extends Controller
{
    //
    public function Index()
    {
        $subCategory = Subcategory::get();
        return view('admin.layout.product.allproducts', compact('subCategory'));
    }
    public function getProductJson()
    {
        $products = Product::with(['subcategory', 'sizes'])->latest()->get();
        return response()->json(['data' => $products]);
    }
    public function AddProduct()
    {
        $categories = Category::latest()->get();
        $subcategories = Subcategory::latest()->get();
        return view('admin.layout.product.addproduct', compact('categories', 'subcategories'));
    }
    public function StoreProduct(Request $request)
    {
        // Get the uploaded images
        $images = $request->file('product_images');
        $images_child = $request->file('product_images_child');

        $imageUrls = [];
        $imageChildUrls = [];

        foreach ($images as $image) {
            // Generate a unique filename for each image
            $img_name = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            // Move each image to the public 'upload' directory
            $image->move(public_path('dashboard/img/ecommerce-product-images/product'), $img_name);
            // Construct the URL of each uploaded image
            // Store each image URL in the array
            $imageUrls = $img_name;
        }
        // Update the product's image URLs in the database as a JSON array

        foreach ($images_child as $image) {
            // Generate a unique filename for each image
            $img_name = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
            // Move each image to the public 'upload' directory
            $image->move(public_path('dashboard/img/ecommerce-product-images/child-product'), $img_name);
            // Construct the URL of each uploaded image
            // Store each image URL in the array
            $imageChildUrls[] = $img_name;
        }
        // Update the product's image URLs in the database as a JSON array
        $subcategory_id = $request->subcategory_product;
        $shortDescription = $request->input('short-description-input');
        $longDescription = $request->input('long-description-input');


        // Create the product and get its ID
        $product = Product::create([
            'product_name' => $request->product_name,
            'product_short_des' => $shortDescription,
            'product_long_des' => $longDescription,
            'price' => $request->product_price,
            'discount_price' => $request->product_discount_price,
            'stock' => $request->input('product_stock'),
            'sku' => $request->productSku,
            'product_subcategory_id' => $subcategory_id,
            'product_img' => $imageUrls,
            'product_img_child' => json_encode($imageChildUrls),
            'status' => $request->product_status,
            'tags' => $request->input('ecommerce_product_tags'),
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

        $products = Product::with(['subcategory', 'sizes'])->get();
        return response()->json($products);
    }


    public function UpdateProduct(Request $request)
    {
        $imageUrls = [];
        $imageChildUrls = [];

        $product = Product::findOrFail($request->edit_product_id);
        if ($request->hasFile('edit_product_images')) {
            $oldImagePath = public_path('dashboard/img/ecommerce-product-images/product' . $product->product_image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
            $images = $request->file('edit_product_images');
            foreach ($images as $image) {
                // Generate a unique filename for each image
                $img_name = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                // Move each image to the public 'upload' directory
                $image->move(public_path('dashboard/img/ecommerce-product-images/product'), $img_name);
                // Construct the URL of each uploaded image
                // Store each image URL in the array
                $imageUrls = $img_name;
            }
            $product->product_img = $imageUrls;

        }
        if ($request->hasFile('edit_product_images_child')) {
            foreach ($product->product_img_child as $child_images) {
                $oldImagePath = public_path('dashboard/img/ecommerce-product-images/child-product' . $child_images);
                if (File::exists($oldImagePath)) {
                    File::delete($oldImagePath);
                }
            }
            // Get the uploaded images
            $images_child = $request->file('edit_product_images_child');
            // Update the product's image URLs in the database as a JSON array
            foreach ($images_child as $image) {
                // Generate a unique filename for each image
                $img_name = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                // Move each image to the public 'upload' directory
                $image->move(public_path('dashboard/img/ecommerce-product-images/child-product'), $img_name);
                // Construct the URL of each uploaded image
                // Store each image URL in the arrayx
                $imageChildUrls[] = $img_name;
            }
            $product->product_img_child = json_encode($imageChildUrls);
        }


        $product->product_name = $request->edit_product_name;
        $product->product_short_des = $request->input('edit-short-description-input');
        $product->product_long_des = $request->input('edit-long-description-input');
        $product->price = $request->edit_product_price;
        $product->discount_price = $request->edit_product_discount_price;
        $product->stock = $request->input('edit_product_stock');
        $product->sku = $request->edit_productSku;
        $product->product_subcategory_id = $request->edit_subcategory_product;
        $product->status = $request->edit_product_status;
        $product->tags = $request->input('edit_product_tags');
        $product->slug =  strtolower(str_replace(' ', '-', $request->edit_product_name));

        // Update sizes and quantities
        $product->sizes()->delete();
        foreach ($request->input('size', []) as $key => $size) {
            $quantity = $request->input('quantity')[$key];
            // Create and associate the size and quantity with the product
            $product->sizes()->updateOrCreate([
                'size' => $size,
                'quantity' => $quantity,
            ]);
        }
        $product->save();
        $products = Product::with(['subcategory', 'sizes'])->get();
        return $products;
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
