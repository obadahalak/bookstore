<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('books_schedulings', function (Blueprint $table) {
            $table->dropColumn('pages_per_day');
        });
    }

    public function down(): void
    {
        Schema::table('books_schedulings', function (Blueprint $table) {
            //
        });
    }
};
