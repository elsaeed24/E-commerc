<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latest = Product::with('category')->latest()->take(8)->get();
        return view('front.home.index',[
            'latest' => $latest
        ]);
    }
}
