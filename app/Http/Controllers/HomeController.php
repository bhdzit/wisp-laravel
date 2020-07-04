<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('dashbord',['clientes'=>DB::table('wisp_clients')
          ->join('wisp_services','wc_id','=','ws_id_cliente')
          ->join('wisp_pkg','ws_pkg','=','wp_id')
          ->join('wisp_contract','wct_id','=','ws_contract')
          ->select(DB::raw('ST_Y(ws_maps) as lat,ST_X(ws_maps) as lng, INET_NTOA(ws_ip) as ws_ip'),'ws_id','wc_name','wc_last_name','wc_phone','wc_phone2','ws_ssid','ws_pass','ws_pkg','wct_id','wct_nombre','ws_sector','wp_name','ws_date','ws_first_pay_date','wp_id')
          ->orderBy('ws_date')
          ->get(),
          'servicios'=>DB::select('call CLIENTESTADISTIC()'),
          'monthpays'=> DB::table('wisp_pays')
                  ->leftJoin('drop_pay','wdp_pay','=','wps_id')
                  ->leftJoin('wisp_deposit','wd_pay','=','wps_id')
                  ->join('wisp_services','wps_servicios','=','ws_id_cliente')
                  ->join('wisp_clients','wps_servicios','=','wc_id')
                  ->join('wisp_pkg','wps_pkg','=','wp_id')
                  ->select(DB::raw('DATE_FORMAT(wps_mes, "%M-%Y") as wps_mes,DATE_FORMAT(wps_date, "%d-%M-%Y") as wps_date,if(wd_banc IS NULL,"Efectivo","Deposito") as wps_pay_type '),'wps_id','wps_servicios','ws_id_cliente','wc_name','wc_last_name','wp_name','wps_monto','wdp_pay','wd_banc')
                  ->where([[DB::raw('month(wps_date)'),date('m')],[DB::raw('year(wps_date)'),date('Y')]])
                  ->get()->count()]);
    }
}
