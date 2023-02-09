<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubCategoryController extends Controller
{
    //
    public function Index()
    {
        return view('admin.layout.subcategory.allsubcategory');
    }
    public function addSubCategory()
    {
        return view('admin.layout.subcategory.addsubcategory');
    }
}
