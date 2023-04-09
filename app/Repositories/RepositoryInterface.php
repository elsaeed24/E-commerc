<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;

interface RepositoryInterface
{
    
    public function all();

    public function add(Request $request);


    public function update(Request $request ,Product $product);

    public function delete(Product $product);
   
}
