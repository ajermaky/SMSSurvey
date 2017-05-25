<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompletedPhonenumbers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('completed_phonenumbers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('surveys_id')->unsigned();
			$table->integer('phone_numbers_id')->unsigned();
			$table->foreign('surveys_id')->references('id')->on('surveys')->onDelete('cascade');
			$table->foreign('phone_numbers_id')->references('id')->on('phone_numbers')->onDelete('cascade');
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
		Schema::drop('completed_phonenumbers');
	}

}
