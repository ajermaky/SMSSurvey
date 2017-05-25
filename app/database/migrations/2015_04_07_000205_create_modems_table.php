<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModemsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('modems', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('modem_name');
			$table->integer('messages_sent')->unsigned();
			$table->integer('airtime_sent')->unsigned();

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
		Schema::drop('modems');
	}

}
