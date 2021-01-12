<?php

namespace App\Http\Controllers;

use App\Business;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ConfiguracionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        //$file= \Storage::disk('local')->get('\\imagenes\\'.auth()->user()->perfil_img);
       //echo "<img src='/storage/imagenes/a.jpg'>"; 
        return view("configuracion",["business"=>Business::first(),"Users"=>User::get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
       $business=Business::find(1);
       $business->wb_name=$request->business_name;
       $business->wb_rfc=$request->rfc;
       

       $user= User::find(auth()->user()->id);
       $user->name=$request->user_name;
       $user->email=$request->user_email;
       

        if ($request->hasFile('img')) {
            $file = $request->file('img');
            //obtenemos el nombre del archivo
            $nombre =  time() . "_" . $file->getClientOriginalName();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            Storage::disk('imagenes')->put($nombre,  \File::get($file));
            $user->perfil_img=$nombre;
        }

        if ($request->hasFile('business_img_chooser')) {
            $file = $request->file('business_img_chooser');
            //obtenemos el nombre del archivo
            $nombre =  time() . "_" . $file->getClientOriginalName();
            //indicamos que queremos guardar un nuevo archivo en el disco local
            Storage::disk('imagenes')->put($nombre,  \File::get($file));
            $business->wb_perfil_img=$nombre;
        }

        

        $business->save();
        $user->save(); 
        // echo "<img src=".asset(Storage::disk('local')->get("\\imagenes\\".$nombre)).">";//$file;
        return redirect()->route('configuracion.index');
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
