<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\TicketController;
use App\Models\Status;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
// CUSTOMERS ROUTES ...
Route::get('/home', [HomeController::class, 'index'])->name('home');
// Tickets Routes ... 
Route::get('tickets', [TicketController::class, 'index'])->name('tickets.index');
Route::get('tickets/create', [TicketController::class, 'create'])->name('tickets.create');
Route::post('tickets/store', [TicketController::class, 'store'])->name('tickets.store');
Route::get('tickets/show/{id}', [TicketController::class, 'show'])->name('tickets.show');
Route::post('tickets/reply/{id?}', [TicketController::class, 'customerTicketWiseReponse'])->name('tickets.reply');
// CUSTOMERS ROUTES ...
// ADMIN ROUTES ... 
Route::group(['middleware' => 'is_admin'], function() {
    Route::get('admin/dashboard', [HomeController::class, 'adminHome'])->name('admin.dashboard');
    Route::group(['prefix' => 'admin', 'namespace' => 'Admin'], function() {
        Route::get('users', [UserController::class, 'index'])->name('admin.users');
        // Tickets Routes ... 
        Route::get('tickets', [TicketController::class, 'index'])->name('admin.tickets.index');
        Route::get('tickets/create', [TicketController::class, 'adminCreateTicket'])->name('admin.tickets.create');
        Route::post('tickets/store', [TicketController::class, 'store'])->name('admin.tickets.store');
        // Update ticket closed status ...
        Route::post('tickets/update-ticket-close-status', [TicketController::class, 'updateTicketCloseStatus'])->name('admin.tickets.update-ticket-close-status');
        Route::get('tickets/show/{id?}', [TicketController::class, 'adminTicketShow'])->name('admin.tickets.show');
        Route::post('tickets/reply/{id?}', [TicketController::class, 'adminTicketWiseReponse'])->name('admin.tickets.reply');
    });

});
// ADMIN ROUTES ... 
