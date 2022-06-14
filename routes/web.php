<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\ModuleTest1Controller;
use App\Http\Controllers\ModuleTest2Controller;
use App\Http\Controllers\ModuleTest3Controller;
use App\Http\Controllers\DashboardController;

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
    return redirect('/login');
});

Auth::routes();

Route::post('/authenticate', [LoginController::class, 'authenticate']);
Route::get('/activate-new-account/{id}', [LoginController::class, 'activateNewAccount']);

Route::group(['middleware' => ['auth']], function() {

    Route::get('/logout', [LoginController::class, 'logout']);
    Route::get('/welcome', [WelcomeController::class, 'index'])->name('welcome');
    
    //user controller
    Route::get('/users', [UserController::class, 'index'])->name('users')->middleware('module:users');;
    Route::post('/create-user', [UserController::class, 'createUser']);
    Route::post('/update-user', [UserController::class, 'updateUser']);
    Route::post('/delete-user', [UserController::class, 'deleteUser']);
    Route::post('/upload-file', [UserController::class, 'uploadFile']);
    Route::get('/save-password/{password}', [UserController::class, 'savePassword']);
    Route::get('/get-all-users', [UserController::class, 'getAllUsers']);

    //role controller
    Route::get('/roles', [RoleController::class, 'index'])->name('roles')->middleware('module:roles');
    Route::get('/get-role-modules-permissions/{id}', [RoleController::class, 'getRoleModulesAndPermissions']);
    Route::post('/update-role', [RoleController::class, 'updateRole']);

    //additional modules for testing
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/module-test-1', [ModuleTest1Controller::class, 'index'])->name('module-test-1');
    Route::get('/module-test-2', [ModuleTest2Controller::class, 'index'])->name('module-test-2');
    Route::get('/module-test-3', [ModuleTest3Controller::class, 'index'])->name('module-test-3');

});

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
