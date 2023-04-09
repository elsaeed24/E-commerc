<?php

namespace App\Repositories;

use App\Models\Tag;
use App\Models\Product;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
use Illuminate\Support\Facades\Storage;
use App\Repositories\RepositoryInterface;


class Repository implements RepositoryInterface
{

     
     // latest() by default ordring for created_at but possible select specific column for ordering latest('name') 
    public function all()
    {
         return Product::with('category')
                            ->latest()
                            ->orderBy('name', 'ASC')
                            ->withoutGlobalScope('in-stock') // possible  withoutGlobalScopes() هيشل كل الجلوبل سكوب من الابليكشن ومن ضمنها السوفت ديليت
                          //  ->status()    // local scope
                            ->paginate();
    }


    public function add(Request $request)
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
                
            }
        }


    }

   

    public function update(Request $request, Product $product)
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

    }

    public function delete(Product $product)
    {

    }

    public function with($ralations)
    {

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
