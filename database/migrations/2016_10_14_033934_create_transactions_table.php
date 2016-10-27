<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
			$table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
			$table->index('id');
			$table->integer('consignor_id')->unsigned();
			$table->integer('item_id')->unsigned();
			$table->foreign('consignor_id')->references('id')->on('consignors');
			$table->foreign('item_id')->references('id')->on('items')->onUpdate('cascade');
			$table->integer('quantity');
			$table->decimal('price',6,2);
			$table->decimal('total_price',6,2);
			$table->string('remarks');
			$table->boolean('is_deleted')->default(false);
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
        Schema::drop('transactions');
    }
}
