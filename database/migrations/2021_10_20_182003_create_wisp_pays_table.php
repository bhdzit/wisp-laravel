<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWispPaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wisp_pays', function(Blueprint $table)
		{
			$table->integer('wps_id', true);
			$table->decimal('wps_monto', 7);
			$table->date('wps_date');
			$table->date('wps_mes');
			$table->integer('wps_servicios')->index('wps_servicios');
			$table->integer('wps_pkg')->index('wps_pkg');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wisp_pays');
	}

}
