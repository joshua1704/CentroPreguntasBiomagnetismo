@extends('admin.layouts.panel')
@section('header')
    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#staticBackdrop">
        <span>Nuevo</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" class="bi bi-plus" viewBox="0 0 16 16">
            <path d="M8 4a.5.5 0 0 1 .5.5v3h3a.5.5 0 0 1 0 1h-3v3a.5.5 0 0 1-1 0v-3h-3a.5.5 0 0 1 0-1h3v-3A.5.5 0 0 1 8 4"/>
        </svg>
    </button>
@endsection
@section('title_table')
    <p class="text-center mb-0">Usuarios</p>
@endsection
@section('headers_table')
    <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Usuario</th>
        <th scope="col">Creación</th>
        <th scope="col" class="text-center">Accciones</th>
    </tr>
@endsection
@section('body_table')
    @foreach ($users as $user)
        <tr>
            <th scope="row" class="align-middle">{{ $user->id }}</th>
            <td class="align-middle">{{ $user->name }}</td>
            <td class="align-middle">{{ $user->username }}</td>
            <td class="align-middle">{{ $user->created_at }}</td>
            <td class="align-middle">
                <div class="d-flex justify-content-center">
                    <a href="#" class="btn btn-warning btn-sm me-2" title="Editar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
@endsection
<!-- Modal -->
<div class="modal fade" id="staticBackdrop" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin_user_store') }}">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Nuevo usuario</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    @if ($errors->any())
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <strong>Errores!</strong>
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endif
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Usuario:</label>
                        <input type="text" class="form-control" id="exampleFormControlInput1" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="exampleFormControlInput1" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Confirmar Contraseña:</label>
                        <input type="password" class="form-control" id="exampleFormControlInput1" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
@if ($errors->any())
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var modal = new bootstrap.Modal(document.getElementById('staticBackdrop'));
            modal.show();
        });
    </script>
@endif

