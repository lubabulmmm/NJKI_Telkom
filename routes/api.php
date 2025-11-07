<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CalculatorController;
use App\Http\Controllers\ArchiveController;

Route::post('/save-archive', [ArchiveController::class, 'saveArchive']);


Route::get('/items', [CalculatorController::class, 'getItems']);
Route::get('/bandwidth/{itemId}', [CalculatorController::class, 'getBandwidth']);
Route::post('/calculate-investment-metrics', [CalculatorController::class, 'calculateInvestmentMetrics']);
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
