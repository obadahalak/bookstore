<?php

namespace App\Http\Services;

use App\Events\PublishedBook;
use App\Models\Book;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BookService
{
    public static function getUserWishlist()
    {

        return DB::table('likes')
            ->where('likes.user_id', auth()->user()->id)
            ->join('books as b', 'b.id', '=', 'likes.book_id')
            ->select('b.id')
            ->pluck('b.id');
    }

    public function createBook($data)
    {

        return DB::transaction(function () use ($data) {

            $book = Book::create([
                'name' => $data->name,
                'overview' => $data->overview,
                'category_id' => $data->category_id,
                'page_count' => $data->page_count,
                'user_id' => auth()->id(),
            ]);

            $this->book_gallery($book, $data['book_gallery']);

            $this->coverImage($book, $data['book_cover']);

            $this->bookFile($book, $data['book_file']);

            return $book;

        });
    }

    public function active(Book $book, $status)
    {

        $book->update(['active' => $status]);
        event(new PublishedBook($book));

    }

    public function similarBooks($categoryId)
    {
        return Book::with('coverImage:imageable_type,imageable_id,file')->where('category_id', $categoryId)->inRandomOrder()->take(5)->get();
    }

    protected function book_gallery($book, $data)
    {
        foreach ($data as $book_images) {

            $book->images()->create([
                'file' => Storage::disk('public')->url($book_images['src']->store('bookGaller', 'public')),
                'filename' => $book_images['src']->getClientOriginalName(),
                'type' => Image::GALLARY_TYPE,
            ]);
        }

        return $book;
    }

    protected function coverImage($book, $data)
    {
       return $book->coverImage()->create([
                'file' => Storage::disk('public')->url($data->store('bookCover', 'public')),
                'filename' => $data->getClientOriginalName(),
                'type' => Image::COVER_TYPE,
            ]);
    }

    protected function bookFile($book, $data)
    {
        return  $book->bookFile()->create([
                'file' => Storage::disk('public')->url($data->storeAs('books', "{$book->id}.pdf", 'public')),
                'filename' => "{$book->id}.pdf",
                'type' => Image::FILE_TYPE,
            ]);

    }
}
