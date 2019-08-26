<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProdutosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('produtos', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nome');
            $table->text('descricao');
            $table->double('preco', 10,2);
            $table->text('formato_embalagem')->nullable();
            $table->integer('peso')->nullable();
            $table->integer('comprimento')->nullable();
            $table->integer('altura')->nullable();
            $table->integer('largura')->nullable();
            $table->integer('diametro')->nullable();
            $table->integer('user_id')->unsigned();
            
            $table->integer('pagina_id')->unsigned();
            
            $table->timestamps();
        });
        
        Schema::table('produtos', function (Blueprint $table) {
            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('pagina_id')->references('id')->on('paginas');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('produtos');
    }
}
