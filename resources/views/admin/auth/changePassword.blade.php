@extends('layouts.app')
@section('title', 'Change password')
@section('content')
<div class="bg-image">
    <div class="centrado-vh">
        <div class="card w-sm-100 w-md-75 w-lg-50 mx-sm-2">
            <div class="card-body">
                <h3 class="text-center mb-3">{{ __('changePassword.title') }}</h3>
                <form method="post" action="{{ route('admin_change_password') }}" id="newPasswordForm">
                    @csrf
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">{{ __('changePassword.pass_tag') }}</label>
                        <input type="password" class="form-control" id="exampleFormControlInput1" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="exampleFormControlInput1" class="form-label">{{ __('changePassword.pass_conf_tag') }}</label>
                        <input type="password" class="form-control" id="exampleFormControlInput1" name="password_confirmation" required>
                    </div>
                    <div class="d-grid gap-2 col-lg-6 mx-lg-auto mt-5 mb-3">
                        <button type="submit" class="btn btn-primary btn-sm" id="btnNewPasswordFormSubmit">{{ __('changePassword.btn_submit') }}</button>
                        <button type="button" class="btn btn-primary btn-sm mt-3 d-none" id="btnNewPasswordFormSpinner" disabled>
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                            <span role="status">{{ __('changePassword.btn_spinner') }}</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</div>
@endsection
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let newPasswordForm = document.querySelector('#newPasswordForm');
        newPasswordForm.addEventListener('submit', function() {
            let btnNewPasswordFormSubmit = document.querySelector('#btnNewPasswordFormSubmit');
            let btnNewPasswordFormSpinner = document.querySelector('#btnNewPasswordFormSpinner');
            btnNewPasswordFormSubmit.classList.add('d-none');
            btnNewPasswordFormSpinner.classList.remove('d-none');
        });
    });
</script>
