<?php

use App\Http\Controllers\Backend\AuthController;
use App\Http\Controllers\TenderController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Models\Permission;



/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::middleware(['auth:sanctum','role:super-admin'])->group(function () {
    Route::get('/user', [UserController::class, 'index']);
    Route::post('/user/assign-role', [UserController::class, 'assignRole']);
    Route::post('/user/assign-permission', [UserController::class, 'assignPermission']);
    Route::get('/user/permissions', [UserController::class, 'getUserPermissions']);
    
});

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('/tenders', [TenderController::class, 'index'])->middleware('permission:edit product');
    Route::get('/tenders/{id}', [TenderController::class, 'show']);
    Route::post('/tenders', [TenderController::class, 'store'])->middleware('permission:create product');
});


