<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWispServicesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wisp_services', function(Blueprint $table)
		{
			$table->foreign('ws_id_cliente', 'wisp_services_ibfk_1')->references('wc_id')->on('wisp_clients')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('ws_contract', 'wisp_services_ibfk_2')->references('wct_id')->on('wisp_contract')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('ws_sector', 'wisp_services_ibfk_3')->references('wsct_id')->on('wisp_sector')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wisp_services', function(Blueprint $table)
		{
			$table->dropForeign('wisp_services_ibfk_1');
			$table->dropForeign('wisp_services_ibfk_2');
			$table->dropForeign('wisp_services_ibfk_3');
		});
	}

}
