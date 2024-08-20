<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers;
use App\Http\Controllers\StockController;

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


Route::get('/', [App\Http\Controllers\HomeController::class, 'home'])->name('home');

Route::get('/login', [App\Http\Controllers\UserController::class, 'login'])->name('login');
Route::post('/login', [App\Http\Controllers\UserController::class, 'userLogin'])->name('user.login');
Route::get('/inventory-dashboard', [App\Http\Controllers\HomeController::class, 'inventoryData']);
Route::get('/salses-dashboard', [App\Http\Controllers\HomeController::class, 'salesData']);
Route::get('/data-collection', [App\Http\Controllers\HomeController::class, 'dataCollection']);


Route::get('/roles', [App\Http\Controllers\SetupController::class, 'getRoles']);
Route::get('/users', [App\Http\Controllers\UserController::class, 'getUsers']);
Route::get('/hos', [App\Http\Controllers\SetupController::class, 'getOffices']);
Route::get('/depts', [App\Http\Controllers\SetupController::class, 'getDepts']);
Route::get('/branchs', [App\Http\Controllers\SetupController::class, 'getBranchs']);
Route::get('/annoucements', [App\Http\Controllers\AnnoucementController::class, 'getAnnoucements']);
Route::get('/categories', [App\Http\Controllers\ProductController::class, 'getCategories']);
Route::get('/productlist', [App\Http\Controllers\ProductController::class, 'getProducts']);
Route::get('/units', [App\Http\Controllers\ProductController::class, 'getUnits']);
Route::get('/tasks', [App\Http\Controllers\TaskController::class, 'getTasks']);
Route::get('/customers', [App\Http\Controllers\CustomerController::class, 'getCustomers']);
Route::get('/discounts', [App\Http\Controllers\StockController::class, 'getDiscounts']);
Route::get('/pos', [App\Http\Controllers\StockController::class, 'pos']);
Route::get('/pos/{id}', [App\Http\Controllers\StockController::class, 'posSellingType']);
Route::get('/meeting-minutes', [App\Http\Controllers\SetupController::class, 'getMeetingMinutes']);
Route::get('/personal-source', [App\Http\Controllers\DataCollectionController::class, 'getPersons']);

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
Route::get('/annoucement/{id}/status', [App\Http\Controllers\AnnoucementController::class, 'updateAnnoucementStatus'])->name('annoucement.status');

Route::get('/category', [App\Http\Controllers\ProductController::class, 'getCategory']);
Route::get('/category/{id}', [App\Http\Controllers\ProductController::class, 'getCategoryById'])->name('category.edit');
Route::post('/category-new',  [App\Http\Controllers\ProductController::class, 'saveCategory'])->name('category.create');
Route::put('/category/{id}', [App\Http\Controllers\ProductController::class, 'saveCategory'])->name('category.update');

Route::get('/person-info', [App\Http\Controllers\DataCollectionController::class, 'getPerson']);
Route::get('/person-edit/{id}', [App\Http\Controllers\DataCollectionController::class, 'getPersonById'])->name('person.edit');
Route::post('/person-info-new',  [App\Http\Controllers\DataCollectionController::class, 'savePerson'])->name('person.create');
Route::put('/person-info/{id}', [App\Http\Controllers\DataCollectionController::class, 'savePerson'])->name('person.update');

Route::get('/unit', [App\Http\Controllers\ProductController::class, 'getUnit']);
Route::get('/unit/{id}', [App\Http\Controllers\ProductController::class, 'getUnitById'])->name('unit.edit');
Route::post('/unit-new',  [App\Http\Controllers\ProductController::class, 'saveUnit'])->name('unit.create');
Route::put('/unit/{id}', [App\Http\Controllers\ProductController::class, 'saveUnit'])->name('unit.update');

Route::get('/customer', [App\Http\Controllers\CustomerController::class, 'getCustomer']);
Route::get('/customer/{id}', [App\Http\Controllers\CustomerController::class, 'getCustomerById'])->name('customer.edit');
Route::post('/customer-new',  [App\Http\Controllers\CustomerController::class, 'saveCustomer'])->name('customer.create');
Route::put('/customer/{id}', [App\Http\Controllers\CustomerController::class, 'saveCustomer'])->name('customer.update');
Route::get('/customer/{id}/status', [App\Http\Controllers\CustomerController::class, 'updateCustomerStatus'])->name('customer.status');

