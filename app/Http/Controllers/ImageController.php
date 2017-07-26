<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\File;
use App\Image;

class ImageController extends Controller
{
    public function uploadImage()
    {
        $file = request()->file('file');
        $validator = Validator::make(['file' => $file], Image::$rules, Image::$messages);
        if($validator->fails()) return Response::json(['error' => true,'message' => $validator->messages()->first(),'code' => 400], 400);

        $path = "/images/";
        $name = $file->hashName();
        $file->store($path, 'public');

        // insert into database
        $image = new Image([
          'name' => $name,
          'path' => $path,
        ]);
        $image->save();

        return Response::json(['error' => false,'code'  => 200,'id' => $image->id,'image' => $path.$name,], 200);
    }

    public function deleteImage()
    {
        $image = Image::find(request('id'));
        if(!$image)
            return Response::json(['error' => true,'code'  => 400], 400);
        else {
            $name = $image->name;
            $path = $image->path;
            if(File::exists($path.$name))
                File::delete($path.$name);
            $image->delete();
            return Response::json(['error' => false,'code' => 200,], 200);
        }
    }
}
