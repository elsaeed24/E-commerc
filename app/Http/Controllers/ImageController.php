<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageController extends Controller
{
    public function index($disk, $width, $height, $image_path)
    {
        if (!Storage::disk($disk)->exists($image_path)) {
            abort(404);
        }
        $path = Storage::disk($disk)->exists($image_path);
       $image = Image::make($path);
       $image->resize($width,$height);


       return $image->response();

    }
}
