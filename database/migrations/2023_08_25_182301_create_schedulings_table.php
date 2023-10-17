<?php

use App\Models\BooksScheduling;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('scheduling_info', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(BooksScheduling::class)->constrained()->cascadeOnDelete();
            $table->date('date');
            $table->integer('pages');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('schedulings');
    }
};
