<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistema - Controle de Eventos</title>

        <!-- Sweet Alert 2 -->
        <link href="/plugins/sweetalert2/sweetalert2.css" rel="stylesheet">
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/a5ea35bb9b.js" crossorigin="anonymous"></script>
        <!-- Theme style -->
        <link rel="stylesheet" href="/css/adminlte.min.css">
        <!-- jQuery -->
        <script src="/plugins/jquery/jquery.min.js"></script>
        <!-- Bootstrap 4 -->
        <script src="/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
        <!-- AdminLTE App -->
        <script src="/js/adminlte.min.js"></script>
        <!-- Sweet Alert 2 -->
        <script src="/plugins/sweetalert2/sweetalert2.min.js"></script>
    </head>
    <body class="hold-transition sidebar-mini">
        <!-- Site wrapper -->
        <div class="wrapper">
        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-white navbar-light">
            <!-- Left navbar links -->

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
            <li class="nav-item">
                <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="{{ route('logout') }}" role="button">
                <i class="fas fa-sign-out-alt"></i>
                </a>
            </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar sidebar-dark-primary elevation-4">
            <!-- Brand Logo -->
            <a href="{{ route('home') }}" class="brand-link">
                <img src="/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">ADMIN</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                    <div class="image">
                        <img src="/img/user2-160x160.jpg" class="img-circle elevation-2" alt="User Image">
                    </div>
                    <div class="info">
                        <a href="#" class="d-block">{{ Auth::user()->name }}</a>
                    </div>
                </div>

                <!-- SidebarSearch Form -->
                <div class="form-inline">
                    <div class="input-group" data-widget="sidebar-search">
                        <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
                        <div class="input-group-append">
                            <button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button>
                        </div>
                    </div>
                </div>

                <!-- Sidebar Menu -->
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        <li class="nav-item">
                            <a href="{{ route('home') }}" class="nav-link" id="home"><i class="nav-icon fas fa-home"></i><p>Início</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('eventos.index') }}" class="nav-link" id="eventos"><i class="nav-icon fa-solid fa-calendar-days"></i><p>Eventos</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('inscricao.index') }}" class="nav-link" id="inscricao"><i class="nav-icon fa-solid fa-calendar-day"></i><p>Eventos inscritos</p></a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('inscricao.index_checkin') }}" class="nav-link" id="checkin"><i class="nav-icon fa-solid fa-calendar-check"></i><p>Checkins</p></a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>@yield('title')</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                    <li class="breadcrumb-item active"><strong>@yield('breadcrumb')</strong></li>
                    </ol>
                </div>
                </div>
            </div><!-- /.container-fluid -->
            </section>

            <!-- Main content -->
            <section class="content">

            <div class="wrapper wrapper-content">
                <div class="animated fadeInRightBig">
                    <div class="info-box loading">
                        <span class="info-box-icon"></span><p style="color:black">Carregando, aguarde...</p>
                    </div>
                    @yield('content')
                </div>
            </div>

            <script>
                $('.loading').hide();
            </script>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <footer class="main-footer">
            <div class="float-right d-none d-sm-block">
            <b>Version</b> 3.2.0
            </div>
            <strong>Copyright &copy; 2023 - <a>Sistema: Controle de Eventos</a>.</strong> All rights reserved.
        </footer>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
        </div>

        <style>
            .loading.info-box:before {
                width: 100%;
                min-height: inherit;
                z-index: 50;
                background: rgba(255,255,255,0.8);
                /*   border-radius: 3px; */
                content: " ";
                position: absolute;
            }

            .loading.info-box .info-box-icon i{
                display: none;
            }

            .loading.info-box .info-box-icon:after {
                position: absolute;
                margin-top: 20px;
                margin-left: -.4em;
                /*   text-align: center; */
                content: "\f021";
                font: normal normal normal 1em/1 FontAwesome;
                webkit-animation: fa-spin .8s infinite linear;
                animation: fa-spin .8s infinite linear;
                z-index: 999;
                color: #555;
            }
        </style>
    </body>
</html>