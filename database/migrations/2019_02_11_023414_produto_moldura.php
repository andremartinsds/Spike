<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProdutoMoldura extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produto_moldura', function(Blueprint $table){
            $table->increments('id');

            $table->integer('produto_id')->unsigned();
            $table->integer('moldura_id')->unsigned();

            $table->foreign('produto_id')->references('id')->on('produtos')->onDelete('cascade');
            
            $table->foreign('moldura_id')->references('id')->on('moldura_produtos')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produto_moldura');
    }
}
