<?php

use App\Http\Controllers\TicketsController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/tickets/{status}', [TicketsController::class, 'index'])
    ->where('status', 'open|closed')
    ->name('ticket.index');
Route::get('/users/{email}/tickets', [TicketsController::class, 'user'])
    ->name('ticket.user');
Route::get('/stats', [TicketsController::class, 'stats'])
    ->name('stats');
