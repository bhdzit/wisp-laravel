'<form  id="ClienteForm" method="POST" action="{{route('clientes.store')}}" >'+
'@csrf'+
    '<div class="form-group row">'+
      '<div class="col-sm-5">'+
          '<select class="custom-select swal2-input">'+
            '<option>ITEM</option>'+
            '<option>Cable</option>'+
            '<option>ANTENAS</option>'+
            '<option>INSUMOS</option>'+
            '<option>OTROS</option>'+
          '</select></div>'+
          '<div class="col-sm-3" style="width: auto;padding-left: 0;padding-right: 0;">'+
          '<input style="margin-bottom:0" type="number" class="custom-select swal2-input" placeholder="cantidad">'+
          '</div>'+
          '<div class="col-sm-3" style="width: auto;padding-right: 0;">'+
          '<input style="margin-bottom:0" type="number" class="custom-select swal2-input" placeholder="precio" >'+
          '</div>'+
    '</div>'+
'<input type="submit" id="send_btn" name="subir_btn" Value="Enviar" hidden="hidden">'+
'</form>'
