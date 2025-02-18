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
                                    @foreach ($dato->roles as $role)
                                    <span>{{ $role->name }}</span>
                                    @if (!$loop->last) 
                                        ,
                                    @endif
                                @endforeach
                                </td>
                                <td>
                                    <div class="d-flex">
                                        <div class="mod-rol me-2">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                                data-bs-target="#editUserModal" data-user-id="{{ $dato->id }}"
                                                data-user-name="{{ $dato->name }}" data-user-email="{{ $dato->email }}"
                                                data-user-role="{{ implode(',', $dato->roles->pluck('id')->toArray()) }}">
                                                <i class="fas fa-user-shield"></i> Modificar
                                            </button>

                                        </div>

                                        <div class="delete-user">
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-user-id="{{ $dato->id }}">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="editUserModalLabel">Editar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="editUserForm" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="edit-name" class="form-label">Nombre</label>
                                        <input type="text" id="edit-name" name="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-email" class="form-label">Email</label>
                                        <input type="email" id="edit-email" name="email" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="edit-role" class="form-label">Roles</label>
                                        <select id="edit-role" name="roles[]" class="form-select" multiple>
                                            @foreach ($roles as $rol)
                                                <option value="{{ $rol->id }}">{{ $rol->name }}</option>
                                            @endforeach
                                        </select>
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


                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Eliminar Usuario</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ¿Está seguro de que desea eliminar este usuario? Esta acción no se puede deshacer.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary"
                                    data-bs-dismiss="modal">Cancelar</button>
                                <form id="deleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

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
                                        <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
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

                <div class="d-flex justify-content-center">
                    {{ $usuarios->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("exampleModal").addEventListener("show.bs.modal", function(event) {
            document.getElementById("confirmForm").action = "/administracion/usuarios/" + event
                .relatedTarget.getAttribute("data-user-id");
        });

        document.getElementById("deleteModal").addEventListener("show.bs.modal", function(event) {
            document.getElementById("deleteForm").action = "/administracion/usuarios/" + event
                .relatedTarget.getAttribute("data-user-id");
        });
    });
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById("editUserModal").addEventListener("show.bs.modal", function(event) {
            var button = event.relatedTarget;
            var userId = button.getAttribute("data-user-id");
            var userName = button.getAttribute("data-user-name");
            var userEmail = button.getAttribute("data-user-email");
            var userRoles = button.getAttribute("data-user-role").split(
                ",");

            document.getElementById("edit-name").value = userName;
            document.getElementById("edit-email").value = userEmail;

            // Limpiar selección anterior y marcar los roles actuales
            var roleSelect = document.getElementById("edit-role");
            for (var i = 0; i < roleSelect.options.length; i++) {
                roleSelect.options[i].selected = userRoles.includes(roleSelect.options[i].value);
            }

            document.getElementById("editUserForm").action = "/administracion/usuarios/" + userId;
        });
    });
</script>
