@can('admin')
    <li class="nav-item {{ Request::is('admin/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/admin/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <hr class="sidebar-divider">

    <li class="nav-item {{ Request::is('admin/users*') || Request::is('admin/eksekutor*') || Request::is('admin/kategori-pengaduan*') || Request::is('admin/kamus-sara*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true"
            aria-controls="collapseTwo">
            <i class="fas fa-fw fa-cog"></i>
            <span>Master Data</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/admin/users">Data User</a>
                <a class="collapse-item" href="/admin/kategori-pengaduan">Data Kategori Pengaduan</a>
                <a class="collapse-item" href="/admin/kamus-sara">Data Kamus SARA</a>
            </div>
        </div>
    </li>
    <li class="nav-item {{ Request::is('admin/pengaduan-list*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseThree" aria-expanded="true"
            aria-controls="collapseThree">
            <i class="fas fa-fw fa-cog"></i>
            <span>Pengaduan</span>
        </a>
        <div id="collapseThree" class="collapse" aria-labelledby="headingThree" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/admin/pengaduan">Pengaduan Tercatat</a>
            </div>
        </div>
    </li>

    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fas fa-home"></i>
            <span>Halaman depan</span></a>
    </li>
@endcan

@can('penduduk')
    <li class="nav-item {{ Request::is('penduduk/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/penduduk/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item {{ Request::is('penduduk/pengaduan*') ? 'active' : '' }}">
        <a class="nav-link" href="/penduduk/pengaduan">
            <i class="fa fa-clipboard"></i>
            <span>Pengaduan Saya</span></a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fas fa-home"></i>
            <span>Halaman depan</span></a>
    </li>
@endcan

@can('eksekutor')
    <li class="nav-item {{ Request::is('eksekutor/dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="/eksekutor/dashboard">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item {{ Request::is('eksekutor/pengaduan*') ? 'active' : '' }}">
        <a class="nav-link" href="/eksekutor/pengaduan">
            <i class="fa fa-clipboard"></i>
            <span>Pengaduan</span></a>
    </li>
    <li class="nav-item {{ Request::is('eksekutor/tindak-lanjut*') ? 'active' : '' }}">
        <a class="nav-link" href="/eksekutor/tindak-lanjut">
            <i class="fa fa-clipboard"></i>
            <span>Tindak Lanjut</span></a>
    </li>
    <hr class="sidebar-divider">
    <li class="nav-item">
        <a class="nav-link" href="/">
            <i class="fas fa-home"></i>
            <span>Halaman depan</span></a>
    </li>
@endcan
