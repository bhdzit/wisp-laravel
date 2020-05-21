<?php

namespace App\Http\Controllers;
use App\Torres;
use App\Paquetes;
use App\Servicios;
use App\Clientes;
use DB;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clientes',[
        'clientes'=>DB::table('wisp_clients')
        ->join('wisp_services','wc_id','=','ws_id_cliente')
        ->join('wisp_pkg','ws_pkg','=','wp_id')
        ->join('wisp_contract','wct_id','=','ws_contract')
        ->select(DB::raw('ST_Y(ws_maps) as lat,ST_X(ws_maps) as lng, INET_NTOA(ws_ip) as ws_ip'),'ws_id','wc_name','wc_last_name','wc_phone','wc_phone2','ws_ssid','ws_pass','ws_pkg','wct_id','wct_nombre','ws_sector','wp_name','ws_date','ws_first_pay_date','wp_id')
        ->get(),
        'sectores'=>DB::table('wisp_sector')
        ->join('wisp_tower','wsct_tower','=','wt_id')
        ->join('wisp_antenna_type','wsct_antenna','=','wa_id')
        ->select('wisp_sector.*','wt_nombre','wa_name')
        ->get(),"paquetes"=>Paquetes::get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      request()->validate([
        "wc_name"=>["required"],
        "wc_last_name"=>["required"],
        "wc_phone"=>["required","numeric"],
        "wc_phone2"=>["nullable","numeric"],
        "wc_date"=>["required","date_format:Y-m-d"],
        "wc_pay_date"=>["required","date_format:Y-m-d"],
        "wc_pkg"=>["required","numeric"],
        "wc_point"=>["required"],
        "wc_contract"=>["required","numeric"],
        "wc_sector"=>["required","numeric"],
        "wc_ip"=>["required",'regex:/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/' ]
      ]);
      $cliente= new Clientes();
      $cliente->wc_name=$request->get('wc_name');
      $cliente->wc_last_name=$request->get('wc_last_name');
      $cliente->wc_phone=$request->get('wc_phone');
      $cliente->wc_phone2=$request->get('wc_phone2');
      $cliente->save();
      $servicio= new Servicios;
      $servicio->ws_id_cliente=$cliente->wc_id;
      $servicio->ws_date=$request->get('wc_date');
      $servicio->ws_first_pay_date=$request->get('wc_pay_date');
      $servicio->ws_pkg=$request->get('wc_pkg');
      $servicio->ws_maps=\DB::raw("POINT(".$request->get('wc_point').")");
      $servicio->ws_contract=$request->get('wc_contract');
      $servicio->ws_sector=$request->get('wc_sector');
      $servicio->ws_ssid=$request->get('wc_ssid');
      $servicio->ws_pass=$request->get('wc_pass');
      $servicio->ws_ip=\DB::raw("INET_ATON('".$request->get('wc_ip').'\')');
      $servicio->save();
          return redirect()->route('clientes.index');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
      request()->validate([
        "wc_name"=>["required","min:8"],
        "wc_last_name"=>["required","min:8"],
        "wc_phone"=>["required","numeric"],
        "wc_phone2"=>["nullable","numeric"],
        "wc_date"=>["required","date_format:Y-m-d"],
        "wc_pay_date"=>["required","date_format:Y-m-d"],
        "wc_pkg"=>["required","numeric"],
        "wc_point"=>["required"],
        "wc_contract"=>["required","numeric"],
        "wc_sector"=>["required","numeric"],
        "wc_ip"=>["required",'regex:/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/' ]
      ]);
      $servicio= Servicios::find($id);
      $servicio->ws_date=$request->get('wc_date');
        $servicio->ws_first_pay_date=$request->get('wc_pay_date');
      $servicio->ws_pkg=$request->get('wc_pkg');
      $servicio->ws_maps=\DB::raw("POINT(".$request->get('wc_point').")");
      $servicio->ws_contract=$request->get('wc_contract');
      $servicio->ws_sector=$request->get('wc_sector');
      $servicio->ws_ssid=$request->get('wc_ssid');
      $servicio->ws_pass=$request->get('wc_pass');
      $servicio->ws_ip=\DB::raw("INET_ATON('".$request->get('wc_ip').'\')');
      $servicio->save();

      $cliente= Clientes::find($servicio->ws_id_cliente);
      $cliente->wc_name=$request->get('wc_name');
      $cliente->wc_last_name=$request->get('wc_last_name');
      $cliente->wc_phone=$request->get('wc_phone');
      $cliente->wc_phone2=$request->get('wc_phone2');
      $cliente->save();

        return redirect()->route('clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Servicios::destroy($id);
        return redirect()->route('clientes.index');
    }
}
