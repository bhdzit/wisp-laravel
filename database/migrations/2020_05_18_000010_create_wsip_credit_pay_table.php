<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWsipCreditPayTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'wsip_credit_pay';

    /**
     * Run the migrations.
     * @table wsip_credit_pay
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('wcp_id');
            $table->integer('wcp_credit');
            $table->integer('wcp_pay');

            $table->index(["wcp_credit"], 'wcp_credit');


            $table->foreign('wcp_credit', 'wcp_credit')
                ->references('wct_id')->on('wisp_credit')
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
