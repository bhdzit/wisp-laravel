<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWispPkgTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wisp_pkg', function(Blueprint $table)
		{
			$table->integer('wp_id', true);
			$table->string('wp_name', 30);
			$table->integer('wp_tx');
			$table->integer('wp_rx');
			$table->integer('wp_price');
			$table->string('wp_description', 100);
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wisp_pkg');
	}

}
