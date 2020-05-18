'<form  id="SectorForm" method="POST" action="{{route('sectores.store')}}" >'+
  '{{ csrf_field() }}'+
    '<div class="form-group row">'+
                '<div class="col-sm-4">'+
                  '<input type="text" class="form-control swal2-input" id="wsct_name" name="wsct_name"  placeholder="Nombre">'+
                 '</div>'+
              '  <div class="col-sm-4">'+
              '      <select id="wsct_antennatype" name="wsct_antennatype" class="custom-select swal2-input">'+
              '      <option value="0" selected="">Tipo de Antena</option>'+
              '      <option value="1">Sectorial</option>'+
              '      <option value="2">Omnidirectional</option>'+
              '      </select>'+
              '  </div>'+
              '  <div class="col-sm-4">'+
              '      <select id="wsct_tower" name="wsct_tower" class="custom-select swal2-input">'+
              '      <option  value="0" selected="">Torre</option>'+
                @forelse($towers as $tower)
                '      <option  value="{{$tower->wt_id}}" >{{$tower->wt_nombre}}</option>'+
                @empty

                @endforelse


              '      </select>'+
              '  </div>'+
              '<div class="col-sm-4">'+
                '<input  type="text" class="form-control swal2-input" id="wsct_address" name="wsct_address" placeholder="IP" >'+
               '</div>'+
               '<div class="col-sm-4">'+
                 '<input  type="text" class="form-control swal2-input" id="wsct_description" name="wsct_description" placeholder="descripcion" >'+
                '</div>'+
               '<div class="col-sm-2 distance container">'+
                 '<input style="max-width:100%;" type="number" class="form-control swal2-input" id="wsct_dist" name="wsct_dist" placeholder="Distancia" value="800">'+
                '</div>'+
               '<div id="apperdiv" class="col-sm-2 hide">'+
               '      <select id="apper" name="apper" class="custom-select swal2-input">'+
               '      <option  value="0" selected="">Apertura</option>'+
               '      <option  value="30" >30°</option>'+
               '      <option  value="90" >90°</option>'+
               '      <option  value="120" >120°</option>'+
               '      </select>'+
               '  </div>'+
                '</div>'+
             '<input style="max-width:100%;" type="number" class="swal2-input db" id="deg" name="deg" hidden value="-88">'+
              '  <div class="col-sm-12 ">'+
            '<div style="width: 100%; height: 380px" id="mapContainer"></div>'+
            '<input type="submit" id="send_btn" name="subir_btn" Value="Enviar" hidden="hidden">'+
          '</div>'+
  '</form>'
