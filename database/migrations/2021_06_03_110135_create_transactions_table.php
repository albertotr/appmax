<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            $table->char('origin'); // I para transacao na interface VUE e A para transacoes por api
            $table->integer('amount'); // quantidade de produtos da transacao, podendo ser de incremento (>0) ou decremento (<0)
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products'); // id do produto
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
        Schema::dropIfExists('transactions');
    }
}
