@extends('layouts.app')

@section('title', 'Preguntar')

@section('content')
<div class="bg-image">
    <div class="centrado-vh">
        <div class="card w-sm-100 w-md-75 w-lg-50 mx-sm-2">
            <div class="card-body">
                <div class="d-grid col-1 ms-auto mb-3">
                    <a href="{{ route('home') }}" class="btn btn-danger btn-sm">X</a>
                </div>
                <h1 class="card-title my-3 text-center">{{ __('ask_form.title') }}</h1>
                @if ($errors->any())
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ __('ask_form.errors_tag') }}</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                @if (session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong>{{ __('ask_form.error_tag') }}</strong> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif
                <form id="questionForm" method="POST" action="{{ route('store_question') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="FormControlName" class="form-label fw-semibold">{{ __('ask_form.label_name') }}</label>
                        <input type="text" class="form-control form-control-lg" id="FormControlname" name="name" placeholder="{{ __('ask_form.placeholder_name') }}">
                    </div>
                    <div class="mb-3">
                        <label for="FormControlQuestion" class="form-label fw-semibold">{{ __('ask_form.label_question') }}</label>
                        <textarea class="form-control form-control-lg" id="FormControlQuestion" name="question" rows="5" placeholder="{{ __('ask_form.placeholder_question') }}"></textarea>
                    </div>

                    <div class="d-grid gap-2 col-lg-6 mx-lg-auto mb-3">
                        <button class="btn btn-primary btn-lg" id="btnQuestionFormSubmit" type="submit">{{ __('ask_form.btn_send') }}</button>
                        <button class="btn btn-primary btn-lg d-none" id="btnQuestionFormSpinner" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                            <span role="status">{{ __('ask_form.btn_load') }}</span>
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
