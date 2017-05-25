<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeDelimiterFromCharToVarcharSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('settings', function(Blueprint $table)
		{
			//
			$table->dropColumn('delimiter');
		});
		Schema::table('settings', function(Blueprint $table)
		{
			//
			$table->string('delimiter',1)->default('#')->after('id');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('settings', function(Blueprint $table)
		{
			//
			$table->dropColumn('delimiter');

		});
		Schema::table('settings', function(Blueprint $table)
		{
			//
			$table->char('delimiter',1)->default('#')->after('id');

		});
	}

}
