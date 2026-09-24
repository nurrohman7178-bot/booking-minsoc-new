<style>
    .topbar {
        position: sticky !important;
        top: 0;
        z-index: 1020;
    }
</style>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow">
    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
        <i class="fa fa-bars"></i>
    </button>

    {{-- Topbar Navbar --}}
    <ul class="navbar-nav ml-auto">
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link" href="{{ route('notification.index') }}">
                <i class="fas fa-bell fa-fw"></i>
                <span class="badge badge-danger badge-counter">3</span>
            </a>
        </li>
        {{-- User --}}
        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown">
                <span style="border-left: 1px solid #ddd; height: 25px; margin-right: 15px;"></span>
                <span class="mr-2 d-none d-lg-inline text-gray-600 medium">
                    {{ Auth::user()->name }}
                </span>
                <img class="img-profile rounded-circle" src="{{ asset('img/undraw_profile.svg') }}">
            </a>

            {{-- Dropdown --}}
            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in">

                {{-- Profile --}}
                <a class="dropdown-item" href="#">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>
                <div class="dropdown-divider"></div>

                {{-- Logout --}}
                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>
            </div>
        </li>
    </ul>
</nav>
