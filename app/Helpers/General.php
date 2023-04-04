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
