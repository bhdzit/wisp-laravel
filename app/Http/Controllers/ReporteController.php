<?php

namespace App\Http\Controllers;

use App\Business;
use Illuminate\Http\Request;
use DB;
use App\Pagos;
use PDF;

const PAYS = 1;
const DEPOSITS = 2;
const CREDITS = 3;
const FREE = 4;

class ReporteController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */


  public function index()
  {
    date_default_timezone_set('America/Mexico_City');
    return view('reportepagos', [
      'pagos' => DB::table('wisp_pays')
        ->leftJoin('drop_pay', 'wdp_pay', '=', 'wps_id')
        ->leftJoin('wisp_deposit', 'wd_pay', '=', 'wps_id')
        ->join('wisp_services', 'wps_servicios', '=', 'ws_id_cliente')
        ->leftJoin('wisp_services_credit', 'wps_id', '=', 'wsc_pay')
        ->join('wisp_clients', 'wps_servicios', '=', 'wc_id')
        ->join('wisp_pkg', 'wps_pkg', '=', 'wp_id')
        ->select(DB::raw('DATE_FORMAT(wps_mes, "%M-%Y") as wps_mes,DATE_FORMAT(wps_date, "%d-%M-%Y") as wps_date,if(wd_banc IS NULL,"Efectivo","Deposito") as wps_pay_type '), 'wps_id', 'wps_monto', 'wps_servicios', 'ws_id_cliente', 'wc_name', 'wc_last_name', 'wp_name', 'wd_banc', 'wsc_id', 'wdp_pay')
        ->orderBy('wps_date', 'desc')
        ->get(),
      'cortes' => DB::table('wisp_services')
        ->leftJoin('wisp_pays', function ($join) {
          $join->on('wps_mes', '=', DB::raw('\'' . date('Y-m') . '-01\''))->on('ws_id', '=', 'wps_servicios');
        })
        ->leftJoin('wisp_clients', 'ws_id_cliente', '=', 'wc_id')
        ->leftJoin('wisp_pkg', 'ws_pkg', '=', 'wp_id')
        ->select(DB::raw('DATE_FORMAT(wps_mes, "%M-%Y") as wps_mes'), 'ws_id', 'wp_price', 'wps_servicios', 'wps_date', 'wc_name', 'wc_last_name')
        ->where("ws_first_pay_date","<",now())
        ->where('wps_id', null)
        ->get(), 'total' => DB::select('SELECT sum(wps_monto) as total FROM wisp.wisp_pays'),
        "business"=>Business::first()
    ]);
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request)
  {
    date_default_timezone_set('America/Mexico_City');
    switch (request('action')) {

      case 1:

        break;

      case 2:

        $pago = new Pagos();
        $pago->wps_monto = '0.00';
        $pago->wps_date = DB::raw("'" . date('Y-m-d') . "'");
        $pago->wps_mes = DB::raw("'" . date('Y-m') . "-01'");
        $pago->wps_servicios = request('ws_id');
        $pago->wps_pkg = 1;
        $pago->save();

        break;

      case 3:

        $mes = date('m');
        $year=date('Y');
        for ($i = 0; $i < request('credit'); $i++) {
          $pago = new Pagos();
          $pago->wps_monto = '0.00';
          $pago->wps_date = DB::raw("'" . date('Y-m-d') . "'");
          $pago->wps_mes = DB::raw("'" .$year."-". $mes . "-01'");
          $pago->wps_servicios = request('ws_id');
          $pago->wps_pkg = 1;
          $pago->save();
          $mes++;
          if($mes==13){
            $mes=1;
            $year++;
          }
          DB::insert('insert into wisp_services_credit values(null,?)', [$pago->wps_id]);
        }

        break;

      default:

        break;
    }

    return $request;
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    echo 'show';
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
    return 'update';
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
  public function data(Request $request)
  {
    date_default_timezone_set('America/Mexico_City');
    $dates =  explode(' - ', request('filterTime'));
    $tableData = null;
    $dateone = explode('/', $dates[0]);
    $datetwo = explode('/', $dates[1]);
    switch (request("filter")) {
      case PAYS:
        $tableData = DB::table('wisp_pays')
          ->leftJoin('drop_pay', 'wdp_pay', '=', 'wps_id')
          ->leftJoin('wisp_deposit', 'wd_pay', '=', 'wps_id')
          ->join('wisp_services', 'wps_servicios', '=', 'ws_id_cliente')
          ->leftJoin('wisp_services_credit', 'wps_id', '=', 'wsc_pay')
          ->join('wisp_clients', 'wps_servicios', '=', 'wc_id')
          ->join('wisp_pkg', 'wps_pkg', '=', 'wp_id')
          ->select(DB::raw('DATE_FORMAT(wps_mes, "%M-%Y") as wps_mes,DATE_FORMAT(wps_date, "%d-%M-%Y") as wps_date,if(wd_banc IS NULL,"Efectivo","Deposito") as wps_pay_type '), 'wps_id', 'wps_servicios', 'ws_id_cliente', 'wc_name', 'wc_last_name', 'wp_name', 'wps_monto', 'wdp_pay', 'wd_banc', 'wsc_id', 'wdp_pay')
          ->whereBetween('wps_date', [$dateone[2] . "-" . $dateone[1] . "-" . $dateone[0], $datetwo[2] . "-" . $datetwo[1] . "-" . $datetwo[0]])
          ->orderBy('wps_date', 'desc')
          ->get();

        break;

      case DEPOSITS:
        $tableData = DB::table('wisp_pays')
          ->leftJoin('drop_pay', 'wdp_pay', '=', 'wps_id')
          ->leftJoin('wisp_deposit', 'wd_pay', '=', 'wps_id')
          ->join('wisp_services', 'wps_servicios', '=', 'ws_id_cliente')
          ->join('wisp_clients', 'wps_servicios', '=', 'wc_id')
          ->join('wisp_pkg', 'wps_pkg', '=', 'wp_id')
          ->whereNotNull('wd_banc')
          ->select(DB::raw('DATE_FORMAT(wps_mes, "%M-%Y") as wps_mes,DATE_FORMAT(wps_date, "%d-%M-%Y") as wps_date,if(wd_banc IS NULL,"Efectivo","Deposito") as wps_pay_type '), 'wps_id', 'wps_servicios', 'ws_id_cliente', 'wc_name', 'wc_last_name', 'wp_name', 'wps_monto')
          ->whereBetween('wps_date', [$dateone[2] . "-" . $dateone[1] . "-" . $dateone[0], $datetwo[2] . "-" . $datetwo[1] . "-" . $datetwo[0]])
          ->orderBy('wps_date', 'desc')
          ->get();
        break;

      case CREDITS:
        $tableData= DB::table('wisp_pays')
        ->leftJoin('drop_pay', 'wdp_pay', '=', 'wps_id')
        ->leftjoin('wisp_services', 'wps_servicios', '=', 'ws_id_cliente')
        ->rightJoin('wisp_services_credit', 'wps_id', '=', 'wsc_pay')
        ->join('wisp_clients', 'wps_servicios', '=', 'wc_id')
        ->join('wisp_pkg', 'wps_pkg', '=', 'wp_id')
        ->select(DB::raw('DATE_FORMAT(wps_mes, "%M-%Y") as wps_mes,DATE_FORMAT(wps_date, "%d-%M-%Y") as wps_date '), 'wps_id', 'wps_servicios', 'ws_id_cliente', 'wc_name', 'wc_last_name', 'wp_name', 'wps_monto', 'wdp_pay',  'wsc_id', 'wdp_pay')
       
        ->whereBetween('wps_date', [$dateone[2] . "-" . $dateone[1] . "-" . $dateone[0], $datetwo[2] . "-" . $datetwo[1] . "-" . $datetwo[0]])
        ->get();

        break;

        case FREE:
          $tableData= DB::table('wisp_pays')
        ->leftJoin('drop_pay', 'wdp_pay', '=', 'wps_id')
        ->leftjoin('wisp_services', 'wps_servicios', '=', 'ws_id_cliente')
        ->leftJoin('wisp_services_credit', 'wps_id', '=', 'wsc_pay')
        ->join('wisp_clients', 'wps_servicios', '=', 'wc_id')
        ->join('wisp_pkg', 'wps_pkg', '=', 'wp_id')
        ->select(DB::raw('DATE_FORMAT(wps_mes, "%M-%Y") as wps_mes,DATE_FORMAT(wps_date, "%d-%M-%Y") as wps_date '), 'wps_id', 'wps_servicios', 'ws_id_cliente', 'wc_name', 'wc_last_name', 'wp_name', 'wps_monto', 'wdp_pay',  'wsc_id', 'wdp_pay')
        ->where('wps_monto', '=', '0.00')
        ->whereNull('wsc_id')
        ->whereBetween('wps_date', [$dateone[2] . "-" . $dateone[1] . "-" . $dateone[0], $datetwo[2] . "-" . $datetwo[1] . "-" . $datetwo[0]])
        ->get();
          break;

      default:

        break;
    }

    if ($request->has('pdf')) {

      $pdf = PDF::loadView('layouts.reportpdf', compact('tableData'));
      //    $pdf->save('my_stored_file.pdf')->stream('download.pdf');
      return  $pdf->stream(); #redirect()->route('pagos.index');
      //        return view('layouts.reportpdf'); //
    }
    return $tableData;
  }
}
