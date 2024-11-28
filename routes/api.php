<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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


Route::prefix('tasks')->group(function () {
    // 1. Display all paginated list of tasks with filters
    Route::get('/', [TaskController::class, 'index']);

    // 2. Show a task by ID
    Route::get('/{id}', [TaskController::class, 'show']);

    // 3. Store a new task
    Route::post('/', [TaskController::class, 'store']);

    // 4. Mark a task as complete by ID
    Route::patch('/{id}/complete', [TaskController::class, 'complete']);

    // 5. Restore a soft-deleted task by ID
    Route::patch('/{id}/restore', [TaskController::class, 'restore']);
});
