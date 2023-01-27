<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::post('/register', \App\Http\Controllers\Auth\RegisterController::class);
Route::post('/login', \App\Http\Controllers\Auth\LoginController::class);
Route::post('/logout', \App\Http\Controllers\Auth\LogoutController::class);

/**
 * Маршруты для работы с ЗАДАЧАМИ
 */
Route::middleware('auth:sanctum')->group(function () {
    // Создать задачу
    Route::post('/task/create', \App\Http\Controllers\Task\CreateController::class);
// Редактировать задачу (Использовать для пометки выполнения задачи)
    Route::post('/task/update', \App\Http\Controllers\Task\UpdateController::class);
// Заменить текущую задачу на новую
    Route::post('/task/replace/{id}', \App\Http\Controllers\Task\ReplacementController::class);
// Получить задачу по ID
    Route::get('/task/get/{id}', \App\Http\Controllers\Task\GetByIDController::class);
// Получить задачи пользователя по ID
    Route::get('/task/get_user_task/{user_id}', \App\Http\Controllers\Task\GetAllUserTaskController::class);
});

