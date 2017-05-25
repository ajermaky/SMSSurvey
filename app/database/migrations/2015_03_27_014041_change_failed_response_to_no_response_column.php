<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeFailedResponseToNoResponseColumn extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('phone_numbers', function(Blueprint $table)
		{
			//
			$table->dropColumn('failed_responses');
			$table->integer('attempts')->unsigned()->after('phone');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('phone_numbers', function(Blueprint $table)
		{
			//
			$table->dropColumn('attempts');
			$table->integer('failed_responses')->after('phone');
		});
	}

}
