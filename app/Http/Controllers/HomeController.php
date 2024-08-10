<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    //
    public function Index()
    {
        $popular_product = Product::latest()->get();
        return view('user.home', compact('popular_product'));
    }
    public function filterByCategory($categoryId)
    {
        return redirect()->route('shop', ['category_id' => $categoryId]);
    }

    public function filterBySubcategory($subcategoryId)
    {
        return redirect()->route('shop', ['subcategory_id' => $subcategoryId]);
    }

}
