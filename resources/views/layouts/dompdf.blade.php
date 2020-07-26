<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title></title>
    <style>
    html{
    width: 100%;
    height: 100%;
    padding: 0;
    margin-left:   5px;

    }
    h5,h3{
      padding: 0;
      margin:   5px;
    }
    label{
      font-size: 15px;
      margin:   5px;
    }
    </style>
  </head>
  <body >
    <div  style="margin: 0px;width: 190px;">

<center>
  @php
   $total=0;
   $date=0;
  @endphp
  <img style="width:100px" src="../public/adminlte/dist/img/zona.png">
    <br>
    <br>
    <label>ZONA ON</label><br>
    <label>EMILIANO ZAPATA 22</label>
    <label>772 114 5890</label><br>
    <label>*SOMOS DIFERENTES*</label>
    <br><br>
      <h5 style="border-top: 2px solid #000;border-bottom: 2px solid #000;" >COMPROBANTE DE PAGO</h5>
      <br>
      <h5><b>{{$request->get('clientName')}}<b/></h5>
      <label style="font-size:17px; border-bottom: 2px solid #000;">Fecha : {{date('d-m-Y h:i')}}</label>



      @foreach($pagos as $pago)
        @php
        $total+=$pago->wps_monto;
        $d=new DateTime(str_replace("'","",$pago->wps_mes));
        $date=$d->format("m")+1;
         @endphp
      <br>
      <label style="display: block; text-align: left;">Servicio No:  00{{$pago->wps_servicios}}</label>
      <label style="display: block; text-align: left;">Mes Pagado:{{$d->format('m-Y')}}</label>
      <label style="display: block; text-align: left;">Plan:  {{getPkg($pago->wps_pkg)}}</label>
      <label style="display: block; text-align: left;">Mesualidad:  $ {{$pago->wps_monto}}</label>

      @endforeach

      <br>
      <h5 style="border-top: 2px solid #000;border-bottom: 2px solid #000;" >Extra</h5>
      @foreach($extras as $extra)
      <label style="display: block; text-align: left;">{{$extra["item"]}} : $ {{$extra["costo"]}}</label>
      @php
      $total+=$extra["costo"]
      @endphp
      @endforeach
      <br>
  <h5 style="border-top: 2px solid #000;border-bottom: 2px solid #000;" ><strong>Corte de servicio a partir del <br>{{'01-'.$date.date('-Y')}}<strong/></h5>
  <br>

  <label style="display: block; text-align: left;">Reconexión:  $ 0.00</label>
  <label style="display: block; text-align: left;">Total ${{$total}} </label>
  <h5 style="text-align: left;"><strong>Le Atendio </strong>:Admin</h5>
  <p style="border-top: 2px solid #000;"></p>
  <br>
<label>* GRACIAS POR
  SU PREFERENCIA*</label>
<center>
</div>
  </body>
</html>
