'<form method="POST" id="towerForm" action={{route("torres.store")}}>'+
'@csrf'+
'<div class="form-group row">'+
'  <div class="col-sm-6">'+
  '<input type="text" class="form-control swal2-input" id="torreNombre" name="wt_nombre" placeholder="Nombre" required>'+
  '  </div>'+
  '  <div class="col-sm-6">'+
  '<input type="number" class="form-control swal2-input" id="torreAltura" name="wt_altura" placeholder="Altura" required>'+
    '<input type="hidden"  class="form-control swal2-input" id="torrePoint" name="wt_point" require ">'+
  '  </div>'+
  '  <div class="col-sm-12 ">'+
  '<div style="width: 100%; height: 380px" id="mapContainer"></div>'+
  '  </div>'+
  '  </div>'+
  '<input type="submit" id="send_btn" name="subir_btn" Value="Enviar" hidden="hidden">'+
  '</form>'
