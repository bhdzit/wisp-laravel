<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>WISP Admin</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="/adminlte/bower_components/bootstrap/dist/css/bootstrap.min.css">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="/adminlte/bower_components/font-awesome/css/font-awesome.min.css">
    <!-- Ionicons -->
    <link rel="stylesheet" href="/adminlte/bower_components/Ionicons/css/ionicons.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/adminlte/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
        page. However, you can choose any other skin. Make sure you
        apply the skin class to the body tag so the changes take effect. -->
    <link rel="stylesheet" href="/adminlte/dist/css/skins/skin-blue.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="/adminlte/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css">
    <!-- daterange picker -->
    <link rel="stylesheet" href="/adminlte/bower_components/bootstrap-daterangepicker/daterangepicker.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="/adminlte/bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
    <!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="/adminlte/plugins/iCheck/all.css">

    <!-- Bootstrap Color Picker -->
    <link rel="stylesheet"
        href="/adminlte/bower_components/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css">
    <!-- Bootstrap time Picker -->
    <link rel="stylesheet" href="/adminlte/plugins/timepicker/bootstrap-timepicker.min.css">
    <!-- Select2 -->
    <link rel="stylesheet" href="/adminlte/bower_components/select2/dist/css/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="/adminlte/dist/css/AdminLTE.min.css">
    <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
    <link rel="stylesheet" href="/adminlte/dist/css/skins/_all-skins.min.css">
    <link rel="stylesheet" href="/css/preloader/preloader-style.css">

    <link rel="stylesheet" href="/adminlte/dist/css/fonts.css">
    <link rel="stylesheet" href="/adminlte/dist/css/style.css">
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">
    <script src="https://kit.fontawesome.com/015cfc4544.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-core.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-service.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-ui.js"></script>
    <script type="text/javascript" src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js"></script>
    <link rel="icon" href="/adminlte/dist/img/zona.png" type="image/x-icon">
 <!-- bootstrap wysihtml5 - text editor -->
 <link rel="stylesheet" href="/adminlte/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">
</head>

