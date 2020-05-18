<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Paquetes extends Model
{
    protected $table='wisp_pkg';
    protected $primaryKey = 'wp_id';
    public $timestamps = false;
    protected $fillable=['wp_id','wp_name','wp_tx','wp_rx','wp_price','wp_description'];
}
