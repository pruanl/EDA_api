<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('matriculas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('email');
            $table->string('telefone');
            $table->string('cpf')->nullable();
            $table->unsignedBigInteger('documento_tipo_id')->nullable();
            $table->string('documento_numero')->nullable();
            $table->string('responsavel_nome');
            $table->string('responsavel_cpf');
            $table->string('responsavel_telefone');
            $table->string('responsavel_email');
            $table->timestamps();
            $table->softDeletes();

            // Chave estrangeira para documento_tipos
            $table->foreign('documento_tipo_id')->references('id')->on('documento_tipos');


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('matriculas');
    }
};
