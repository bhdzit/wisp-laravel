@extends('admin.layout')
@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 class="box-title">Reporte de pagos</h3>
        <div class="row" >
        <form action="{{route('reportepagos.data')}}" method="POST" id="reportFrom">
          @csrf
            <input style="margin-right: 20px;" class="btn btn-primary pull-right" type="submit"  value="Aplicar">
          <div class="form-group col-md-3 pull-right">
                    <select name="filter" id="filter" class="form-control">
                      <option value="1">Todos los Pagos</option>
                      <option value="2">Pagos de Mes</option>
                      <option value="3">Fecha</option>
                      <option value="4">Cortes del Mes</option>
                      <option value="5">Deposito del Mes</option>
                    </select>
                  </div>
                  <div class="form-group col-md-3 pull-right">
                        <input type="text" name="filterTime" class="form-control pull-right" id="reservationtime" hidden>
                  </div>
              </form>
          </div>


      </div>
      <div class="box-body">

      <table id="paysTable" class="table table-bordered table-striped">
        <thead>
          <tr>
            <th>Total :</th><th><b id='totalPay'>$ {{$pagos->sum('wps_monto')}}</b></th>
            <th>Efectivo :</th><th><b id='totalPay'>$ {{$pagos->where('wps_pay_type','=','Efectivo')->sum('wps_monto')}}</b></th>
            <th>Deposito :</th><th><b id='totalPay'>$ {{$pagos->where('wps_pay_type','=','Deposito')->sum('wps_monto')}}</b></th>
            <th>Pagos Retardados</th><th><b id='totalPay'>{{$cortes->count()}}</b></th>
          </tr>
          <tr role="row">
                <th>No.</th>
                <th>Cliente</th>
                <th>Paquete</th>
                <th>METODO</th>
                <th>MES PAGADO</th>
                <th>FECHA</th>
                <th style="width:60px;">Imprimir</th>
                <th style="width:60px;">Eliminar</th>
          </tr>
        </thead>
            <tbody id="PaysTableBody">
              @php
              $i=1;
              @endphp
              @foreach($pagos as $pago)
              <tr>

                <td>{{$i++}}</td>
                <td>{{$pago->wc_name}} {{$pago->wc_last_name}}</td>
                <td>{{$pago->wp_name}}</td>
                <td>{{$pago->wps_pay_type}}@php setSmall($pago)@endphp</td>
                <td>{{$pago->wps_mes}}</td>
                <td>{{$pago->wps_date}}</td>
                <td>    <form  target="{{route('pagos.data')}}" action="{{route('pagos.data')}}" method="POST">
                      @csrf
                      <input type="hidden" name="payid" value="{{$pago->wps_id}}">
                    <input type="hidden" name="clientName" value="{{$pago->wc_name}} {{$pago->wc_last_name}}">
                    <button type="submit" class="btn btn-primary"><i class="fas fa-print"></i></button>
                  </form>
                </td>
                <td>
                  <form action="{{ url('pagos/'.$pago->wps_id) }}" method="POST">
                    {{ csrf_field() }}
                      {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger"><i class="fa fa-btn fa-trash"></i></button>
                  </form></td>
              </tr>
              @endforeach
            </tbody>
        <tfoot>
        </tfoot>
      </table>
      <table id="suspendTable" class="table table-bordered table-striped" hidden>
        <thead><tr role="row"><th>No.</th><th>Cliente</th><th>Accion</th><th>Aplicar</th></tr></thead>
        <tbody>
          @php
          $i=1;
          @endphp
              @forelse($cortes as $corte)
              <tr class="clietnSupendRow">
                <td>{{$i++}}</td><td>{{$corte->wc_name." ".$corte->wc_last_name}}</td>
                <td>
                  <input type="text" value="{{$corte->ws_id}}" hidden>
                  <select class="form-control clietnSupendAction" >
                  <option value="1">Suspender</option>
                  <option value="2">Mes Gratis</option>
                  <option value="3">Dar Credito</option>
                  </select>
                <select class="form-control" style="display: none" >
                <option value="1">1 mes</option>
                  @for($j=2;$j<=12;$j++)
                  <option value="{{$j}}">{{$j." meses"}}</option>
                  @endfor
                </select>
                <input type="text" value="{{$corte->wp_price}}" hidden>
              </td>
                <td><form action="{{route('reportepagos.store')}}" method="POST">@csrf<button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button></form></td>
              </tr>
              @empty
              @endforelse
        </tbody>
      </table>
    </div>
    </div>
    <!-- /.box -->
  </div>
  <!-- /.col -->
</div>
@stop
@section('script')
<script src="/adminlte/bower_components/moment/min/moment.min.js"></script>
<script src="/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- bootstrap datepicker -->
<script src="/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- bootstrap color picker -->
<script type="text/javascript">
var table;
$(function () {

table=$('#paysTable').DataTable({
  "language": {
        "search":         "Buscar:",
       "lengthMenu":     "Mostrar : _MENU_ ",
       "info":           "Pago _START_ al _END_ de _TOTAL_ Pagos",
       "paginate": {
          "first":      "Primera",
          "last":       "Ultima",
          "next":       "Siguiente",
          "previous":   "Anterior"
      },
  }
})

});
$('#reservationtime').daterangepicker({
  locale: {
     format: 'Y-MM-DD'
   }
});

</script>
@stop
