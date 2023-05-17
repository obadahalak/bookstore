<?php

namespace App\traits;

use App\Models\Image;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

trait UploadImage{

    public $folder;
    public $filename;
    public $disk='public';


    public function fileName($mimType){

        $this->filename=Str::uuid() .'__.'.$mimType;
        
        
        $checkImage=Image::where('filename',$this->filename)->get();
        
       while ($checkImage->count()) {
     
         $this->filename=Str::uuid() .'__.'.$mimType;
       }
       return $this->filename;


    }
    public function disk(){
        return $this->disk='public';
    }
    public function setFolder($folderName){
        return $this->folder=$folderName;
    }


    public function uploadSingleImage($image,$folder){
       
        $this->setFolder($folder);
         $fileName= $this->filename($image->extension());
         
        
        $path= $image->storeAs($this->folder,$fileName,$this->disk);

        return ['url'=>Storage::disk('public')->url($path),'filename'=>$fileName];
       
    
    }
    public function unlinkImage($image,$folder){
       
        if(Storage::disk('public')->exists($folder.'/'.$image))
        
            return Storage::disk('public')->delete($folder.'/'.$image);
        
       
    }
}
