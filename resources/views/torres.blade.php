@extends('admin.layout')

@section('content')

<div class="row">
  <div class="col-xs-12">
        <div class="box">
      <div class="box-header">

        <h3 class="box-title">Tabla de Torres</h3>
        <button class="btn btn-primary pull-right" onclick="addTower()">Agregar Torres</button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <table id="example1" class="table table-bordered table-striped">
          <thead>
            <tr role="row">
                  <th>No.</th>
                  <th>Nombre</th>
                  <th>Altura</th>
                  <th>Ubiucacion</th>
                  <th style="width:60px;">Editar</th>
                  <th style="width:60px;">Eliminar</th>
            </tr>
          </thead>
          <tbody id="clientListTable">
            @forelse($torres as $torre)
            <tr>
              <td>{{$torre->wt_id}} </td>
              <td>{{$torre->wt_nombre}}</td>
              <td>{{$torre->wt_altura}}</td>
              <td class="mapPoint">
                <i onclick="showTowerPosition({{$torre->wt_lng}},{{$torre->wt_lat}})" class="fas fa-map-marker-alt" style=color:#000;></i></td>
              </td>
              <td>
                    <button class="btn btn-success" onclick="editTower({{json_encode(($torre->toArray()))}})"><i class="fa fa-btn fa-edit"></i></button>
              </td>
              <td>
                <form action="{{ url('torres/'.$torre->wt_id) }}" method="POST">
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

<!-- /.row -->
@stop

@section('script')
<script type="text/javascript">
$(function () {
    $('#example1').DataTable()

});
function editTower(torre){
  console.log(torre);
  Swal.fire({
    title: 'Agregar Torre',
    html:@include('sweetAlert2.TowerLayout'),
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
  var url="{{url('torres/')}}";
  url+="/"+torre.wt_id;

   $('#towerForm').attr('action', url);

   $('#towerForm').append('{{ method_field("PATCH") }}');

$("#wt_id").val(torre.wt_id);
$('#torreNombre').val(torre.wt_nombre);
$('#torreAltura').val(torre.wt_altura);
$('#torrePoint').val(torre.wt_lat+','+torre.wt_lng);
  setMap();
  addMarck({lat:torre.wt_lat,lng:torre.wt_lng});
  map.addEventListener('tap',function(evt){
    var coord = map.screenToGeo(evt.currentPointer.viewportX,
            evt.currentPointer.viewportY);
      if(marker!=null)map.removeObject(marker);
      addMarck({lat:coord.lat,lng:coord.lng});
      $("#torrePoint").val(coord.lat+","+coord.lng);
  });


}
function addTower(){
Swal.fire({
  title: 'Agregar Torre',
  html:@include('sweetAlert2.TowerLayout'),
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
map.addEventListener('tap',function(evt){
  var coord = map.screenToGeo(evt.currentPointer.viewportX,
          evt.currentPointer.viewportY);
    if(marker!=null)map.removeObject(marker);
    addMarck({lat:coord.lat,lng:coord.lng});
    $("#torrePoint").val(coord.lat+","+coord.lng);
});

}
@if($errors->any())
  addTower();
  @if(old('_method'))

  var url="{{url('torres/')}}";
  url+="/"+$("#wt_id").val();

   $('#towerForm').attr('action', url);

   $('#towerForm').append('{{ method_field("PATCH") }}');
  @endif
@endif


</script>
@stop
