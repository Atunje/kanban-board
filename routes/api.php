<?php

use App\Http\Controllers\CardController;
use App\Http\Controllers\ColumnController;
use App\Http\Controllers\SqlDumpController;
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
    'create', 'show', 'edit', 'update'
]);

Route::resource('cards', CardController::class)->only([
    'store', 'update'
]);

Route::get('list-cards', [CardController::class, 'listing'])->name('cards.listing');
Route::patch('cards/{card}/shift', [CardController::class, 'shift'])->name('cards.shift');
Route::patch('cards/{card}/add-to-column', [CardController::class, 'addToColumn'])->name('cards.add_to_column');

Route::get('sql-dump', SqlDumpController::class)->name('sql.dump');


