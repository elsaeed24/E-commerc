<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory,SoftDeletes;

    protected $fillable =[

        'name', 'slug', 'parent_id','description','image','status'

    ];

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault([
            'name' => 'No Parent'
        ]);
    }

    // one category has many products
    public function products()
    {
        return $this->hasMany(Product::class,'category_id','id');
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
}
