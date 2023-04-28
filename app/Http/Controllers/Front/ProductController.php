<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class ProductController extends Controller
{
    public function show($slug)
    {
        $locale = App::currentLocale();
        $join = $locale != 'en';
        $product = Product::where('slug',$slug)


        ->firstOrFail();


        return view('front.products.show',compact('product'));
    }
}
