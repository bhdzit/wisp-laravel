@extends('admin.layout')

    @section('content')
    <div class="row">
      <div class="col-xs-12">
            <div class="box">
          <div class="box-header">
            <h3 class="box-title">Tabla de Paquetes</h3>
            <button class="btn btn-primary pull-right" onclick="addPkg()">Agregar Paquete</button>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                      <th>No.</th>
                      <th>Nombre</th>
                      <th>TX</th>
                      <th>RX</th>
                      <th>PRECIO</th>
                      <th>DESCRIPTION</th>
                      <th style="width:60px;">Editar</th>
                      <th style="width:60px;">Eliminar</th>
                </tr>
              </thead>
                  <tbody id="SectorListTable">
                    @forelse($paquetes as $paquete)
                        <tr>
                          <td>{{$paquete->wp_id}} </td>
                          <td>{{$paquete->wp_name}} </td>
                          <td>{{$paquete->wp_tx}} </td>
                          <td>{{$paquete->wp_rx}} </td>
                          <td>{{$paquete->wp_price}} </td>
                          <td>{{$paquete->wp_description}}</td>
                          <td>
                                <button class="btn btn-success" onclick="editPkg({{json_encode($paquete)}})"><i class="fa fa-btn fa-edit"></i></button>
                          </td>
                          <td>
                            <form action="{{ url('paquetes/'.$paquete->wp_id) }}" method="POST">
                              {{ csrf_field() }}
                                {{ method_field('DELETE') }}
                              <button type="submit" class="btn btn-danger"><i class="fa fa-btn fa-trash"></i></button>
                            </form>
                          </td>
                        </tr>
                    @empty
                    <li>No Hay Datos</li>
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
    $('#example1').DataTable({
      "language": {
            "search":         "Buscar:",
           "lengthMenu":     "Mostrar : _MENU_ ",
           "info":           "Paquete _START_ al _END_ de _TOTAL_ Paquetes",
           "paginate": {
              "first":      "Primera",
              "last":       "Ultima",
              "next":       "Siguiente",
              "previous":   "Anterior"
          },
      }
    })

});
    function addPkg(){
      Swal.fire({
      title: 'Agregar Paquete',
        html:@include('sweetAlert2.PaquetesLayout'),

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

    function editPkg(json){
      Swal.fire({
      title: 'Editar Paquete',
      html:@include('sweetAlert2.PaquetesLayout') ,

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
    var url="{{url('paquetes/')}}";
    url+="/"+json.wp_id;

    $('#PaquetesForm').attr('action', url);
    $('#PaquetesForm').append('{{ method_field("PATCH") }}');
    $("#wp_id").val(json.wp_id);
    $("#pkg_name").val(json.wp_name);
    $("#pkg_tx").val(json.wp_tx);
    $("#pkg_rx").val(json.wp_rx);
    $("#pkg_price").val(json.wp_price);
    $("#pkg_description").val(json.wp_description);
    }
    @if($errors->any())
        addPkg();
    @if(old('_method'))

              var url="{{url('paquetes/')}}";
            url+="/"+$("#wp_id").val();

            $('#PaquetesForm').attr('action', url);
            $('#PaquetesForm').append('{{ method_field("PATCH") }}');
    @endif

    @endif
    </script>
    @stop
