@if (auth()->guard('admin')->check())
    <script>
        window.location = "{{ route('admin.dashboard') }}";
    </script>
@endif
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Log In | ISP-Billing Management System </title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link href="{{ asset('Backend/plugins/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- icheck bootstrap -->
    <link href="{{ asset('Backend/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}" rel="stylesheet"
        type="text/css" />
    <!-- Theme style -->
    <link href="{{ asset('Backend/dist/css/adminlte.min.css?v=3.2.0') }}" rel="stylesheet" type="text/css" />

    <style>
        .login-box .card,
        .register-box .card {

            /* border: 2px #838383 dotted !important; */
            background: rgba(255, 255, 255, 0.3) !important;
        }

        .login-card-body,
        .register-card-body {
            border-bottom: 20px !important;
            /* background: rgba(255, 255, 255, 0.3) !important; */
            background: rgb(0 0 0 / 30%) !important;
        }

        body {
            position: relative;
            min-height: 100vh;
            overflow: hidden;
        }

        /* Background image layer */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url('');
            background-size: cover;
            background-position: center;
            filter: blur(8px);
            transform: scale(1.05);
            z-index: -2;
        }

        /* Dark overlay for readability */
        body::after {
            content: '';
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.55);
            z-index: -1;
        }
    </style>
</head>


<body class="hold-transition register-page"
    style="background-image: url(''); background-size: cover; background-position: center;">

    <div class="register-box">
        <div class="card">
            @if ($errors->any())
                <div class="card-header">
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endif
            @if (Session::has('error-message'))
                <div class="card-header">
                    <p class="alert alert-danger">{{ Session::get('error-message') }}</p>
                </div>
            @endif
            <div class="card-body register-card-body">
                <div class="register-logo">
                   

                    

                    <img width="200px" src="{{asset('Backend/images/isp_logo.jpg')}}">
                </div>
                <p class="login-box-msg ">
                    <strong class="text-success text-white">Welcome Back</strong><br>
                    <small class="text-muted text-white">Login to your ISP Management Panel</small>
                </p>


                <form action="{{ route('login.functionality') }}" method="post">
                    @csrf

                    <div class="input-group mb-3">
                        <input type="text" name="login" class="form-control" placeholder="Enter Email or Username"
                            value="{{ old('login') }}">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-user"></span></div>
                        </div>
                    </div>

                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Enter Your Password">
                        <div class="input-group-append">
                            <div class="input-group-text"><span class="fas fa-lock"></span></div>
                        </div>
                    </div>

                    <button type="submit" id="loginBtn" class="btn btn-block"
                        style="background: linear-gradient(to left, #544890 0%, #8b96bb 100%);color:white">
                        Login <i class="fas fa-sign-in-alt"></i>
                    </button>
                </form>

                

                <p class="mb-1 text-white">
                    <a href="#">I forgot my password</a>
                </p>
                <p class="mb-0 text-white">
                    <a href="#" class="text-center">Register a new membership</a>
                </p>
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    <!-- jQuery -->
    <script src="{{ asset('Backend/plugins/jquery/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('form').on('submit', function() {
                let $btn = $('#loginBtn');
                $btn.html('<i class="fas fa-spinner fa-spin"></i> Logging in...');
                $btn.prop('disabled', true);
            });
        });
    </script>
</body>

</html>
