<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    //
    public function Index()
    {
        $subcategories = Subcategory::latest()->get();
        return view('admin.layout.subcategory.allsubcategory', compact('subcategories'));
    }
    public function AddSubCategory()
    {
        $categories = Category::latest()->get();
        return view('admin.layout.subcategory.addsubcategory', compact('categories'));
    }
    public function StoreSubCategory(Request $request)
    {
        $request->validate([
            'subcategory_name' => 'required|unique:subcategories',
            'category_id' => 'required'
        ]);

        $category_id = $request->category_id;
        $category_name = Category::where('id', $category_id)->value('category_name');

        Subcategory::insert([
            'subcategory_name' => $request->subcategory_name,
            'slug' => strtolower(str_replace('', '-', $request->subcategory_name)),
            'category_id' => $category_id,
            'category_name' => $category_name
        ]);
        Category::where('id', $category_id)->increment('subcategory_count', 1);

        return redirect()->route('allsubcategory')->with('message', 'Sub Category Added Successfully');
    }
    public function EditSubCategory($id)
    {
        $categories = Category::latest()->get();
        $subcategory_info = Subcategory::findOrFail($id);
        return view('admin.layout.subcategory.editsubcategory', compact('subcategory_info', 'categories'));
    }
    public function UpdateSubCategory(Request $request)
    {

        $category_id = $request->category_id;
        $category_name = Category::where('id', $category_id)->value('category_name');
        $subcategory_id = $request->subcategory_id;
        $request->validate([
            'subcategory_name' => 'required|unique:subcategories'
        ]);

        Subcategory::findOrFail($subcategory_id)->update([
            'category_id' => $category_id,
            'category_name' => $category_name,
            'subcategory_name' => $request->subcategory_name,
            'slug' => strtolower(str_replace('', '-', $request->subcategory_name))
        ]);
        return redirect()->route('allsubcategory')->with('message', 'Category Update Successfully!');
    }
    public function DeleteSubCategory($id)
    {
        $category_id = Subcategory::where('id', $id)->value('category_id');
        Subcategory::findOrFail($id)->delete();
        Category::where('id', $category_id)->decrement('subcategory_count', 1);
        return redirect()->route('allsubcategory')->with('message', 'Category Deleted Successfully!');
    }
}
