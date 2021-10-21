<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWispCreditTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wisp_credit', function(Blueprint $table)
		{
			$table->integer('wct_id', true);
			$table->integer('wct_services')->index('wct_services');
			$table->integer('wct_msi');
			$table->date('wct_date');
			$table->decimal('wct_credit', 7);
			$table->string('wct_description', 128);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wisp_credit');
	}

}
