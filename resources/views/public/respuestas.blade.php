@extends('layouts.app')

@section('title', 'Respuestas')

@section('content')
<div class="bg-image">
    <div class="container w-sm-100 w-md-100 w-lg-75 pt-3">
        <div class="card">
            <div class="card-header">
                <form method="GET" action="{{ route('panel_respuestas') }}">
                    <div class="row">
                        <div class="col-10 offset-1 mb-1">
                            <h5 class="text-center">{{ __('answers.title') }}</h5>
                        </div>
                        <div class="col-1">
                            <a href="{{ route('home') }}" class="btn btn-danger btn-sm">X</a>
                        </div>
                        <div class="col-10 col-md-6 offset-md-2 mb-1">
                            <input type="search" class="form-control form-control-sm" name="search" value="{{ $search }}" placeholder="Nombre o pregunta a buscar...">
                        </div>
                        <div class="col-2 col-md-2 mb-1">
                            <button type="submit" class="btn btn-primary btn-sm w-100">
                                <span class="d-none d-md-inline-block">{{ __('answers.btn_search') }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                                    <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001q.044.06.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1 1 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="card-body overflow-auto" style="height: calc(100vh - 110px);">
                <ul class="list-group list-group-flush">
                    @foreach($questions as $question)
                        <li class="list-group-item">
                            <div class="d-flex w-100 justify-content-between">
                                <h5 class="mb-1"><b>{{ $question->id }}.</b> {{ $question->name }}</h5>
                                <small class="text-body-secondary">{{ \Carbon\Carbon::parse($question->created_at)->locale(app()->getLocale())->diffForHumans() }}</small>
                            </div>
                            <p class="mb-1">
                                <b>{{ __('answers.question_tag') }}</b> {{ $question->question }}
                            </p>
                            <p class="mb-1 text-primary">
                                <b>{{ __('answers.answer_tag') }}</b>
                                <div class="ql-editor">{!! $question->answer !!}</div>
                            </p>
                        </li>
                    @endforeach
                </ul>
                {{ $questions->withQueryString()->links() }}
            </div>
        </div>
    </div>
</div>

@endsection
