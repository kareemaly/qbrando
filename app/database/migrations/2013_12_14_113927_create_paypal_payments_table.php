<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaypalPaymentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('paypal_payments', function(Blueprint $table)
		{
			$table->increments('id');

            $table->integer('status');
            $table->string('token');
            $table->string('transaction_id');

            $table->integer('gross_amount_id')->unsigned()->nullable();
            $table->foreign('gross_amount_id')->references('id')->on('price_amounts')->onDelete('CASCADE');

            $table->integer('fee_amount_id')->unsigned()->nullable();
            $table->foreign('fee_amount_id')->references('id')->on('price_amounts')->onDelete('CASCADE');

            $table->integer('order_id')->unsigned();
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('CASCADE');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('paypal_payments');
	}

}
