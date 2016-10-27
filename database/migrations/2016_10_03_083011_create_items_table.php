<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
			$table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
			$table->string('code',20)->unique();
			$table->string('name');
			$table->decimal('price',6,2);
			$table->integer('consignor_id')->unsigned();
			$table->foreign('consignor_id')->references('id')->on('consignors');
			$table->integer('stocks')->default(0);
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
        Schema::drop('items');
    }
}
