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
                                <button class="btn btn-success" onclick="editSector({{json_encode($sector)}})"><i class="fa fa-btn fa-edit"></i></button>
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
      $('#example1').DataTable({
        "language": {
              "search":         "Buscar:",
             "lengthMenu":     "Mostrar : _MENU_ ",
             "info":           "Sector _START_ al _END_ de _TOTAL_ Sectores",
             "paginate": {
                "first":      "Primera",
                "last":       "Ultima",
                "next":       "Siguiente",
                "previous":   "Anterior"
            },
        }
      })

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
        return false;
      }
    });

    setMap();
    var a=('{{json_encode(($towers->toArray()),JSON_FORCE_OBJECT)}}');
    a=JSON.parse(a.replace(/&quot;/g,"\""));
   setSectorTowerAndAntennasEvents(a);


    }
    function editSector(sector){

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
          return false;
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

    $('#wsct_id').val(sector.wsct_id);
    $('#wsct_name').val(sector.wsct_name);
    $("#wsct_antennatype").val(sector.wsct_antenna);
    $("#wsct_tower").val(sector.wsct_tower);
    $("#wsct_address").val(sector.wsct_ip+"/"+sector.wsct_segment);
    $("#wsct_description").val(sector.wsct_description);
    $("#wsct_dist").val(sector.wsct_dist);
    $("#wsct_tower").trigger('change');
    $("#wsct_antennatype").trigger('change');
    if(sector.wsct_antenna==1){

        $('#deg').val(sector.wsec_deg);
        $('#apper').val(sector.wsec_rank);
          $('#apper').trigger('change');
    }
    $("#wsct_color").val("#"+sector.wsct_color);
    $("#wsct_color").trigger('change');
    }
    @if($errors->any())
      addSector();
      @if(old('_method'))

      var url="{{url('sectores/')}}";
      url+="/"+$('#wsct_id').val();

       $('#SectorForm').attr('action', url);
       $('#SectorForm').append('{{ method_field("PATCH") }}');
      @endif
     $("#wsct_antennatype").val({{ old('wsct_antennatype')}});


     $("#wsct_tower").val({{ old('wsct_tower')}});
     $("#apper").val({{old('apper')}});
        $("#wsct_antennatype").trigger('change');


    @endif

    </script>
    @stop
