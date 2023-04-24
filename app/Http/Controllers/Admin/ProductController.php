<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Str;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use App\Exports\ProductExport;
use App\Imports\ProductImport;
use App\Repositories\Repository;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Gate;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Repositories\RepositoryInterface;

class ProductController extends Controller
{


    // protected $product;

    // public function __construct(RepositoryInterface $product){

    //     $this->product = $product;
    // }

   /**
   * Authorize with PolicyProduct
   * fetch all Product by repo
   * show all product from this view
   */
    public function index(Request $request)
    {

       $this->authorize('view-any', Product::class);

       // $products = $this->product->all();

       $products = Product::with('category')
                            ->latest()
                            ->orderBy('name', 'ASC')
                           // ->withoutGlobalScope('in-stock') // possible  withoutGlobalScopes() هيشل كل الجلوبل سكوب من الابليكشن ومن ضمنها السوفت ديليت
                            //  ->status()    // local scope
                            ->paginate();

        return view('admin.products.index',compact('products'));
    }


    /**
    * Authorize with PolicyProduct
    */
    public function create()
    {
        $this->authorize('create', Product::class);

        return view('admin.products.create',[
            'product' => new Product(),
            'categories' => Category::all(),
            'tags' => ''
        ]);
    }

    /**
     * Authorize with PolicyProduct

     */
    public function store(ProductRequest $request)
    {
        $this->authorize('create', Product::class);

        //$this->product->add($request);

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
    public function show(Product $product)
    {


        $this->authorize('view', $product);   // policyProduct


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
    public function update(Request $request, Product $product)
    {
        $this->authorize('update', $product);   // policyProduct

       //$this->product->update($request,$product);

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

           // Gallery
         if ($request->hasFile('gallery')) {
            foreach ( $request->file('gallery') as $file ) {
                $image_path = $file->store('GalleryProducts', [
                    'disk' => 'uploads'
                ]);
                $product->images()->create([
                    'image_path' => $image_path,
                ]);

            }
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
        $this->authorize('delete', $product);   // policyProduct

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

    public function trash()   // هيرجع العناصر المحذوفة فقط
    {
        return view('admin.products.trash', [
            'products' => Product::onlyTrashed()->paginate(),
        ]);
    }
    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return redirect()
            ->route('products.index')
            ->with('success', 'Product restored');
    }

    public function forceDelete($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->forceDelete();
        return redirect()
            ->route('products.trash')
            ->with('success', 'Product deleted forever.');
    }

    public function export(Request $request)
    {
        // $query = $this->query($request);

         $export = new ProductExport();
        // $export->setQuery($query);

        return Excel::download($export, 'products.xlsx');
    }

    public function importView()
    {
        return view('admin.products.import');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => ['required', 'mimes:xls,xlsx,csv'],
        ]);

        Excel::import(new ProductImport, $request->file('file')->path());

        return redirect()->route('products.index')
            ->with('success', "Products imported!");
    }
}
