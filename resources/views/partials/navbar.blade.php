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
            <a class="sidebar-link" href="/monitoring" aria-expanded="false">
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
{{-- <li class="sidebar-item">
    <a class="sidebar-link" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" aria-expanded="false">
        <span>
            <i class="ti ti-logout"></i>
        </span>
        <span class="hide-menu">Logout</span>
    </a>

    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
        @csrf
    </form>
</li> --}}
<li class="sidebar-item">
    <a class="sidebar-link" href="#" onclick="showLogoutModal()">
        <span><i class="ti ti-logout"></i></span>
        <span class="hide-menu">Logout</span>
    </a>
</li>

    </ul>
</nav>

<!-- Logout Confirmation Modal -->
{{-- <div class="modal fade" id="logoutModal" tabindex="-1" aria-labelledby="logoutModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-warning">
                <h5 class="modal-title" id="logoutModalLabel">Konfirmasi Logout</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
            </div>
            <div class="modal-body">
                Apakah Anda yakin ingin logout?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                <form id="logout-form" action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div> --}}

<div id="customLogoutModal" style="display:none; position: fixed; inset: 0; background-color: rgba(0, 0, 0, 0.5); z-index: 1050;">
    <div style="max-width: 500px; margin: 2% auto 0 auto; background-color: #fff; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);">
        <div style="display: flex; justify-content: space-between; align-items: center; padding: 16px 20px; border-bottom: 1px solid #eee;">
            <h5 style="margin: 0; font-size: 18px; font-weight: 600;">Konfirmasi Logout</h5>
            <button onclick="hideLogoutModal()" style="border: none; background: none; font-size: 20px;">&times;</button>
        </div>
        <div style="padding: 20px;">
            <p style="margin-bottom: 0.5rem;">Apakah Anda yakin ingin Logout dari akun ini?</p>
        </div>
        <div style="display: flex; justify-content: end; gap: 8px; padding: 16px 20px; border-top: 1px solid #eee;">
            <button onclick="hideLogoutModal()" class="btn btn-light border">Batal</button>
            <form id="logout-form" action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Ya, Logout</button>
            </form>
        </div>
    </div>
</div>

<script>
function showLogoutModal() {
    document.getElementById('customLogoutModal').style.display = 'block'
}

function hideLogoutModal() {
    document.getElementById('customLogoutModal').style.display = 'none'
}
</script>
