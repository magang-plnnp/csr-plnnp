<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'My App')</title>
    <link rel="shortcut icon" type="image/png" href="{{ asset('images/logos/logo-pln1.png') }}" />
    <link rel="stylesheet" href="{{ asset('css/styles.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('datatable.css') }}" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <!-- Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <aside class="left-sidebar">
            <!-- Sidebar scroll-->
            <div>
                <div class="brand-logo d-flex align-items-center justify-content-between">
                    <a href="./index.html" class="text-nowrap logo-img">
                        <img src="{{ asset('images/logos/logo-pln2.png') }}" width="180" alt="" />
                    </a>
                    <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
                        <i class="ti ti-x fs-8"></i>
                    </div>
                </div>
                <!-- Sidebar navigation -->
                @include('partials.navbar')
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll -->
        </aside>
        <!-- Sidebar End -->
        <!-- Main wrapper -->
        <div class="body-wrapper">
            <!-- Header Start -->
            @include('partials.header')
            <!-- Header End -->
            <div class="container-fluid">
                <!-- Footer Start -->
                @yield('content')
                @include('partials.footer')
                <!-- Footer End -->
            </div>
        </div>
    </div>
    
    <script src="{{ asset('libs/jquery/dist/jquery.min.js') }}"></script>
    <script src="{{ asset('libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/sidebarmenu.js') }}"></script>
    <script src="{{ asset('js/app.min.js') }}"></script>
    <script src="{{ asset('libs/apexcharts/dist/apexcharts.min.js') }}"></script>
    <script src="{{ asset('libs/simplebar/dist/simplebar.js') }}"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>
    @stack('scripts')
</body>

</html>
