<?php

namespace App\Http\Controllers;
use App\Torres;
use App\Paquetes;
use App\Servicios;
use App\Clientes;
use DB;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('clientes',[
        'clientes'=>DB::table('wisp_clients')
        ->join('wisp_services','wc_id','=','ws_id_cliente')
        ->join('wisp_sector','wsct_id','=','ws_sector')
        ->join('wisp_pkg','ws_pkg','=','wp_id')
        ->join('wisp_contract','wct_id','=','ws_contract')
        ->select(DB::raw('ST_Y(ws_maps) as lat,ST_X(ws_maps) as lng, INET_NTOA(ws_ip) as ws_ip'),'ws_id','wc_name','wc_last_name','wc_phone','wc_phone2','ws_ssid','ws_pass','ws_pkg','wct_id','wct_nombre','ws_sector','wp_name','ws_date','ws_first_pay_date','wp_id','wsct_name')
        ->get(),
        'services'=>DB::table('wisp_services')
        ->select(DB::raw('INET_NTOA(ws_ip) as ip'),'ws_sector','ws_ip')
        ->orderBy('ws_ip','ASC')
        ->get(),
        'sectores'=>DB::table('wisp_sector')
        ->join('wisp_tower','wsct_tower','=','wt_id')
        ->join('wisp_antenna_type','wsct_antenna','=','wa_id')
        ->leftjoin("wisp_sec_ant","wsct_id","=","wsec_id")
        ->select('wisp_sector.*','wt_nombre','wa_name','wsct_id','wisp_sec_ant.*',DB::raw('INET_NTOA(wsct_address) as ws_ip,ST_X(wt_point) as lat,ST_Y(wt_point) as lng'))
        ->get(),"paquetes"=>Paquetes::get()]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      request()->validate([
        "wc_name"=>["required"],
        "wc_last_name"=>["required"],
        "wc_phone"=>["required","numeric"],
        "wc_phone2"=>["nullable","numeric"],
        "wc_date"=>["required","date_format:Y-m-d"],
        "wc_pay_date"=>["required","date_format:Y-m-d"],
        "wc_pkg"=>["required","numeric"],
        "wc_point"=>["required"],
        "wc_contract"=>["required","numeric"],
        "wc_sector"=>["required","numeric"],
        "wc_ip"=>["required",'regex:/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/' ]
      ]);
      $cliente= new Clientes();
      $cliente->wc_name=$request->get('wc_name');
      $cliente->wc_last_name=$request->get('wc_last_name');
      $cliente->wc_phone=$request->get('wc_phone');
      $cliente->wc_phone2=$request->get('wc_phone2');
      $cliente->save();
      $servicio= new Servicios;
      $servicio->ws_id_cliente=$cliente->wc_id;
      $servicio->ws_date=$request->get('wc_date');
      $servicio->ws_first_pay_date=$request->get('wc_pay_date');
      $servicio->ws_pkg=$request->get('wc_pkg');
      $servicio->ws_maps=\DB::raw("POINT(".$request->get('wc_point').")");
      $servicio->ws_contract=$request->get('wc_contract');
      $servicio->ws_sector=$request->get('wc_sector');
      $servicio->ws_ssid=$request->get('wc_ssid');
      $servicio->ws_pass=$request->get('wc_pass');
      $servicio->ws_ip=\DB::raw("INET_ATON('".$request->get('wc_ip').'\')');
      $servicio->save();
          return redirect()->route('clientes.index');;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
      echo '    <script >
       
      async function setClient(usuario,pass){
             let xmlhttp = new XMLHttpRequest();   // El objeto que te provee el browser
             xmlhttp.open("POST", "http://10.10.1.2/emby/Users/New?api_key=50c386f40d804f35be90080b78c7357d"); // le dices que quieres hacer un POST y a que path relativo
             xmlhttp.setRequestHeader("Content-Type", "application/json"); // le dices que vas a enviar un JSON
             let obj = {
                         "Name": usuario
             };
              // Supongamos este es tu objeto
             let jsonData = JSON.stringify(obj); // Conviertes el objeto a JSON
             xmlhttp.onload = async function(e) {
                         if (this.status == 200) {
                            await resolveAfter2Seconds();
                            configUserCount(JSON.parse(this.response));
                           
                            await resolveAfter2Seconds();
                            setPassword(JSON.parse(this.response),pass);
                             
                         }
                     };
             xmlhttp.send(jsonData) // envías el JSON
             document.write("<br>se Creo el usuario : "+usuario);
             document.write("<br>Contraseña : "+pass );
                 }
             function configUserCount(data){
                 var json=
                     {"IsAdministrator": false,
                     "IsHidden": true,
                     "IsHiddenRemotely": true,
                     "SimultaneousStreamLimit":1};
     
                     let xmlhttp = new XMLHttpRequest();   // El objeto que te provee el browser
             xmlhttp.open("POST", "http://10.10.1.2/emby/Users/"+data.Id+"/Policy?api_key=348cdfd97c0e4277b40b61cb004aa5c9"); // le dices que quieres hacer un POST y a que path relativo
             xmlhttp.setRequestHeader("Content-Type", "application/json"); // le dices que vas a enviar un JSON
              // Supongamos este es tu objeto
             let jsonData = JSON.stringify(json); // Conviertes el objeto a JSON
          
             xmlhttp.send(jsonData) // envías el JSON
             }
         function setPassword(data,pass){
             var json=
             {
                 "Id": data.Id,
                 "CurrentPw": "",
                 "NewPw": pass,
                 "ResetPassword": false
                 };
     
                     let xmlhttp = new XMLHttpRequest();   // El objeto que te provee el browser
             xmlhttp.open("POST", "http://10.10.1.2/emby/Users/"+data.Id+"/Password?api_key=348cdfd97c0e4277b40b61cb004aa5c9"); // le dices que quieres hacer un POST y a que path relativo
             xmlhttp.setRequestHeader("Content-Type", "application/json"); // le dices que vas a enviar un JSON
              // Supongamos este es tu objeto
             let jsonData = JSON.stringify(json); // Conviertes el objeto a JSON
             xmlhttp.send(jsonData) // envías el JSON
          
     
         }
             function resolveAfter2Seconds() {
                     return new Promise(resolve => {
                         setTimeout(() => {
                         resolve("resolved");
                         }, 5000);
                     });
                     }
             function getRandomPassword(){
                 var text="";
                 var code=Math.floor(Math.random() * 10)+97;
                 text+=String.fromCharCode(code);
                 text+=Math.floor(Math.random() * 10);
                 code=Math.floor(Math.random() * 10)+97;
                text+=String.fromCharCode(code);
                text+=Math.floor(Math.random() * 10);
                return text;
             }

     
         </script>';
        $clientes=DB::table('wisp_clients')
        ->join('wisp_services','wc_id','=','ws_id_cliente')
        ->join('wisp_sector','wsct_id','=','ws_sector')
        ->join('wisp_pkg','ws_pkg','=','wp_id')
        ->join('wisp_contract','wct_id','=','ws_contract')
        ->select(DB::raw('ST_Y(ws_maps) as lat,ST_X(ws_maps) as lng, INET_NTOA(ws_ip) as ws_ip'),'ws_id','wc_name','wc_last_name','wc_phone','wc_phone2','ws_ssid','ws_pass','ws_pkg','wct_id','wct_nombre','ws_sector','wp_name','ws_date','ws_first_pay_date','wp_id','wsct_name')
        ->get();
       
        foreach($clientes as $cliente){
          $pass="";
          echo '<br>ZO#C'.$cliente->ws_id;
          $pass.=chr(rand(97,122));
          $pass.=rand(0,9);
          $pass.=chr(rand(97,122));
          $pass.=rand(0,9);
        }
        $usu='ZO#C'.$cliente->ws_id;
        echo '<script>setClient("'.$usu.'","'.$pass.'");</script>';
        DB::insert('insert into wisp_emby values(?,?,?)',[$cliente->ws_id,$usu,$pass]);
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
      request()->validate([
        "wc_name"=>["required"],
        "wc_last_name"=>["required"],
        "wc_phone"=>["required","numeric"],
        "wc_phone2"=>["nullable","numeric"],
        "wc_date"=>["required","date_format:Y-m-d"],
        "wc_pay_date"=>["required","date_format:Y-m-d"],
        "wc_pkg"=>["required","numeric"],
        "wc_point"=>["required"],
        "wc_contract"=>["required","numeric"],
        "wc_sector"=>["required","numeric"],
        "wc_ip"=>["required",'regex:/^(?:(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)\.){3}(?:25[0-5]|2[0-4][0-9]|[01]?[0-9][0-9]?)$/' ]
      ]);
      
      $servicio= Servicios::find($id);
      $servicio->ws_date=$request->get('wc_date');
      $servicio->ws_first_pay_date=$request->get('wc_pay_date');
      $servicio->ws_pkg=$request->get('wc_pkg');
      $servicio->ws_maps=\DB::raw("POINT(".$request->get('wc_point').")");
      $servicio->ws_contract=$request->get('wc_contract');
      $servicio->ws_sector=$request->get('wc_sector');
      $servicio->ws_ssid=$request->get('wc_ssid');
      $servicio->ws_pass=$request->get('wc_pass');
      $servicio->ws_ip=\DB::raw("INET_ATON('".$request->get('wc_ip').'\')');
      $servicio->save();

      $cliente= Clientes::find($servicio->ws_id_cliente);
      $cliente->wc_name=$request->get('wc_name');
      $cliente->wc_last_name=$request->get('wc_last_name');
      $cliente->wc_phone=$request->get('wc_phone');
      $cliente->wc_phone2=$request->get('wc_phone2');
      $cliente->save();
      return redirect()->route('clientes.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Servicios::destroy($id);
        return redirect()->route('clientes.index');
    }
}
