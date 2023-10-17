<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Pion\Laravel\ChunkUpload\Handler\HandlerFactory;
use Pion\Laravel\ChunkUpload\Receiver\FileReceiver;

class UploadController extends Controller
{
    public function store(Request $request)
    {
        $receiver = new FileReceiver('file', $request, HandlerFactory::classFromRequest($request));

        if (! $receiver->isUploaded()) {
            dd('uploading is not complete');
            // file not uploaded
        }

        $fileReceived = $receiver->receive(); // receive file
        if ($fileReceived->isFinished()) { // file uploading is complete / all chunks are uploaded
            // dd('ff');
            $file = $fileReceived->getFile(); // get file
            $extension = $file->getClientOriginalExtension();
            $fileName = str_replace('.' . $extension, '', $file->getClientOriginalName()); //file name without extenstion
            $fileName .= '_' . md5(time()) . '.' . $extension; // a unique file name

            $disk = Storage::disk('public');
            $path = $disk->putFileAs('videos', $file, $fileName);

            // delete chunked file
            unlink($file->getPathname());

            return [
                'path' => asset('storage/' . $path),
                'filename' => $fileName,
            ];
        }

        // otherwise return percentage information
        $handler = $fileReceived->handler();

        return [
            'done' => $handler->getPercentageDone(),
            'status' => true,
        ];
    }
}
