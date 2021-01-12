@extends('admin.layout')
    @section('content')
    <div class="row">
      <div class="col-xs-12">
            <div class="box">
          <div class="box-header">
            <h3 class="box-title">Agregar Deposito</h3>

          </div>
          <div class="box-body">
            <div class="row" >
            <button style="margin-right: 30px;" href="pagos\agregarpago" class="btn btn-primary pull-right" onclick="scanQR()">Escaner QR</button>
                <div class="col-sm-6">
                  <input id="clientInput" class="form-control" placeholder="cliente" list="clientes" value="@isset($cliente){{$cliente[0]->wc_name}} {{$cliente[0]->wc_last_name}}@endisset" >
                        <datalist  id="clientes">

                        </datalist>

                  </div>
                </div>

                  <div class="row " style="margin-top:25px">
                          <div class="col-sm-4">
                                <div class="box">
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Pagos Reciente</h3>
                                      <button style="margin-right: 30px;" href="pagos\agregarpago" class="btn btn-primary pull-right" href="">Imprimir</button>
                                    </div>
                                    <!-- /.box-header -->
                                    <div class="box-body">
                                      <table class="table table-bordered">
                                        <tr>
                                          <th style="width: 10px">#</th>
                                          <th>Mes</th>
                                          <th>Paquete</th>
                                          <th>Imprimir</th>
                                        </tr>
                                        <tr>
                                      <tbody id="recentPays">
                                      </tbody>
                                    </table>
                                    </div>
                                  </div>
                        </div>
                        <div class="col-sm-8">
                              <div class="box">
                                  <div class="box-header with-border">
                                    <h3 class="box-title">Deposito de Pago</h3>
                                  </div>
                                  <!-- /.box-header -->
                                  <form method="POST" action="{{route('agregarpago.store')}}">
                                    @csrf
                                  <div class="box-body">
                                    <table class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>Fecha</th>
                                          <th>Hora</th>
                                          <th>Banco</th>
                                          <th>img</th>
                                        </tr>
                                      </thead>
                                      <tr>
                                        <td><input type="date" class="form-control"></td>
                                        <td><input type="time" class="form-control"></td>
                                        <td><select class="form-control">
                                            <option>Banco</option>
                                        </select></td>
                                        <td><input type="file" name="file" id="file" class="inputfile"/>
                                      </tr>
                                    </table>
                                    <div class="box-header with-border">
                                      <h3 class="box-title">Pagos</h3>
                                    </div>
                                    <table class="table table-bordered table-striped">
                                      <thead>
                                        <tr>
                                          <th>#</th>
                                          <th>Mes</th>
                                          <th>Paquete</th>
                                          <th style="width: 80px">Costo</th>
                                        </tr>
                                      </thead>
                                        <tbody id="payTable">

                                        </tbody>
                                        <tfoot>
                                          <tr>
                                            <td colspan="3"><b>TOTAL : </b></td>
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

              </div>
          </div>
        <!-- /.box -->
      </div>
      <!-- /.col -->
    </div>
    @stop
    @section('script')
    <script type="text/javascript">

      $('#clientInput').trigger('change');
        function getClientPays(){

      var row='  <tr id="payOptions">'
        +'<td><input type="number" id="serviceId" name="serviceId" hidden ></td>'
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
    </script>
    @stop
