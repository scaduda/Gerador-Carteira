<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArquivosRgbmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('arquivos_rgbms', function (Blueprint $table) {
            $table->id();
            $table->binary('frente');
            $table->binary('verso');
            $table->uuid('rgbm_id');
            $table->foreign('rgbm_id')->references('id')->on('rgbms')->onUpdate('RESTRICT')->onDelete('RESTRICT');
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
        Schema::dropIfExists('arquivos_rgbms');
    }
}
