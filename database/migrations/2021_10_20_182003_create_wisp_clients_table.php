<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWispClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('wisp_clients', function(Blueprint $table)
		{
			$table->integer('wc_id', true);
			$table->string('wc_name', 30);
			$table->string('wc_last_name', 30);
			$table->decimal('wc_phone', 10, 0)->nullable();
			$table->decimal('wc_phone2', 10, 0)->nullable();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('wisp_clients');
	}

}
