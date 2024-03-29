@extends('admin.layout')

@section('content')
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Encuestas
            <small>Control panel</small>
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
            <li class="active">Encuesta</li>
        </ol>
    </section>
    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-xs-12">
                <div class="box">
                    <div class="box-header">
                        <h3 class="box-title">Tabla de Clientes</h3>
                        <button class="btn btn-primary pull-right" onclick="addClient()">Agregar Cliente</button>
                        <button style="margin-right: 20px;" class="btn btn-primary pull-right" onclick="seeClients()">Ver
                            Clientes</button>
                    </div>
                    <!-- /.box-header -->
                    <div class="box-body">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr role="row">
                                    <th>No.</th>
                                    <th>Clientes</th>
                                    <th>Paquete</th>
                                    <th>Tipo de Contrato</th>
                                    <th>Fecha de Contrato</th>
                                    <th>Sector</th>
                                    <th>QR</th>
                                    <th style="width:60px;">Editar</th>
                                    <th style="width:60px;">Eliminar</th>
                                </tr>
                            </thead>
                            <tbody id="SectorListTable">
                                @forelse($clientes as $cliente)
                                    <tr>
                                        <td>{{ $cliente->ws_id }} </td>
                                        <td>{{ $cliente->wc_name }} {{ $cliente->wc_last_name }} </td>
                                        <td>{{ $cliente->wp_name }} </td>
                                        <td>{{ $cliente->wct_nombre }}</td>
                                        <td>{{ $cliente->ws_date }}</td>
                                        <td>{{ $cliente->wsct_name }}</td>
                                        <td><i class="fas fa-qrcode" style=color:#000;
                                                onclick='showQR(JSON.stringify({{ json_encode($cliente) }}))'></i></td>
                                        <td>
                                            <button class="btn btn-success"
                                                onclick="editClient({{ json_encode($cliente) }})"><i
                                                    class="fa fa-btn fa-edit"></i></button>
                                        </td>
                                        <td>
                                            <form action="{{ url('clientes/' . $cliente->ws_id) }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                                <button type="submit" class="btn btn-danger"><i
                                                        class="fa fa-btn fa-trash"></i></button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty

                                @endforelse
                            </tbody>
                            <tfoot>
                            </tfoot>
                        </table>

                    </div>
                    <!-- /.box-body -->
                </div>
                <!-- /.box -->
            </div>
            <!-- /.col -->
        </div>
    </section>
