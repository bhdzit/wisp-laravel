<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWsipCreditPayTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wsip_credit_pay', function(Blueprint $table)
		{
			$table->integer('wcp_id', true);
			$table->integer('wcp_credit')->index('wcp_credit');
			$table->integer('wcp_pay');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wsip_credit_pay');
	}

}
