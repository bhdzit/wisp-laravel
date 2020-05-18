<?php

namespace App\Http\Controllers;
use App\Torres;
use Illuminate\Http\Request;
use DB;
use RealRashid\SweetAlert\Facades\Alert;
class TorresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    //  Alert::html(@include('sweetalert2.TowerLayout'),'asdsa');

        return view('torres',['torres'=>Torres::get(['wt_id','ST_X(\'wt_point\')'])]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $torre=new Torres();
      $torre->wt_nombre=$request->get('wt_nombre');
      $torre->wt_altura=$request->get('wt_altura');
      $torre->wt_point=\DB::raw("POINT(".$request->get('wt_point').")");
      $torre->save();
      return redirect()->route('torres.index');
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
      $torre = Torres::find($id);
      $torre->wt_nombre=$request->get('wt_nombre');
      $torre->wt_altura=$request->get('wt_altura');
      $torre->wt_point=\DB::raw("POINT(".$request->get('wt_point').")");
      $torre->save();
      return redirect()->route('torres.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( $id)
    {
        Torres::destroy($id);
        return redirect()->route('torres.index');
    }


}
