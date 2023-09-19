<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('discussoes_respostas', function (Blueprint $table) {
            $table->id();
            $table->text('texto');
            $table->unsignedBigInteger('discussao_id');
            $table->unsignedBigInteger('usuario_id');
            $table->timestamps();

            $table->foreign('discussao_id')->references('id')->on('discussoes');
            $table->foreign('usuario_id')->references('id')->on('usuarios');
        });
    }


    public function down(): void
    {
        //
    }
};
