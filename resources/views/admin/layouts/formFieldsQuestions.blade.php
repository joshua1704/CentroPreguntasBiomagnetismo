
<div class="row">
    <div class="col-lg-2 col-12 mb-3 mb-lg-0">
        <div class="d-flex d-lg-block align-items-center gap-2">
            <label class="form-label" for="inputSelectTopics">Filtrar:</label>
            <select class="form-select form-select-sm" id="inputSelectTopics" name="topic">
                <option value="">Todos</option>
                @foreach ($topics as $topic)
                    <option value="{{ $topic->id }}" {{ ($search_params['topic'] ?? '') == $topic->id ? 'selected' : '' }}>{{ $topic->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    <div class="col-12 col-lg-4 mb-3 mb-3 mb-lg-0">
        <div class="d-flex d-lg-block align-items-center gap-2">

            <label class="form-label" for="inputSelectDate">Fecha:</label>
            <select class="form-select form-select-sm {{ ($search_params['date'] ?? '') == 'custome_range' ? 'd-none' : '' }}" id="inputSelectDate" name="date">
                <option value="">Todos</option>
                <option value="today" {{ ($search_params['date'] ?? '') == 'today' ? 'selected' : '' }}>Hoy</option>
                <option value="week" {{ ($search_params['date'] ?? '') == 'week' ? 'selected' : '' }}>Una semana</option>
                <option value="month" {{ ($search_params['date'] ?? '') == 'month' ? 'selected' : '' }}>Un mes</option>
                <option value="last_month" {{ ($search_params['date'] ?? '') == 'last_month' ? 'selected' : '' }}>Mes pasado</option>
                <option value="custome_range" {{ ($search_params['date'] ?? '') == 'custome_range' ? 'selected' : '' }}>Rango personalizado</option>
            </select>
            <div id="dateRange" class="input-group {{ ($search_params['date'] ?? '') == 'custome_range' ? '' : 'd-none' }}">
                <input type="date" id="desdeDate" name="desdeDate" class="form-control form-control-sm" max="{{ date('Y-m-d') }}" value="{{ ($search_params['desdeDate'] ?? '') }}">
                <input type="date" id="hastaDate" name="hastaDate" class="form-control form-control-sm" max="{{ date('Y-m-d') }}" min="{{ $search_params['desdeDate'] ?? '' }}" value="{{ $search_params['hastaDate'] ?? '' }}">
                <button type="button" id="cancelDate" class="btn btn-danger btn-sm">X</button>
            </div>

        </div>
    </div>
    <div class="col-12 col-lg-4 mb-3 mb-lg-0">
        <div class="d-flex d-lg-block align-items-center gap-2">
            <label class="form-label" for="inputSelectDate">Búsqueda:</label>
            <input class="form-control form-control-sm" type="search" placeholder="Texto a buscar" name="search" value="{{ $search_params['search'] ?? '' }}">
        </div>
    </div>
    <div class="offset-3 col-6 offset-md-4 col-md-4 offset-lg-0 col-lg-2 mb-3 mb-lg-0 align-content-end">
        <button class="btn btn-primary btn-sm w-100" id="btnSearchParamsSubmit">Buscar</button>
        <button type="button" class="btn btn-primary btn-sm w-100 d-none" id="btnSearchParamsSpinner" disabled>
            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
            <span role="status">Buscando...</span>
        </button>
    </div>
</div>
