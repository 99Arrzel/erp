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
        Schema::create('gestion', function (Blueprint $table) {
            $table->id('id_gestion');
            $table->string('nombre', 15);
            $table->timestamp('fecha_inicio');
            $table->timestamp('fecha_fin');
            $table->tinyInteger('estado');
            $table->foreignId('id_usuario')->constrained('usuario', 'id_usuario');
            $table->foreignId('id_empresa')->constrained('empresa', 'id_empresa');
            $table->unique(['nombre', 'id_empresa']);

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
