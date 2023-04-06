<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
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
            'categories' => Category::all(),
            'tags' => ''
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
            'store_id' => 6
           ]);

         $data = $request->except('image');

        $data['image'] = uploadImage($request,'image','Products');


       $product = Product::create($data);

        $product->tags()->attach($this->getTags($request));

         // Gallery
         if ($request->hasFile('gallery')) {
            foreach ( $request->file('gallery') as $file ) {
                $image_path = $file->store('GalleryProducts', [
                    'disk' => 'uploads'
                ]);
                $product->images()->create([
                    'image_path' => $image_path,
                ]);
                // $image = new ProductImage([
                //     'image_path' => $image_path,
                // ]);
                // $product->images()->save($image);
            }
        }




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
        $tags = $product->tags()->pluck('name')->toArray();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all(),
            'tags' => implode(',', $tags),
        ]);
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

        $product->tags()->sync($this->getTags($request));

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

    protected function getTags(Request $request)
    {
        $tag_ids = [];

        $tags = $request->post('tags');
        $tags = json_decode($tags);
        //DB::table('product_tag')->where('product_id', '=', $product->id)->delete();
        if (is_array($tags) && count($tags) > 0) {

            foreach ($tags as $tag) {
                $tag_name = $tag->value;
                $tagModel = Tag::firstOrCreate([
                    'name' => $tag_name
                ], [
                    'slug' => Str::slug($tag_name)
                ]);

                /*DB:table('product_tag')->insert([
                    'product_id' => $product->id,
                    'tag_id' => $tagModel->id,
                ]);*/
                $tag_ids[] = $tagModel->id;
            }
        }
        return $tag_ids;
    }
}
