@extends('admin.layout')

@section('content')

<!-- Content Wrapper. Contains page content -->

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1> Dashboard </h1>
    <ol class="breadcrumb">
        <li class="active">Here</li>
    </ol>
</section>

<!-- Main content -->
<section class="content container-fluid">
    <div class="row">
        <div class="col-md-6">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#tab_1" data-toggle="tab" aria-expanded="true">Tab 1</a></li>
                    <li class=""><a href="#tab_2" data-toggle="tab" aria-expanded="false">Tab 2</a></li>
                    <li class=""><a href="#tab_3" data-toggle="tab" aria-expanded="false">Tab 3</a></li>
                    <li class="pull-right"><a href="#" class="text-muted"><i class="fa fa-gear"></i></a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="tab_1">
                        <!-- LINE CHART -->
                        <div class="box box-info">

                            <div class="box-header with-border">



                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="line-chart"></div>

                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_2">
                        <!-- LINE CHART -->
                        <div class="box box-info">

                            <div class="box-header with-border">
                                <div class="box-tools pull-right">
                                    <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                            class="fa fa-minus"></i>
                                    </button>
                                    <button type="button" class="btn btn-box-tool" data-widget="remove"><i
                                            class="fa fa-times"></i></button>
                                </div>
                            </div>
                            <div class="box-body chart-responsive">
                                <div class="chart" id="service-year" style="height:400px;width:480px;"></div>

                                <!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="tab_3">

                    </div>
                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
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
                        <li><a href="#">Instalaciones del Mes<span class="pull-right badge bg-blue">0</span></a></li>
                        <li><a href="#">Servicios <span
                                    class="pull-right badge bg-aqua">{{$clientes->count()}}</span></a></li>
                        <li><a href="#">Pagos del Mes<span class="pull-right badge bg-green">{{$monthpays}}</span></a>
                        </li>
                        <li><a href="#">Egresos del Mes<span class="pull-right badge bg-red">0</span></a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@stop
@section('script')
<script src="adminlte/bower_components/raphael/raphael.min.js"></script>
<script src="adminlte/bower_components/morris.js/morris.min.js"></script>
<script type="text/javascript">


var line =  new Morris.Line({
  // ID of the element in which to draw the chart.
  element: 'service-year',
  // Chart data records -- each entry in this array corresponds to a point on
  // the chart.
  data: [
    { year: '2008', value: 20 },
    { year: '2009', value: 10 },
    { year: '2010', value: 5 },
    { year: '2011', value: 5 },
    { year: '2012', value: 20 }
  ],
  // The name of the data record attribute that contains x-values.
  xkey: 'year',
  // A list of names of data record attributes that contain y-values.
  ykeys: ['value'],
  // Labels for the ykeys -- will be displayed when you hover over the
  // chart.
  labels: ['Value']
});
var line = new Morris.Line({
    element: 'line-chart',
    resize: true,
    data: [
        @foreach($servicios as $servicio) {
            fecha: '{{$servicio->month_est}}',
            noclientes: '{{($servicio->num_clients)}}'
        },
        @endforeach

    ],
    xkey: 'fecha',
    ykeys: ['noclientes'],
    labels: ['Item 1'],
    lineColors: ['#3c8dbc'],


});
</script>
@stop