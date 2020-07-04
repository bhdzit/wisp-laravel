@extends('admin.layout')
  @section('content')
  <div class="row">
    <div class="col-xs-12">
          <div class="box">
        <div class="box-header">
          <h3 class="box-title">Tabla de Compras</h3>
          <button class="btn btn-primary pull-right" onclick="addPkg()">Agregar Compra</button>
        </div>
        <!-- /.box-header -->
        <div class="box-body">
          <table id="example1" class="table table-bordered table-striped">
            <thead>
              <tr role="row">
                    <th>No.</th>
                    <th>ITEM</th>
                    <th>CANTIDAD</th>
                    <th>PRECIO</th>
                    <th style="width:60px;">Editar</th>
                    <th style="width:60px;">Eliminar</th>
              </tr>
            </thead>
                  <tbody>
                    <tr>
                      <td>1</td>
                      <td>Cable 300m </td>
                      <td>1</td>
                      <td>$ 3500</td>
                      <td>
                            <button class="btn btn-success" onclick=""><i class="fa fa-btn fa-edit"></i></button>
                      </td>
                      <td>
                        <form action="" method="POST">
                          {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                          <button type="submit" class="btn btn-danger"><i class="fa fa-btn fa-trash"></i></button>
                        </form>
                      </td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>ANTENAS </td>
                      <td>10</td>
                      <td>$20,000</td>
                      <td>
                            <button class="btn btn-success" onclick=""><i class="fa fa-btn fa-edit"></i></button>
                      </td>
                      <td>
                        <form action="" method="POST">
                          {{ csrf_field() }}
                            {{ method_field('DELETE') }}
                          <button type="submit" class="btn btn-danger"><i class="fa fa-btn fa-trash"></i></button>
                        </form>
                      </td>
                    </tr>
                  </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  @stop
  @section('script')
<script type="text/javascript">
  function addPkg(){
          Swal.fire({
          title: 'Agregar Compra',
            html:@include('sweetAlert2.ComprasLayout'),
      width:'60%',
          showClass: {
            popup: 'animated fadeInDown faster'
          },
          hideClass: {
            popup: 'animated fadeOutUp faster'
          },
          preConfirm:function(){
        document.getElementById("send_btn").click();
        return false;
              }

        });
  }
</script>
@stop
