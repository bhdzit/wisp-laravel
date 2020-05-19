<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWispSecAntTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'wisp_sec_ant';

    /**
     * Run the migrations.
     * @table wisp_sec_ant
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('wsec_id');
            $table->integer('wsec_deg');
            $table->integer('wsec_rank');


            $table->foreign('wsec_id', 'wisp_sec_ant_wsec_id')
                ->references('wsct_id')->on('wisp_sector')
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
