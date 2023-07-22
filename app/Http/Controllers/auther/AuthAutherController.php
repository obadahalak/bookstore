<?php

namespace App\Http\Controllers\Author;

use App\Models\Book;
use App\Models\Author;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Http\Resources\BookResource;
use Illuminate\Support\Facades\Hash;

class AuthAuthorController extends Controller
{

    public function myBooks(){

       return BookResource::collection(auth('Author')->user()->myBooks);

    }

    public function store(BookRequest $request)
    {
       $book=auth('Author')->user()->books()->create([
            'name' => $request->name,
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

    public function login(AuthorRequest $request)
    {

        $Author = Author::where('email', $request->email)->first();
        if (!$Author || !Hash::check($request->password, $Author->password)) {
            return $this->validationException();
        } else {
            return  response()->json(['token'=>$Author->createToken('Token Name')->accessToken]);
        }
    }


    public function createAuthor(AuthorRequest $Request)
    {
        $Author = Author::create($Request->validated());
        return  response()->json(['token'=>$Author->createToken('Token Name')->accessToken]);
    }
    protected function cheackOldPassword($old_password, $AuthorPassword)
    {
        if (Hash::check($old_password, $AuthorPassword)) return  true;
        return false;
    }
    public function update(AuthorRequest $request)
    {
        $return = [];
        $Author = auth('Author')->user();

        $Author->update([
            'email' => $request->email,
            'name' => $request->name,
            'type' => $request->type,
            'bio' => $request->bio,
        ]);
        $return['profile'] = 'Author profile updated successfully';
        if ($request->old_password) {
            if ($this->cheackOldPassword($request->old_password, auth('Author')->user()->password)) {

                $Author->update([
                    'password' => $request->new_password,
                ]);

                $return['password'] = 'Author password changed successfully';
            }
        }
        if ($request->image) {
            $path = $request->image->store('AuthorImages', 'public');
            $Author->image()->create([
                'file' => 'public/' . $path
            ]);
            $return['image'] = 'image profile updated successfully';
        }
        return response()->json($return);
    }
}
