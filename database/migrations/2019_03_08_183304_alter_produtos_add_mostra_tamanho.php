<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterProdutosAddMostraTamanho extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('produtos', function (Blueprint $table) {
            $table->integer('id_mostra')->unsigned()->nullable();
            $table->foreign('id_mostra')->references('id')->on('mostrars');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('produtos', function (Blueprint $table) {
            Schema::table('produtos', function (Blueprint $table) {
                $table->dropColumn('id_mostra');
            });
        });
    }
}
