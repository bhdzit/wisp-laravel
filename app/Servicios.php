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
          setlocale(LC_TIME, "es_ES");
          return DB::select('call paytable(?,?)',[$this->attributes['ws_date'],$this->attributes['ws_id']]);
        }

        public function getCreditAttribute(){
          return DB::table('wisp_pays')
          ->leftJoin('wisp_services_credit','wps_id','=','wsc_pay')
          ->where('wps_servicios','=',$this->attributes['ws_id'])
          ->get();      
        }

        public function getLastMonthPayAttribute(){
            return DB::select('select max(wps_mes) as last_month_pay  from wisp_pays where wps_servicios=?',[$this->attributes['ws_id']])[0]->last_month_pay;
        }
}
