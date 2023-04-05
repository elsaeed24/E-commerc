<?php

namespace App\Http\Controllers\Admin;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{

    /**
     * latest() by default ordring for created_at but possible select specific column for ordering latest('name')
     * Display a listing of the resource.
     */
    public function index()
    {
        $products = Product::with('category')->latest()->orderBy('name', 'ASC')->paginate();

        return view('admin.products.index',[
            'products' => $products
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

        return view('admin.products.create',[
            'product' => new Product(),
            'categories' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {

          // Request Merge
        $request->merge([   // use to filed not exist in request
            'slug' => Str::slug($request->post('name')),
            'store_id' => 1
           ]);

         $data = $request->except('image');

        $data['image'] = uploadImage($request,'image','Products');

        Product::create($data);


              //PRG  post redirect get
              return redirect()
              ->route('products.index')
              ->with('success', 'Product Created'); // flash message
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('admin.products.show',compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = Category::all();
        return view('admin.products.edit',compact('product','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request, Product $product)
    {
        $old_image = $product->image;

        $data = $request->except('image');

        $new_image = uploadImage($request,'image','Products');
        if($new_image){
            $data['image']  = $new_image;
        }

        $product->update($data);

        if($old_image && $new_image){     // isset () is exists and null return false
            Storage::disk('uploads')->delete($old_image);
           }

       //PRG  post redirect get
       return redirect()
       ->route('products.index')
       ->with('success', 'Product Updated'); // flash message
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $old_image = $product->image;

        // Delete Old Image
        if($old_image ){
            Storage::disk('uploads')->delete($old_image);
        }

        $product->delete();

          //PRG  post redirect get
       return redirect()
       ->route('products.index')
       ->with('success', 'Product Deleted'); // flash message
    }
}
