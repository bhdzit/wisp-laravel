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
                                <button onclick="document.getElementById('clientsMsj').submit()" type="submit" class="btn btn-info pull-right">Enviar</button>
                            </div>

                        </div>

                    </div>
                    <form action="enviarmsj" method="POST" id="clientsMsj">
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
                                                    href="#">{{ $cliente->wc_name . ' ' . $cliente->wc_last_name . ' / ' . $cliente->wc_phone }}
                                                    <span class="pull-right "><input name="num[]" value="{{$cliente->wc_phone}}" type="checkbox"></span></a></li>
                                        @endforeach
                                    </ul>
                                    <!-- /.direct-chat-msg -->
                                </div>

                            </div>
                            <div class="box-body pad col-sm-5">
                                <form>
                                    <textarea id="editor1" name="editor1" rows="10" cols="80">
                                                 This is my textarea to be replaced with CKEditor.
                                                </textarea>
                                </form>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
    </section>


@endsection
@section('script')
    <script src="/adminlte/bower_components/ckeditor/ckeditor.js"></script>
    <!-- Bootstrap WYSIHTML5 -->
    <script src="/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
    <script>
        let torres = document.querySelectorAll("[data-torre]");


        document.getElementById("torres").addEventListener("change", function(evt) {

            for (let i = 0; i < torres.length; i++) {
                let torreDeSector = torres[i].getAttribute("data-torre");
                if (evt.target.value != torreDeSector) {
                    torres[i].setAttribute("hidden", "true");
                } else {
                    torres[i].removeAttribute("hidden", "true");
                }
            }
            document.getElementById("sectores").selectedIndex = 0;
            setClientFilter();
        });

        document.getElementById("sectores").addEventListener("change", setClientFilter);

        let clientes = document.getElementsByClassName("client-phone");

        function setClientFilter() {

            let torreSelecionada = document.getElementById("torres").value;
            let sectorSelecionado = document.getElementById("sectores").value;

            for (let i = 0; i < clientes.length; i++) {
                let torre = clientes[i].getAttribute("data-cli-torre");
                let sector = clientes[i].getAttribute("data-cli-sec");
                if ((torre == torreSelecionada || torreSelecionada == 0) && (sectorSelecionado == 0 || sector ==
                        sectorSelecionado)) {
                    clientes[i].classList.remove("hidden");
                } else {
                    clientes[i].classList.add("hidden");
                }
            }
        }


        document.getElementById("search").addEventListener("keyup", function(evt) {
            for (let i = 0; i < clientes.length; i++) {
                if (clientes[i].children[0].textContent.includes(evt.target.value)) {
                    clientes[i].classList.remove("hidden");
                    console.log(clientes[i].children[0].textContent);

                } else {
                    clientes[i].classList.add("hidden");
                }
            }
        });


        document.getElementById("selectAllcheckbox").addEventListener("change", function(evt) {
            for (let i = 0; i < clientes.length; i++) {
                clientes[i].children[0].children[0].children[0].checked = evt.target.checked;
            }
        });
        $(function() {
            // Replace the <textarea id="editor1"> with a CKEditor
            // instance, using default configuration.
            CKEDITOR.replace('editor1')
            //bootstrap WYSIHTML5 - text editor
            $('.textarea').wysihtml5()
        })
    </script>
@endsection
