<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController; 
use App\Http\Controllers\BomUploadController;
use App\Http\Controllers\PurchaseIntentController;
use App\Http\Controllers\MaterialAllocationController;
use App\Http\Controllers\InventoryController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
|
*/



Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    Route::post('/bom/upload', [BomUploadController::class, 'upload'])->middleware('can:upload-bom');
    Route::get('/bom/{id}', [BomUploadController::class, 'details'])->name('bom.details')->middleware('can:view-bom');

    Route::get('/bom-line-items', [BomUploadController::class, 'index'])->middleware('can:view-bom');
    Route::get('/inventories', [InventoryController::class, 'index'])->middleware('can:view-bom');
    Route::get('/purchase-intents', [PurchaseIntentController::class, 'index'])->middleware('can:manage-purchase-intents');
    Route::get('/allocations', [MaterialAllocationController::class, 'index'])->middleware('can:view-allocations');
});




