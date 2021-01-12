@extends('admin.layout')
@section('content')
<div class="row">
  <div class="col-xs-12">
    <div class="box">
      <div class="box-header">
        <h3 style="display: contents;"><strong>Configuracion</strong></h3>
        <button class="btn btn-primary pull-right" onclick="$('#Settings_form').submit()">Aplicar Cambios</button>
      </div>
      <!-- /.box-header -->
      <div class="box-body">
        <form id="Settings_form" action="{{route('configuracion.store')}}" method="post" enctype="multipart/form-data">
          @csrf
          <div class="box"></div>
          <H4><strong>Datos Personales<strong></H4>
          <div class="row">
            <div class="col-sm-2">
              <div class="form-group">
                <img src="{{asset('/storage/imagenes/'.auth()->user()->perfil_img)}}" class="user-image" style="cursor: pointer;width: 160px" id="user_img" alt="User Image" onclick="$('#usu_img_chooser').trigger( 'click' )">
                <input type="file" id="usu_img_chooser" name="img" accept="image/*" style="display: none;">
              </div>
            </div>
            <div class="col-sm-10">

              <div class="form-group">
                <label for="formGroupExampleInput">Nombre</label>
                <input type="text" class="form-control" value="{{auth()->user()->name}}" name="user_name">
              </div>

              <div class="form-group">
                <label for="formGroupExampleInput">Correo</label>
                <input type="email" class="form-control" value="{{auth()->user()->email}}" name="user_email">
              </div>

            </div>
            <div class="col-sm-10">
              <div class="form-group">

                <a class="btn btn-primary">Cambiar Contraseña</a>
              </div>

            </div>
          </div>



          <div class="box-body">
            <div class="box"></div>
            <H4><strong>Datos Empresa<strong></H4>
            <div class="col-sm-2">
              <div class="form-group">
                <img src="{{asset('/storage/imagenes/'.$business->wb_perfil_img)}}" class="user-image" style="cursor: pointer;width: 160px" id="business_img" alt="User Image" onclick="$('#business_img_chooser').trigger( 'click' )">
                <input type="file" id="business_img_chooser" name="business_img_chooser" accept="image/*" style="display: none;">
              </div>
            </div>
            <div class="col-sm-10">

              <div class="form-group">
                <label for="formGroupExampleInput">Nombre de la Empresa</label>
                <input type="text" class="form-control" placeholder="Nombre de empresa" name="business_name" value="{{$business->wb_name}}">
              </div>

              <div class="form-group">
                <label for="formGroupExampleInput">RFC</label>
                <input type="email" class="form-control" placeholder="RFC" name="rfc" value="{{$business->wb_rfc}}">
              </div>
            </div>
          </div>

          <div class="box-body">
            <div class="box"></div>
            <H4 style="display: contents;"><strong>Usuarios<strong></H4>
            <button class="btn btn-primary pull-right" onclick="$('#Settings_form').submit()">Agregar usuario</button>
          </div>
          <table id="example1" class="table table-bordered table-striped">

            <thead>
              <tr>
                <th colspan="5">Igresos del Mes : <span>$ 13,000</span> </th>
              </tr>
              <tr role="row">
                <th>No.</th>
                <th>Usuario</th>
                <th>Rol</th>
                <th style="width:60px;">Editar</th>
                <th style="width:60px;">Eliminar</th>
              </tr>
            </thead>
            <tbody>
              @php $i=1@endphp
              @foreach($Users as $user)
              <tr>
                <td>{{$i++}}</td>
                <td>{{$user->name}}</td>
                <td></td>
                <td>
                  <button class="btn btn-success" onclick="" ><i class="fa fa-btn fa-edit"></i></button>
                </td>
                <td>
                  <form action="" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('DELETE') }}
                    <button type="submit" class="btn btn-danger"><i class="fa fa-btn fa-trash"></i></button>
                  </form>
                </td>
              </tr>
              @endforeach
            </tbody>
          </table>

        </form>
      </div>
    </div>
  </div>
</div>
@stop

@section('script')
<script type="text/javascript">
  $("#usu_img_chooser").change(function(e) {
    $("#user_img")[0].src = URL.createObjectURL(document.querySelector("#usu_img_chooser").files[0]);
  });
  $("#business_img_chooser").change(function(e) {
    $("#business_img")[0].src = URL.createObjectURL(document.querySelector("#business_img_chooser").files[0]);
  });
</script>

@stop