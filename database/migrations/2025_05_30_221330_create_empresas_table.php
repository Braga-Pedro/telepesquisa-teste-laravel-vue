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
        Schema::create('empresas', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('cep');
            $table->string('rua');
            $table->string('numero_casa');
            $table->string('bairro');
            $table->string('estado');
            $table->string('telefone');
            $table->string('cpf_cnpj')->unique();

            $table->unsignedBigInteger('segmento_id');
            $table->foreign('segmento_id')->references('id')->on('segmentos');

            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('empresas');
    }
};
