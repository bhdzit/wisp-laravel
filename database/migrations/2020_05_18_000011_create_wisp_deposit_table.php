<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWispDepositTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'wisp_deposit';

    /**
     * Run the migrations.
     * @table wisp_deposit
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('wd_id');
            $table->dateTime('wd_date');
            $table->integer('wd_pay');
            $table->string('wd_banc', 20);

            $table->index(["wd_pay"], 'wd_pay');


            $table->foreign('wd_pay', 'wd_pay')
                ->references('wps_id')->on('wisp_pays')
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
