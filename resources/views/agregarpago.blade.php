@extends('admin.layout')
    @section('content')
    <div class="row">
      <div class="col-xs-12">
            <div class="box">
          <div class="box-header">
            <h3 class="box-title">Agregar Pago</h3>

          </div>
          <div class="box-body">
            <div class="row" >
            <button style="margin-right: 30px;" href="pagos\agregarpago" class="btn btn-primary pull-right" onclick="scanQR()">Escaner QR</button>
                <div class="col-sm-6">
                  <input id="clientInput" class="form-control" placeholder="cliente" list="clientes" value="@isset($cliente){{$cliente[0]->wc_name}} {{$cliente[0]->wc_last_name}}@endisset" >
                        <datalist  id="clientes">
                          @isset($clientes)
                          @forelse($clientes as $cliente)
                          <option  id={{$cliente->ws_id}} value="{{$cliente->wc_name}}  {{ $cliente->wc_last_name}}">
                          @empty
                          <li>No Hay Datos</li>
                          @endforelse
                          @endisset
                        </datalist>

                  </div>
                </div>

                  <div class="row " style="margin-top:25px">
                        <div class="col-sm-12">
                              <div class="box">
                                  <div class="box-header with-border">
                                    <h3 class="box-title">Realizar Pago</h3>
                                  </div>
                                  <!-- /.box-header -->
                                  <form target="pdf" method="POST" acction="{{route('agregarpago.store')}}">
                                    @csrf
                                    <input type="hidden" id="clientName" name="clientName" value="">
                                  <div class="box-body">
                                    <table class="table table-bordered table-striped hidden">
                                          <thead>
                                            <tr><th colspan="5">Creditos</th></tr>
                                          </thead>
                                        <tr><td colspan="5"><span>No hay Creditos</span></td></tr>

                                      <thead>
                                        <tr>
                                          <th>#</th>
                                          <th>Mes</th>
                                          <th>Paquete</th>
                                          <th>METODO de Pago
                                          <th style="width: 80px">Costo</th>
                                        </tr>
                                      </thead>
                                        <tbody id="payTable">

                                        </tbody>

                                          <tr>
                                            <td colspan="3">
                                              <!-- radio -->
                                              <div class="form-group">
                                                <label>
                                                  <input type="radio" name="r3" class="flat-red" value="OXXO" checked>
                                                  OXXO
                                                </label>
                                                <label>
                                                  <input type="radio" name="r3" class="flat-red" value="BANAMEX">
                                                  BANAMEX
                                                </label>
                                                <label>
                                                  <input type="radio" name="r3" class="flat-red" value="BANCOPPEL">
                                                  BANCOPPEL
                                                </label>
                                              </div>
                                            </td>
                                            <td colspan="2">
                                              <input type="datetime-local" name="depositDate" class="form-control pull-right" id="reservationtime1">
                                            </td>

                                          </tr>
                                          <thead>
                                            <tr>
                                              <th colspan="3">Extras</th>
                                                <th colspan="2">
                                                  <div class="form-group">
                                                    <input type="button" id="btnAddNote" onclick="addNote()" style="margin-right: 10px;" class="btn btn-success pull-right" value="Agregar Nota">
                                                    <input type="button" onclick="addExtra()" style="margin-right: 10px;" class="btn btn-success pull-right" value="Agregar Extra">
                                                  </div>
                                                </th>
                                            </tr>
                                          </thead>
                                              <tbody id="extratbody">



                                              </tbody>
                                        <tfoot>
                                          <tr>
                                            <td colspan="4"><b>TOTAL : </b></td>
                                            <td><b id='totalPay'>$ 0</b></td>
                                          </tr>
                                        </tfoot>
                                    </table>
                                  </div>
                                 <input type="submit" class="btn btn-primary pull-right">
                               </form>
                              <button style="margin-right: 10px;" onclick="addPayRow()" class="btn btn-success pull-right" href=""><i class="fas fa-plus"></i></button>
                            </div>
                      </div>

                      <div class="col-sm-4">
                            <div class="box">
                                <div class="box-header with-border">
                                  <h3 class="box-title">Pagos Reciente</h3>
                                  <button style="margin-right: 30px;" href="pagos\agregarpago" class="btn btn-primary pull-right" href="">Imprimir</button>
                                </div>
                                <!-- /.box-header -->
                                <div class="box-body">
                                  <table id="recentPaysTable" class="table table-bordered">
                                    <thead>
                                      <th style="width: 10px">#</th>
                                      <th>Mes</th>
                                      <th>Paquete</th>
                                      <th>Imprimir</th>
                                    </thead>

                                  <tbody id="recentPays">
                                  </tbody>
                                  <tfoot>
                                  </tfoot>
                                </table>
                                </div>
                              </div>
                    </div>

              </div>
          </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    @stop
    @section('script')
    <script src="/adminlte/bower_components/moment/min/moment.min.js"></script>
    <script src="/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap datepicker -->
    <script src="/adminlte/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript">


    //Flat red color scheme for iCheck
    $('input[type="checkbox"].flat-red, input[type="radio"].flat-red').iCheck({
      checkboxClass: 'icheckbox_flat-blue',
      radioClass   : 'iradio_flat-blue'
    });
    $('#reservationtime').daterangepicker();
      $('#clientInput').trigger('change');
        function getClientPays(){

      var row='  <tr id="payOptions">'
        +'<td style="width: 30px"> <i id="eliminar" style="color:#F00;" class="fas fa-trash-alt"></i><input type="number" id="serviceId" name="serviceId" hidden ></td>'
        +'    <td class="todo-list ui-sortable">'
        +'  <select  class="form-control" id="payMonth">'
        +'    <option value="1">ENE</option>'
        +'    <option value="2">FEB</option>'
        +'    <option value="3">MAR</option>'
        +'    <option value="4">ABR</option>'
        +'    <option value="5">MAY</option>'
        +'    <option value="6">JUN</option>'
        +'    <option value="7">JUL</option>'
        +'    <option value="8">AGO</option>'
        +'    <option value="9">SEP</option>'
        +'    <option value="10">OCT</option>'
        +'    <option value="11">NOV</option>'
        +'    <option value="12">DIC</option>'
        +'  </select>'
        +'    </td>'
        +'  <td>'
        +'      <select  class="form-control pkgClient" id="pkgClient">'
                @forelse($paquetes as $paquete)
        +'          <option value="{{$paquete->wp_id}}">{{$paquete->wp_name}}</option>'
                @empty

                @endforelse
        +'      </select>'
        +'    </td>'
        +'<td><select class="form-control"  id="payMethod">'
        +'<option value="1">Efectivo</option>'
        +'<option value="2">Deposito</option></select></td>'
        +'    <td><b>$<input name="payMoney" style="border: 0;width: 50px;" id="payMoney" type="text" readonly></b></td>'
        +'  </tr>';
    return row;
      }
    //  $('#payTable').append(getClientPays());
    function getPrices(){
    var json='{'
      @forelse($paquetes as $paquete)
      +'"{{$paquete->wp_id}}":{"wp_price":"{{$paquete->wp_price}}"},'
      @empty

      @endforelse
      +'';
      return JSON.parse(json.substr(0,json.length-1)+'}');
    }

    getPrices();

    function scanQR(){
        Swal.fire({
          titel:'Any fool can use a computer',
          input:'text'
          });
    }

    function addExtra(){
        $('#extratbody').append('<tr>'+
          '  <td colspan="4">'+
          '    <input placeholder="Desscripcion" class="form-control">'+
        '    </td>'+
        '    <td colspan="2">'+
      '        <input placeholder="Costo" class="form-control">'+
      '      </td>'+

      '    </tr>');

    }
    function addNote(){
      document.getElementById("btnAddNote").disabled=true;
      $('#extratbody').append('<tr>'+
        '<td colspan="5">'+
        '  <div class="form-group">'+
        '    <textarea placeholder="Nota" class="form-control" ></textarea>'+
        '    </div>'+
        '  </td>'+
        '  </tr>');
    }
    </script>
    @stop
