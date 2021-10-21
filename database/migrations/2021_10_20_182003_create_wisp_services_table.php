<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWispServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wisp_services', function(Blueprint $table)
		{
			$table->integer('ws_id', true);
			$table->integer('ws_id_cliente')->index('ws_id_cliente');
			$table->date('ws_date');
			$table->date('ws_first_pay_date');
			$table->integer('ws_pkg');
			$table->point('ws_maps');
			$table->integer('ws_contract')->index('ws_contract');
			$table->integer('ws_sector')->index('ws_sector');
			$table->string('ws_ssid', 60)->nullable();
			$table->string('ws_pass', 60)->nullable();
			$table->integer('ws_ip')->unsigned();
			$table->integer('ws_isActive')->default(1);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wisp_services');
	}

}
