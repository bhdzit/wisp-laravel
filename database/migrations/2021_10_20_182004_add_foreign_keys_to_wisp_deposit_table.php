<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWispDepositTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wisp_deposit', function(Blueprint $table)
		{
			$table->foreign('wd_pay', 'wisp_deposit_ibfk_1')->references('wps_id')->on('wisp_pays')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wisp_deposit', function(Blueprint $table)
		{
			$table->dropForeign('wisp_deposit_ibfk_1');
		});
	}

}
