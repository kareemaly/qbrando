<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');

            // This is the only required field
            $table->string('email')->unique();

            // These two fields can be nullable
            $table->string('username')->nullable()->unique();
            $table->string('password')->nullable();

            $table->smallInteger('type')->default(Kareem3d\Membership\User::VISITOR);

            $table->boolean('accepted')->default(false);

            $table->softDeletes();

            $table->dateTime('online_at');

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
		Schema::drop('users');
	}

}
