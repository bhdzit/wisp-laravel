<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWispIngressTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wisp_ingress', function(Blueprint $table)
		{
			$table->integer('wi_id', true);
			$table->string('wi_desciption', 128);
			$table->integer('wi_prices');
			$table->date('wi_date');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wisp_ingress');
	}

}
