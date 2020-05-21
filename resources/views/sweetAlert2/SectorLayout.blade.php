'<form  id="SectorForm" method="POST" action="{{route('sectores.store')}}" >'+
  '{{ csrf_field() }}'+
    '<div class="form-group row">'+
                '<div class="col-sm-4">'+
                  '<input type="text" class="form-control swal2-input @error('wsct_name') is-invalid @enderror" id="wsct_name" name="wsct_name" value="{{ old('wsct_name') }}" placeholder="Nombre" required>'+
                  '   @error("wsct_name")'+
                  '<div  class=" alert-danger" role="alert">'+
                  '  <strong>¡Error al Cargar Sector!</strong>Nombre de Sector requerido'+
                  '</div>'+
                  '  @enderror'+

              '</div>'+
              '  <div  style="margin-bottom: 0;" class="col-sm-4">'+
              '      <select style="margin-bottom: 0;" id="wsct_antennatype" name="wsct_antennatype" class="custom-select swal2-input" value="{{ old('wsct_antennatype')}}"  required>'+
              '      <option disabled selected>Tipo de Antena</option>'+
              '      <option value="1">Sectorial</option>'+
              '      <option value="2">Omnidirectional</option>'+
              '    </select>'+




              @error("wsct_antennatype")

              '<div  class=" alert-danger" role="alert">'+
              '  <strong>¡Error al Cargar Sector!</strong>Tipo de Sector requerido'+
              '</div>'+
              @enderror
              '  </div>'+
              '  <div class="col-sm-4">'+
              '      <select style="margin-bottom: 0;" id="wsct_tower" name="wsct_tower" class="custom-select swal2-input" value="{{ old('wsct_tower')}}" >'+
              '      <option  disabled selected>Sector</option>'+
                @forelse($towers as $tower)
                '      <option  value="{{$tower->wt_id}}" >{{$tower->wt_nombre}}</option>'+
                @empty

                @endforelse


              '      </select>'+
              '   @error("wsct_tower")'+
              '<div  class=" alert-danger" role="alert">'+
              '  <strong>¡Error al Cargar Sector!</strong>Ubicacion de Sector requerido'+
              '</div>'+
              '  @enderror'+
              '  </div>'+
                '</div><div class="form-group row">'+
              '<div class="col-sm-4">'+
                '<input style="margin-bottom: 0;" type="text" class="form-control swal2-input" id="wsct_address" name="wsct_address" placeholder="IP" required value="{{ old('wsct_address') }}">'+
                '@error('wsct_address')'+
                '<div  class=" alert-danger" role="alert">'+
                '  <strong>¡Error al Cargar Sector!</strong>Ip/Segmento de Sector requerido'+
                '</div>'+
                '@enderror'+
               '</div>'+
               '<div class="col-sm-4">'+
                 '<input  style="margin-bottom: 0;" type="text" class="form-control swal2-input" id="wsct_description" name="wsct_description" value="{{ old('wsct_description') }}" placeholder="descripcion" required>'+
                 '   @error('wsct_description')'+
                 '<div  class=" alert-danger" role="alert">'+
                 '  <strong>¡Error al Cargar Sector!</strong>Descripcion de Sector requerido'+
                 '</div>'+
                 '  @enderror'+

                '</div>'+
               '<div class="col-sm-2 distance container">'+
                 '<input style="max-width:100%;" type="number" class="form-control swal2-input" id="wsct_dist" name="wsct_dist" placeholder="Distancia" value="800" required>'+
                '</div>'+
               '<div id="apperdiv" class="col-sm-2 hide" >'+
               '      <select  id="apper" name="apper" class="custom-select swal2-input" required>'+
               '      <option  disabled selected>Apertura</option>'+
               '      <option  value="30" >30°</option>'+
               '      <option  value="90" >90°</option>'+
               '      <option  value="120" >120°</option>'+
               '      </select>'+
               '   @error('wsct_apper')'+
               '<div  class=" alert-danger" role="alert">'+
               '  <strong>¡Error al Cargar Sector!</strong>Apertura de Sector requerido'+
               '</div>'+
               '  @enderror'+
               '  </div>'+
                '</div>'+
             '<input style="max-width:100%;" type="number" class="swal2-input db" id="deg" name="deg" hidden value="-88" required>'+
              '  <div class="col-sm-12 ">'+
            '<div style="width: 100%; height: 380px" id="mapContainer"></div>'+
            '<input type="submit" id="send_btn" name="subir_btn" Value="Enviar" hidden="hidden">'+
          '</div>'+
  '</form>'
