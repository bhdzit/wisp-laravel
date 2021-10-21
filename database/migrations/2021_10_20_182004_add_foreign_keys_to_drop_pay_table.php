<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddForeignKeysToDropPayTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::table('drop_pay', function(Blueprint $table)
		{
			$table->foreign('wdp_pay', 'drop_pay_ibfk_1')->references('wps_id')->on('wisp_pays')->onUpdate('NO ACTION')->onDelete('NO ACTION');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::table('drop_pay', function(Blueprint $table)
		{
			$table->dropForeign('drop_pay_ibfk_1');
		});
	}

}
