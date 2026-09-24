<link href="{{ asset('css/sb-admin-2.min.css') }}" rel="stylesheet">

<style>
    /* SIDEBAR */
    .sidebar {
        position: sticky !important;
        top: 0;
        height: 100vh;
        align-self: flex-start;
        overflow-y: auto;
    }

    /* MENU AKTIF */
    .sidebar .nav-item.active .nav-link {
        background-color: #dff7e9;
        color: #10b981;
        border-radius: 3px;
    }

    .sidebar .nav-item.active .nav-link i {
        color: #10b981;
    }

    .sidebar .nav-item.active .nav-link:hover {
        background-color: #dff7e9;
        color: #10b981;
    }
</style>
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar" style="background-color:white;">
    {{-- Brand --}}
    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            <i class="fas fa-fw fa-futbol" style="color:#10b981;"></i>
        </div>
        <div class="sidebar-brand-text">
            Minisoccer <span style="color:#10b981;">Book</span>
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
    <li class="nav-item {{ request()->routeIs('customer.*') ? 'active' : '' }}">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-users"></i>
            <span>Customers</span>
        </a>
    </li>

    {{-- Booking --}}
    <li class="nav-item {{ request()->routeIs('booking.*') ? 'active' : '' }}">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Booking</span>
        </a>
    </li>

    {{-- Schedule --}}
    <li class="nav-item {{ request()->routeIs('schedule.*') ? 'active' : '' }}">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Schedule</span>
        </a>
    </li>

    {{-- Setting --}}
    <li class="nav-item {{ request()->routeIs('setting.*') ? 'active' : '' }}">
        <a class="nav-link" href="">
            <i class="fas fa-fw fa-cog"></i>
            <span>Setting</span>
        </a>
    </li>
</ul>
