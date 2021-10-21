<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWispBusinessTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wisp_business', function(Blueprint $table)
		{
			$table->integer('wb_id', true);
			$table->string('wb_name', 100);
			$table->string('wb_rfc', 12);
			$table->string('wb_perfil_img', 100);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wisp_business');
	}

}
