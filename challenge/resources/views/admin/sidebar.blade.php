<div class="sidebar sidebar-dark sidebar-fixed border-end" style="width: 250px; height: 100vh;">
    <div class="content-sidebar">
        <h4 class="titulo-dashboard text-white">The Events</h4>
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
            </ul>
        </div>
    </div>
</div>
