<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Servicios extends Model
{
        protected $primaryKey = 'ws_id';
        protected $table='wisp_services';
        public $timestamps = false;

        public function getPaysAttribute($id){
          date_default_timezone_set('America/Mexico_City');
          return DB::select('call paytable(\'2019-01-01\',?)',[$this->attributes['ws_id']]);
        }

        public function getCreditAttribute(){
          return DB::table('wisp_pays')
          ->leftJoin('wisp_services_credit','wps_id','=','wsc_pay')
          ->where('wps_servicios','=',$this->attributes['ws_id'])
          ->get();      
        }
}
