<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShapeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\TaskController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::middleware(['api', 'auth:sanctum'])->group(function (){
    Route::resource('shapes', ShapeController::class);
    Route::resource('tasks', TaskController::class);
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('overview', [ShapeController::class, 'overview_data']);
});

Route::middleware('api')->group(function (){
    Route::get('shapes', [ShapeController::class, 'index']);
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::get('unauthorized', [AuthController::class, 'unauthorized'])->name('unauthorized');
});