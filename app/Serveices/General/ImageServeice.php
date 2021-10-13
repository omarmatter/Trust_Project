<?php

namespace App\Serveices\General;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Modules\Menu\Entities\Product;

class ImageServeice
{
    static  function  uplodeImage($file){


     $date =  date('Y-m-d');
     $data =[];

         $image_path = $file->store('/'.$date, 'uplode');

         $size = $file->getSize();

         $type = $file->extension();

         $data=['image'=>   $image_path ,
                 'size' =>$size ,
                  'type' => $type
             ];
       return $data;
//       $file = $request->file('main_image');
//       $image_path = $file->store('/', 'uplode');
//       $data = $request->validated();

//       $product = Product::create($data);


//           $file = $request->file('image');
//           foreach ($file as $img) {

//         /      $image_path = $img->store('/', 'uplode');


//               $product->images()->create(['image' => $image_path]);
           }

}
