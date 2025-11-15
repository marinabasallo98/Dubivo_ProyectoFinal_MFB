<?php

use App\Http\Controllers\ActorController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\WorkController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\SchoolTeacherController;
use Illuminate\Support\Facades\Route;

// Página principal
Route::get('/', function () {
    return view('welcome');
});

// Rutas públicas
Route::get('/actors', [ActorController::class, 'index'])->name('actors.index');
Route::get('/schools', [SchoolController::class, 'index'])->name('schools.index');
Route::get('/schools/{school}', [SchoolController::class, 'show'])->name('schools.show');
Route::get('/works', [WorkController::class, 'index'])->name('works.index');
Route::get('/works/{work}', [WorkController::class, 'show'])->name('works.show');

// Rutas de registro separadas
Route::get('/register/actor', [App\Http\Controllers\Auth\RegisterController::class, 'showActorRegistrationForm'])->name('register.actor');
Route::get('/register/client', [App\Http\Controllers\Auth\RegisterController::class, 'showClientRegistrationForm'])->name('register.client');
Route::post('/register/actor', [App\Http\Controllers\Auth\RegisterController::class, 'registerActor'])->name('register.actor.submit');
Route::post('/register/client', [App\Http\Controllers\Auth\RegisterController::class, 'registerClient'])->name('register.client.submit');

// Dashboard general
Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

// Rutas que requieren autenticación
Route::middleware(['auth'])->group(function () {
    // PERFIL DE ACTOR - debe ir ANTES de la ruta pública de actors.show
    Route::get('/actor/profile/create', [ActorController::class, 'create'])->name('actors.create');
    Route::post('/actor/profile', [ActorController::class, 'store'])->name('actors.store');
    Route::get('/actor/profile/{actor}/edit', [ActorController::class, 'edit'])->name('actors.edit');
    Route::put('/actor/profile/{actor}', [ActorController::class, 'update'])->name('actors.update');
    Route::delete('/actor/profile/{actor}', [ActorController::class, 'destroy'])->name('actors.destroy');

    // SOLICITUDES - CORREGIDAS
    Route::get('/requests', [RequestController::class, 'index'])->name('requests.index');
    
    // Cambiar la ruta de create para evitar conflicto
    Route::get('/contact-actor/{actor}', [RequestController::class, 'create'])->name('requests.create');
    Route::post('/contact-actor/{actor}', [RequestController::class, 'store'])->name('requests.store');
    
    Route::patch('/requests/{contactRequest}/{status}', [RequestController::class, 'updateStatus'])->name('requests.updateStatus');
    Route::delete('/requests/{contactRequest}', [RequestController::class, 'destroy'])->name('requests.destroy');

    // ADMIN ROUTES - SIN MIDDLEWARE DUPLICADO
    Route::prefix('admin')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');

        // Escuelas
        Route::get('/schools', [AdminController::class, 'schools'])->name('admin.schools');
        Route::get('/schools/create', [AdminController::class, 'createSchool'])->name('admin.schools.create');
        Route::post('/schools', [AdminController::class, 'storeSchool'])->name('admin.schools.store');
        Route::get('/schools/{school}/edit', [AdminController::class, 'editSchool'])->name('admin.schools.edit');
        Route::put('/schools/{school}', [AdminController::class, 'updateSchool'])->name('admin.schools.update');
        Route::delete('/schools/{school}', [AdminController::class, 'destroySchool'])->name('admin.schools.destroy');

        // Obras
        Route::get('/works', [AdminController::class, 'works'])->name('admin.works');
        Route::get('/works/create', [AdminController::class, 'createWork'])->name('admin.works.create');
        Route::post('/works', [AdminController::class, 'storeWork'])->name('admin.works.store');
        Route::get('/works/{work}/edit', [AdminController::class, 'editWork'])->name('admin.works.edit');
        Route::put('/works/{work}', [AdminController::class, 'updateWork'])->name('admin.works.update');
        Route::delete('/works/{work}', [AdminController::class, 'destroyWork'])->name('admin.works.destroy');

        // Actores
        Route::get('/actors', [AdminController::class, 'actors'])->name('admin.actors');
        Route::get('/actors/create', [AdminController::class, 'createActor'])->name('admin.actors.create');
        Route::post('/actors', [AdminController::class, 'storeActor'])->name('admin.actors.store');
        Route::get('/actors/{actor}/edit', [AdminController::class, 'editActor'])->name('admin.actors.edit');
        Route::put('/actors/{actor}', [AdminController::class, 'updateActor'])->name('admin.actors.update');
        Route::delete('/actors/{actor}', [AdminController::class, 'destroyActor'])->name('admin.actors.destroy');

        // Usuarios
        Route::get('/users', [AdminController::class, 'users'])->name('admin.users');
        Route::get('/users/create', [AdminController::class, 'createUser'])->name('admin.users.create');
        Route::post('/users', [AdminController::class, 'storeUser'])->name('admin.users.store');
        Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('admin.users.edit');
        Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('admin.users.update');
        Route::delete('/users/{user}', [AdminController::class, 'destroyUser'])->name('admin.users.destroy');

        // Rutas para gestión de profesores
        Route::get('/schools/{school}/teachers/create', [SchoolTeacherController::class, 'create'])->name('admin.schools.teachers.create');
        Route::post('/schools/{school}/teachers', [SchoolTeacherController::class, 'store'])->name('admin.schools.teachers.store');
        Route::get('/schools/{school}/teachers/{actor}/edit', [SchoolTeacherController::class, 'edit'])->name('admin.schools.teachers.edit');
        Route::put('/schools/{school}/teachers/{actor}', [SchoolTeacherController::class, 'update'])->name('admin.schools.teachers.update');
        Route::delete('/schools/{school}/teachers/{actor}', [SchoolTeacherController::class, 'destroy'])->name('admin.schools.teachers.destroy');
    });
});

// RUTA PÚBLICA DE ACTORES - debe ir AL FINAL para evitar conflictos
Route::get('/actors/{actor}', [ActorController::class, 'show'])->name('actors.show');

// Rutas de autenticación de Laravel
require __DIR__ . '/auth.php';