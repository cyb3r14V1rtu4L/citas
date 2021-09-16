<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSedeEntrevistadorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sede_entrevistadors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('entrevistador_id')->constrained('entrevistadors', 'id');
            $table->foreignId('sede_id')->constrained('sedes', 'id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sede_entrevistadors');
    }
}
