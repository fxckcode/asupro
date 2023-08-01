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
        Schema::create('horarios', function (Blueprint $table) {
            $table->increments('id')->unsigned(false);
            $table->integer('dia_inicio');
            $table->integer('dia_fin');
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->enum('estado', ['activo', 'inactivo']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('horarios');
    }
};
