<style>
    .topbar {
        position: sticky !important;
        top: 0;
        z-index: 1020;
    }

    .topbar .nav-link {
        color: #5a5c69;
    }

    .topbar .nav-link:hover {
        color: #10b981;
    }
</style>

<nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 shadow-sm">

    <button id="sidebarToggleTop"
            class="btn btn-link d-md-none rounded-circle mr-3"
            type="button">
        <i class="fa fa-bars"></i>
    </button>
    <ul class="navbar-nav ml-auto">

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link" href="#" title="Notifikasi">
                <i class="fas fa-bell fa-fw"></i>
            </a>
        </li>

        <li class="topbar-divider d-none d-sm-block"></li>

        <li class="nav-item dropdown no-arrow">
            <a class="nav-link dropdown-toggle"
               href="#"
               id="userDropdown"
               role="button"
               data-toggle="dropdown"
               aria-haspopup="true"
               aria-expanded="false">

                <span class="mr-2 d-none d-lg-inline text-gray-600 font-weight-bold">
                    {{ Auth::user()->name }}
                </span>

                <img class="img-profile rounded-circle"
                     src="{{ asset('img/undraw_profile.svg') }}"
                     alt="Profile">

            </a>

            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                 aria-labelledby="userDropdown">

                <div class="dropdown-header">
                    <strong>{{ Auth::user()->name }}</strong>
                    <div class="small text-muted">{{ Auth::user()->email }}</div>
                </div>

                {{-- Profile --}}
                <a class="dropdown-item" href="{{ route('profil') }}">
                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                    Profile
                </a>

                <div class="dropdown-divider"></div>

                <a class="dropdown-item"
                   href="#"
                   data-toggle="modal"
                   data-target="#logoutModal">
                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                    Logout
                </a>

            </div>
        </li>

    </ul>
</nav>
