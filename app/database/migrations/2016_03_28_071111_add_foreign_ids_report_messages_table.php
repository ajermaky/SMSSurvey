<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeignIdsReportMessagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('report_messages', function(Blueprint $table)
		{
            $table->foreign('phone_numbers_id')->references('id')->on('phone_numbers')->onDelete('cascade');
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
		Schema::table('report_messages', function(Blueprint $table)
		{
			//
            $table->dropForeign('report_messages_phone_numbers_id_foreign');
            $table->dropForeign('report_messages_surveys_id_foreign');
		});
	}

}
