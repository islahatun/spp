<div class="main-sidebar sidebar-style-2">
    <aside id="sidebar-wrapper">
        <div class="sidebar-brand">
            <a href="index.html">Stisla</a>
        </div>
        <div class="sidebar-brand sidebar-brand-sm">
            <a href="index.html">St</a>
        </div>
        <ul class="sidebar-menu">
            <li class="menu-header">Dashboard</li>
            <li class="nav-item dropdown {{ $type_menu === 'dashboard' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-fire"></i><span>Dashboard</span></a>
                <ul class="dropdown-menu">
                    <li class='{{ Request::is('home') ? 'active' : '' }}'>
                        <a class="nav-link"
                            href="{{ url('home') }}">General Dashboard</a>
                    </li>
                </ul>
            </li>
            <li class="menu-header">Starter</li>
            @if (Auth::user()->role != "Siswa")
            <li class="nav-item dropdown {{ $type_menu === 'Student' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"
                    data-toggle="dropdown"><i class="fas fa-columns"></i> <span>Siswa</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('students') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('students') }}">Daftar Siswa</a>
                    </li>
                </ul>
            </li>
            @endif

            <li class="nav-item dropdown {{ $type_menu === 'Pembayaran' ? 'active' : '' }}">
                <a href="#" class="nav-link has-dropdown"><i class="fas fa-th"></i> <span>Pembayaran</span></a>
                @if (Auth::user()->role =="Siswa")
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('sppStudent') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('sppStudent') }}">Spp</a>
                    </li>
                </ul>
                @else
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('spp') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('spp') }}">Spp</a>
                    </li>
                </ul>
                @endif

            </li>
            @if (Auth::user()->role != "Siswa")
            <li class="nav-item dropdown {{ $type_menu === 'Laporan' ? 'active' : '' }}">
                <a href="#"
                    class="nav-link has-dropdown"><i class="fas fa-th-large"></i>
                    <span>Laporan</span></a>
                <ul class="dropdown-menu">
                    <li class="{{ Request::is('laporan') ? 'active' : '' }}">
                        <a class="nav-link"
                            href="{{ url('laporan') }}">Laporan Pembayaran</a>
                    </li>

                </ul>
            </li>
            @endif

        </ul>
    </aside>
</div>
