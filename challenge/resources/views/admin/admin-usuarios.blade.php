@extends('admin.admin-dashboard')

@section('title', 'Administración')
@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div class="tabla-listado">
            <div class="table-responsive">
                <div class="buscador mb-3 d-flex justify-content-between">
                    <form method="GET" action="{{ route('admin.users') }}" class="search-form d-flex">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2"
                            placeholder="Buscar">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                    <button type="button" class="btn-style btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#addUserModal">
                        <i class="fas fa-user-plus"></i> Agregar Usuario
                    </button>
                </div>
                <table class="table tabla-style table-bordered table-hover shadow-lg rounded">
                    <thead>
                        <tr>
                            <th scope="col">Nombre</th>
                            <th scope="col">Email</th>
                            <th scope="col">Rol</th>
                            <th scope="col" class="acciones">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($usuarios as $dato)
                            <tr>
                                <td>{{ $dato->name }}</td>
                                <td>{{ $dato->email }}</td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                        data-bs-target="#modalRoles{{ $dato->id }}">
                                        Ver/Modificar
                                    </button>
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="mod-rol me-2">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editUserModal{{ $dato->id }}">
                                                <i class="fas fa-user-shield"></i> Modificar
                                            </button>
                                        </div>
                                        <div class="mod-rol me-2">
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteUserModal{{ $dato->id }}">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    @foreach ($usuarios as $dato)
                        <!-- Modal para modificar usuario -->
                        <div class="modal fade" id="editUserModal{{ $dato->id }}" tabindex="-1"
                            aria-labelledby="editUserModalLabel{{ $dato->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="editUserModalLabel{{ $dato->id }}">Modificar
                                            Usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <form action="{{ route('admin.updateUsuario', $dato->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')

                                            <div class="mb-3">
                                                <label for="name" class="form-label">Nombre</label>
                                                <input type="text" class="form-control" id="name" name="name"
                                                    value="{{ $dato->name }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="email" class="form-label">Correo Electrónico</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $dato->email }}" required>
                                            </div>

                                            <div class="mb-3">
                                                <label for="password" class="form-label">Contraseña</label>
                                                <input type="password" class="form-control" id="password" name="password"
                                                    placeholder="Nueva contraseña (opcional)">
                                            </div>

                                            <div class="mb-3">
                                                <label for="password_confirmation" class="form-label">Confirmar
                                                    Contraseña</label>
                                                <input type="password" class="form-control" id="password_confirmation"
                                                    name="password_confirmation" placeholder="Confirma la nueva contraseña">
                                            </div>

                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Cancelar</button>
                                                <button type="submit" class="btn btn-primary">Guardar Cambios</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Modal para eliminar usuario -->
                        <div class="modal fade" id="deleteUserModal{{ $dato->id }}" tabindex="-1"
                            aria-labelledby="deleteUserModalLabel{{ $dato->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="deleteUserModalLabel{{ $dato->id }}">Eliminar
                                            Usuario</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        ¿Estás seguro de que deseas eliminar a <strong>{{ $dato->name }}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <form action="{{ route('admin.destroyUsuario', $dato->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Eliminar</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>




                        {{-- Modal Roles del Usuario --}}
                        <div class="modal fade" id="modalRoles{{ $dato->id }}" tabindex="-1"
                            aria-labelledby="modalRolesLabel{{ $dato->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="modalRolesLabel{{ $dato->id }}">Roles de
                                            {{ $dato->name }}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        {{-- Lista de roles actuales --}}
                                        <h6>Roles asignados:</h6>
                                        <ul id="roles-list-{{ $dato->id }}" class="roles-list">
                                            @foreach ($dato->roles as $role)
                                                <li id="role-{{ $dato->id }}-{{ $role->id }}">
                                                    {{ $role->name }}
                                                    <button
                                                        onclick="removeRole({{ $dato->id }}, {{ $role->id }})">❌</button>
                                                </li>
                                            @endforeach
                                        </ul>

                                        {{-- Agregar nuevos roles --}}
                                        <h6 class="mt-3">Agregar Rol:</h6>
                                        <select id="new-role-{{ $dato->id }}" class="form-select">
                                            @foreach ($roles as $role)
                                                <option value="{{ $role->id }}">{{ $role->name }}</option>
                                            @endforeach
                                        </select>
                                        <button class="btn btn-success btn-sm mt-2"
                                            onclick="addRole({{ $dato->id }})">
                                            Agregar Rol
                                        </button>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cerrar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                    {{-- Modal Agregar Usuario --}}
                    <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="addUserModalLabel">Agregar Usuario</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                        aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form id="addUserForm" action="{{ route('admin.users') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Nombre</label>
                                            <input type="text" name="name" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="email" class="form-label">Email</label>
                                            <input type="email" name="email" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password" class="form-label">Contraseña</label>
                                            <input type="password" name="password" class="form-control" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="password_confirmation" class="form-label">Confirmar
                                                Contraseña</label>
                                            <input type="password" name="password_confirmation" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="rol" class="form-label">Rol</label>
                                            <select name="role" class="form-select">
                                                <option value="" disabled selected>seleccione rol</option>
                                                @foreach ($roles as $rol)
                                                    <option value={{ $rol->id }}>{{ $rol->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Cancelar</button>
                                            <button type="submit" class="btn btn-success">Agregar Usuario</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
            <div class="d-flex justify-content-center">
                @if($totalUsuarios>5)
                {{ $usuarios->links() }}
                @endif
            </div>
        </div>$totalUsuarios
    </div>
    </div>

@endsection

<script>
    function removeRole(userId, roleId) {
        fetch(`/usuarios/${userId}/roles/${roleId}/eliminar`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    document.getElementById(`role-${userId}-${roleId}`).remove();
                }
            })
            .catch(error => console.error('Error:', error));
    }

    function addRole(userId) {
        const roleId = document.getElementById(`new-role-${userId}`).value;

        fetch(`/usuarios/${userId}/roles/agregar`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    role_id: roleId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const rolesList = document.getElementById(`roles-list-${userId}`);
                    const newRoleItem = document.createElement('li');
                    newRoleItem.id = `role-${userId}-${data.role.id}`;
                    newRoleItem.innerHTML = `${data.role.name} 
                <button class="btn btn-danger btn-sm" onclick="removeRole(${userId}, ${data.role.id})">
                    ❌
                </button>`;
                    rolesList.appendChild(newRoleItem);
                }
            })
            .catch(error => console.error('Error:', error));
    }
</script>
