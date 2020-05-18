'<form  id="PaquetesForm" method="POST" action="{{route('paquetes.store')}}" >'+
  '{{ csrf_field() }}'+
'<div class="form-group row">'+
          '<div class="col-sm-12">'+
              '<input type="text" class="form-control swal2-input" id="pkg_name" name="pkg_name" placeholder="Nombre">'+
          '</div>'+
          '<div class="col-sm-12">'+
              '<input type="text" class="form-control swal2-input" id="pkg_tx" name="pkg_tx" placeholder="Subida">'+
          '</div>'+
          '<div class="col-sm-12">'+
              '<input type="text" class="form-control swal2-input" id="pkg_rx" name="pkg_rx" placeholder="Bajada">'+
          '</div>'+
          '<div class="col-sm-12">'+
              '<input type="text" class="form-control swal2-input" id="pkg_price" name="pkg_price" placeholder="Precio">'+
          '</div>'+
          '<div class="col-sm-12">'+
              '<input type="text" class="form-control swal2-input" id="pkg_description" name="pkg_description" placeholder="Descripcion">'+
          '</div>'+
        '</div>'+
'<input type="submit" id="send_btn" name="subir_btn" Value="Enviar" hidden="hidden">'+
'</form>'
