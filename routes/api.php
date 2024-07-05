<?php

use App\Http\Controllers\Api\V1\TaskController;
use Illuminate\Support\Facades\Route;

Route::group([
    'prefix' => 'v1',
    'namespace' => 'App\Http\Controllers\Api\V1',
], function () {
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index']);

        Route::post('/', [TaskController::class, 'store']);

        Route::get('/{task}', [TaskController::class, 'show']);

        Route::put('/{task}', [TaskController::class, 'update']);

        Route::delete('/{task}', [TaskController::class, 'destroy']);
    });
});
