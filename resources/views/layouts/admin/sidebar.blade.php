<style>
<<<<<<< HEAD
    /* SIDEBAR */
    /* SIDEBAR */
=======
>>>>>>> 31e2af5067c9108ce512f1147ceb4f359d46fc77
    .sidebar {
        position: sticky !important;
        top: 0;
        height: 100vh;
        align-self: flex-start;
        overflow-y: auto;
    }

<<<<<<< HEAD
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
=======
    .sidebar .nav-item {
        margin-bottom: 8px;
    }

    .sidebar .nav-link {
        padding: 0.85rem 1rem;
    }

>>>>>>> 31e2af5067c9108ce512f1147ceb4f359d46fc77
    .sidebar .nav-item.active .nav-link {
        background-color: #dff7e9;
        color: #10b981;
        border-radius: 4px;
    }

    .sidebar .nav-item.active .nav-link i {
        color: #10b981;
    }

    .sidebar .nav-link i {
        width: 22px;
        text-align: center;
    }

    .sidebar-brand-text {
        white-space: nowrap;
    }

    .sidebar .disabled-link {
        color: #b7b9cc !important;
        cursor: not-allowed;
    }
</style>

<ul class="navbar-nav sidebar sidebar-light accordion"
    id="accordionSidebar"
    style="background-color:white;">

    <a class="sidebar-brand d-flex align-items-center justify-content-center">
        <div class="sidebar-brand-icon">
            <i class="fas fa-fw fa-futbol" style="color:#10b981;"></i>
        </div>
        <div class="sidebar-brand-text">
            Minisoccer <span style="color:#10b981;">Book</span>
        </div>
    </a>

    <hr class="sidebar-divider my-0">

    <li class="nav-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('dashboard') }}">
            <i class="fas fa-fw fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>
<<<<<<< HEAD
    {{-- Customer --}}
=======

>>>>>>> 31e2af5067c9108ce512f1147ceb4f359d46fc77
    <li class="nav-item {{ request()->routeIs('customer.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('customer.index') }}">
            <i class="fas fa-fw fa-users"></i>
            <span>Customer Data</span>
        </a>
    </li>

    <li class="nav-item {{ request()->routeIs('booking.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('booking.index') }}">
            <i class="fas fa-fw fa-calendar-check"></i>
            <span>Booking Data</span>
        </a>
    </li>

<<<<<<< HEAD
    {{-- Schedule --}}
    <li class="nav-item {{ request()->routeIs('schedule.*') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('schedule.index') }}">
=======
    <li class="nav-item">
        <span class="nav-link disabled-link">
>>>>>>> 31e2af5067c9108ce512f1147ceb4f359d46fc77
            <i class="fas fa-fw fa-calendar-alt"></i>
            <span>Schedule Data</span>
        </span>
    </li>
<<<<<<< HEAD
=======

    <li class="nav-item">
        <span class="nav-link disabled-link">
            <i class="fas fa-fw fa-bell"></i>
            <span>Notifications</span>
        </span>
    </li>

    <li class="nav-item">
        <span class="nav-link disabled-link">
            <i class="fas fa-fw fa-cog"></i>
            <span>Settings</span>
        </span>
    </li>

>>>>>>> 31e2af5067c9108ce512f1147ceb4f359d46fc77
</ul>
