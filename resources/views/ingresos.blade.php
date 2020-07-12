@extends('admin.layout')
  @section('content')
  <div class="row">
    <div class="col-xs-12">
          <div class="box">
        <div class="box-header">
          <h3 class="box-title">Tabla de Ingresos</h3>
          <button class="btn btn-primary pull-right" onclick="addIngreso()">Agregar Ingreso</button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">

            <thead>
                <tr>
                    <th colspan="5">Igresos del Mes : <span>$ 13,000</span> </th>
                </tr>
              <tr role="row">
                    <th>No.</th>
                    <th>Descripcion</th>
                    <th>PRECIO</th>
                    <th style="width:60px;">Editar</th>
                    <th style="width:60px;">Eliminar</th>
              </tr>
            </thead>
            <tbody>
              @php $i=1;@endphp
              @foreach($ingresos as $ingreso )
                  <tr>
                    <td>{{$i++}}</td>
                    <td>{{$ingreso->wi_desciption}} </td>
                    <td>$ {{$ingreso->wi_prices}}</td>
                    <td>
                          <button class="btn btn-success" onclick="editIngreso({{json_encode($ingreso)}})"><i class="fa fa-btn fa-edit"></i></button>
                    </td>
                    <td>
                      <form action="{{ url('ingresos/'.$ingreso->wi_id) }}" method="POST">
                        {{ csrf_field() }}
                          {{ method_field('DELETE') }}
                        <button type="submit" class="btn btn-danger"><i class="fa fa-btn fa-trash"></i></button>
                      </form>
                    </td>
                  </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  @stop
  @section('script')
<script type="text/javascript">
  function addIngreso(){
          Swal.fire({
          title: 'Agregar Ingreso',
            html:'<form  id="ClienteForm" method="POST" action="{{route('ingresos.store')}}" >'+
            @include('sweetAlert2.IngresosEgresosLayout'),
      width:'60%',
          showClass: {
            popup: 'animated fadeInDown faster'
          },
          hideClass: {
            popup: 'animated fadeOutUp faster'
          },
          preConfirm:function(){
        document.getElementById("send_btn").click();
        return false;
              }

        });
  }
  function editIngreso(ingreso){
          Swal.fire({
          title: 'Agregar Ingreso',
            html:'<form  id="ClienteForm" method="POST" action="{{route('ingresos.store')}}" >'+
            @include('sweetAlert2.IngresosEgresosLayout'),
      width:'60%',
          showClass: {
            popup: 'animated fadeInDown faster'
          },
          hideClass: {
            popup: 'animated fadeOutUp faster'
          },
          preConfirm:function(){
        document.getElementById("send_btn").click();
        return false;
              }

        });
        var url="{{url('ingresos/')}}";
        url+="/"+ingreso.wi_id;
        $('#ClienteForm').attr('action', url);
        $('#ClienteForm').append('{{ method_field("PATCH") }}');
        $("#precio").val(ingreso.wi_prices);
        $("#descripcion").val(ingreso.wi_desciption);
  }
</script>
@stop
