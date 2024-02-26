<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TicketsController;

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

