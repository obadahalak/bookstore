<?php

use App\Models\Book;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('books_schedulings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Book::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnDelete();
            $table->json('days');
            $table->integer('pages_per_day');
            $table->boolean('status')->default(false);
            $table->integer('duration'); //// duration for finish book;
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('books_schedulings');
    }
};
