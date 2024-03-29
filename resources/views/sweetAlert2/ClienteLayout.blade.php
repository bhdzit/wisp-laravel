'<form  id="ClienteForm" method="POST" action="{{route('clientes.store')}}" >'+
  '<input type="hidden" id="wc_id" name="wc_id" value="{{old("wc_id")}}">'+
  '@csrf'+
'<div class="form-group row">'+
    '  <div class="col-sm-12">'+
    '<input style="margin-bottom:0" type="text" class="form-control swal2-input" id="wc_name" name="wc_name" placeholder="Nombre" required value="{{old('wc_name')}}">'+
    '   @error("wc_name")'+
    '<div  class=" alert-danger" role="alert">'+
    '  <strong>¡Error al Cargar Cliente!</strong>Nombre de Cliente requerido'+
    '</div>'+
    '  @enderror'+
    '  </div>'+
    '</div><div class="form-group row">'+
    '  <div class="col-sm-3">'+
    '<input style="margin-bottom:0" type="text" class="form-control swal2-input" id="wc_phone" name="wc_phone" placeholder="Telefono"  value="{{old('wc_phone')}}">'+
    '   @error("wc_phone")'+
    '<div  class=" alert-danger" role="alert">'+
    '  <strong>¡Error al Cargar Cliente!</strong>Telefono de Cliente requerido'+
    '</div>'+
    '  @enderror'+
    '  </div>'+
    '  <div class="col-sm-3">'+
    '<strong>Fecha de Instalacion</strong>'+
        '<input style="margin-bottom:0" style="margin-top:0" type="date" class="form-control swal2-input" id="wc_date" name="wc_date" required value="{{old('wc_date')}}" >'+
        '   @error("wc_date")'+
        '<div  class=" alert-danger" role="alert">'+
        '  <strong>¡Error al Cargar Cliente!</strong>Fecha de Instalacion requerida'+
        '</div>'+
        '  @enderror'+
    '  </div>'+
    '  <div class="col-sm-3">'+
    '<strong>Fecha de Primer Pago</strong>'+
        '<input style="margin-bottom:0" style="margin-top:0" type="date" class="form-control swal2-input" id="wc_pay_date" name="wc_pay_date" required value="{{old('wc_pay_date')}}">'+
        '   @error("wc_pay_date")'+
        '<div  class=" alert-danger" role="alert">'+
        '  <strong>¡Error al Cargar Cliente!</strong>Fecha de Primer pago requerida'+
        '</div>'+
        '  @enderror'+
    '  </div></div>'+
    '</div><div class="form-group row">  <div class="col-sm-4">'+
    '      <select style="margin-bottom:0" id="wc_pkg" name="wc_pkg" class="custom-select swal2-input">'+
    '      <option disabled selected="">Paquete</option>'+
    @forelse($paquetes as $paquete)
    '      <option  value="{{$paquete->wp_id}}" >{{$paquete->wp_name}}</option>'+
    @empty

    @endforelse
    '      </select>'+
    '   @error("wc_pkg")'+
    '<div  class=" alert-danger" role="alert">'+
    '  <strong>¡Error al Cargar Cliente!</strong>Pquete requerido'+
    '</div>'+
    '  @enderror'+
    '  </div>'+
    '  <div class="col-sm-4">'+
    '      <select style="margin-bottom:0" id="wc_contract" name="wc_contract" class="custom-select swal2-input">'+
    '      <option disabled selected="">Contrato</option>'+
    '      <option value="1">Prepago</option>'+
    '      <option value="2">Arendamiento</option>'+
    '      </select>'+
    '   @error("wc_contract")'+
    '<div  class=" alert-danger" role="alert">'+
    '  <strong>¡Error al Cargar Cliente!</strong>Contrato requerido'+
    '</div>'+
    '  @enderror'+
    '  </div>'+
    '  <div class="col-sm-4">'+
    '      <select style="margin-bottom:0" id="wc_sector" name="wc_sector" class="custom-select swal2-input">'+
    '      <option disabled selected="">Sector</option>'+
    @forelse($sectores as $sector)
    '      <option  value="{{$sector->wsct_id}}" >{{$sector->wsct_name}}</option>'+
    @empty

    @endforelse

    '      </select>'+
    '   @error("wc_sector")'+
    '<div  class=" alert-danger" role="alert">'+
    '  <strong>¡Error al Cargar Cliente!</strong>Sector requerido'+
    '</div>'+
    '  @enderror'+
    '  </div>'+
    

    '<input type="hidden" class="form-control swal2-input" id="wc_point" name="wc_point" required value="{{old("wc_point")}}" >'+
    '  <div class="col-sm-12 ">'+
    '<div style="width: 100%; height: 380px" id="mapContainer"></div>'+
    '   @error("wc_point")'+
    '<div  class=" alert-danger" role="alert">'+
    '  <strong>¡Error al Cargar Cliente!</strong>Ubiucacion requerida'+
    '</div>'+
    '  @enderror'+
    '  </div>'+

    '  </div>'+
    '<input type="submit" id="send_btn" name="subir_btn" Value="Enviar" hidden="hidden">'+
    '</form>'
