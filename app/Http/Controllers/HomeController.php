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
}
