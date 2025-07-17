<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CSR PLN Nusantara Power UP Paiton</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/logo-pln1.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <div
            class="position-relative overflow-hidden radial-gradient min-vh-100 d-flex align-items-center justify-content-center">
            <div class="d-flex align-items-center justify-content-center w-100">
                <div class="row justify-content-center w-100">
                    <div class="col-md-8 col-lg-6 col-xxl-3">
                        <div class="card mb-0">
                            <div class="card-body">
                                <a href="./index.html" class="text-nowrap logo-img text-center d-block py-3 w-100">
                                    <img src="{{ asset('images/logos/logo-pln2.png') }}" width="180" alt="">
                                </a>
                               @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif

<form method="POST" action="{{ route('login') }}">
    @csrf
    <div class="mb-3">
        <label for="username" class="form-label">Username</label>
        <input
            placeholder="Masukkan Username"
            type="text"
            name="username"
            class="form-control @error('username') is-invalid @enderror"
            id="username"
            value="{{ old('username') }}"
            required autofocus
        >
        @error('username')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>

    <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <input
            placeholder="Masukkan password"
            type="password"
            name="password"
            class="form-control @error('password') is-invalid @enderror"
            id="password"
            required
        >
        @error('password')
            <div class="invalid-feedback">{{ $message }}</div>
        @enderror
    </div>
    <div class="d-flex align-items-center justify-content-between mb-4">
                    <div class="form-check">
                      <input class="form-check-input primary" type="checkbox" name="remember"  value="" id="remember" {{ old('remember') ? 'checked' : '' }}  checked>
                      <label class="form-check-label text-dark" for="remember"> 
                        Simpan Login
                      </label>
                    </div>
                    
                  </div>

    <button type="submit" class="btn btn-primary w-100 py-8 fs-4 mb-4 rounded-2">Sign In</button>
</form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>
