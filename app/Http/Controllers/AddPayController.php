<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Paquetes;
use App\Clientes;
use App\Servicios;
use App\Pagos;
class AddPayController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      return view('agregarpago',['clientes'=>DB::table('wisp_clients')
      ->join('wisp_services','wc_id','=','ws_id_cliente')
      ->join('wisp_pkg','ws_pkg','=','wp_id')
      ->join('wisp_contract','wct_id','=','ws_contract')
      ->select(DB::raw('ST_Y(ws_maps) as lat,ST_X(ws_maps) as lng, INET_NTOA(ws_ip) as ws_ip'),'ws_id','wc_name','wc_id','wc_last_name','wc_phone','wc_mail','ws_pkg','wct_id','wct_nombre','ws_sector','wp_name','ws_date','wp_id')
      ->get(),'paquetes'=>Paquetes::get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $numRows=(count($request->all())-4)/4;
       date_default_timezone_set('America/Mexico_City');


        for($i=0;$i<$numRows;$i++){

          $pago= new Pagos();
          $pago->wps_monto=1*request('pay'.($i+1));
          $pago->wps_date=DB::raw("'".date('Y-m-d')."'");
          $pago->wps_mes=DB::raw("'".date('Y').'-'.request('payMonth'.($i+1))."-01'");
          $pago->wps_servicios=request('serviceId');
          $pago->wps_pkg=request('pkgClient'.($i+1));
          $pago->save();
          if(request('payMethod'.($i+1))==2){
          DB::insert('insert into wisp_deposit values(null,?,?,?)',[str_replace("T"," ",request('depositDate')),$pago->wps_id,request('r3')]);#;
        }
      }
        return $request;#redirect()->route('pagos.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
            //  $data=Clientes::where('wc_name',$id);#DB::select('select wc_id from wisp_clients where wc_name = \'?\'',[$id]);
          return Servicios::where('ws_id_cliente',$id)->get(['ws_pkg','ws_id'])->append('pays','yes')->toArray();

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
                return 'ip';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
                return 'DETROY';
    }
}
