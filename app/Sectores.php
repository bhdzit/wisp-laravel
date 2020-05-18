<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sectores extends Model
{
    protected $primaryKey = 'wsct_id';
    public $timestamps = false;
    protected $table= 'wisp_sector';
    protected $fillable=['wsct_id','wsct_name','wsct_dist','wsct_antenna','wsct_address','wsct_tower','wsct_description',];
}
