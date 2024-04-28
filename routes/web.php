<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ElectoralCenterController;
use App\Http\Controllers\IndividualController;
use App\Http\Controllers\TeamLeaderController;

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
    return redirect()->route('login');
});

Auth::routes(['register' => false]);

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/state', [App\Http\Controllers\HomeController::class, 'state'])->name('state');
Route::get('/import', [App\Http\Controllers\HomeController::class, 'import'])->name('import');
Route::post('/store_import', [App\Http\Controllers\HomeController::class, 'storeImport'])->name('storeImport');

// Profile Routes
Route::prefix('profile')->name('profile.')->middleware('auth')->group(function(){
    Route::get('/', [HomeController::class, 'getProfile'])->name('detail');
    Route::post('/update', [HomeController::class, 'updateProfile'])->name('update');
    Route::post('/change-password', [HomeController::class, 'changePassword'])->name('change-password');
});

// Roles
Route::resource('roles', App\Http\Controllers\RolesController::class);

// Permissions
Route::resource('permissions', App\Http\Controllers\PermissionsController::class);

// Users
Route::middleware('auth')->prefix('users')->name('users.')->group(function(){
    Route::get('/', [UserController::class, 'index'])->name('index');
    Route::get('/show/{user}', [UserController::class, 'show'])->name('show');

    Route::get('/create', [UserController::class, 'create'])->name('create');
    Route::post('/store', [UserController::class, 'store'])->name('store');
    Route::get('/edit/{user}', [UserController::class, 'edit'])->name('edit');
    Route::put('/update/{user}', [UserController::class, 'update'])->name('update');
    Route::delete('/delete/{user}', [UserController::class, 'delete'])->name('destroy');
    Route::get('/update/status/{user_id}/{status}', [UserController::class, 'updateStatus'])->name('status');


    // Route::get('/import-users', [UserController::class, 'importUsers'])->name('import');
    // Route::post('/upload-users', [UserController::class, 'uploadUsers'])->name('upload');

    // Route::get('export/', [UserController::class, 'export'])->name('export');

});

// TeamLeaders
Route::middleware('auth')->prefix('teamLeaders')->name('teamLeaders.')->group(function(){
    Route::get('/', [TeamLeaderController::class, 'index'])->name('index');
    Route::get('/create', [TeamLeaderController::class, 'create'])->name('create');
    Route::post('/store', [TeamLeaderController::class, 'store'])->name('store');
    Route::get('/edit/{teamLeader}', [TeamLeaderController::class, 'edit'])->name('edit');
    Route::get('/show/{teamLeader}', [TeamLeaderController::class, 'show'])->name('show');
    Route::put('/update/{teamLeader}', [TeamLeaderController::class, 'update'])->name('update');
    Route::delete('/delete/{teamLeader}', [TeamLeaderController::class, 'delete'])->name('destroy');

    Route::get('/search', [TeamLeaderController::class, 'search'])->name('search');

});

Route::middleware('auth')->prefix('electoralCenters')->name('electoralCenters.')->group(function () {
    Route::get('/', [ElectoralCenterController::class, 'index'])->name('index');
    Route::get('/create', [ElectoralCenterController::class, 'create'])->name('create');
    Route::post('/store', [ElectoralCenterController::class, 'store'])->name('store');
    Route::get('/edit/{electoralCenter}', [ElectoralCenterController::class, 'edit'])->name('edit');
    Route::get('/show/{electoralCenter}', [ElectoralCenterController::class, 'show'])->name('show');
    Route::put('/update/{electoralCenter}', [ElectoralCenterController::class, 'update'])->name('update');
    Route::delete('/delete/{electoralCenter}', [ElectoralCenterController::class, 'delete'])->name('destroy');

    Route::get('/get', [ElectoralCenterController::class, 'get'])->name('get');

});

Route::middleware('auth')->prefix('individuals')->name('individuals.')->group(function () {
    Route::get('/', [IndividualController::class, 'index'])->name('index');
    Route::get('/create', [IndividualController::class, 'create'])->name('create');
    Route::post('/store', [IndividualController::class, 'store'])->name('store');
    Route::get('/edit/{individual}', [IndividualController::class, 'edit'])->name('edit');
    Route::get('/show/{individual}', [IndividualController::class, 'show'])->name('show');
    Route::put('/update/{individual}', [IndividualController::class, 'update'])->name('update');
    Route::delete('/delete/{individual}', [IndividualController::class, 'delete'])->name('destroy');

    Route::post('/check-i-no', [IndividualController::class, 'checkINO'])->name('checkINO');

    Route::get('/search', [IndividualController::class, 'search'])->name('search');

});
