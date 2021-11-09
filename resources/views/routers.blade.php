@extends('admin.layout')
@section('content')
    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div id="agregar-router" class="box-header">
                    <agregar-router></agregar-router>
                </div>
                <!-- /.box-header -->
                <div class="box-body">
                    <table id="example1" class="table table-bordered table-striped">
                        <thead>
                            <tr role="row">
                                <th>No.</th>
                                <th>Identidad</th>
                                <th>Usuario</th>
                                <th>Contraseña</th>
                                <th style="width:60px;">Editar</th>
                                <th style="width:60px;">Eliminar</th>
                            </tr>
                        </thead>

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
@stop

@section('script')
    <script src="{{ mix('/js/mikrotik.js') }}"></script>
    <script type="text/javascript">
        $(function() {
            $('#example1').DataTable({
                "language": {
                    "search": "Buscar:",
                    "lengthMenu": "Mostrar : _MENU_ ",
                    "info": "Sector _START_ al _END_ de _TOTAL_ Sectores",
                    "paginate": {
                        "first": "Primera",
                        "last": "Ultima",
                        "next": "Siguiente",
                        "previous": "Anterior"
                    },
                }
            })

        });
    </script>
@stop
