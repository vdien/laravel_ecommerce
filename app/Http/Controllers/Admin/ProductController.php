<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    //
    public function Index()
    {
        return view('admin.layout.product.allproducts');
    }
    public function addProduct()
    {
        return view('admin.layout.product.addproduct');
    }
}
