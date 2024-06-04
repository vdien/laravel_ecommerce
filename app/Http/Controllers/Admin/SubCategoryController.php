<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
class SubCategoryController extends Controller
{
    //
    public function Index()
    {
        $subcategories = Subcategory::latest()->get();
        $categories = Category::latest()->get();
        return view('admin.layout.subcategory.allsubcategory', compact('subcategories','categories'));
    }
    public function GetSubCategoryJson()
    {
        $subcategories = Subcategory::with(['category', 'products'])->withCount('products')->get();
        return response()->json(['data' => $subcategories]);
    }
    public function StoreSubCategory(Request $request)
    {

        if ($request->hasFile('ecommerce_subcategory_image')) {
            $image = $request->file('ecommerce_subcategory_image');

            if ($image->isValid()) {
                $filename = uniqid() . '_' . time() . '.' . $image->getClientOriginalExtension();
                $image->move(public_path('dashboard/img/ecommerce-category-images/subcategory'), $filename);
                $subcategoryImage = $filename;
            } else {
                // Handle invalid file error
                return response()->json(['error' => 'Invalid file.'], 400);
            }
        } else {
            // Handle no file error
            return response()->json(['error' => 'No image provided.'], 400);
        }

        $description = $request->input('ecommerce_subcategory_description', 'Default description');

        $subcategory = Subcategory::create([
            'category_id' => $request->parent_subcategory,
            'subcategory_name' => $request->subcategory_name,
            'slug' => strtolower(str_replace(' ', '-', $request->ecommerce_subcategory_slug)),
            'description' => $description,
            'subcategory_image' => $subcategoryImage ?? 'default_image.jpg',
            'subcategory_status' => $request->subcategory_status
            // Add other fields as needed
        ]);

        $subcategories = Subcategory::with(['category', 'products'])->withCount('products')->get();
        // Return JSON response with updated data
        return response()->json($subcategories);

    }

    public function UpdateSubCategory(Request $request)
    {
        $description = $request->input('edit_subcategory_description_input', 'Default description');
        // Find the subcategory by its ID
        $subcategory = Subcategory::findOrFail($request->edit_subcategory_id);
        if ($request->hasFile('edit_ecommerce_subcategory_image')) {
            $oldImagePath = public_path('dashboard/img/ecommerce-category-images/subcategory/' . $subcategory->category_image);
            if (File::exists($oldImagePath)) {
                File::delete($oldImagePath);
            }
        }
        if ($request->hasFile('edit_ecommerce_subcategory_image')) {
            // Handle image upload
            $image = $request->file('edit_ecommerce_category_image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('dashboard/img/ecommerce-category-images/subcategory'), $imageName);
            $subcategory->subcategory_image = $imageName;
        }

        // Update the subcategory fields
        $subcategory->category_id = $request->edit_parent_subcategory;
        $subcategory->subcategory_name = $request->edit_subcategory_name;
        $subcategory->slug = strtolower(str_replace(' ', '-', $request->edit_ecommerce_subcategory_slug));
        $subcategory->description = $description;
        // If a new image is provided, update the image field

        $subcategory->subcategory_status = $request->edit_ecommerce_subcategory_status;
        // Save the changes
        $subcategory->save();
        $subcategories = Subcategory::with(['category', 'products'])->withCount('products')->get();
        // Return JSON response with updated data
        return response()->json($subcategories);

    }
    public function DeleteSubCategory(Request $request)
    // Method to delete a subcategory
    {
        $subcategory_id = $request->input('subcategoryId');

        $subcategory = Subcategory::find($subcategory_id);

        if (!$subcategory) {
            return response()->json(['success' => false, 'message' => 'Subcategory not found'], 404);
        }

        // Delete category image from storage if it exists
        if ($subcategory->subcategory_image) {
            File::delete(public_path('dashboard/img/ecommerce-category-images/subcategory/' . $subcategory->subcategory_image));
        }

        // Delete category record from database
        $subcategory->delete();

        return response()->json(['success' => true, 'message' => 'Subategory deleted successfully']);
    }
}
