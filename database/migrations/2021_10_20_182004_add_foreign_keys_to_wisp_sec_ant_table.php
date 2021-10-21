<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWispSecAntTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wisp_sec_ant', function(Blueprint $table)
		{
			$table->foreign('wsec_id', 'wisp_sec_ant_ibfk_1')->references('wsct_id')->on('wisp_sector')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wisp_sec_ant', function(Blueprint $table)
		{
			$table->dropForeign('wisp_sec_ant_ibfk_1');
		});
	}

}
