@extends('layouts.app')
@section('title', 'Respuestas')
@section('content')
<div class="bg-image">
    <div class="centrado-vh">
         <div class="card w-sm-100 w-md-75 w-lg-50 mx-sm-2">
            <div class="card-body">
                <h3 class="text-center mb-3">Panel Administración</h3>
                <h4 class="text-center mb-5">Inicio de Sesion</h4>
                @error('login')
                    <div class="alert alert-danger" role="alert">{{ $message }}</div>
                @enderror
                <form method="POST" action="#">
                    @csrf

                    <div class="mb-3">
                        <label for="FormControlUser" class="form-label fw-semibold">Usuario</label>
                        <input type="text" name="username" class="form-control" id="FormControlUser" placeholder="Escribe tu usuario..." required>
                    </div>
                    <div class="mb-3">
                        <label for="FormControlName" class="form-label fw-semibold">Contraseña</label>
                        <input type="password" name="password" class="form-control" id="FormControlpassword" placeholder="Escribe tu contraseña..." required>
                    </div>
                    <div class="d-grid gap-2 col-lg-6 mx-lg-auto mt-5 mb-3">
                        <button class="btn btn-primary" type="submit">Entrar</button>
                    </div>
                </form>
            </div>
         </div>
    </div>
</div>
@endsection
