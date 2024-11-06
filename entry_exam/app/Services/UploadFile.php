<?php

namespace App\Services;

use Illuminate\Support\Facades\File;

class UploadFile
{
    /**
     * @param $file: Instance Illuminate\Http\UploadedFile
     * @param $pathTmp: link image
     * @param $oldImage: link image
     * @return void
     */
    public function upload($file, $pathTmp, $oldImage = '')
   {
       $fileName = time() . "_" . $file->getClientOriginalName();
       $uploadPath = public_path($pathTmp); // Folder upload path

       if (!file_exists($uploadPath)) {
           mkdir($uploadPath, 0777, true);
       }

       $file->move($uploadPath, $fileName);

       // Remove old file
       if (File::exists($oldImage)) {
           File::delete($oldImage);
       }

       return $pathTmp . '/' . $fileName;;
   }
}