@stop
@section('script')
<script type="text/javascript">
    $(function() {
        $('#example1').DataTable({
            "language": {
                "search": "Buscar:",
                "lengthMenu": "Mostrar : _MENU_ ",
                "info": "Clientes _START_ al _END_ de _TOTAL_ Clientes",
                "paginate": {
                    "first": "Primera",
                    "last": "Ultima",
                    "next": "Siguiente",
                    "previous": "Anterior"
                },
            }
        });

    });

    function addClient() {
        Swal.fire({
            title: 'Agregar Cliente',
            html: @include('sweetAlert2.ClienteLayout'),
            width: '60%',
            showClass: {
                popup: 'animated fadeInDown faster'
            },
            hideClass: {
                popup: 'animated fadeOutUp faster'
            },
            preConfirm: function() {
                document.getElementById("send_btn").click();
                return false;
            }

        });
        setMap();
        map.addEventListener('tap', function(evt) {
            var coord = map.screenToGeo(evt.currentPointer.viewportX,
                evt.currentPointer.viewportY);
            if (marker != null) {
                map.removeObject(marker);
            }
            $("#wc_point").val(coord.lng + "," + coord.lat);
            addMarck({
                lat: coord.lat,
                lng: coord.lng
            });
        });


        $("#wc_sector").change(function(evt) {

            $("#wc_ip").attr('list', 'ipdisponiblesec' + evt.target.value);
        });

    }

    function editClient(json) {

        Swal.fire({
            title: 'Editar Cliente',
            html: @include('sweetAlert2.ClienteLayout'),
            width: '60%',
            showClass: {
                popup: 'animated fadeInDown faster'
            },
            hideClass: {
                popup: 'animated fadeOutUp faster'
            },
            preConfirm: function() {
                document.getElementById("send_btn").click();
                return false;
            }
        });
        var url = "{{ url('clientes/') }}";
        url += "/" + json.ws_id;

        $('#ClienteForm').attr('action', url);

        $('#ClienteForm').append('{{ method_field('PATCH') }}');
        setMap();

        $("#wc_id").val(json.ws_id);
        $("#wc_name").val(json.wc_name);
        $("#wc_last_name").val(json.wc_last_name);
        $("#wc_phone").val(json.wc_phone);
        $("#wc_phone2").val(json.wc_phone2);
        $("#wc_mail").val(json.wc_mail);
        $("#wc_date").val(json.ws_date);
        $("#wc_pay_date").val(json.ws_first_pay_date);
        $("#wc_pkg").val(json.wp_id);
        $("#wc_ip").val(json.ws_ip);
        $("#wc_ssid").val(json.ws_ssid);
        $("#wc_pass").val(json.ws_pass);
        $("#wc_contract").val(json.wct_id);
        $("#wc_sector").val(json.ws_sector);
        $("#wc_point").val(json.lng + "," + json.lat);

        addMarck({
            lat: json.lat,
            lng: json.lng
        });
        map.addEventListener('tap', function(evt) {
            var coord = map.screenToGeo(evt.currentPointer.viewportX,
                evt.currentPointer.viewportY);
            if (marker != null) {
                map.removeObject(marker);
            }
            $("#wc_point").val(coord.lng + "," + coord.lat);
            addMarck({
                lat: coord.lat,
                lng: coord.lng
            });
        });


    }
    @if ($errors->any())
        addClient();
        @if (old('_method'))
    
            var url="{{ url('clientes/') }}";
            url+="/"+$("#wc_id").val();
    
            $('#ClienteForm').attr('action', url);
    
            $('#ClienteForm').append('{{ method_field('PATCH') }}');
        @endif
    
        $("#wc_pkg").val({{ old('wc_pkg') }});
        $("#wc_contract").val({{ old('wc_pkg') }});
        $("#wc_sector").val({{ old('wc_sector') }});
    @endif


    function seeClients() {
        Swal.fire({
            title: 'Agregar Cliente',
            html: @include('sweetAlert2.SeeAllClientsLayout'),
            width: '100%',
            showClass: {
                popup: 'animated fadeInDown faster'
            },
            hideClass: {
                popup: 'animated fadeOutUp faster'
            },
            preConfirm: function() {
                document.getElementById("send_btn").click();
                return false;
            }

        });
        setMap();

        var towerpoint = {};
        @foreach ($sectores as $sector)
            addMarck({lng:{{ $sector->lng }},lat:{{ $sector->lat }}});
            var id={{ $sector->wsct_id }};
            towerpoint=Object.assign({ {{ $sector->wsct_id }}:
            {lng:{{ $sector->lng }},lat:{{ $sector->lat }},color:"#{{ $sector->wsct_color }}",sector_type:{{ $sector->wsct_antenna }},dist:{{ $sector->wsct_dist }}
            } }, towerpoint);
            // console.log(towerpoint["8"]);
            if({{ $sector->wsct_antenna }}==2){
            map.addObject(dreawOmniAntenna({{ $sector->lat }},{{ $sector->lng }},{{ $sector->wsct_dist }},"#{{ $sector->wsct_color }}"));
            }
            else{
            var lineString = new H.geo.LineString();
            var d='{{ $sector->wsct_dist }}'*1;
            var apertura='{{ $sector->wsec_rank }}'/2;
            var deg='{{ $sector->wsec_deg }}';
            var limit=((deg*1)+apertura);
        
            var i=(deg-apertura)*1;
            //console.dir(typeof i+"<"+ typeof limit+"||"+deg+","+apertura); for(i;i<limit;i++){ //
                console.log((deg-apertura)+"<"+limit+"||"+deg+","+apertura); var
                point=getLatLng(toRad({{ $sector->lat }}),d,i,toRad({{ $sector->lng }}));
                lineString.pushPoint({lat:point.lat, lng:point.lng}); //i++; };
                lineString.pushPoint({lat:{{ $sector->lat }},lng:{{ $sector->lng }} }); var
                color="#{{ $sector->wsct_color }}" ; if(color=="#0" ){ color="#000000" } polyline=new H.map.Polygon(
                lineString, { style: {lineWidth: 3,strokeColor: color, fillColor: hex2rgba_convert(color,50)} } );
                console.log(polyline);
                map.addObject(polyline);//dreawSectoralAntenna({{ $sector->lat }},{{ $sector->lng }},{{ $sector->wsct_dist }},"#{{ $sector->wsct_color }}",30,{{ $sector->wsec_deg }}));
                } @endforeach

        @foreach ($clientes as $cliente)
            var lat={{ $cliente->lat }};
            var lng={{ $cliente->lng }};
        
            // addMarck({lat:lat,lng:lng});
        
            var cords={lat:lat,lng:lng};
            var icon = new H.map.Icon(mapmarck);
            marker = new H.map.Marker(cords, {icon: icon});
            map.addObject(marker);
            lineString = new H.geo.LineString();
            lineString.pushPoint({lat:lat, lng:lng});
            lineString.pushPoint(towerpoint[{{ $cliente->ws_sector }}]);
            var sectorColor=towerpoint[{{ $cliente->ws_sector }}].color;
            if(sectorColor=="#0"){
            sectorColor="#000";
            }
            map.addObject(new H.map.Polyline(
            lineString, { style: { lineWidth: 1,strokeColor:sectorColor }}
            ));
        @endforeach
    }
</script>
@stop