<body class="hold-transition skin-blue sidebar-mini">
    <div class="wrapper">

        <header class="main-header">

            <!-- Logo -->
            <a href="index2.html" class="logo">
                <!-- mini logo for sidebar mini 50x50 pixels -->
                <span class="logo-mini"><img src="{{ asset('/storage/imagenes/default.png') }}"
                        style="width: 48px;" /><b>WISP</b></span>
                <!-- logo for regular state and mobile devices -->
                <span class="logo-lg"><b>WISP Admin</b></span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
                <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">

                        <!-- User Account Menu -->
                        <li class="dropdown user user-menu">
                            <!-- Menu Toggle Button -->
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <!-- The user image in the navbar-->
                                <img src="{{ asset('/storage/imagenes/default.png') }}"
                                    class="user-image" alt="User Image">
                                <!-- hidden-xs hides the username on small devices so only the image appears. -->
                                <span class="hidden-xs">Carlos Alberto</span>
                            </a>

                        </li>
                        <!-- Control Sidebar Toggle Button -->
                        <li>
                            <a href="#" href="{{ route('logout') }}" onclick="event.preventDefault();
                                 document.getElementById('logout-form').submit();">

                                <i class="fas fa-sign-out-alt"></i></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                style="display: none;">
                                @csrf
                            </form>
                        </li>
                        <li>

                        </li>

                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">




                <!-- Sidebar Menu -->
                <ul class="sidebar-menu" data-widget="tree">
                    <li class="header">MENU</li>
                    <!-- Optionally, you can add icons to the links -->
                    <li class="{{ setActive('home') }}"><a href="{{ url('home/') }}"><i
                                class="fas fa-chart-line"></i>
                            <span> Dashboard</span></a></li>
                    <li class="{{ setActive('torres') }}"><a href="{{ route('torres.index') }}"><i
                                class="fas fa-broadcast-tower"></i><span> Torres</span></a></li>
                  

                    <li class="treeview" style="height: auto;">
                        <a href="#">
                            <i class="fas fa-users"></i>
                            <span>Clientes</span>
                            <span class="pull-right-container">
                                <i class="fa fa-angle-left pull-right"></i>
                            </span>
                        </a>
                        <ul class="treeview-menu" style="display: none;">
                            <li class="{{ setActive('clientes') }}"><a href="{{ route('clientes.index') }}"><i class="fa fa-circle-o"></i>Ver Clientes</a></li>
                            <li class="{{ setActive('enviarmsj') }}"><a href="enviarmsj"><i class="fa fa-circle-o"></i> Enviar Msj</a></li>
                            <li><a href="emby"><i class="fa fa-circle-o"></i> Usuarios Emby</a></li>
                            
                        </ul>
                    </li>

                    <li class="{{ setActive('sectores') }}"><a href="{{ route('sectores.index') }}"><i
                                class="fas fa-wifi"></i> <span> Sectores</span></a></li>
                    <li class="{{ setActive('paquetes') }}"><a href="{{ route('paquetes.index') }}"><i
                                class="fas fa-boxes"></i><span> Paquetes</span></a></li>
                    <li class="{{ setActive('pagos') }}"><a href="{{ route('pagos.index') }}/"><i
                                class="fas fa-receipt"></i> <span> Pagos</span></a></li>
                    <li class="{{ setActive('compras') }}"><a href="{{ route('compras.index') }}/"><i
                                class="fas fa-shopping-cart"></i><span> Compras</span></a></li>
                    <li class="{{ setActive('ingresos') }}"><a href="{{ route('ingresos.index') }}/"><i
                                class="fas fa-hand-holding-usd"></i><span> Ingresos</span></a></li>
                    <li class="{{ setActive('egresos') }}"><a href="{{ route('egresos.index') }}/"><i
                                class="fas fa-hand-holding"></i><span> Egresos</span></a></li>
                    <li class="{{ setActive('tickets') }}"><a href="{{ route('tickets.index') }}"><i
                                class="fas fa-bug"></i><span> Tickets</span></a></li>
                    <li class="{{ setActive('configuracion') }}"><a href="{{ route('configuracion.index') }}"><i
                                class="fa fa-gears"></i><span> Configuracion</span></a></li>

                    <!--         <li class="treeview">
        <a href="#"><i class="fa fa-link"></i> <span>Paquetes</span>
          <span class="pull-right-container">
              <i class="fa fa-angle-left pull-right"></i>
            </span>
        </a>
        <ul class="treeview-menu">
          <li><a href="#">Link in level 2</a></li>
          <li><a href="#">Link in level 2</a></li>
        </ul>
      </li>-->
                </ul>
                <!-- /.sidebar-menu -->
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            @yield('content')
        </div>
        <!-- /.content-wrapper -->
        <footer class="main-footer">

            <strong>Copyright &copy; 2020-2022 <a href="../#">Eliut</a>.</strong> All rights
            reserved.
        </footer>



        <div class="control-sidebar-bg"></div>
    </div>



    <!-- jQuery 3 -->
    <script src="/adminlte/bower_components/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap 3.3.7 -->
    <script src="/adminlte/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <script src="/adminlte/bower_components/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/adminlte/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
    <!-- SlimScroll -->
    <script src="/adminlte/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <!-- FastClick -->
    <script src="/adminlte/bower_components/fastclick/lib/fastclick.js"></script>
    <!-- AdminLTE App -->
    <script src="/adminlte/dist/js/adminlte.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="/adminlte/plugins/iCheck/icheck.min.js"></script>
    <script src="/adminlte/dist/js/demo.js"></script>
    <script src="/adminlte/dist/js/js.js"></script>
    <script src="/adminlte/dist/js/qrcode.js"></script>
    @yield('script')
   

</body>

</html>
