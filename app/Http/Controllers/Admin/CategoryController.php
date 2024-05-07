<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class CategoryController extends Controller
{
    //
    public function Index()
    {

        $categories = Category::latest()->get();
        return view('admin.layout.category.allcategory', compact('categories'));
    }
    public function GetCategoryJson()
    {
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
        $categories = Category::all();

        // Return JSON response with updated data
        return response()->json($categories);
    }
    public function EditCategory($id)
    {
        $category_info = Category::findOrFail($id);
        return view('admin.layout.category.editcategory', compact('category_info'));
    }
    public function UpdateCategory(Request $request)
    {
        $request->validate([
            'edit_category_id' => 'required|exists:categories,id',
            'edit_category_name' => 'required|string|max:255',
            'edit_ecommerce_category_slug' => 'required|string|max:255',
            'edit_ecommerce_category_description' => 'nullable|string',
            'edit_ecommerce_category_status' => 'required|string|in:Scheduled,Publish,Inactive',
            'edit_ecommerce_category_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // adjust max file size as needed
        ]);

        $category = Category::findOrFail($request->edit_category_id);
        // Remove old image if it exists
        if ($request->hasFile('edit_ecommerce_category_image') && $category->category_image) {
            $oldImagePath = public_path('dashboard/img/ecommerce-category-images/category/' . $category->category_image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }
        $category->category_name = $request->edit_category_name;
        $category->slug = $request->edit_ecommerce_category_slug;
        $category->description = $request->edit_ecommerce_category_description;
        $category->category_status = $request->edit_ecommerce_category_status;

        if ($request->hasFile('edit_ecommerce_category_image')) {
            // Handle image upload
            $image = $request->file('edit_ecommerce_category_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('dashboard/img/ecommerce-category-images/category'), $imageName);
            $category->category_image = $imageName;
        }

        $category->save();
        // Fetch updated data
        $categories = Category::all();

        // Return JSON response with updated data
        return response()->json($categories);
    }
    public function DeleteCategory(Request $request)
    // Method to delete a category
    {
        $category_id = $request->input('categoryId');

        $category = Category::find($category_id);

        if (!$category) {
            return response()->json(['success' => false, 'message' => 'Category not found'], 404);
        }

        // Delete category image from storage if it exists
        if ($category->category_image) {
            Storage::delete('dashboard/img/ecommerce-category-images/category/' . $category->category_image);
        }

        // Delete category record from database
        $category->delete();

        return response()->json(['success' => true, 'message' => 'Category deleted successfully']);
    }
}
