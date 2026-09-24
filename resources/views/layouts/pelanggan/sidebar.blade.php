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
        color: #2563EB;
        border-radius: 3px;
    }

    .sidebar .nav-item.active .nav-link i {
        color: #2563EB;
    }

    .sidebar .nav-item.active .nav-link:hover {
        background-color: #dbe4f3;
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

    {{-- Schedule --}}
    <li class="nav-item {{ request()->routeIs('schedule.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('schedule.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Field Schedule</span>
        </a>
    </li>

    {{-- Booking --}}
    <li class="nav-item {{ request()->routeIs('booking.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('booking.index') }}">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>My Booking</span>
        </a>
    </li>

    {{-- History --}}
    <li class="nav-item {{ request()->routeIs('history.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('history.index') }}">
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>History</span>
        </a>
    </li>

    {{-- Setting --}}
    <li class="nav-item {{ request()->routeIs('setting.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('setting.index') }}">
            <i class="fas fa-fw fa-cog"></i>
            <span>Setting</span>
        </a>
    </li>
</ul>
