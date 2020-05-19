@extends('admin.layout')

    @section('content')
    <div class="row">
      <div class="col-xs-12">
            <div class="box">
          <div class="box-header">
            <h3 class="box-title">Tabla de Sectores</h3>
            <button class="btn btn-primary pull-right" onclick="addSector()">Agregar Sector</button>
          </div>
          <!-- /.box-header -->
          <div class="box-body">
            <table id="example1" class="table table-bordered table-striped">
              <thead>
                <tr role="row">
                      <th>No.</th>
                      <th>Nombre</th>
                      <th>Torre</th>
                      <th>Tipo de Antena</th>
                      <th style="width:60px;">Editar</th>
                      <th style="width:60px;">Eliminar</th>
                </tr>
              </thead>
                  <tbody id="SectorListTable">
                    @forelse($sectores as $sector)
                        <tr>
                          <td>{{$sector->wsct_id}} </td>
                          <td>{{$sector->wsct_name}} </td>
                          <td>{{$sector->wt_nombre}} </td>
                          <td>{{$sector->wa_name}} </td>
                          <td>
                                <button class="btn btn-success" onclick="editSector({{json_encode($sector)}},{{json_encode(DB::select('select * from wisp_sec_ant where wsec_id=?',[$sector->wsct_id]))}})"><i class="fa fa-btn fa-edit"></i></button>
                          </td>
                          <td>
                            <form action="{{ url('sectores/'.$sector->wsct_id) }}" method="POST">
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
    function addSector(){
    Swal.fire({
      title: 'Agregar Sector',
      html:@include('sweetAlert2.SectorLayout'),
      width:'60%',
      showClass: {
        popup: 'animated fadeInDown faster'

      },

      hideClass: {
        popup: 'animated fadeOutUp faster'
      },
      preConfirm:function(){
        document.getElementById("send_btn").click();
      }
    });

    setMap();
    var a=('{{json_encode(($towers->toArray()),JSON_FORCE_OBJECT)}}');
    a=JSON.parse(a.replace(/&quot;/g,"\""));
   setSectorTowerAndAntennasEvents(a);


    }
    function editSector(sector,sec){

      Swal.fire({
        title: 'Agregar Sector',
        html:@include('sweetAlert2.SectorLayout'),
        width:'60%',
        showClass: {
          popup: 'animated fadeInDown faster'

        },

        hideClass: {
          popup: 'animated fadeOutUp faster'
        },
        preConfirm:function(){
          document.getElementById("send_btn").click();
        }
      });
      var url="{{url('sectores/')}}";
      url+="/"+sector.wsct_id;

       $('#SectorForm').attr('action', url);

       $('#SectorForm').append('{{ method_field("PATCH") }}');

       setMap();
       var a=('{{json_encode(($towers->toArray()),JSON_FORCE_OBJECT)}}');
       a=JSON.parse(a.replace(/&quot;/g,"\""));
      setSectorTowerAndAntennasEvents(a);
        if(sector.wsct_antenna==1){
            $('#deg').val(sec[0].wsec_deg);
            $('#apper').val(sec[0].wsec_rank);
        }
    $('#wsct_name').val(sector.wsct_name);
    $("#wsct_antennatype").val(sector.wsct_antenna);
    $("#wsct_tower").val(sector.wsct_tower);
    $("#wsct_address").val(sector.wsct_address);
    $("#wsct_description").val(sector.wsct_description);
    $("#wsct_dist").val(sector.wsct_dist);
    $("#wsct_tower").trigger('change');
    $("#wsct_antennatype").trigger('change');
    }
    </script>
    @stop
