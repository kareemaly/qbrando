<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddProductInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('products', function(Blueprint $table)
        {
            $table->integer('color_id')->nullable()->unsigned();
            $table->foreign('color_id')->references('id')->on('colors')->onDelete('CASCADE');
        });

		Schema::table('product_specs', function(Blueprint $table)
		{
            $table->string('model');
            $table->enum('gender', array('male', 'female', 'unisex'));
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('products', function(Blueprint $table)
        {
            $table->dropForeign('color_id');
        });

		Schema::table('product_specs', function(Blueprint $table)
		{
            $table->dropColumn('model', 'gender');
		});
	}

}