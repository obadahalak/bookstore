<?php

namespace App\Http\Controllers\Api\Auth;

use index;
use App\traits\UploadImage;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Cache;

class ProfileController extends Controller
{

    use UploadImage;
    public function index()
    {

        return response()->json()->cacheResponse(new UserResource(auth()->user()));
    }

    protected function updateUserImage($requestImage, $user)
    {

        $updateOrCreate = $user->image ? 'update' : 'create';
        $updateOrCreate == 'update' ? $this->unlinkImage($user->image->filename, 'UserProfileImages')  : true;
        $uploadImage = $this->uploadImage($requestImage, 'UserProfileImages');

        $user->image()->$updateOrCreate([
            'file' => $uploadImage['url'],
            'filename' => $uploadImage['filename'],
        ]);
        return response()->json(['message' => '' . $updateOrCreate . ' profile updated successfully']);
    }

    public function update(UserRequest $request)
    {
        $response = [];
        $user = auth()->user();
        if (isset($request->type))
            $user->assignRole('author');


        $user->update($request->validatedData());
        $response = ['message' => 'information updated sucessfully.'];

        if (isset($request->image))
            $this->updateUserImage($request->image, $user);
        return  response()->data($response);
    }
}
