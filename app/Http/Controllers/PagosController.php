<?php

namespace App\Http\Controllers;

use App\Business;
use Illuminate\Http\Request;
use DB;
use App\Paquetes;
use App\Servicios;
use App\Clientes;
use App\Pagos;
use ArrayObject;
use PDF;
class PagosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

date_default_timezone_set('America/Mexico_City');
    return view('pagos',['pagos'=>DB::table('wisp_pays')
    ->leftJoin('drop_pay','wdp_pay','=','wps_id')
    ->leftJoin('wisp_deposit','wd_pay','=','wps_id')
    ->join('wisp_services','wps_servicios','=','ws_id_cliente')
    ->leftJoin('wisp_services_credit','wps_id','=','wsc_pay')
    ->join('wisp_clients','wps_servicios','=','wc_id')
    ->join('wisp_pkg','wps_pkg','=','wp_id')
    ->select(DB::raw('DATE_FORMAT(wps_mes, "%M-%Y") as wps_date,if(wd_banc IS NULL,"Efectivo","Deposito") as wps_pay_type'),'wps_id','wps_monto','wps_servicios','ws_id_cliente','wc_name','wc_last_name','wp_name','wd_banc','wsc_id','wdp_pay')
    ->where('wps_date', date('Y-m-d'))
    ->get(),'paquetes'=>Paquetes::get(),"business"=>Business::first()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return response()->view('errors.404', [], 404);
//return view('errors.404');
/*     return view('agregarpago',['cliente'=>DB::select('select * from wisp_clients join wisp_services on ws_id_cliente=wc_id where ws_id_cliente=?',[$id])
      ,'paquetes'=>Paquetes::get()]);*/
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
        //
    }
    public function data(Request $request){
      $pago=Pagos::find($request->get('payid'));
      $pagos= new ArrayObject();
      $pagos->append($pago);
      $customPaper = array(0,0,667.00,150);
      $credenciales=DB::select("select * from wisp_emby where wem_id=?",[$pago->wps_servicios]);
      $extras=null;
      $pdf = PDF::loadView('layouts.dompdf',compact('request',['pagos','extras','credenciales']))->setPaper($customPaper, 'landscape');
  //    $pdf->save('my_stored_file.pdf')->stream('download.pdf');
      return  $pdf->stream();#redirect()->route('pagos.index'); view('layouts.dompdf');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::insert('insert into drop_pay (wdp_pay) values(?)',[$id]);
       return redirect()->route('pagos.index');;
    }
}
