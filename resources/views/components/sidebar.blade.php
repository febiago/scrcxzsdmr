<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="{{ route('dashboard') }}">SPPD KEC. SUDIMORO</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="#">SPPD</a>
        </div>
        <ul class="sidebar-menu">
            <li class="{{ Request::is('dashboard') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('dashboard') }}"><i class="far fa-square"></i> <span>Dashboard</span></a>
            </li>
            <li class="menu-header">Perjalanan Dinas</li>
            <li class="{{ Request::is('sppd') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('sppd') }}"><i class="far fa-file-alt"></i> <span>SPPD</span></a>
            </li>
            <li class="{{ Request::is('rekap') ? 'active' : '' }}">
                <a class="nav-link"
                    href="{{ url('rekap') }}"><i class="far fa-file-alt"></i> <span>Laporan SPPD</span></a>
            </li>
            @if (Auth::check() && Auth::user()->getRole() === 'admin')
            <li class="menu-header">Setting</li>
            <li class="nav-item dropdown {{ (isset($type_menu) && $type_menu === 'components') ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fa fa-database" aria-hidden="true"></i>
                    <span>Master Data</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('user') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('kegiatan') }}"><span>User</span></a>
                    </li>
                    <li class="{{ Request::is('pegawai') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('pegawai') }}"></i> <span>Pegawai</span></a>
                    </li>
                    <li class="{{ Request::is('kegiatan') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('kegiatan') }}"><span>Kegiatan</span></a>
                    </li>
                    <li class="{{ Request::is('jenis') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('jenis') }}"><span>Jenis SPPD</span></a>
                    </li>
                    <li class="{{ Request::is('tujuan') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('tujuan') }}"><span>Tujuan</span></a>
                    </li>
                </ul>
            </li>
            @endif
            

        </ul>
    </aside>
</div>
