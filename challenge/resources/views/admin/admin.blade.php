@extends('admin.admin-dashboard')

@section('title', 'Administración')

@section('content')
    <div class="container">
        <div class="tabla-evento">
            <h1 class="display-4 text-primary mb-4">Bienvenido a The C.R.U.D</h1>
            <p class="lead text-muted">
                Podrás gestionar tanto los <strong class="text-info">usuarios</strong> como los <strong class="text-info">roles</strong> de tu aplicación.
            </p>
            <p class="text-dark mb-4">
                Tendrás la capacidad de <strong class="text-success">crear</strong>, <strong class="text-warning">editar</strong>, 
                <strong class="text-danger">eliminar</strong> y <strong class="text-primary">listar</strong> tanto los usuarios 
                como los roles, facilitando la administración de tu sistema.
            </p>
            <p class="text-dark">
                Además, podrás asignar distintos <strong class="text-success">roles</strong> a los usuarios.
            </p>
        </div>
    </div>
@endsection