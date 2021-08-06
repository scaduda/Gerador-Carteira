<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateRgbmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rgbms', function (Blueprint $table) {
            $table->uuid('id')->primary()->default(DB::raw('uuid_generate_v4()'));
            $table->string('nom_completo', 100);
            $table->string('cargo_nome', 100);
            $table->string('num_cpf', 14);
            $table->string('num_matricula', 30);
            $table->string('num_rgbm', 30);
            $table->string('rg', 30);
            $table->string('tip_sangue', 4);
            $table->string('siape', 30);
            $table->string('naturalidade', 30);
            $table->string('nacionalidade', 30);
            $table->binary('foto');
            $table->binary('assinatura');
            $table->dateTime('dat_nasc');
            $table->dateTime('dat_validade_rgbm');
            $table->dateTime('data_expedicao');
            $table->softDeletes();
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
        Schema::dropIfExists('rgbms');
    }
}
