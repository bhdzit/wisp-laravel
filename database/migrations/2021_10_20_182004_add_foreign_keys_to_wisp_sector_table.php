<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToWispSectorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('wisp_sector', function(Blueprint $table)
		{
			$table->foreign('wsct_antenna', 'wisp_sector_ibfk_1')->references('wa_id')->on('wisp_antenna_type')->onUpdate('NO ACTION')->onDelete('NO ACTION');
			$table->foreign('wsct_tower', 'wisp_sector_ibfk_2')->references('wt_id')->on('wisp_tower')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('wisp_sector', function(Blueprint $table)
		{
			$table->dropForeign('wisp_sector_ibfk_1');
			$table->dropForeign('wisp_sector_ibfk_2');
		});
	}

}
