<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWispCreditTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wisp_credit', function(Blueprint $table)
		{
			$table->foreign('wct_services', 'wisp_credit_ibfk_1')->references('ws_id')->on('wisp_services')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wisp_credit', function(Blueprint $table)
		{
			$table->dropForeign('wisp_credit_ibfk_1');
		});
	}

}
