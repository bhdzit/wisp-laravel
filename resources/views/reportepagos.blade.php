@extends('admin.layout')
@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">

        <div class="box-header with-border">
          <h3 class="box-title"><Strong>Reporte de pagos</Strong></h3><i style="color: #aeb5b9;margin-left: 3px;" class="fas fa-angle-double-right"></i><a> Pagos del mes</a>
        </div>
        <div class="row" style="margin: 16px 16px 0px 16px;" hidden id="filter-row">
          <form target="{{route('reportepagos.data')}}" action="{{route('reportepagos.data')}}" method="POST">

            @csrf
            <input type="hidden" name="pdf">
            <input type="hidden" name="filter" id="filterpdf" value="1">
            <input type="hidden" name="filterTime" id="filterTimepdf">
            <button style="margin-right: 20px;" type="submit" class="btn btn-primary pull-right"><i class="fas fa-print " aria-hidden="true"></i></button>
          </form>
          <form target="{{route('reportepagos.data')}}" action="{{route('reportepagos.data')}}" method="POST" id="reportFrom">
            @csrf
            <input style="margin-right: 5px;" class="btn btn-primary hidden" type="submit" value="Aplicar">
            <div class="form-group col-md-3 ">
              <select name="filter" id="filter" class="form-control">
                <option value="1">Pagos</option>
                <option value="2">Depositos</option>
                <option value="3">Credito</option>
                <option value="4">Meses Gratis</option>
                <option value="5">Cortes del Mes</option>

              </select>
            </div>
            <div id="dateDivFilter" class="form-group col-md-3 ">
              <input type="text" name="filterTime" class="form-control pull-right" id="reservationtime" value="DEl MES">
            </div>
          </form>
        </div>


      </div>
      <div class="box-body">
        <div class="row" id="charging-row">
          <div class="charging">
            <div class="col-lg-12 col-md-12 col-sm-4 col-xs-12">
              <div class="preloader-single mt-b-30">
                <div class="ts_preloading_box">
                  <div id="ts-preloader-absolute02">
                    <div class="tsperloader2" id="tsperloader2_four"></div>
                    <div class="tsperloader2" id="tsperloader2_three"></div>
                    <div class="tsperloader2" id="tsperloader2_two"></div>
                    <div class="tsperloader2" id="tsperloader2_one"></div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <table id="paysTable" class="table table-bordered table-striped" style="display: none;">
          <thead>
            <tr id="thAllPays">
              <th colspan="2">Total : <b id='totalPay'>$ {{$pagos->whereNull('wdp_pay')->sum('wps_monto')}}</b></th>
              <th colspan="2">Efectivo : <b id='totalCash'>$ {{$pagos->where('wps_pay_type','=','Efectivo')->whereNull('wdp_pay')->sum('wps_monto')}}</b></th>
              <th colspan="2">Deposito :
                <b id="totalDep">$
                  @php
                  $deposito=$pagos->where('wps_pay_type','=','Deposito')->whereNull('wdp_pay')->sum('wps_monto');


                  @endphp
                  {{$deposito}}
                </b></th>
              <th colspan="2">Pagos Retardados : <b id='totalSuspend'>{{$cortes->count()}}</b></th>
            </tr>

            <tr id="thDeposit" hidden>
              <th colspan="2">Total : $ {{$deposito}}</th>
              <th colspan="2">Oxxo : </th>
              <th colspan="2">Banamex : </th>
              <th colspan="2">Coppel : </th>
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
              <td>
                <form target="{{route('pagos.data')}}" action="{{route('pagos.data')}}" method="POST">
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
                </form>
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
          </tfoot>
        </table>
        <table id="suspendTable" class="table table-bordered table-striped" hidden>
          <thead>
            <tr role="row">
              <th>No.</th>
              <th>Cliente</th>
              <th>Accion</th>
              <th>Aplicar</th>
            </tr>
          </thead>
          <tbody>
            @php
            $i=1;
            @endphp
            @foreach($cortes as $corte)
            <tr class="clietnSupendRow">
              <td>{{$i++}}</td>
              <td>{{$corte->wc_name." ".$corte->wc_last_name}}</td>
              <td>
                <input type="text" value="{{$corte->ws_id}}" hidden>
                <select class="form-control clietnSupendAction">
                  <option value="1">Suspender</option>
                  <option value="2">Mes Gratis</option>
                  <option value="3">Dar Credito</option>
                </select>
                <select class="form-control" style="display: none">
                  <option value="1">1 mes</option>
                  @for($j=2;$j<=12;$j++) <option value="{{$j}}">{{$j." meses"}}</option>
                    @endfor
                </select>
                <input type="text" value="{{$corte->wp_price}}" hidden>
              </td>
              <td>
                <form action="{{route('reportepagos.store')}}" method="POST">@csrf<button type="submit" class="btn btn-success"><i class="fas fa-check"></i></button></form>
              </td>
            </tr>

            @endforeach
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
  //$('#paysTable').hide();
  
  

  window.onload = function() {
   hideCharingBar();
  };
  var table;
  $(function() {

    table = $('#paysTable').DataTable({
      "language": {
        "search": "Buscar:",
        "lengthMenu": "Mostrar : _MENU_ ",
        "info": "Pago _START_ al _END_ de _TOTAL_ Pagos",
        "paginate": {
          "first": "Primera",
          "last": "Ultima",
          "next": "Siguiente",
          "previous": "Anterior"
        },
      }
    })

  });

  $('#reservationtime').daterangepicker({
    locale: {
      format: 'DD/MM/Y',
      "daysOfWeek": [
        "Dom",
        "Lun",
        "Mar",
        "Mir",
        "Jue",
        "Vie",
        "Sab"
      ],
      "monthNames": [
        "Enero",
        "Febrero",
        "Marzo",
        "Abril",
        "Mayo",
        "Junio",
        "Julio",
        "Agosto",
        "Septiembre",
        "Octubre",
        "Noviembre",
        "Diciembre"
      ],
    },
    ranges: {
      'Hoy': [moment(), moment()],
      'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
      'Ultimos 7 Días': [moment().subtract(6, 'days'), moment()],
      'Ultimos 30 Días': [moment().subtract(29, 'days'), moment()],
      'Este Mes': [moment().startOf('month'), moment().endOf('month')],
      'Ultimo Mes': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
    }
  });
  $('#filterTimepdf').val($('#reservationtime').val());
  $('#reservationtime').on('change', function(evt) {
    $('#filterTimepdf').val(evt.target.value);
  });

  $('#filter').on('change', function(evt) {
    $("#reportFrom").submit();
    //$('#dateDivFilter')[0].hidden=evt.target.value=SELECT_DAY_FILTER?true:false;
    if (CUTS_OF_MONTH != evt.target.value) {
      $('#dateDivFilter').removeAttr('hidden');

    } else {
      $('#dateDivFilter').attr('hidden', 'true');

    }
    $('#filterpdf').val(evt.target.value);

  });
  $('#reservationtime').on('change', function(evt) {
    showCharingbar();
    $("#reportFrom").submit();
  });

</script>
@stop