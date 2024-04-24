<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function Index()
    {

        $categories = Category::latest()->get();
        return view('admin.layout.category.allcategory', compact('categories'));
    }
    public function GetCategoryJson(){
        $categories = Category::latest()->get()->toArray();
    return response()->json(['data' => $categories]);
    }
    public function AddCategory()
    {
        return view('admin.layout.category.addcategory');
    }
    public function StoreCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories',
            'ecommerce_category_image' => 'image|mimes:jpeg,png,jpg,gif|max:2048' // Adjust the validation rules as per your requirements

        ]);
        // Handle category image upload
        if ($request->hasFile('ecommerce_category_image')) {
            // Get the file from the request
            $image = $request->file('ecommerce_category_image');

            // Generate a unique filename for the image
            $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();

            // Store the image in the storage folder
            $image->move(public_path('dashboard/img/ecommerce-category-images/category'), $filename);

            // You may want to save the filename or path in the database
            // For example, if you have a 'category_image' column in your categories table
            $categoryImage = $filename;
        } else {
            // Default image if no image is provided
            $categoryImage = 'default_image.jpg';
        }
        $description = $request->input('ecommerce_category_description', 'Default description');

        $category = Category::create([
            'category_name' => $request->category_name,
            'slug' => strtolower(str_replace(' ', '-', $request->ecommerce_category_slug)),
            'description' => $description,
            'category_image' => $categoryImage,
            'category_status' => $request->ecommerce_category_status
            // Add other fields as needed
        ]);
        return redirect()->route('allcategory')->with('message', 'Category Added Successfully');
    }
    public function EditCategory($id)
    {
        $category_info = Category::findOrFail($id);
        return view('admin.layout.category.editcategory', compact('category_info'));
    }
    public function UpdateCategory(Request $request)
    {
        $category_id = $request->category_id;
        $request->validate([
            'category_name' => 'required|unique:categories'
        ]);
        Category::findOrFail($category_id)->update([
            'category_name' => $request->category_name,
            'slug' => strtolower(str_replace(' ', '-', $request->category_name))
        ]);
        return redirect()->route('allcategory')->with('message', 'Category Update Successfully!');
    }
    public function DeleteCategory($id)
    {
        Category::findOrFail($id)->delete();
        return redirect()->route('allcategory')->with('message', 'Category Deleted Successfully!');
    }
}
