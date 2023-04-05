<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

   // protected $perPage = 10;   // default paginate if not pass number for paginate() in controller

    protected $fillable = [
        'name', 'category_id', 'description', 'price', 'sale_price', 'quantity',
        'image', 'status', 'slug', 'store_id',
    ];

   /* protected $with = [     // if in call with('product') in controller will auto Egar loading with inside array

        'category','store'

    ];*/

    //one product follow one store
    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }

     //one product follow one category
     public function category()
     {
         return $this->belongsTo(Category::class,'category_id','id');
     }


     // one product belongs many tags
     public function tags()
     {
        return $this->belongsToMany
        (
            Tag::class,
            'product_tag',
            'product_id',
            'tag_id',
            'id',
            'id'
        );
     }
}
