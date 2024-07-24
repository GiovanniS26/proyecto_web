<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PasswordResetController;
use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\LeadController;
use App\Http\Controllers\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('index');
;

Route::get('/gallery', function () {
    return view('pages.gallery');
})->name('gallery');

Route::get('/about', function () {
    return view('pages.about');
})->name('about');

Route::get('/info', function () {
    return view('pages.info');
})->name('info');

Route::get('/more_design', function () {
    return view('pages.more_design');
})->name('more_design');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login_create'])->name('login');
    Route::post('/login', [AuthController::class, 'login_store']);
    Route::get('/register', [AuthController::class, 'register_create'])->name('register');
    Route::post('/register', [AuthController::class, 'register_store']);

    Route::get('/password/reset', [PasswordResetController::class, 'requestReset'])->name('password_request');
    Route::post('/password/email', [PasswordResetController::class, 'sendResetLinkEmail'])->name('password_email');
    Route::get('/password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
    Route::post('/password/reset', [PasswordResetController::class, 'reset'])->name('password_update');


    Route::post('/leads', [LeadController::class, 'store'])->name('store_leads');

});

Route::middleware('auth')->group(function () {
    // App Pages
    Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');

    // Data CRUD
    Route::get('/users_page', [UserController::class, 'index'])->name('users_page');
    Route::get('/users', [UserController::class, 'index'])->name('get_users');
    Route::post('/users', [UserController::class, 'store'])->name('store_users');
    Route::post('/update_users/{id}', [UserController::class, 'update'])->name('update_users');
    Route::delete('/destroy_users/{id}', [UserController::class, 'destroy'])->name('destroy_users');

    Route::get('/roles_page', [RoleController::class, 'index'])->name('roles_page');
    Route::get('/roles', [RoleController::class, 'index'])->name('get_roles');
    Route::post('/roles', [RoleController::class, 'store'])->name('store_roles');
    Route::post('/update_roles/{id}', [RoleController::class, 'update'])->name('update_roles');
    Route::delete('/destroy_roles/{id}', [RoleController::class, 'destroy'])->name('destroy_roles');

    Route::get('/clients_page', [ClientController::class, 'index'])->name('clients_page');
    Route::get('/clients', [ClientController::class, 'index'])->name('get_clients');
    Route::post('/clients', [ClientController::class, 'store'])->name('store_clients');
    Route::post('/update_clients/{id}', [ClientController::class, 'update'])->name('update_clients');
    Route::delete('/destroy_clients/{id}', [ClientController::class, 'destroy'])->name('destroy_clients');

    Route::get('/projects_page', [ProjectController::class, 'index'])->name('projects_page');
    Route::get('/projects', [ProjectController::class, 'index'])->name('get_projects');
    Route::get('/projects/details/{id}', [ProjectController::class, 'details'])->name('project_details');
    Route::get('/projects/{id}/members', [ProjectController::class, 'members'])->name('get_project_members');
    Route::post('/projects', [ProjectController::class, 'store'])->name('store_projects');
    Route::post('/update_projects/{id}', [ProjectController::class, 'update'])->name('update_projects');
    Route::delete('/destroy_projects/{id}', [ProjectController::class, 'destroy'])->name('destroy_projects');

    Route::get('/tasks_page', [TaskController::class, 'index'])->name('tasks_page');
    Route::get('/tasks', [TaskController::class, 'index'])->name('get_tasks');
    Route::post('/project/tasks/{id}', [TaskController::class, 'store'])->name('store_tasks');
    Route::post('/update_tasks/{id}', [TaskController::class, 'update'])->name('update_tasks');
    Route::delete('/destroy_tasks/{id}', [TaskController::class, 'destroy'])->name('destroy_tasks');
    Route::patch('/tasks/{id}/complete', [TaskController::class, 'complete'])->name('tasks.complete');
    Route::post('/update_tasks/status/{id}', [TaskController::class, 'change_status'])->name('change_status_tasks');

    Route::get('/leads_page', [LeadController::class, 'index'])->name('leads_page');
    Route::get('/leads', [LeadController::class, 'index'])->name('get_leads');
    Route::post('/update_leads/{id}', [LeadController::class, 'update'])->name('update_leads');
    Route::delete('/destroy_leads/{id}', [LeadController::class, 'destroy'])->name('destroy_leads');

    Route::get('/tickets_page', [TicketController::class, 'index'])->name('tickets_page');
    Route::get('/tickets', [TicketController::class, 'index'])->name('get_tickets');
    Route::post('/tickets', [TicketController::class, 'store'])->name('store_tickets');
    Route::post('/resolve_tickets/{id}', [TicketController::class, 'resolve'])->name('resolve_tickets');
    Route::post('/close_tickets/{id}', [TicketController::class, 'close'])->name('close_tickets');
    Route::post('/update_tickets/{id}', [TicketController::class, 'update'])->name('update_tickets');
    Route::delete('/destroy_tickets/{id}', [TicketController::class, 'destroy'])->name('destroy_tickets');

    //logout
    Route::post('/logout', [AuthController::class, 'destroy'])->name('logout');
});