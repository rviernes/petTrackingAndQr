<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Request;
use App\Http\Controllers\NewController;
use App\Http\Controllers\MainController;
use App\Http\Controllers\Customercontroller;
use App\Http\Controllers\AdminController;


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
//FOR CUSTOMER
Route::prefix('user')->name('user.')->group(function() {
    
    Route::middleware(['guest','PreventBackHistory'])->group(function() {
        Route::view('/login','dashboard.user.login')->name('login');
        Route::post('/check',[MainController::class, 'checkUser'])->name('check');
        Route::view('/register','dashboard.user.register')->name('register');
        Route::post('/create', [MainController::class, 'create'])->name('validateregister');
        // Route::get('/home', [Customercontroller::class, 'widgetPets']);
    });

    Route::middleware(['auth','PreventBackHistory'])->group(function() {
        Route::get('/home-dashboard', [Customercontroller::class, 'widgetPets'])->name('home');
        Route::get('/custProfile', [Customercontroller::class, 'userProfile'])->name('custhome');
        Route::post('/logout', [MainController:: class, 'logout'])->name('logout');
    });
});


//FOR ADMIN
Route::prefix('admin')->name('admin.')->group(function() {
    
    Route::middleware(['guest:admin','PreventBackHistory'])->group(function() {
        Route::view('/login','dashboard.admin.login')->name('login');
        Route::post('/check', [AdminController::class,'checkAdmin'])->name('check');
    });

    Route::middleware(['auth:admin','PreventBackHistory'])->group(function() {
        Route::get('/home-dashboard', [AdminController::class, 'admin_CountData'])->name('home');
        Route::get('/CRUDvet', [AdminController::class, 'getAllVet'])->name('vet.home');
        Route::get('/CRUDpet', [AdminController::class, 'petSearch'])->name('petsearch');
        Route::get('/CRUDpettype', [AdminController::class, 'petTypeSearch'])->name('pettypesearch');
        Route::get('/CRUDpetbreed', [AdminController::class, 'breedSearch'])->name('breedsearch');
        Route::get('/CRUDcustomers', [AdminController::class, 'customerSearch2'])->name('custsearch');
        Route::get('/CRUDclinic', [AdminController::class, 'clinicSearch'])->name('clinicsearch');
        Route::get('/CRUDusers', [AdminController::class, 'userSearch'])->name('usersearch');

        Route::get('pet/CRUDaddtype',function() { 
            return view('pet/CRUDaddtype'); 
        });
        
        Route::post('pet/CRUDaddtype', [AdminController::class, 'addType'])->name('addType');

        // Route::get('/CRUDpettype/Create', [AdminController::class, 'addType'])->name('addtype');
        Route::post('/logout', [AdminController:: class, 'logout'])->name('logout');
    });
});

// Route::prefix('admin')->name('admin.')->group(function() {

//     Route::middleware(['guest:admin'])->group(function() {
//         Route::view('/login','dashboard.admin.login')->name('login');
//         Route::
//     });

//     Route::middleware(['auth:admin'])->group(function() {
//         Route::get('/home-dashboard', 'dashboard.admin.home')->name('home');
//     });

// });

