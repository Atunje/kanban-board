<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', function () {
    $response = ['message' => 'Welcome to '.config('app.name').' API v1.0.0', 'success' => 1];
    return response()->json($response, 200);
})->name('app.index');

Route::resource('columns', ColumnController::class)->except([
    'create', 'show', 'edit'
]);

Route::resource('cards', CardController::class)->only([
    'store', 'update'
]);

Route::get('list-cards', [CardController::class, 'listing'])->name('cards.listing');

