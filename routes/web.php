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
        Route::get('/home-dashboard', [AdminController::class, 'admin_CountData'])->name('home');                               //admin home-dashboard
        Route::get('/CRUDvet', [AdminController::class, 'getAllVet'])->name('vet.home');                                        //lists vets
        Route::get('/CRUDpet', [AdminController::class, 'petSearch'])->name('petsearch');                                       //lists pets
        Route::get('/CRUDpettype', [AdminController::class, 'petTypeSearch'])->name('pettypesearch');                           //lists pet types and search function
        Route::get('/CRUDpetbreed', [AdminController::class, 'breedSearch'])->name('breedsearch');                              //lists breed and search function
        Route::get('/CRUDcustomers', [AdminController::class, 'customerSearch2'])->name('custsearch');                          //lists customers and search function
        Route::get('/CRUDclinic', [AdminController::class, 'clinicSearch'])->name('clinicsearch');                              //lists clinic and search function
        Route::get('/CRUDusers', [AdminController::class, 'userSearch'])->name('usersearch');                                   //lists users, user's email, and search function
        Route::get('/CRUDpettype/Add', [AdminController::class, 'addType'])->name('addtype');                                   //view add pet type page
        Route::post('/CRUDpettype/Add/Save', [AdminController::class, 'addPetType'])->name('addpettype');                       //saves and create pet type
        Route::get('/pet/CRUDpettype/Edit/{id}',[AdminController::class,'getTypeID']);                                          //view edit type page
        Route::post('/pet/CRUDpettype/Edit/{id}/Save',[AdminController::class,'saveType']);                                     //save update function
        Route::get('/pet/CRUDpettype/Delete/{type_id}',[AdminController::class,'deleteType'])->name('deleteType');              //deletes pet type and saves
        Route::get('/pet/CRUDpetbreed/Add', [AdminController::class, 'viewAddBreed'])->name('addbreed');                        //view add breed page 
        Route::post('/pet/CRUDpetbreed/Add/Save', [AdminController::class, 'AddBreed'])->name('addbreed');                      //saves and create breed name
        Route::get('/pet/CRUDpetbreed/Edit/{breed_id}',[AdminController::class,'getBreedID']);                                  //view edit breed page
        Route::post('/pet/CRUDpetbreed/Edit/{breed_id}/Save',[AdminController::class,'saveBreed']);                             //saves and update breed name
        Route::get('/CRUDcustomers/{customer_id}',[AdminController::class, 'admin_PatientsOwnerViews'])->name('adminPetView');  //lists pet registered to customer_id
        Route::get('/pet/CRUDpetbreed/Delete/{breed_id}',[AdminController::class,'deleteBreed'])->name('breed_deleted');        //delete breed name function
        Route::get('/CRUDcustomers/Edit/{customer_id}',[AdminController::class, 'admin_veteditcustomersID']);                   //view customer update page
        Route::post('/CRUDcustomers/Edit/{customer_id}/Save',[AdminController::class, 'admin_SaveCustomers']);                  //update customer function
        Route::get('/CRUDcustomers/delete/{customer_id}/Delete',[AdminController::class, 'admin_DeleteCustomer2']);             //delete customer function
        Route::get('/CRUDclinic/register',[AdminController::class,'viewCLinic']);
        Route::post('/CRUDclinic/register/save', [AdminController::class, 'admin_AddClinicSubmit'])->name('addclinic');
        // Route::get('/CRUDclinic/vets/{clinic_id}',[AdminController::class, 'admin_viewVetDetails'])->name('clinicvet');
        Route::get('/CRUDclinic/regVet/{clinic_id}', [AdminController::class, 'admin_AddVetID'])->name('display');
        Route::post('/CRUDclinic/regVet/save', [AdminController::class, 'admin_AddVeterinarian'])->name('addveterinarian');
     
        Route::post('/logout', [AdminController:: class, 'logout'])->name('logout');                                            //logs user out
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

