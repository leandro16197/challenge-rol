<div class="sidebar sidebar-dark sidebar-fixed border-end" style="width: 250px; height: 100vh;">
    <div class="content-sidebar">
        <h4 class="titulo-dashboard text-white">C.R.U.D</h4>
        <p class=" border-bottom pb-3"></p>
        <h5 class="titulo-dashboard text-white">Dashboard</h5>
        <p class=" border-bottom pb-3"></p>
        <div class="lista-sedebar">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a class="sidebar-li-text nav-link text-white" href="/">
                        <i class="fas fa-home"></i> Inicio
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-li-text nav-link text-white" href="{{ route('admin.users') }}">
                        <i class="fas fa-users"></i> Usuarios
                    </a>
                </li>              
                <li class="nav-item">
                    <a class="sidebar-li-text nav-link text-white" href="{{ route('admin.roles') }}">
                        <i class="fas fa-users-gear"></i> Roles
                    </a>
                </li>
                <li class="nav-item">
                    <a class="sidebar-li-text nav-link text-white" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </div>
</div>
