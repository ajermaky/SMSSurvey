<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestructureFailedMessagesTable extends Migration {

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
            $table->string("message");

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
            $table->dropColumn("message");
		});
	}

}
