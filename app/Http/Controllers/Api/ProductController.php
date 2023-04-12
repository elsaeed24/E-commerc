<?php

namespace App\Http\Controllers\Api;

use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ProductRequest;

class ProductController extends Controller
{
    use ResponseTrait;

    // حماية الاكشنز الا يوزر مسموح
    public function __construct()
    {
        $this->middleware('auth:sanctum');//->except('index','show');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResponse
    {
        $product = Product::get();

        return $this->responseSuccess($product,'Product List Fetch Successfully !');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {

        $request->merge([
            'slug' => Str::slug($request->post('name')),
            'store_id' => 6
        ]);

        $product = Product::create($request->all());

        $product->refresh();   // return all data with default value

        return $this->responseSuccess($product,'Product Create Successfully !');


    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return $this->responseSuccess($product);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->update($request->all());

        return $this->responseSuccess($product,"Product Update Successfully");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $user= Auth::guard('sanctum')->user();
        if(!$user->tokenCan('products.delete')){
            return response([
                'message' => 'Not allowed'
            ], 403);
        }

      $product->delete();
      return $this->responseSuccess($product,"Product Delete Successfully");
    }
}
