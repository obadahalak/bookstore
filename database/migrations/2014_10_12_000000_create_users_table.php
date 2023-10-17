<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            // $table->text('address');
            $table->string('password');
            // $table->string('role');
            $table->string('type')->nullable();
            $table->text('bio')->nullable();
            $table->integer('count_of_books')->default(0);
            $table->string('rest_token')->nullable()->unique();
            $table->timestamp('reset_token_expiration')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('users');
    }
};
