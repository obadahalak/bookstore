<?php

namespace App\Http\Controllers\auther;

use App\Models\Book;
use App\Models\Auther;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\AutherRequest;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Hash;

class AuthAutherController extends Controller
{

    public function myBooks(){

       return BookResource::collection(auth('auther')->user()->myBooks);

    }

    public function store(BookRequest $request)
    {
       $book=auth('auther')->user()->books()->create([
            'name' => $request->name,
            'details' => $request->details,
            'overview' => $request->overview,
            'category_id' => $request->category_id,
            'rating' => 1,
        ]);

        foreach ($request->book_gallery as $image) {

            $bookGalleryPath = $image['src']->store('bookGaller', 'public');
            $book->bookImages()->create([
                'file' => 'public/' . $bookGalleryPath,
                'type' => 'gallary'
            ]);
        }
        $coverPath = $request->book_cover->store('bookCover', 'public');
        $book->coverBook()->create([
            'file' => 'public/' . $coverPath,
            'type' => 'cover'
        ]);

        return response()->json(['message'=>'book created success'], 201);
    }

    public function login(AutherRequest $request)
    {

        $auther = Auther::where('email', $request->email)->first();
        if (!$auther || !Hash::check($request->password, $auther->password)) {
            return $this->validationException();
        } else {
            return  response()->json(['token'=>$auther->createToken('Token Name')->accessToken]);
        }
    }


    public function createAuther(AutherRequest $Request)
    {
        $auther = Auther::create($Request->validated());
        return  response()->json(['token'=>$auther->createToken('Token Name')->accessToken]);
    }
    protected function cheackOldPassword($old_password, $autherPassword)
    {
        if (Hash::check($old_password, $autherPassword)) return  true;
        return false;
    }
    public function update(AutherRequest $request)
    {
        $return = [];
        $auther = auth('auther')->user();

        $auther->update([
            'email' => $request->email,
            'name' => $request->name,
            'type' => $request->type,
            'bio' => $request->bio,
        ]);
        $return['profile'] = 'auther profile updated successfully';
        if ($request->old_password) {
            if ($this->cheackOldPassword($request->old_password, auth('auther')->user()->password)) {

                $auther->update([
                    'password' => $request->new_password,
                ]);

                $return['password'] = 'auther password changed successfully';
            }
        }
        if ($request->image) {
            $path = $request->image->store('autherImages', 'public');
            $auther->image()->create([
                'file' => 'public/' . $path
            ]);
            $return['image'] = 'image profile updated successfully';
        }
        return response()->json($return);
    }
}
