<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EventController;
use App\Http\Controllers\TicketController;
use App\Models\Ticket;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {

    return view('welcome');
});

Route::get('/event/create', function () {
    $tickets = Ticket::all();
    return view('event.create')->with(compact('tickets'));
})->name('create.event');

Route::post('/store', [EventController::class, 'store'])->name('event.store');
Route::resource('ticket', TicketController::class);
