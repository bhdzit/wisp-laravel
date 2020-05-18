@extends('admin.layout')

    @section('content')
    <div class="row">
      <div class="col-xs-12">
            <div class="box">
          <div class="box-header">
            <h3 class="box-title">Pagos del Día</h3>
             <button type="submit" class="btn btn-primary pull-right"><i class="fas fa-print " aria-hidden="true"></i></button>
            <a style="margin-right: 10px;" href="{{route('pagos.index')}}/agregarpago" class="btn btn-primary pull-right" href="">Agregar Pagos</a>
            <a style="margin-right: 10px;" href="{{route('pagos.index')}}/reportepagos" class="btn btn-primary pull-right" href="">Reporte de Pagos</a>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr>
                  <th>Total :</th><th><b id='totalPay'>$ {{$pagos->sum('wps_monto')}}</b></th>
                  <th>Efectivo :</th><th><b id='totalPay'>$ {{$pagos->where('wps_pay_type','=','Efectivo')->sum('wps_monto')}}</b></th>
                  <th>Deposito :</th><th><b id='totalPay'>$ {{$pagos->where('wps_pay_type','=','Deposito')->sum('wps_monto')}}</b></th>

                </tr>
                <tr role="row">
                      <th>No.</th>
                      <th>Cliente</th>
                      <th>Paquete</th>
                      <th>METODO</th>
                      <th>FECHA</th>
                      <th style="width:60px;">Imprimir</th>
                      <th style="width:60px;">Eliminar</th>
                </tr>
              </thead>
                  <tbody id="SectorListTable">
                    @forelse($pagos as $pago)
                    <tr>
                      <td>{{$pago->wps_id}}</td>
                      <td>{{$pago->wc_name}} {{$pago->wc_last_name}}</td>
                      <td>{{$pago->wp_name}}</td>
                      <td>{{$pago->wps_pay_type}}@php setSmall($pago)@endphp<span class="pull-right-container">
            </span></td>
                      <td>{{$pago->wps_date}}</td>
                      <td><button type="submit" class="btn btn-primary"><i class="fas fa-print"></i></button></td>
                      <td>
                        <form action="{{ url('pagos/'.$pago->wps_id) }}" method="POST">
                          {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                          <button type="submit" class="btn btn-danger"><i class="fa fa-btn fa-trash"></i></button>
                        </form>
                      </td>
                    </tr>
                    @empty
                    @endforelse
                  </tbody>
              <tfoot>
              </tfoot>
            </table>
          </div>
          <!-- /.box-body -->
        </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    @stop
    @section('script')
    <script type="text/javascript">
    $(function () {

        $('#example1').DataTable();

    });
    </script>
    @stop
