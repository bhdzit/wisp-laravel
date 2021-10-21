<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWsipCreditPayTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wsip_credit_pay', function(Blueprint $table)
		{
			$table->foreign('wcp_credit', 'wsip_credit_pay_ibfk_1')->references('wct_id')->on('wisp_credit')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wsip_credit_pay', function(Blueprint $table)
		{
			$table->dropForeign('wsip_credit_pay_ibfk_1');
		});
	}

}
