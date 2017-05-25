<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFailedMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('failed_messages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('phone_numbers_id')->unsigned();
			$table->integer('attempts');
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
		
		Schema::drop('failed_messages');
	}

}
