<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddStatusDescriptionsToReportMessages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('report_messages', function(Blueprint $table)
		{
			//
            $table->string("status_short")->before('created_at');
            $table->string("status")->before('created_at');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('report_messages', function(Blueprint $table)
		{
			//
            $table->dropColumn("status_short");
            $table->dropColumn("status");
		});
	}

}