Route::get('/discount', [App\Http\Controllers\StockController::class, 'getDiscount']);
Route::get('/discount/{id}', [App\Http\Controllers\StockController::class, 'getDiscountById'])->name('discount.edit');
Route::post('/discount-new',  [App\Http\Controllers\StockController::class, 'saveDiscount'])->name('discount.create');
Route::put('/discount/{id}', [App\Http\Controllers\StockController::class, 'saveDiscount'])->name('discount.update');
Route::get('/discount/{id}/status', [App\Http\Controllers\StockController::class, 'updateDiscountStatus'])->name('discount.status');

Route::get('/product', [App\Http\Controllers\ProductController::class, 'getProduct']);
Route::get('/product/{id}', [App\Http\Controllers\ProductController::class, 'getProductById'])->name('product.edit');
Route::post('/product-new',  [App\Http\Controllers\ProductController::class, 'saveProduct'])->name('product.create');
Route::put('/product/{id}', [App\Http\Controllers\ProductController::class, 'saveProduct'])->name('product.update');

Route::get('/product-images/{id}',  [App\Http\Controllers\ProductController::class, 'showProductImages'])->name('images.show');
Route::get('product-image/{productImageId}/delete', [App\Http\Controllers\ProductController::class, 'destroy']);
Route::post('products/{productId}/upload', [App\Http\Controllers\ProductController::class, 'imageStore']);

Route::get('/stocks', [App\Http\Controllers\StockController::class, 'getStocks']);
Route::put('/stocks/{id}', [App\Http\Controllers\StockController::class, 'updateStocks'])->name('stock.update');

Route::get('/meeting-minute', [App\Http\Controllers\SetupController::class, 'getMeetingMinute']);
Route::get('/meeting-minute/{id}', [App\Http\Controllers\SetupController::class, 'getMeetingMinuteById'])->name('minute.edit');
Route::post('/meeting-minute-new',  [App\Http\Controllers\SetupController::class, 'saveMeetingMinute'])->name('minute.create');
Route::put('/meeting-minute/{id}', [App\Http\Controllers\SetupController::class, 'saveMeetingMinute'])->name('minute.update');

Route::get('cart', [StockController::class, 'showCartTable']);
Route::get('add-to-cart/{id}/{sid}/{pid}', [StockController::class, 'addToCart']);
Route::get('minus-to-cart/{id}', [StockController::class, 'minusToCart']);
Route::get('custom-to-cart/{id}/{q}', [StockController::class, 'customToCart']);

Route::post('sale', [App\Http\Controllers\StockController::class, 'saleProduct'])->name('sale.create');

Route::delete('remove-from-cart', [StockController::class, 'removeCartItem']);
Route::get('clear-cart', [StockController::class, 'clearCart']);


Route::get('/task', [App\Http\Controllers\TaskController::class, 'getTask']);
Route::get('/task/{id}', [App\Http\Controllers\TaskController::class, 'getTaskById'])->name('task.edit');
Route::post('/task-new',  [App\Http\Controllers\TaskController::class, 'saveTask'])->name('task.create');
Route::put('/task/{id}', [App\Http\Controllers\TaskController::class, 'saveTask'])->name('task.update');

Route::post('/task-detail-create', [App\Http\Controllers\TaskController::class, 'saveTaskDetail'])->name('task_detail.create');

Route::get('/task-detail/{id}', [App\Http\Controllers\TaskController::class, 'getTaskDetailById'])->name('task_detail.edit');
Route::put('/task-detail/{id}/update', [App\Http\Controllers\TaskController::class, 'updateTaskDetail'])->name('task_detail.update');
Route::post('/task-detail/{id}/status', [App\Http\Controllers\TaskController::class, 'updateStatusTaskDetail'])->name('task_detail.status.update');
Route::post('/task/{taskId}/upload', [App\Http\Controllers\TaskController::class, 'attachmentStore']);
Route::get('/task-file/{fileId}/delete', [App\Http\Controllers\TaskController::class, 'destroy']);

Route::get('/task-detail/{id}/delete', [App\Http\Controllers\TaskController::class, 'deleteTask'])->name('task_detail.delete');

Route::post('api/fetch-branchs', [App\Http\Controllers\SetupController::class, 'fetchBranchs']);
Route::post('api/fetch-depts', [App\Http\Controllers\SetupController::class, 'fetchDepts']);
Route::get('api/fetch-annoucement', [App\Http\Controllers\AnnoucementController::class, 'fetchAnnoucements']);
Route::get('api/fetch-users/{deptId}', [App\Http\Controllers\TaskController::class, 'fetchUsers']);

Route::post('api/fetch-states', [App\Http\Controllers\DataCollectionController::class, 'fetchStates']);
Route::post('api/fetch-cities  ', [App\Http\Controllers\DataCollectionController::class, 'fetchcities']);


Route::get('/download/{fid}', [App\Http\Controllers\Controller::class, 'download'])->name('download');

