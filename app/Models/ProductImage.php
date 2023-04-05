<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductImage extends Model
{
    use HasFactory;

    protected $fillable =[
        'product_id','image_path'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // public function getImageUrlAttribute()
    // {
    //     return Storage::disk('uploads')->url($this->image_path);
    // }

       // Accessors:
    // get{AttrName}Attribute
    // $product->image_url
    public function getImageUrlAttribute()
    {
        if ($this->image_path) {

            return asset('uploads/' . $this->image_path);
        }

        return 'https://ui-avatars.com/api/?name=' . $this->name;
    }
}
