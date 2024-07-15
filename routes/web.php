<?php

use App\Http\Controllers\PagesController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProjectController;
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

Route::get('/more_design', function () {
    return view('pages.more_design');
})->name('more_design');



Route::middleware('guest')->group(function () {
    Route::get('/login', [UserController::class, 'login_create'])->name('login');
    Route::post('/login', [UserController::class, 'login_store']);
    Route::get('/register', [UserController::class, 'register_create'])->name('register');
    Route::post('/register', [UserController::class, 'register_store']);
});

Route::middleware('auth')->group(function () {
    // App Pages
    Route::get('/dashboard', [PagesController::class, 'dashboard'])->name('dashboard');

    // Data CRUD
    Route::get('/users_page', [UserController::class, 'users'])->name('users_page');
    Route::get('/users', [UserController::class, 'get_users']);
    Route::post('/users', [UserController::class, 'register_store']);
    Route::post('/update_users/{id}', [UserController::class, 'update_users']);
    Route::post('/destroy_users/{id}', [UserController::class, 'destroy_users']);

    Route::get('/roles', [UserController::class, 'get_roles']);
    Route::post('/roles', [UserController::class, 'create_roles']);
    Route::post('/update_roles/{id}', [UserController::class, 'update_roles']);
    Route::post('/destroy_roles/{id}', [UserController::class, 'destroy_roles']);

    Route::get('/clients_page', [ClientController::class, 'index'])->name('clients_page');
    Route::get('/clients', [ClientController::class, 'index'])->name('get_clients');
    Route::post('/clients', [ClientController::class, 'store'])->name('store_clients');
    Route::post('/update_clients/{id}', [ClientController::class, 'update'])->name('update_clients');
    Route::delete('/destroy_clients/{id}', [ClientController::class, 'destroy'])->name('destroy_clients');

    Route::get('/projects_page', [ProjectController::class, 'index'])->name('projects_page');
    Route::get('/projects', [ProjectController::class, 'index'])->name('get_projects');
    Route::get('/projects/{id}/members', [ProjectController::class, 'members'])->name('get_project_members');
    Route::post('/projects', [ProjectController::class, 'store'])->name('store_projects');
    Route::post('/update_projects/{id}', [ProjectController::class, 'update'])->name('update_projects');
    Route::delete('/destroy_projects/{id}', [ProjectController::class, 'destroy'])->name('destroy_projects');

    Route::get('/leads_page', [LeadController::class, 'leads'])->name('leads_page');
    Route::get('/leads', [LeadController::class, 'index'])->name('get_leads');
    Route::post('/leads', [LeadController::class, 'store'])->name('store_leads');
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
    Route::post('/logout', [UserController::class, 'destroy'])->name('logout');
});