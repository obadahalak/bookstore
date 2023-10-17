<?php

namespace App\traits;

use App\Models\Image;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait UploadImage
{
    public $folder;
    public $filename;
    public $disk = 'public';

    public function fileName($mimType)
    {

        $this->filename = Str::uuid() . '__.' . $mimType;

        while (Image::where('filename', $this->filename)->first()) {

            $this->filename = Str::uuid() . '__.' . $mimType;
        }

        return $this->filename;

    }

    public function setFolder($folderName)
    {
        return $this->folder = $folderName;
    }

    public function uploadImage($image, $folder)
    {

        $this->setFolder($folder);
        $fileName = $this->filename($image->extension());

        $path = $image->storeAs($this->folder, $fileName, $this->disk);

        return ['url' => Storage::disk('public')->url($path), 'filename' => $fileName];

    }

    public function unlinkImage($image, $folder)
    {

        if (Storage::disk('public')->exists($folder . '/' . $image)) {

            return Storage::disk('public')->delete($folder . '/' . $image);
        }

    }
}
