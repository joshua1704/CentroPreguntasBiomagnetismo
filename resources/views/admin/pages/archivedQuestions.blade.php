@extends('admin.layouts.panel')
@section('header')
    <form method="GET" action="{{ route('admin_get_questions', 'archived') }}" id="searchParamsForm">
        @include('admin.layouts.formFieldsQuestions')
    </form>
@endsection
@section('title_table')
    <p class="text-center mb-0">Preguntas Archivadas</p>
@endsection
@section('headers_table')
    <th scope="col">#</th>
    <th scope="col">Nombre</th>
    <th scope="col">Pregunta</th>
    <th scope="col">Respuesta</th>
    <th scope="col">Tema</th>
    <th scope="col">Fecha</th>
    <th scope="col" class="text-center">Accciones</th>
@endsection
@section('body_table')
    @foreach ($questions as $question)
        <tr>
            <th scope="row" class="align-top">{{ $question->id }}</th>
            <td class="align-top">{{ $question->name }}</td>
            <td class="align-top">{{ $question->question }}</td>
            <td class="align-top">
                <div class="ql-editor">{!! $question->answer !!}</div>
            </td>
            <td class="align-top">{{ $question->topic }}</td>
            <td class="align-top">{{ $question->created_at }}</td>
            <td class="align-top">
                <div class="d-flex justify-content-center">
                    <a href="{{ route('admin_edit_question', [ $question->id, 'archived']) }}" class="btn btn-warning btn-sm me-2" title="Editar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5z"/>
                        </svg>
                    </a>
                    <a href="{{ route('admin_change_status_question', [$question->id, 2]) }}" class="btn btn-secondary btn-sm me-2" title="Desarchivar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-up" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M3.5 6a.5.5 0 0 0-.5.5v8a.5.5 0 0 0 .5.5h9a.5.5 0 0 0 .5-.5v-8a.5.5 0 0 0-.5-.5h-2a.5.5 0 0 1 0-1h2A1.5 1.5 0 0 1 14 6.5v8a1.5 1.5 0 0 1-1.5 1.5h-9A1.5 1.5 0 0 1 2 14.5v-8A1.5 1.5 0 0 1 3.5 5h2a.5.5 0 0 1 0 1z"/>
                            <path fill-rule="evenodd" d="M7.646.146a.5.5 0 0 1 .708 0l3 3a.5.5 0 0 1-.708.708L8.5 1.707V10.5a.5.5 0 0 1-1 0V1.707L5.354 3.854a.5.5 0 1 1-.708-.708z"/>
                        </svg>
                    </a>
                    <a href="{{ route('admin_change_status_question', [$question->id, 5]) }}" class="btn btn-danger btn-sm" title="Eliminar">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                            <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5m3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0z"/>
                            <path d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4zM2.5 3h11V2h-11z"/>
                        </svg>
                    </a>
                </div>
            </td>
        </tr>
    @endforeach
@endsection
@section('paginate_links')
    {{ $questions->withQueryString()->links() }}
@endsection
