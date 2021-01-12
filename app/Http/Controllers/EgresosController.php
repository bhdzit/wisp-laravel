<?php

namespace App\Http\Controllers;

use App\Business;
use Illuminate\Http\Request;
use DB;
class EgresosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     **/
     public function index()
     {
       return  view('egresos',['egresos'=>DB::select('select *  from wisp_expenses'),"business"=>Business::first()]);
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
         DB::insert('insert into wisp_expenses values(null,?,?,?)',[$request->descripcion,$request->precio,date('Y-m-d')]);
         return  redirect()->route('egresos.index');
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
         //
         $affected = DB::update('update wisp_expenses set we_desciption = ?,we_prices=? where we_id = ?', [$request->descripcion,$request->precio,$id]);
        return redirect()->route('egresos.index');
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
         $deleted = DB::delete('delete from wisp_expenses where we_id=?',[$id]);
        return redirect()->route('egresos.index');
     }
}
