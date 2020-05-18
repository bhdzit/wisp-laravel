'<form  id="ClienteForm" method="POST" action="{{route('clientes.store')}}" >'+
  '@csrf'+
'<div class="form-group row">'+
    '  <div class="col-sm-6">'+
    '<input type="text" class="form-control swal2-input" id="wc_name" name="wc_name" placeholder="Nombre">'+
    '  </div>'+
    '  <div class="col-sm-6">'+
        '<input type="text" class="form-control swal2-input" id="wc_last_name" name="wc_last_name" placeholder="Apellido">'+
    '  </div>'+
    '  <div class="col-sm-4">'+
    '<input type="text" class="form-control swal2-input" id="wc_phone" name="wc_phone" placeholder="Telefono">'+
    '  </div>'+
    '  <div class="col-sm-4">'+
        '<input type="text" class="form-control swal2-input" id="wc_mail" name="wc_mail" placeholder="Correo">'+
    '  </div>'+
    '  <div class="col-sm-4">'+
        '<input type="date" class="form-control swal2-input" id="wc_date"name="wc_date" placeholder="Fecha">'+
    '  </div>'+
    '  <div class="col-sm-4">'+
    '      <select id="wc_pkg" name="wc_pkg" class="custom-select swal2-input">'+
    '      <option selected="">Paquete</option>'+
    @forelse($paquetes as $paquete)
    '      <option  value="{{$paquete->wp_id}}" >{{$paquete->wp_name}}</option>'+
    @empty

    @endforelse
    '      </select>'+
    '  </div>'+
    '  <div class="col-sm-4">'+
    '      <select id="wc_contract" name="wc_contract" class="custom-select swal2-input">'+
    '      <option selected="">Contrato</option>'+
    '      <option value="1">Prepago</option>'+
    '      <option value="2">Arendamiento</option>'+
    '      </select>'+
    '  </div>'+
    '  <div class="col-sm-4">'+
    '      <select id="wc_sector" name="wc_sector" class="custom-select swal2-input">'+
    '      <option selected="">Sector</option>'+
    @forelse($sectores as $sector)
    '      <option  value="{{$sector->wsct_id}}" >{{$sector->wsct_name}}</option>'+
    @empty

    @endforelse

    '      </select>'+
    '  </div>'+
    '  <div class="col-sm-4">'+
        '<input type="text" class="form-control swal2-input" id="wc_ip" name="wc_ip" placeholder="ip">'+
    '  </div>'+
    '  <div class="col-sm-4">'+
        '<input type="text" class="form-control swal2-input" id="wc_ssid" name="wc_ssid" placeholder="SSID">'+
    '  </div>'+
    '  <div class="col-sm-4">'+
        '<input type="text" class="form-control swal2-input" id="wc_pass" name="wc_pass" placeholder="PASSWORD">'+
    '  </div>'+
    '<input type="hidden" class="form-control swal2-input" id="wc_point" name="wc_point"  >'+
    '  <div class="col-sm-12 ">'+
    '<div style="width: 100%; height: 380px" id="mapContainer"></div>'+
    '  </div>'+

    '  </div>'+
    '<input type="submit" id="send_btn" name="subir_btn" Value="Enviar" hidden="hidden">'+
    '</form>'
