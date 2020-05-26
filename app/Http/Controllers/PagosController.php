<?php

namespace App\Http\Controllers;

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
    ->leftJoin('wisp_deposit','wd_pay','=','wps_id')
    ->join('wisp_services','wps_servicios','=','ws_id_cliente')
    ->leftJoin('wisp_credit',function($join){
      $join->on('wps_servicios','=','wct_services')->on(DB::raw('date_format(wct_date,\'%Y-%m\')'),'<=',DB::raw('date_format(wps_mes,\'%Y-%m\')'));
    })
    ->join('wisp_clients','wps_servicios','=','wc_id')
    ->join('wisp_pkg','wps_pkg','=','wp_id')
    ->select(DB::raw('DATE_FORMAT(wps_mes, "%M-%Y") as wps_date,if(wd_banc IS NULL,"Efectivo","Deposito") as wps_pay_type'),'wps_id','wps_monto','wps_servicios','ws_id_cliente','wc_name','wc_last_name','wp_name','wd_banc','wct_id')
    ->where('wps_date', date('Y-m-d'))
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

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      return view('agregarpago',['cliente'=>DB::select('select * from wisp_clients join wisp_services on ws_id_cliente=wc_id where ws_id_cliente=?',[$id])
      ,'paquetes'=>Paquetes::get()]);
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
      $customPaper = array(0,0,567.00,150);
      $pdf = PDF::loadView('layouts.dompdf',compact('request','pagos'))->setPaper($customPaper, 'landscape');
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
        //
    }
}
