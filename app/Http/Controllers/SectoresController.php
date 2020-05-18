<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Sectores;
use App\Torres;
use DB;
class SectoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('sectores',[
        'sectores'=>DB::table('wisp_sector')
        ->join('wisp_tower','wsct_tower','=','wt_id')
        ->join('wisp_antenna_type','wsct_antenna','=','wa_id')
        ->select('wisp_sector.*','wt_nombre','wa_name')
        ->get(),
      'towers'=>Torres::get(['wt_id','ST_X(\'wt_point\')'])]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

     $sector=new Sectores();
      $sector->wsct_name="\"".$request->get('wsct_name')."\"";
      $sector->wsct_dist=$request->get('wsct_dist');
      $sector->wsct_antenna=$request->get('wsct_antennatype');
      $sector->wsct_address=\DB::raw("INET_ATON('".$request->get('wsct_address')."')");
      $sector->wsct_tower=$request->get('wsct_tower');
      $sector->wsct_description="\"".$request->get('wsct_description')."\"";

      $sector->save();
          #'2952861463'
      if($request->get('wsct_antennatype')==1){
          DB::insert('insert into wisp_sec_ant (wsec_id, wsec_deg, wsec_rank) values (?,?,?)', [$sector->wsct_id,$request->get('deg'),$request->get('apper')]);
      }
        return redirect()->route('sectores.index');#$request;#redirect()->route('sectores.index');
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
      $sector = Sectores::find($id);
      $sector->wsct_name=$request->get('wsct_name');
      $sector->wsct_dist=$request->get('wsct_dist');
      $sector->wsct_antenna=$request->get('wsct_antennatype');
      $sector->wsct_address=$request->get('wsct_address');
      $sector->wsct_tower=$request->get('wsct_tower');
      $sector->wsct_description=$request->get('wsct_description');
      $sector->save();
      if($request->get('wsct_antennatype')==1){
        #DB::update('update users set votes = 100 where name = ?', ['John']);
          DB::update('update wisp_sec_ant set  wsec_deg=?, wsec_rank=? where wsec_id=?', [$request->get('deg'),$request->get('apper'),$sector->wsct_id]);
      }
      return redirect()->route('sectores.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Sectores::destroy($id);
      return redirect()->route('sectores.index');
    }
}
