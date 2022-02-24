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
        Schema::create('empresa', function (Blueprint $table) {
            $table->id('id_empresa');
            $table->string('nombre', 15)->unique();
            $table->integer('nit')->unique();
            $table->string('sigla', 10)->unique();
            $table->integer('telefono');
            $table->string('correo', 32);
            $table->mediumText('direccion');
            $table->integer('niveles');
            $table->tinyInteger('estado');
            $table->foreignId('id_usuario')->constrained('usuario', 'id_usuario');
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
