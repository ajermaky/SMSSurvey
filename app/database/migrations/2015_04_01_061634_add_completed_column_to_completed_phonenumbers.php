<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompletedColumnToCompletedPhonenumbers extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('completed_phonenumbers', function(Blueprint $table)
		{
			//
			$table->boolean('ugx_sent')->after('phone_numbers_id')->default('0');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('completed_phonenumbers', function(Blueprint $table)
		{
			//
			$table->dropColumn('ugx_sent');
		});
	}

}
