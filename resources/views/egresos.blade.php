@extends('admin.layout')
  @section('content')
  <div class="row">
    <div class="col-xs-12">
          <div class="box">
        <div class="box-header">
          <h3 class="box-title">Tabla de egresos</h3>
          <button class="btn btn-primary pull-right" onclick="addEgreso()">Agregar Egreso</button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
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
              @foreach($egresos as $egreso )
                  <tr>
                    <td>{{$i++}}</td>
                    <td>{{$egreso->we_desciption}} </td>
                    <td>$ {{$egreso->we_prices}}</td>
                    <td>
                          <button class="btn btn-success" onclick="editEgreso({{json_encode($egreso)}})"><i class="fa fa-btn fa-edit"></i></button>
                    </td>
                    <td>
                      <form action="{{ url('egresos/'.$egreso->we_id) }}" method="POST">
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
    function addEgreso(){
            Swal.fire({
            title: 'Agregar Egreso',
              html:'<form  id="ClienteForm" method="POST" action="{{route('egresos.store')}}" >'+
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
    function editEgreso(Egreso){
            Swal.fire({
            title: 'Agregar Egreso',
              html:'<form  id="ClienteForm" method="POST" action="{{route('egresos.store')}}" >'+
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
          var url="{{url('egresos/')}}";
          url+="/"+Egreso.we_id;
          $('#ClienteForm').attr('action', url);
          $('#ClienteForm').append('{{ method_field("PATCH") }}');
          $("#precio").val(Egreso.we_prices);
          $("#descripcion").val(Egreso.we_desciption);
    }
  </script>
  @stop
