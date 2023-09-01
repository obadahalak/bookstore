<?php

use App\Models\BooksScheduling;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('schedulings');
    }
};
