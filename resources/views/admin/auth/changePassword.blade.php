@extends('layouts.app')
@section('title', 'Change password')
@section('content')
<div class="bg-image">
    <div class="centrado-vh">
        <div class="card w-sm-100 w-md-75 w-lg-50 mx-sm-2">
            <div class="card-body">
                <h3 class="text-center mb-3">Cambio de contraseña</h3>
                <form method="post" action="#">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="exampleFormControlInput1" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">Confirmar Contraseña:</label>
                        <input type="password" class="form-control" id="exampleFormControlInput1" name="password_confirmation" required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm" id="btnNewPasswordFormSubmit">Guardar</button>
                    <button type="button" class="btn btn-primary btn-sm mt-3 d-none" id="btnNewPasswordFormSpinner" disabled>
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        <span role="status">Guardando...</span>
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
