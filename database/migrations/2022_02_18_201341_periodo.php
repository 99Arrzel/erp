<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('periodo', function (Blueprint $table) {
            $table->id('id_periodo');
            $table->string('nombre', 15);
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_fin');
            $table->tinyInteger('estado');
            $table->foreignId('id_usuario')->constrained('usuario', 'id_usuario');
            $table->foreignId('id_gestion')->constrained('gestion', 'id_gestion');
            $table->unique(['id_gestion', 'nombre']);
            /* creas el foreign key y lo limitas con la tabla usuario al id_usuario */
        });
    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
    }
};
