<nav class="sidebar-nav scroll-sidebar" data-simplebar="">
    <ul id="sidebarnav">
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Beranda</span>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="/" aria-expanded="false">
                <span>
                    <i class="ti ti-layout-dashboard"></i>
                </span>
                <span class="hide-menu">Dashboard</span>
            </a>
        </li>
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">PROPOSAL</span>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="/proposal" aria-expanded="false">
                <span>
                    <i class="ti ti-article"></i>
                </span>
                <span class="hide-menu">Pengajuan</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="./ui-alerts.html" aria-expanded="false">
                <span>
                    <i class="	ti ti-eye"></i>
                </span>
                <span class="hide-menu">Monitoring</span>
            </a>
        </li>
        @if(Auth::user()->role === 'admin')
        <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">Manajemen Data</span>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="/pengguna" aria-expanded="false">
                <span>
                    <i class="ti ti-user"></i>
                </span>
                <span class="hide-menu">Pengguna</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="/tipologi" aria-expanded="false">
                <span>
                    <i class="ti ti-clipboard"></i>
                </span>
                <span class="hide-menu">Tipologi</span>
            </a>
        </li>
        <li class="sidebar-item">
            <a class="sidebar-link" href="/tipe-proses" aria-expanded="false">
                <span>
                    <i class="ti ti-clipboard"></i>
                </span>
                <span class="hide-menu">Proses</span>
            </a>
        </li>
        @endif
        <li class="nav-small-cap">
    <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
    <span class="hide-menu">Akun</span>
</li>
<li class="sidebar-item">
    <a class="sidebar-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false">
        <span>
            <i class="ti ti-logout"></i>
        </span>
        <span class="hide-menu">Logout</span>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</li>

    </ul>
</nav>
