@extends('admin.layout')

    @section('content')

    <div class="row">
      <div class="col-xs-12">
            <div class="box">
          <div class="box-header">
            <h3 class="box-title">Tabla de Clientes</h3>
            <button class="btn btn-primary pull-right" onclick="addClient()">Agregar Cliente</button>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                      <th>No.</th>
                      <th>Clientes</th>
                      <th>Paquete</th>
                      <th>Tipo de Contrato</th>
                      <th>Fecha de Contrato</th>
                      <th>QR</th>
                      <th style="width:60px;">Editar</th>
                      <th style="width:60px;">Eliminar</th>
                </tr>
              </thead>
                  <tbody id="SectorListTable">
                    @forelse($clientes as $cliente)
                        <tr>
                          <td>{{$cliente->ws_id}} </td>
                          <td>{{$cliente->wc_name}} {{$cliente->wc_last_name}} </td>
                          <td>{{$cliente->wp_name}} </td>
                          <td>{{$cliente->wct_nombre}}</td>
                          <td>{{$cliente->ws_date}}</td>
                          <td><i class="fas fa-qrcode" style=color:#000;  onclick='showQR(JSON.stringify({{json_encode($cliente)}}))'></i></td>
                          <td>
                                <button class="btn btn-success" onclick="editClient({{json_encode($cliente)}})"><i class="fa fa-btn fa-edit"></i></button>
                          </td>
                          <td>
                            <form action="{{ url('clientes/'.$cliente->ws_id) }}" method="POST">
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
        $('#example1').DataTable()

    });
    function addClient(){
      Swal.fire({
      title: 'Agregar Cliente',
      html:@include('sweetAlert2.ClienteLayout'),
      width:'60%',
      showClass: {
        popup: 'animated fadeInDown faster'
      },
      hideClass: {
        popup: 'animated fadeOutUp faster'
      },
      preConfirm: function(){
            document.getElementById("send_btn").click();
            return false;
          }

    });
      setMap();
      map.addEventListener('tap',function(evt){
        var coord = map.screenToGeo(evt.currentPointer.viewportX,
                evt.currentPointer.viewportY);
          if(marker!=null){
            map.removeObject(marker);
          }
          $("#wc_point").val(coord.lng+","+coord.lat);
          addMarck({lat:coord.lat,lng:coord.lng});
      });


    }
    function editClient(json){

          Swal.fire({
            title: 'Editar Cliente',
            html:@include('sweetAlert2.ClienteLayout'),
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
            var url="{{url('clientes/')}}";
            url+="/"+json.ws_id;

             $('#ClienteForm').attr('action', url);

             $('#ClienteForm').append('{{ method_field("PATCH") }}');
            setMap();

              $("#wc_id").val(json.ws_id);
              $("#wc_name").val(json.wc_name);
              $("#wc_last_name").val(json.wc_last_name);
              $("#wc_phone").val(json.wc_phone);
              $("#wc_phone2").val(json.wc_phone2);
              $("#wc_mail").val(json.wc_mail);
              $("#wc_date").val(json.ws_date);
              $("#wc_pay_date").val(json.ws_first_pay_date);
              $("#wc_pkg").val(json.wp_id);
              $("#wc_ip").val(json.ws_ip);
              $("#wc_ssid").val(json.ws_ssid);
              $("#wc_pass").val(json.ws_pass);
              $("#wc_contract").val(json.wct_id);
              $("#wc_sector").val(json.ws_sector);
              $("#wc_point").val(json.lng+","+json.lat);

            addMarck({lat:json.lat,lng:json.lng});
            map.addEventListener('tap',function(evt){
              var coord = map.screenToGeo(evt.currentPointer.viewportX,
                      evt.currentPointer.viewportY);
                if(marker!=null){
                  map.removeObject(marker);
                }
                $("#wc_point").val(coord.lng+","+coord.lat);
                addMarck({lat:coord.lat,lng:coord.lng});
            });


    }
    @if($errors->any())
        addClient();
      @if(old('_method'))

              var url="{{url('clientes/')}}";
              url+="/"+$("#wc_id").val();

               $('#ClienteForm').attr('action', url);

               $('#ClienteForm').append('{{ method_field("PATCH") }}');
      @endif

      $("#wc_pkg").val({{old("wc_pkg")}});
        $("#wc_contract").val({{old("wc_pkg")}});
          $("#wc_sector").val({{old("wc_sector")}});
    @endif
    </script>
    @stop
