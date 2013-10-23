<?php

use Illuminate\Database\Migrations\Migration;

class AddAccessUsers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
        Schema::table('users', function(\Illuminate\Database\Schema\Blueprint $table)
        {
            $table->smallInteger('access');
        });
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
        Schema::table('users', function($table)
        {
            $table->dropColumn('access');
        });
	}

}