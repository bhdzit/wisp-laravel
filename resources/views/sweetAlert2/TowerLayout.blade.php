'<form method="POST" id="towerForm" action={{route("torres.store")}}>'+
'@csrf'+
'<div class="form-group row">'+
'  <div class="col-sm-6">'+
    '<input     style="margin-bottom: 0;" type="text" class="form-control swal2-input" id="torreNombre" name="wt_nombre" placeholder="Nombre" required>'+
    '   @error('wt_nombre')'+
    '<div  class=" alert-danger" role="alert">'+
    '  <strong>¡Error al Cargar Torre!</strong>Nombre de Torre requerido'+
    '</div>'+
    '  @enderror'+
  '</div>'+
  '  <div class="col-sm-6">'+
  '<input style="margin-bottom: 0;" type="number" class="form-control swal2-input" id="torreAltura" name="wt_altura" placeholder="Altura" required>'+
  '   @error('wt_altura')'+
  '<div  class=" alert-danger" role="alert">'+
  '  <strong>¡Error al Cargar Torre!</strong>Altura de Torre requerida'+
  '</div>'+
  '  @enderror'+
'</div>'+
  '<input type="hidden"  class="form-control swal2-input   @error('wt_point') is-invalid @enderror" id="torrePoint" name="wt_point" required >'+
  '  <div class="col-sm-12 ">'+
  '<div style="width: 100%; height: 380px" id="mapContainer"></div>'+
    '   @error('wt_point')'+
    '<div  class=" alert-danger" role="alert">'+
    '  <strong>¡Error al Cargar Torre!</strong>Ubiucacion de Torre requerida'+
    '</div>'+
    '  @enderror'+
  '  </div>'+
  '  </div>'+
  '<input type="submit" id="send_btn" name="subir_btn" Value="Enviar" hidden="hidden">'+
  '</form>'
