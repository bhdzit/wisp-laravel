<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWispCreditTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'wisp_credit';

    /**
     * Run the migrations.
     * @table wisp_credit
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('wct_id');
            $table->integer('wct_services');
            $table->integer('wct_msi');
            $table->date('wct_date');
            $table->decimal('wct_credit', 7, 2);
            $table->string('wct_description', 128);

            $table->index(["wct_services"], 'wct_services');


            $table->foreign('wct_services', 'wct_services')
                ->references('ws_id')->on('wisp_services')
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
