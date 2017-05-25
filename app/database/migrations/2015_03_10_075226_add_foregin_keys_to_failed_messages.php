<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddForeginKeysToFailedMessages extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('failed_messages', function(Blueprint $table)
		{
			//
			$table->foreign('phone_numbers_id')->references('id')->on('phone_numbers')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('failed_messages', function(Blueprint $table)
		{
			//
			$table->dropForeign('failed_messages_phone_numbers_id_foreign');
		});
	}

}
