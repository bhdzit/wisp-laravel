<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clientes extends Model
{
    protected $primaryKey = 'wc_id';
    protected $table='wisp_clients';
        public $timestamps = false;
}
