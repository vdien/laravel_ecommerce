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
    public function AddCategory()
    {
        return view('admin.layout.category.addcategory');
    }
    public function StoreCategory(Request $request)
    {
        $request->validate([
            'category_name' => 'required|unique:categories'
        ]);
        Category::create([
            'category_name' => $request->category_name,
            'slug' => strtolower(str_replace(' ', '-', $request->category_name))
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
