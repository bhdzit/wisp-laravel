@extends('admin.layout')
@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Clientes
            <small>Enviar msj</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li>Clientes</li>
            <li class="active">enviarmsj</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Mensaje</h3>

                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <div class="form-group  col-sm-4">
                            <label>Torre : </label>
                            <select id="torres" class="form-control">
                                <option value="0">Todos</option>
                                @foreach ($torres as $torre)
                                    <option value="{{ $torre->wt_id }}">{{ $torre->wt_nombre }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group  col-sm-4">
                            <label>Sector : </label>
                            <select id="sectores" class="form-control">
                                <option value="0">Todos</option>
                                @foreach ($Sectores as $sector)
                                    <option value="{{ $sector->wsct_id }}" data-torre="{{ $sector->wsct_tower }}">
                                        {{ $sector->wsct_name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group  col-sm-4 ">
                            <label> </label>
                            <div class="box-footer p-0">
                                <button onclick="genEmbyUsrs()" type="submit"
                                    class="btn btn-info pull-right">Enviar</button>
                            </div>

                        </div>

                    </div>
                    <form action="genembyusr" method="POST" id="embyusrs">
                        @csrf
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="input-group m-5 direct-chat-messages">

                                    <input id="search" type="text" name="message" placeholder="Buscar" class="form-control">
                                    <span class="input-group-btn">
                                        <button type="submit" class="btn btn-warning btn-flat"><i
                                                class="fas fa-search"></i></button>
                                    </span>
                                </div>
                                <div class="direct-chat-info clearfix">

                                    <input id="selectAllcheckbox" class="pull-right" type="checkbox"><span
                                        class="direct-chat-timestamp pull-right ">Todos :</span>
                                </div>
                                <div class="direct-chat-messages">

                                    <ul class="nav nav-stacked">

                                        <!-- Message. Default to the left -->
                                        @php $i=1;@endphp
                                        @foreach ($clientes as $cliente)
                                            <li class="client-phone " data-cli-sec="{{ $cliente->wsct_id }}"
                                                data-cli-torre="{{ $cliente->wsct_tower }}"><a
                                                    href="#">{{ $cliente->wc_name . ' ' . $cliente->wc_last_name . ' / ' . $cliente->wsct_name }}
                                                    <span class="pull-right "><input name="usu[]"
                                                            value="{{ $cliente->ws_id }}" type="checkbox"></span></a>
                                            </li>
                                        @endforeach
                                    </ul>
                                    <!-- /.direct-chat-msg -->
                                </div>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
    </section>
    <template id="my-template">
        <swal-title>
            Verificando Conexion al Servidor Emby
        </swal-title>
        <swal-icon type="info"></swal-icon>

        <swal-param name="allowEscapeKey" value="false" />
        <swal-param name="allowEKey" value="false" />
        <swal-param name="customClass" value='{ "popup": "my-popup" }' />
    </template>

    <template id="genUserTemplate">
        <swal-title>
            Generando usuarios Emby..
        </swal-title>
        <swal-icon type="info"></swal-icon>

        <swal-param name="allowEscapeKey" value="false" />
        <swal-param name="allowEKey" value="false" />
        <swal-param name="customClass" value='{ "popup": "my-popup" }' />
    </template>
@endsection

@section('script')

    <script>
        let timerInterval;
        Swal.fire({
            template: '#my-template',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
                return fetch(`http://10.10.1.2/emby/System/Info?api_key=406e0de42e134701bbde790080f4d5cb`)
                    .then(response => {
                        console.log(response);
                        if (!response.ok) {
                            throw new Error(response.statusText)
                        }
                        Swal.close();
                        return response.json();
                    }).catch(error => {
                        Swal.fire({
                            icon: 'error',
                            allowOutsideClick: false,
                            title: 'Oops...',
                            text: 'Parece que no hay acceso al servidor emby!',
                        }).then((result) => {
                            window.location.href = "/"
                        });
                    });
            },
        })


        document.getElementById("embyusrs").onsubmit = function(event) {


        };

        function genEmbyUsrs() {
            const data = new FormData(document.getElementById('embyusrs'));



            Swal.fire({
                template: '#genUserTemplate',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                    return fetch('../genembyusr', {
                            method: 'POST',
                            body: data
                        }).then(response => response.json())
                        .then(data => {
                            let listaArray=[];
                            for(i in data){
                                  
                                   resolveAfter2Seconds();
                            }
                            console.log("Cerradno Ventatna");
                            Swal.close();
                        }).catch(error => {
                            Swal.fire({
                                icon: 'error',
                                allowOutsideClick: false,
                                title: 'Oops...',
                                text: 'Parece que no hay acceso al servidor!',
                            }).then((result) => {
                                window.location.href = "/"
                            });
                        });
                },
            })
        }



        const ipAPI = '//api.ipify.org?format=json'

const inputValue = fetch(ipAPI)
  .then(response => response.json())
  .then(data => data.ip)

const { value: ipAddress } = await Swal.fire({
  title: 'Enter your IP address',
  input: 'text',
  inputLabel: 'Your IP address',
  inputValue: inputValue,
  showCancelButton: true,
  inputValidator: (value) => {
    if (!value) {
      return 'You need to write something!'
    }
  }
})

if (ipAddress) {
  Swal.fire(`Your IP address is ${ipAddress}`)
}          

   




    </script>

@endsection
