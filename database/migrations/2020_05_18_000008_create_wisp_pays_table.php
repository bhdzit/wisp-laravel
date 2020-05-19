<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWispPaysTable extends Migration
{
    /**
     * Schema table name to migrate
     * @var string
     */
    public $tableName = 'wisp_pays';

    /**
     * Run the migrations.
     * @table wisp_pays
     *
     * @return void
     */
    public function up()
    {
        Schema::create($this->tableName, function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('wps_id');
            $table->decimal('wps_monto', 7, 2);
            $table->date('wps_date');
            $table->date('wps_mes');
            $table->integer('wps_servicios');
            $table->integer('wps_pkg');

            $table->index(["wps_pkg"], 'wps_pkg');

            $table->index(["wps_servicios"], 'wps_servicios');


            $table->foreign('wps_servicios', 'wps_servicios')
                ->references('ws_id')->on('wisp_services')
                ->onDelete('restrict')
                ->onUpdate('restrict');

            $table->foreign('wps_pkg', 'wps_pkg')
                ->references('wp_id')->on('wisp_pkg')
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
