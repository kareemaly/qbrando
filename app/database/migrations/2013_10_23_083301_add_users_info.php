<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddUsersInfo extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('users_info', function(Blueprint $table)
		{
            $table->string('contact_number');

            $table->string('delivery_location');

            $table->string('contact_email');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('users_info', function(Blueprint $table)
		{
            $table->dropColumn('contact_number', 'delivery_location', 'contact_email');
		});
	}

}