<?php
// app/Http/Controllers/CheckoutController.php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('user.checkout'); // Ensure this view exists
    }
}
