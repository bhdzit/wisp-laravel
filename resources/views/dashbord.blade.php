@extends('admin.layout')

@section('content')

    <!-- Content Wrapper. Contains page content -->

      <!-- Content Header (Page header) -->
      <section class="content-header">
        <h1> Dashboard </h1>
        <ol class="breadcrumb">
          <li><a href="#"><i class="fa fa-dashboard"></i> Level</a></li>
          <li class="active">Here</li>
        </ol>
      </section>

      <!-- Main content -->
      <section class="content container-fluid">
        <div class="row">
                <!-- /.col (LEFT) -->
                <div class="col-md-6">
                  <!-- LINE CHART -->
                  <div class="box box-info">

                      <div class="box-header with-border">
                        <h3 class="box-title">No. Clientes</h3>

                        <div class="box-tools pull-right">
                          <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-minus"></i>
                          </button>
                          <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
                        </div>
                      </div>
                      <div class="box-body chart-responsive">
                        <div class="chart" id="line-chart" style="height: 300px;"></div>

                    <!-- /.box-body -->
                  </div>
                </div>

                </div>
              <div class="col-md-6">

            <!-- Widget: user widget style 1 -->
            <div class="box box-widget widget-user-2">
              <!-- Add the bg color to the header using any of the bg-* classes -->
              <div class="widget-user-header bg-yellow card-header">
                <h4>Pendientes</h4>

              </div>
              <div class="box-footer no-padding">
                <ul class="nav nav-stacked">
                  <li><a href="#">Instalaciones <span class="pull-right badge bg-blue">31</span></a></li>
                  <li><a href="#">Servicios <span class="pull-right badge bg-aqua">5</span></a></li>
                  <li><a href="#">Pagos de Servicios<span class="pull-right badge bg-green">12</span></a></li>
                  <li><a href="#">Pagos de Clientes<span class="pull-right badge bg-red">842</span></a></li>
                </ul>
              </div>
            </div>

            </div>
              </div>
      </section>
      <!-- /.content -->

    <!-- /.content-wrapper -->

@stop
@section('script')
<script src="adminlte/bower_components/raphael/raphael.min.js"></script>
<script src="adminlte/bower_components/morris.js/morris.min.js"></script>
<script type="text/javascript">

var line = new Morris.Line({
  element: 'line-chart',
  resize: true,
  data: [
/*    @php $previusDate=$clientes[0]->ws_date; @endphp
    @for($i=0;$i<sizeof($clientes);$i++)
      {{date('M-Y',strtotime($previusDate))}},{{date('M-Y',strtotime($clientes[$i]->ws_date))}}
      @if(date('M-Y',strtotime($previusDate))<date('M-Y',strtotime($clientes[$i]->ws_date)))
        {y: '{{$clientes[$i]->ws_date}}',item1: '{{($i+1)}}'},
          @php $previusDate=$clientes[$i]->ws_date @endphp
      @endif
    @endfor*/

  ],
  xkey: 'y',
  ykeys: ['item1'],
  labels: ['Item 1'],
  lineColors: ['#3c8dbc'],


});
</script>
@stop
