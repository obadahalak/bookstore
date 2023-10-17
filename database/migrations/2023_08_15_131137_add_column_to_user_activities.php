<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('user_activities', function (Blueprint $table) {
            $table->bigInteger('count_of_visits')->default(1)->after('book_id');
        });
    }

    public function down(): void
    {
        Schema::table('user_activities', function (Blueprint $table) {
            $table->dropColumn('count_of_visits');
        });
    }
};
