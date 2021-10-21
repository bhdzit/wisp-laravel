<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWispSectorTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wisp_sector', function(Blueprint $table)
		{
			$table->integer('wsct_id', true);
			$table->string('wsct_name', 30);
			$table->integer('wsct_dist');
			$table->integer('wsct_antenna')->index('wsct_antenna');
			$table->integer('wsct_address')->unsigned();
			$table->integer('wsct_segment');
			$table->integer('wsct_tower')->index('wsct_tower');
			$table->string('wsct_description', 100);
			$table->string('wsct_color', 6)->nullable()->default('000');
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wisp_sector');
	}

}
