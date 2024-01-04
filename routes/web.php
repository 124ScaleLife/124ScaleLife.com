<?php

use App\Http\Controllers\Auth\ProviderController;
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

// Make sure that only guests can access the welcome page route
Route::get('/', function () {
    return view('welcome');
})->middleware('guest')->name("welcome");

Route::get('/auth/{provider}/redirect', [ProviderController::class, 'redirect']);

Route::get('auth/{provider}/callback', [ProviderController::class, 'callback']);

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
