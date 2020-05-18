<?php

namespace App\Http\Controllers;
use App\Paquetes;
use Illuminate\Http\Request;

class PaquetesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return view('paquetes',['paquetes'=>Paquetes::get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $paquete= new Paquetes;
        $paquete->wp_name=$request->get('pkg_name');
        $paquete->wp_tx=$request->get('pkg_tx');
        $paquete->wp_rx=$request->get('pkg_rx');
        $paquete->wp_price=$request->get('pkg_price');
        $paquete->wp_description=$request->get('pkg_description');
        $paquete->save();
        return redirect()->route('paquetes.index');
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
        $paquete = Paquetes::find($id);
        $paquete->wp_name=$request->get('pkg_name');
        $paquete->wp_tx=$request->get('pkg_tx');
        $paquete->wp_rx=$request->get('pkg_rx');
        $paquete->wp_price=$request->get('pkg_price');
        $paquete->wp_description=$request->get('pkg_description');
        $paquete->save();
        return redirect()->route('paquetes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
      Paquetes::destroy($id);
      return redirect()->route('paquetes.index');
    }
}
