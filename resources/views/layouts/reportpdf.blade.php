<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- Font Awesome -->
    <title></title>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/css/bootstrap.min.css" integrity="sha384-y3tfxAZXuh4HwSYylfB+J125MxIs6mR5FOHamPBG064zB+AFeWH94NdvaCBm8qnd" crossorigin="anonymous">
  </head>
  <style>
label{
  margin: 0;
}
  </style>
  <body>

<div >
            <img style="width:100px; vertical-align: baseline;" src="../public/adminlte/dist/img/zona.png">

<div style="display:inline-block;margin-left: 100px;">
<br>
<center>
      <label>
          <b>Reporte de Pagos</b>
      </label><br>
      <label><b>ZONA ON<b></label><br>
      <label><b>EMILIANO ZAPATA #22<b></label><br>
      <label><b>772 114 5890<b></label><br>
      </center>
    </div>
<div style="display:inline-block; vertical-align: top;  margin-top: 10px; margin-left: 129px;">    <label><b>30/05/2020</b></label></div>
</div>
<b>
<div style="border:1px solid #000;padding: 10px;">
<div style="margin:10px;">
  <label>Total: $ {{$tableData->sum('wps_monto')}}</label>
  <label style="padding-right:  60px;padding-left : 60px;">Efectivo : $ {{$tableData->where('wps_pay_type','=','Efectivo')->sum('wps_monto')}}</label>
  <label> Deposito : $
    @php
    $deposito=$tableData->where('wps_pay_type','=','Deposito')->sum('wps_monto');


    @endphp
    {{$deposito}}</label>
</div>

<div style="border-top:1px solid #000; margin-left:10px; margin-right:10px;"></div>
<div style=" padding:10px;"><label style="padding-right:  60px;">Despositos:</label>
                                  <label style="padding-right:  60px;">oxxo: $0</label>
                                  <label style="padding-right:  60px;">Coppel: $0</label>
                                  <label>Banamex: $0</label></div>
</div></b>
<table  class="table table-bordered table-striped">
  <thead>
  <tr role="row">
        <th>No.</th>
        <th>Cliente</th>
        <th>Paquete</th>
        <th>METODO</th>
        <th>MES PAGADO</th>
        <th>FECHA</th>
        <th>Monto</th>
  </tr>
</thead>
<tbody>
@php
$i=1;
@endphp
@foreach($tableData as $pago)
<tr>

  <td>{{$i++}}</td>
  <td><small>{{$pago->wc_name}} {{$pago->wc_last_name}}</small></td>
  <td><small>{{$pago->wp_name}}</small></td>
  <td><small>{{$pago->wps_pay_type}}</small></td>
  <td><small>{{$pago->wps_mes}}</small></td>
  <td><small>{{$pago->wps_date}}</small></td>
  <td><small>{{$pago->wps_monto}}</small></td>
  </tr>
@endforeach



</tbody>

</table>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-alpha.2/js/bootstrap.min.js" integrity="sha384-vZ2WRJMwsjRMW/8U7i6PWi6AlO1L79snBrmgiDpgIWJ82z8eA5lenwvxbMV1PAh7" crossorigin="anonymous"></script>
  </body>
</html>
