@extends('layouts.app')

@section('title', 'Inicio')

@section('content')
<div class="bg-image">
    <div class="centrado-vh">
        <div class="container w-sm-100 w-md-75 w-lg-50">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>{{ __('home.success_tag') }}</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <h1 class="text-center">{{ __('home.title_top') }}<br>{{ __('home.title_bottom') }}</h1>
            <div class="buttons-home">
                <a href="{{ route('formulario_preguntas') }}" class="btn-home">{{ __('home.btn_ask_question') }}</a>
                <a href="{{ route('panel_respuestas') }}" class="btn-home">{{ __('home.btn_view_questions') }}</a>
            </div>
        </div>
    </div>
</div>
@endsection
