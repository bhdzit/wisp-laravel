<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business extends Model
{
    protected $table='wisp_business';
    protected $primaryKey = 'wb_id';
    public $timestamps = false;
    protected $fillable=['wb_name','wb_rfc','wb_perfil_img'];
}
