<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWispSectorTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'wisp_sector';

    /**
     * Run the migrations.
     * @table wisp_sector
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('wsct_id');
            $table->string('wsct_name', 30);
            $table->integer('wsct_dist');
            $table->integer('wsct_antenna');
            $table->unsignedInteger('wsct_address');
            $table->integer('wsct_tower');
            $table->string('wsct_description', 100);

            $table->index(["wsct_tower"], 'wsct_tower');

            $table->index(["wsct_antenna"], 'wsct_antenna');


            $table->foreign('wsct_antenna', 'wsct_antenna')
                ->references('wa_id')->on('wisp_antenna_type')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('wsct_tower', 'wsct_tower')
                ->references('wt_id')->on('wisp_tower')
                ->onDelete('restrict')
                ->onUpdate('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
     public function down()
     {
       Schema::dropIfExists($this->tableName);
     }
}
