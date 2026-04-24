@extends('layouts.app')
@section('title', 'Repuestas')
@section('content')
<div class="bg-image">
    <div class="centrado-vh">
        <div class="card-body">
            <h3>Cambio de contraseña</h3>
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
@endsection
