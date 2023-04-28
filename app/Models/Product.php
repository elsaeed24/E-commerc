<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Product extends Model
{
    use HasFactory,SoftDeletes;

   // protected $perPage = 10;   // default paginate if not pass number for paginate() in controller

    protected $fillable = [
        'name', 'category_id', 'description', 'price', 'sale_price', 'quantity',
        'image', 'status', 'slug', 'store_id',
    ];

    protected $appends = [  // عشان القيم بتاعتهم ترجع ضمن الجيسون
        'image_url', 'url',
    ];

    protected $hidden = [
        'image', 'status'
    ];


   /* protected $with = [     // if in call with('product') in controller will auto Egar loading with inside array

        'category','store'

    ];*/

    //globalScope
    //اول ما يتم انشاء اوبجكت من هذا المودل يتم تنفيذ هذا الميثود
    // protected static function booted()
    // {
    //     static::addGlobalScope('in-stock', function(Builder $builder) {

    //         $builder->where('status', '=', 'in-stock');
    //     });
    // }

    // local scope
    // name of function must be start (scope)

    public function scopeSoldout(Builder $builder)
    {
        $builder->where('status', '=', 'sold-out');
    }

    // pass parameter in scope -----status('draft') but defauit in-stock

    public function scopeStatus(Builder $builder, $status = 'in-stock')
    {
        $builder->where('status', '=', $status);
    }



    //one product follow one store
    public function store()
    {
        return $this->belongsTo(Store::class,'store_id','id');
    }

     //one product follow one category
     public function category()
     {
         return $this->belongsTo(Category::class,'category_id','id')->withDefault();
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


      // Accessors:
    // get{AttrName}Attribute
    // $product->image_url
    public function getImageUrlAttribute()
    {
        if ($this->image) {

            return asset('uploads/' . $this->image);
        }

        return 'https://ui-avatars.com/api/?name=' . $this->name;
    }

    public function getThumbUrlAttribute()  // resize for image
    {
        if ($this->image) {

           return route('images', [
            'uploads' ,'265' ,'265' , $this->image
           ]);
        }

        return 'https://ui-avatars.com/api/?name=' . $this->name;
    }

    public function getUrlAttribute()
    {
        return route('front.products.show', $this->slug);
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = Str::title($value);
    }

    //relation with ProductImage
    public function images()
    {
        return $this->hasMany(ProductImage::class,'product_id','id');
    }



}
