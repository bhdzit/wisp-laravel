<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWispDepositTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wisp_deposit', function(Blueprint $table)
		{
			$table->integer('wd_id', true);
			$table->dateTime('wd_date');
			$table->integer('wd_pay')->index('wd_pay');
			$table->string('wd_banc', 20);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wisp_deposit');
	}

}
