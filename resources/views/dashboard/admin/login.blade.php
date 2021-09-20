<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="stylesheet" href="/styles.css">
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>LogIn</title>
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
        <!-- Font Awesome -->
        <link rel="stylesheet" href="{{ asset('vendors/plugins/fontawesome-free/css/all.min.css') }}">
        <!-- icheck bootstrap -->
        <link rel="stylesheet" href="{{ asset('vendors/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('vendors/dist/css/adminlte.min.css') }}">

        <!-- THIS IS A LOGIN FOR USER  -->
        
    </head>
        <body class="hold-transition login-page" style="background-image: url('vendors/dist/img/1.png'')">
            <div class="login-box">
                <!-- /.login-logo -->
                <div class="card card-outline card-primary">
                    <div class="card-header text-center">
                        <div class="avatar">
                            <img src="{{asset('vendors/dist/img/copy2.png') }}" id="loginLogo" alt="Avatar">
                        </div>
                    </div>
                    <div class="card-body">
                        @if(Session::has('success')) 
                        <div class="alert alert-warning" role="alert" id="messageModal">
                         {{ Session::get('success') }}
                       </div>
                       @endif 
                        <p class="login-box-msg">Sign in to start your session</p>
                        <form action="{{ route('admin.check') }}" method="post" autocomplete="off"> 
                            @csrf
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" name="email" placeholder="Email" value="{{ old('user_email')}}">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger">@error('user_email'){{ $message }}@enderror</span>
                            <div class="input-group mb-3">
                                <input type="password" class="form-control" name="password" placeholder="Password">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-lock"></span>
                                    </div>
                                </div>
                            </div>
                            <span class="text-danger">@error('user_password'){{ $message }}@enderror</span>
                            <div class="row">
                                <div class="col-8">
                                    <div class="icheck-primary">
                                        <input type="checkbox" id="remember">
                                        <label for="remember"> Remember Me </label>
                                    </div>
                                </div>
                                <!-- /.col -->
                                <div class="col-4">
                                    <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                </div>
                                <!-- /.col --> 
                            </div>
                        </form>
                        <!-- /.social-auth-links -->
                        <p class="mb-1">
                            <a href="" class="text-center">I forgot my password</a>
                        </p>
                        <p class="mb-0">
                            <a href="{{ route('user.register') }}" class="text-center">Register a new account</a>
                        </p>
                    </div>
                    <!-- /.card-body -->
                </div>
                <!-- /.card -->
            </div>
            <!-- /.login-box -->
            <!-- jQuery -->
            <script src="{{ asset('vendors/plugins/jquery/jquery.min.js') }}"></script>
            <!-- Bootstrap 4 -->
            <script src="{{ asset('vendors/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
            <!-- AdminLTE App -->
            <script src="{{ asset('vendors/dist/js/adminlte.min.js') }}"></script>
            <script>
                $("document").ready(function() {
                    setTimeout(function() {
                        $("#messageModal").remove();
                    }, 2000);
                });
            </script>
        </body>
        <script src="{{ asset('js/app.js') }}"></script>
        @include('sweet::alert')
    </html>