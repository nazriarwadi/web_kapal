<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Login Admin</title>

    <link rel="shortcut icon" href="{{ asset('assets/sb-admin/img/ship.png') }}" type="image/x-icon">

    <!-- Custom fonts for this template -->
    <link href="{{ asset('assets/sb-admin/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="{{ asset('assets/sb-admin/css/sb-admin-2.min.css') }}" rel="stylesheet">
</head>

<body style="
    background-image: url('{{ asset('assets/sb-admin/img/background.png') }}');
    background-size: cover;
    background-position: center;
    background-repeat: no-repeat;
">

    <div class="container">
        <!-- Outer Row -->
        <div class="row justify-content-center align-items-center" style="min-height: 100vh;">
            <div class="col-xl-5 col-lg-6 col-md-6">
                <div class="card o-hidden border-0 shadow-lg">
                    <div class="card-body p-4">
                        <div class="text-center">
                            <h1 class="h4 text-gray-900 mb-4 font-weight-bold">LOGIN</h1>
                        </div>
                        <!-- Logo below login text -->
                        <div class="text-center mb-4">
                            <img src="{{ asset('assets/sb-admin/img/ship.png') }}" alt="Logo" class="img-fluid" style="max-width: 100px;">
                        </div>
                        <!-- Notifikasi -->
                        @if(session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                        @endif
                        <form action="{{ route('login.submit') }}" method="POST" class="user">
                            @csrf
                            <div class="form-group">
                                <input type="email" class="form-control form-control-user" id="email" name="email" placeholder="Enter Email Address..." required>
                            </div>
                            <div class="form-group">
                                <input type="password" class="form-control form-control-user" id="password" name="password" placeholder="Password" required>
                            </div>
                            <div class="form-group">
                                <div class="custom-control custom-checkbox small">
                                    <input type="checkbox" class="custom-control-input" id="customCheck">
                                    <label class="custom-control-label" for="customCheck">Remember Me</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary btn-user btn-block">
                                Login
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript -->
    <script src="{{ asset('assets/sb-admin/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/sb-admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Core plugin JavaScript -->
    <script src="{{ asset('assets/sb-admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

    <!-- Custom scripts for all pages -->
    <script src="{{ asset('assets/sb-admin/js/sb-admin-2.min.js') }}"></script>

</body>

</html>