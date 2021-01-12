<?php

namespace App\Http\Controllers;

use App\Business;
use Illuminate\Http\Request;
use DB;
use App\Paquetes;
use App\Clientes;
use App\Servicios;
use App\Pagos;
use PDF;
use ArrayObject;

class AddPayController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return view('agregarpago', ['clientes' => DB::table('wisp_clients')
      ->join('wisp_services', 'wc_id', '=', 'ws_id_cliente')
      ->join('wisp_pkg', 'ws_pkg', '=', 'wp_id')
      ->join('wisp_contract', 'wct_id', '=', 'ws_contract')
      ->select(DB::raw('ST_Y(ws_maps) as lat,ST_X(ws_maps) as lng, INET_NTOA(ws_ip) as ws_ip'), 'ws_id', 'wc_name', 'wc_id', 'wc_last_name', 'wc_phone', 'ws_pkg', 'wct_id', 'wct_nombre', 'ws_sector', 'wp_name', 'ws_date', 'wp_id')
      ->get(), 'paquetes' => Paquetes::get(),"business"=>Business::first()]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */

  public function store(Request $request)
  {
    
    
    $numRows = (count($request->all()));
    
    date_default_timezone_set('America/Mexico_City');
    $sizeOfPage = 0;
    $year = date('Y');
    $pagos = new ArrayObject();
    $extras = new ArrayObject();
    for ($i = 0; $i < $numRows; $i++) {
      $creditPayCheckbox = request('creditPayCheckbox' . ($i + 1));
      // return $creditPayCheckbox;
      if ($creditPayCheckbox == 'on') {

        $credito = Pagos::find(request('creditPay' . ($i + 1)));
        $credito->wps_monto = '300.00';
        $credito->wps_date = DB::raw("'" . date('Y-m-d') . "'");
        $credito->save();
      }

      if (request('pay' . ($i + 1))) {

        if (request('payMonth' . ($i + 1)) < date('m')) {
          if ($year == date('Y')) {
            $year++;
          }
        } else {
          $year = date('Y');
        }


        $pago = new Pagos();
        $pago->wps_monto = 1 * request('pay' . ($i + 1));
        $pago->wps_date = DB::raw("'" . date('Y-m-d') . "'");
        $pago->wps_mes = DB::raw("'" . $year . '-' . request('payMonth' . ($i + 1)) . "-01'");
        $pago->wps_servicios = request('serviceId');
        $pago->wps_pkg = request('pkgClient' . ($i + 1));
        $pagos->append($pago);
        $pago->save();
        $sizeOfPage++;
      }
      if (request('descripcion' . $i)) {
        $extra = ["item" => request('descripcion' . $i), 'costo' => request('costo' . $i)];
        $extras->append($extra);
        //            $extra->
        $sizeOfPage++;
      }
      if (request('payMethod' . ($i + 1)) == 2) {
        DB::insert('insert into wisp_deposit values(null,?,?,?)', [str_replace("T", " ", request('depositDate')), $pago->wps_id, request('r3')]); #;
      }
    }
    $credenciales = DB::select("select * from wisp_emby where wem_id=?", [$pago->wps_servicios]);
    $customPaper = array(0, 0, 667.00 + (50 * $sizeOfPage), 150);
    $pdf = PDF::loadView('layouts.dompdf', compact('request', ['pagos', 'extras', 'credenciales']))->setPaper($customPaper, 'landscape');
    //$pdf->save('my_stored_file.pdf')->stream('download.pdf');
    return  $pdf->stream(); #redirect()->route('pagos.index'); view('layouts.dompdf');
    // return  $request->all(); //
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
    return Servicios::where('ws_id_cliente', $id)
      ->get(['ws_pkg', 'ws_id', 'ws_date'])
      ->append('last_month_pay', 'yes')
      ->append('pays', 'yes')
      ->append('credit', 'yes');
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
