<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;600&display=swap" rel="stylesheet">

    <title> @yield('title')</title>

    @include('Backend.Include.Style')
    <style>
        .menu-open {
            display: block;
        }

        .sidebar,
        .navbar,
        .content-wrapper {
            font-family: 'Hind Siliguri', sans-serif !important;
        }

        .layout-navbar-fixed .wrapper .sidebar-dark-primary .brand-link:not([class*=navbar]) {
            background-color: #fff !important;
        }



        /*----------------Loader--------------*/
        #loaderOverlay {
            display: flex;
            /* Initially visible */
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.3);
            z-index: 2000;
            align-items: center;
            justify-content: center;
        }

        #loaderBox {
            background: #fff;
            padding: 20px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 18px rgba(0, 0, 0, 0.15);
            display: flex;
            gap: 12px;
            align-items: center;
        }
    </style>
    @php
        // $disable_customer_info_style = request()->routeIs([
        //     'admin.customer.index',
        //     'admin.onu.index'
        // ]);
    @endphp
    <style>
        .info-container {
            display: flex;
            align-items: center;
            text-decoration: none;
            color: #333;
        }
        .info-row {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .view-profile-btn, .copy-btn {
            opacity: 0;
            cursor: pointer;
            transition: opacity 0.2s ease;
        }

        .info-row:hover .view-profile-btn,
        .info-row:hover .copy-btn {
            opacity: 1;
        }



        .copy-btn {
            color: #888;
        }
        .copy-btn:hover {
            color: #333;
        }



        /* pulsing green dot style */
        .online-pulse-dot {
            height: 10px;
            width: 10px;
            background-color: #2ea44f;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
            position: relative;
            box-shadow: 0 0 0 0 rgba(46, 164, 79, 0.7);
            animation: pulse-green 1.5s infinite;
        }

        @keyframes pulse-green {
            0% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(46, 164, 79, 0.7);
            }
            70% {
                transform: scale(1);
                box-shadow: 0 0 0 8px rgba(46, 164, 79, 0);
            }
            100% {
                transform: scale(0.95);
                box-shadow: 0 0 0 0 rgba(46, 164, 79, 0);
            }
        }

        /* offline dot style */
        .offline-static-dot {
            height: 10px;
            width: 10px;
            background-color: #cb2431;
            border-radius: 50%;
            display: inline-block;
            margin-right: 6px;
        }
    </style>
</head>

<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
    <div class="wrapper">

        <!-- Navbar -->
        @include('Backend.Include.Navbar')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('Backend.Include.Sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">

                        </div><!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item">
                                    <a href="{{ route('admin.dashboard') }}">Home</a>
                                     <a href="{{ route('admin.dashboard') }}">/ Dashboard / </a>
                                     <a href="javascript:void(0);" onclick="window.location.reload();" style="cursor: pointer;">
                                        @yield('header_title')
                                    </a>
                                </li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            
            <!-- Loader Overlay -->
            {{-- @if(!$disable_loader)
                <div id="loaderOverlay">
                    <div id="loaderBox">
                        <img src="{{ asset('Backend/images/loading.gif') }}" class="img-fluid" alt="Loading...">
                    </div>
                </div>
            @endif --}}

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid" id="main-content">
                    @yield('content')
                </div><!-- /.container-fluid -->
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        <!-- @include('Backend.Include.Footer') -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    @include('Backend.Include.Script')
    <script type="text/javascript">
    </script>
    
</body>

</html>
