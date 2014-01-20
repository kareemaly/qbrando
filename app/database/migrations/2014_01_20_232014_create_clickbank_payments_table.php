<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClickbankPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('clickbank_payments', function(Blueprint $table)
		{
            $table->increments('id');

            $table->string('cbreceipt');
            $table->string('time');

            $table->integer('item_id')->unsigned();
            $table->foreign('item_id')->references('item_id')->on('clickbank_items');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('clickbank_payments');
	}

}
