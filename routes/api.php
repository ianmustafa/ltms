<?php

use App\Http\Controllers\TranslationController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/user', fn (Request $request) => $request->user());

    Route::apiResource('/translations', TranslationController::class);
    Route::get('/translations/export/{locale}', [TranslationController::class, 'export']);
});
