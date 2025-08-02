<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Log in (v2)</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ url('assets/plugins/fontawesome-free/css/all.min.css') }}">
    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ url('assets/plugins/icheck-bootstrap/icheck-bootstrap.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ url('assets/dist/css/adminlte.min.css') }}"
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <a class="h1"><b>Admin</b></a>
            </div>
            <div class="card-body">

                @include('admin.layouts.message')

                <form action="{{ route('login.post') }}" method="post">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                            placeholder="Email" value="{{ old('email') }}" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password"
                            class="form-control @error('password') is-invalid @enderror" placeholder="Password"
                            required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
        <div class="row mb-3">
          <div class="col-12">
            <div class="icheck-primary">
              <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
              <label for="remember">
                Remember Me
              </label>
            </div>
          </div>
        </div>

        <div class="row">
          <div class="col-12">
            <button type="submit" class="btn btn-primary btn-block py-2">Sign In</button>
          </div>
        </div>
                    </div>
                </form>

                <!-- OR Divider -->
                <div class="text-center mb-3">
                    <div class="d-flex align-items-center">
                        <hr class="flex-grow-1">
                        <span class="px-3 text-muted small">OR</span>
                        <hr class="flex-grow-1">
                    </div>
                </div>

                <div class="social-auth-links text-center mb-4">
                    <div class="row" style="margin: 0 8px;">
                        <div class="col-6 pr-1">
                            <a href="#" class="btn btn-block btn-primary py-2 mb-2">
                                <i class="fab fa-facebook mr-1"></i> Facebook
                            </a>
                        </div>
                        <div class="col-6 pl-1">
                            <a href="#" class="btn btn-block btn-danger py-2 mb-2">
                                <i class="fab fa-google-plus mr-1"></i> Google+
                            </a>
                        </div>
                    </div>
                </div>
                <!-- /.social-auth-links -->

                <div class="text-center mb-3">
                    <a href="forgot-password.html" class="text-muted">
                        <i class="fas fa-key mr-1"></i>Forgot your password?
                    </a>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <!-- jQuery -->
    <script src="{{ url('assets/plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ url('assets/plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ url('assets/dist/js/adminlte.min.js') }}"></script>
</body>

</html>
