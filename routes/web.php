<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewController;
use App\Http\Controllers\MainController;


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

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::prefix('user')->name('user.')->group(function() {
    
    Route::middleware(['guest'])->group(function() {
        Route::view('/login','dashboard.user.login')->name('login');
        Route::view('/register','dashboard.user.register')->name('register');
        Route::post('/create', [MainController::class, 'create'])->name('validateregister');
        Route::post('/check',[MainController::class, 'checkUser'])->name('check');
    });

    Route::middleware(['auth'])->group(function() {
        Route::view('/home','dashboard.user.home')->name('home');
    });
});

Route::post('/nameInput', [newController::class, 'inputName'])->name('add.name');
Route::get('/nameInput', [newController::class, 'index']);
