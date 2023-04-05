<?php



use Illuminate\Http\Request;


function uploadImage(Request $request,$name,$title){
    if(!$request->hasFile($name)){
        return ;
    }
        $file= $request->file($name);
        $path = $file->store($title,[
            'disk' => 'uploads'
        ]);
        return $path;
}


// Gallery

// function uploadGalleryImages(Request $request,$name,$title){
//         if (!$request->hasFile($name)) {
//             return;
//         }
//             foreach ( $request->file($name) as $file ) {
//                 $image_path = $file->store($title, [
//                     'disk' => 'uploads'
//                 ]);
//             }
//             return $image_path;
//         }

