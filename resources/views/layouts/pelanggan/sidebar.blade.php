<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">
<style>
    /* SIDEBAR */
    #wrapper {
        display: flex;
    }
    #content-wrapper {
        width: 100%;
    }
    .sidebar {
        position: sticky !important;
        top: 0;
        height: 100vh;
        min-height: 100vh;
        align-self: flex-start;
        flex-shrink: 0;
        overflow-y: auto;
    }
    /* JARAK ANTAR MENU */
    .sidebar .nav-item {
        margin-bottom: 25px;
    }
    /* UKURAN TEXT MENU */
    .sidebar .nav-link {
        font-size: 16px !important;
    }
    .sidebar .nav-link span {
        font-size: 16px !important;
    }
    /* UKURAN ICON */
    .sidebar .nav-link i {
        font-size: 16px !important;
    }
    /* MENU AKTIF */
    .sidebar .nav-item.active .nav-link {
        background-color: #dff7e9;
        color: #2563EB;
        border-radius: 3px;
    }
    .sidebar .nav-item.active .nav-link i {
        color: #2563EB;
    }
    .sidebar .nav-item.active .nav-link:hover {
        background-color: #dff7e9;
        color: #2563EB;
    }
</style>
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar" style="background-color:white;">
    {{-- Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            <i class="fas fa-fw fa-futbol" style="color:#2563EB;"></i>
        </div>
        <div class="sidebar-brand-text">
            Minisoccer <span style="color:#2563EB;">Book</span>
        </div>
    </a>
    {{-- Dashboard --}}
    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
    {{-- Customer --}}
    <li class="nav-item {{ request()->routeIs('pelanggan.schedule*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pelanggan.schedule') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Schedule</span>
        </a>
    </li>
    {{-- Booking --}}
    <li class="nav-item {{ request()->routeIs('pelanggan.booking*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pelanggan.booking') }}">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Booking</span>
        </a>
    </li>
    {{-- Schedule --}}
    <li class="nav-item {{ request()->routeIs('pelanggan.history*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('pelanggan.history') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>History</span>
        </a>
    </li>
</ul>
