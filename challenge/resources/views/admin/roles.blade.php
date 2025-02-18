@extends('admin.admin-dashboard')

@section('title', 'Administración de Roles')
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
                    <form method="GET" action="{{ route('admin.roles') }}" class="search-form d-flex">
                        <input type="text" name="search" value="{{ request('search') }}" class="form-control me-2"
                            placeholder="Buscar">
                        <button type="submit" class="btn btn-primary">Buscar</button>
                    </form>
                    <button type="button" class="btn-style btn btn-success" data-bs-toggle="modal"
                        data-bs-target="#addRoleModal">
                        <i class="fas fa-user-plus"></i> Agregar Rol
                    </button>
                </div>
                <table class="table tabla-style table-bordered table-hover shadow-lg rounded">
                    <thead>
                        <tr>
                            <th scope="col">Rol</th>
                            <th scope="col">Descripción</th>
                            <th scope="col" class="acciones">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($roles as $rol)
                            <tr>
                                <td>{{ $rol->name }}</td>
                                <td>{{ $rol->description }}</td>
                                <td>
                                    <div class="d-flex">
                                        <div class="mod-rol me-2">
                                            <button type="button" class="btn btn-warning" data-bs-toggle="modal"
                                            data-bs-target="#exampleModal" data-role-id="{{ $rol->id }}" 
                                            data-role-name="{{ $rol->name }}" data-role-description="{{ $rol->description }}">
                                            <i class="fas fa-user-shield"></i> Modificar
                                        </button>
                                        </div>

                                        <div class="delete-role">
                                            <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#deleteModal" data-role-id="{{ $rol->id }}">
                                                <i class="fas fa-trash-alt"></i> Eliminar
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Modal Modificar Rol -->
                <!-- Modal Modificar Rol -->
                <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Modificar Rol</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <!-- Formulario para modificar rol -->
                                <form id="modifyRoleForm" method="POST" action="">
                                    @csrf
                                    @method('PUT')
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nombre del Rol</label>
                                        <input type="text" id="roleName" name="name" class="form-control" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Descripción</label>
                                        <input type="text" id="roleDescription" name="description" class="form-control"
                                            required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-warning">Modificar Rol</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Modal Eliminar Rol -->
                <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="deleteModalLabel">Eliminar Rol</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                ¿Está seguro de que desea eliminar este rol? Esta acción no se puede deshacer.
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                                <form id="deleteForm" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Eliminar</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Modal Agregar Rol -->
                <div class="modal fade" id="addRoleModal" tabindex="-1" aria-labelledby="addRoleModalLabel"
                    aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addRoleModalLabel">Agregar Rol</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addRoleForm" action="{{ route('admin.storeRol') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="name" class="form-label">Nombre del Rol</label>
                                        <input type="text" id="name" name="name" class="form-control"
                                            required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="description" class="form-label">Descripción</label>
                                        <input type="text" id="description" name="description" class="form-control"
                                            required>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Cancelar</button>
                                        <button type="submit" class="btn btn-success">Agregar Rol</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-center">
                    {{ $roles->links() }}
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
   document.addEventListener("DOMContentLoaded", function() {
    // Evento cuando se muestra el modal de modificación
    document.getElementById("exampleModal").addEventListener("show.bs.modal", function(event) {
        // Obtener el rol ID desde el botón
        const roleId = event.relatedTarget.getAttribute("data-role-id");
        
        // Obtener los datos del rol (usando algún mecanismo, por ejemplo, datos ocultos o atributos de los botones)
        const roleName = event.relatedTarget.getAttribute("data-role-name");
        const roleDescription = event.relatedTarget.getAttribute("data-role-description");

        // Establecer la acción del formulario
        document.getElementById("modifyRoleForm").action = "/administracion/roles/" + roleId;
        
        // Llenar los campos del formulario con los datos actuales del rol
        document.getElementById("roleName").value = roleName;
        document.getElementById("roleDescription").value = roleDescription;
    });

    // Evento cuando se muestra el modal de eliminación
    document.getElementById("deleteModal").addEventListener("show.bs.modal", function(event) {
        document.getElementById("deleteForm").action = "/administracion/roles/" + event.relatedTarget.getAttribute("data-role-id");
    });
});

</script>
