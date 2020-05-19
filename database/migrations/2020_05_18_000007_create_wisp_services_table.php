<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWispServicesTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'wisp_services';

    /**
     * Run the migrations.
     * @table wisp_services
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('ws_id');
            $table->integer('ws_id_cliente');
            $table->date('ws_date');
            $table->integer('ws_pkg');
            $table->integer('ws_contract');
            $table->integer('ws_sector');
            $table->string('ws_ssid', 60);
            $table->string('ws_pass', 60);
            $table->unsignedInteger('ws_ip');

            $table->index(["ws_id_cliente"], 'ws_id_cliente');

            $table->index(["ws_contract"], 'ws_contract');

            $table->index(["ws_sector"], 'ws_sector');


            $table->foreign('ws_id_cliente', 'ws_id_cliente')
                ->references('wc_id')->on('wisp_clients')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('ws_contract', 'ws_contract')
                ->references('wct_id')->on('wisp_contract')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('ws_sector', 'ws_sector')
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
