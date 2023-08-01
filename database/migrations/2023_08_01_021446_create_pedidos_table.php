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
        Schema::create('pedidos', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('usuario_id')->index();
            $table->integer('producto_id')->index();
            $table->integer('cantidad');
            $table->string('direccion');
            $table->integer('telefono');
            $table->enum('estado', ['entregado', 'en proceso', 'pendiente']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pedidos');
    }
};
