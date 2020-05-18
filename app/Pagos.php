<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Pagos extends Model
{
  protected $table='wisp_pays';
  protected $primaryKey = 'wps_id';
  public $timestamps = false;
  protected $fillable=['wps_monto','wps_date','wps_mes','wps_servicios','wps_pkg'];
}
