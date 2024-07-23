<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
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


Route::get('/', [App\Http\Controllers\Controller::class, 'home'])->name('home');

Route::get('/login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\UserController::class, 'userLogin'])->name('user.login');


Route::get('/roles', [App\Http\Controllers\SetupController::class, 'getRoles']);
Route::get('/users', [App\Http\Controllers\UserController::class, 'getUsers']);
Route::get('/hos', [App\Http\Controllers\SetupController::class, 'getOffices']);
Route::get('/depts', [App\Http\Controllers\SetupController::class, 'getDepts']);
Route::get('/branchs', [App\Http\Controllers\SetupController::class, 'getBranchs']);
Route::get('/annoucements', [App\Http\Controllers\AnnoucementController::class, 'getAnnoucements']);

Route::get('/role', [App\Http\Controllers\SetupController::class, 'getRole']);
Route::get('/role/{id}', [App\Http\Controllers\SetupController::class, 'getRoleById'])->name('role.edit');

Route::post('/role-new',  [App\Http\Controllers\SetupController::class, 'saveRole'])->name('role.create');
Route::put('/role/{id}', [App\Http\Controllers\SetupController::class, 'saveRole'])->name('role.update');


Route::get('/ho', [App\Http\Controllers\SetupController::class, 'getho']);
Route::get('/ho/{id}', [App\Http\Controllers\SetupController::class, 'gethoById'])->name('ho.edit');

Route::post('/ho-new',  [App\Http\Controllers\SetupController::class, 'saveho'])->name('ho.create');
Route::put('/ho/{id}', [App\Http\Controllers\SetupController::class, 'saveho'])->name('ho.update');

Route::get('/branch', [App\Http\Controllers\SetupController::class, 'getBranch']);
Route::get('/branch/{id}', [App\Http\Controllers\SetupController::class, 'getBranchById'])->name('branch.edit');

Route::post('/branch-new',  [App\Http\Controllers\SetupController::class, 'saveBranch'])->name('branch.create');
Route::put('/branch/{id}', [App\Http\Controllers\SetupController::class, 'saveBranch'])->name('branch.update');


Route::get('/dept', [App\Http\Controllers\SetupController::class, 'getDept']);
Route::get('/dept/{id}', [App\Http\Controllers\SetupController::class, 'getDeptById'])->name('dept.edit');

Route::post('/dept-new',  [App\Http\Controllers\SetupController::class, 'saveDept'])->name('dept.create');
Route::put('/dept/{id}', [App\Http\Controllers\SetupController::class, 'saveDept'])->name('dept.update');


Route::get('/user', [App\Http\Controllers\UserController::class, 'getUser']);
Route::get('/user/{id}', [App\Http\Controllers\UserController::class, 'getUserById'])->name('user.edit');

Route::post('/user-new',  [App\Http\Controllers\UserController::class, 'saveUser'])->name('user.create');
Route::put('/user/{id}', [App\Http\Controllers\UserController::class, 'saveUser'])->name('user.update');

Route::get('/annoucement', [App\Http\Controllers\AnnoucementController::class, 'getAnnoucement']);
Route::get('/annoucement/{id}', [App\Http\Controllers\AnnoucementController::class, 'getAnnoucementById'])->name('annoucement.edit');
Route::post('/annoucement-new',  [App\Http\Controllers\AnnoucementController::class, 'saveAnnoucement'])->name('annoucement.create');
Route::put('/annoucement/{id}', [App\Http\Controllers\AnnoucementController::class, 'saveAnnoucement'])->name('annoucement.update');


Route::post('api/fetch-branchs', [App\Http\Controllers\SetupController::class, 'fetchBranchs']);
Route::post('api/fetch-depts', [App\Http\Controllers\SetupController::class, 'fetchDepts']);
Route::get('api/fetch-annoucement', [App\Http\Controllers\AnnoucementController::class, 'fetchAnnoucements']);
