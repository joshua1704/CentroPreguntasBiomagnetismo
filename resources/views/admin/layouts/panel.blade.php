@extends('admin.layouts.dashboard')
@section('panel')
<div class="card-header bg-light py-1 rounded mb-1 border w-100">
    @yield('header')
</div>
<table class="table table-sm border m-0">
    <thead class="table-light">
        <tr>
            <th>
                @yield('title_table')
            </th>
        </tr>
    </thead>
</table>
<div class="overflow-y-scroll height_calc">
    <table class="table table-sm border">
        <thead class="table-light sticky-top border">
            <tr>
                @yield('headers_table')
            </tr>
        </thead>
        <tbody>
            @yield('body_table')
        </tbody>
    </table>
    @yield('paginate_links')
</div>
@endsection
