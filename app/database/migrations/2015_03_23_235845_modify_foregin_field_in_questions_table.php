<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyForeginFieldInQuestionsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('questions', function(Blueprint $table)
		{
			//
			$table->dropForeign('questions_phone_numbers_id_foreign');
			$table->dropColumn('phone_numbers_id');
			$table->integer('surveys_id')->unsigned()->after('id');
			$table->foreign('surveys_id')->references('id')->on('surveys')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('questions', function(Blueprint $table)
		{
			//
			$table->dropForeign('questions_surveys_id_foreign');
			$table->dropColumn('surveys_id');
			$table->integer('phone_numbers_id')->unsigned()->after('id');
			$table->foreign('phone_numbers_id')->references('id')->on('phone_numbers')->onDelete('cascade');

		});
	}

}
