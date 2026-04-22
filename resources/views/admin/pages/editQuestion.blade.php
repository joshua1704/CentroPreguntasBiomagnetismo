@extends('admin.layouts.dashboard')
@section('panel')
    <div class="card w-100">
        <div class="card-header">
            <div class="row">
                <div class="col-8">
                    <h6>Pregunta número {{ $question->id }}</h6>
                </div>
                <div class="col-4 text-end">
                    @php
                        $route = route('admin_get_questions', 'pending');
                    @endphp
                    @switch($sidebar)
                        @case('Pending')
                            @php
                                $route = route('admin_get_questions', 'pending');
                            @endphp
                            @break
                        @case('Answered')
                            @php
                                $route = route('admin_get_questions', 'answered');
                            @endphp
                            @break
                        @case('Published')
                            @php
                                $route = route('admin_get_questions', 'published');
                            @endphp
                            @break
                        @case('Archived')
                            @php
                                $route = route('admin_get_questions', 'archived');
                            @endphp
                            @break
                        @default
                            @php
                                $route = route('admin_get_questions', 'pending');
                            @endphp
                    @endswitch
                    <a href="{{ $route }}" class="btn btn-danger btn-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
                            <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>
        <div class="card-body overflow-auto" style="height: calc(100vh - 120px);">
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
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Exitoso!</strong> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
            <form id="EditQuestionForm" method="POST" action="{{ route('admin_update_question') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" value="{{ $question->id }}" name="id">
                <div class="mb-3">
                    <label for="InputName" class="form-label fw-bold">Nombre</label>
                    <input type="text" class="form-control form-control-sm" id="ModalQPInputName" name="name" value="{{ $question->name }}">
                </div>
                <div class="mb-3">
                    <label for="InputQuestion" class="form-label fw-bold">Pregunta</label>
                    <input type="text" class="form-control form-control-sm" id="ModalQPInputQuestion" name="question" value="{{ $question->question }}">
                </div>
                <div class="mb-3">
                    <label for="InputTopic" class="form-label fw-bold" id="ModalQPInputTopic">Tema</label>
                    <select class="form-select form-select-sm" aria-label="InputTopic" name="topic_id">
                        @foreach ($topics as $topic)
                            <option value="{{ $topic->id }}" {{ $topic->id == $question->topic_id ? 'selected' : '' }}>{{ $topic->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label for="InputAnswer" class="form-label fw-bold">Respuesta</label>
                    <div id="editor" style="height: 200px;"></div>
                    <input type="hidden" name="answer" id="content" value="{{ $question->answer }}">
                </div>
                <div class="d-grid col-4 mx-auto">
                    <button type="submit" class="btn btn-primary btn-sm mt-3" id="btnEditQuestionFormSubmit">Guardar</button>
                    <button type="button" class="btn btn-primary btn-sm mt-3 d-none" id="btnEditQuestionFormSpinner" disabled>
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        <span role="status">Guardando...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
