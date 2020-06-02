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
          ->get()]);
    }
}
