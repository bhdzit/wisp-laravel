'<form  id="PaquetesForm" method="POST" action="{{route('paquetes.store')}}" >'+

  '{{ csrf_field() }}'+
'<div class="form-group row">'+
          '<div class="col-sm-12">'+
              '<input type="text" class="form-control swal2-input" id="pkg_name" name="pkg_name" required placeholder="Nombre" value="{{old('pkg_name')}}">'+
              '   @error("pkg_name")'+
              '<div  class=" alert-danger" role="alert">'+
              '  <strong>¡Error al Cargar Paquete!</strong>Nombre de Paquete requerido'+
              '</div>'+
              '  @enderror'+
          '</div>'+
          '<div class="col-sm-12">'+
              '<input type="text" class="form-control swal2-input" id="pkg_tx" name="pkg_tx" required  placeholder="Subida" value="{{old('pkg_tx')}}">'+
              '   @error("pkg_tx")'+
              '<div  class=" alert-danger" role="alert">'+
              '  <strong>¡Error al Cargar Paquete!</strong>Subida de Paquete requerido'+
              '</div>'+
              '  @enderror'+
          '</div>'+
          '<div class="col-sm-12">'+
              '<input type="text" class="form-control swal2-input" id="pkg_rx" name="pkg_rx" required  placeholder="Bajada" value="{{old('pkg_rx')}}">'+
              '   @error("pkg_rx")'+
              '<div  class=" alert-danger" role="alert">'+
              '  <strong>¡Error al Cargar Paquete!</strong>Bajada de Paquete requerido'+
              '</div>'+
              '  @enderror'+
          '</div>'+
          '<div class="col-sm-12">'+
              '<input type="text" class="form-control swal2-input" id="pkg_price" name="pkg_price" required  placeholder="Precio" value="{{old('pkg_price')}}">'+
              '   @error("pkg_price")'+
              '<div  class=" alert-danger" role="alert">'+
              '  <strong>¡Error al Cargar Paquete!</strong>Precio de Paquete requerido'+
              '</div>'+
              '  @enderror'+
          '</div>'+
          '<div class="col-sm-12">'+
              '<input type="text" class="form-control swal2-input" id="pkg_description" name="pkg_description" required value="{{old('pkg_description')}}" placeholder="Descripcion">'+
              '   @error("pkg_description")'+
              '<div  class=" alert-danger" role="alert">'+
              '  <strong>¡Error al Cargar Paquete!</strong>Decripcion de Paquete requerido'+
              '</div>'+
              '  @enderror'+
          '</div>'+
        '</div>'+
'<input type="submit" id="send_btn" name="subir_btn" Value="Enviar" hidden="hidden">'+
'</form>'
