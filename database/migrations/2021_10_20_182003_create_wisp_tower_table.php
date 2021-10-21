<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWispTowerTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wisp_tower', function(Blueprint $table)
		{
			$table->integer('wt_id', true);
			$table->string('wt_nombre', 30);
			$table->integer('wt_altura');
			$table->point('wt_point');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wisp_tower');
	}

}
