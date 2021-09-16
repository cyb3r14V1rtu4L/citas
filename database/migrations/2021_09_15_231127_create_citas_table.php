<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCitasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('citas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sede_id')->constrained('sedes', 'id');
            $table->foreignId('entrevistador_id')->constrained('entrevistadors', 'id');
            $table->integer('user_id')->nullable();
            $table->time('hora_inicio');
            $table->time('hora_fin');
            $table->date('fecha');
            $table->boolean('estatus');

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('citas');
    }
}
