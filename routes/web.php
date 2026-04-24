<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('public.home');
})->name('home');

Route::get('/formulario/preguntas', function() {
    return view('public.formulario');
})->name('formulario_preguntas');

Route::post('/crear/pregunta', [QuestionController::class, 'store'])->name('store_question');
Route::get('/panel/respuestas', [QuestionController::class, 'publishQuestions'])->name('panel_respuestas');

Route::prefix('admin')->name('admin_')->group(function() {
    Route::get('/', function() {
        return redirect()->route('admin_login');
    });
    Route::middleware('guest')->group(function () {
        Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
        Route::post('/login', [AuthController::class, 'login'])->name('login');
    });

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware(['auth', 'force.password'])->group(function() {
        Route::get('/preguntas/{sidebar}', [QuestionController::class, 'getQuestions'])->name('get_questions');
        Route::get('/editar/pregunta/{id}/{sidebar}', [QuestionController::class, 'showEdit'])->name('edit_question');
        Route::get('/cambia/status/pregunta/{id}/{status}', [QuestionController::class, 'changeStatusQuestion'])->name('change_status_question');
        Route::get('/users', [UserController::class, 'index'])->name('users');
        Route::post('/user/store', [UserController::class, 'store'])->name('user_store');
        Route::get('/topics', [TopicController::class, 'index'])->name('topics');
        Route::post('/pregunta/modificar', [QuestionController::class, 'update'])->name('update_question');
        Route::post('/upload_image', [QuestionController::class, 'uploadImage']);
        Route::get('/change_password', [AuthController::class, 'showChangePassword'])->name('change_password');
        Route::post('/change_password', [AuthController::class, 'changePassword']);
    });
});
