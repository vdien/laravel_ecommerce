<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //
    public function Index()
    {
        return view('admin.layout.category.allcategory');
    }
    public function addCategory()
    {
        return view('admin.layout.category.addcategory');
    }
}
