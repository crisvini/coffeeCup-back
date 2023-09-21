<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users_teste', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('lastname');
            $table->string('nickname')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->timestamps();
        });
    }


    public function down(): void
    {
        //
    }
};