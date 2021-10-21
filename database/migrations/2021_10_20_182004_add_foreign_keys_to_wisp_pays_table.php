<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWispPaysTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wisp_pays', function(Blueprint $table)
		{
			$table->foreign('wps_servicios', 'wisp_pays_ibfk_1')->references('ws_id')->on('wisp_services')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('wps_pkg', 'wisp_pays_ibfk_2')->references('wp_id')->on('wisp_pkg')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wisp_pays', function(Blueprint $table)
		{
			$table->dropForeign('wisp_pays_ibfk_1');
			$table->dropForeign('wisp_pays_ibfk_2');
		});
	}

}
