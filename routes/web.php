<?php
require __DIR__.'/auth.php';

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\BomUploadController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PurchaseIntentController;
use App\Http\Controllers\MaterialAllocationController;


use Illuminate\Support\Facades\Route;
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('home'); 
    }
    return redirect()->route('login');
});
Route::group(['middleware' => 'guest'], function () {

  Route::get('/login', [AuthController::class, 'login'])->name('login');
  Route::post('/login', [AuthController::class, 'loginPost'])->name('loginPost');
});
Route::group(['middleware' => 'auth'], function () {
Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::get('/upload', [BomUploadController::class, 'uploadForm'])->name('bom.upload');
Route::post('/upload', [BomUploadController::class, 'upload'])->name('bom.upload.save');
Route::get('/bom-line-items', [BomUploadController::class, 'index'])->name('bom_line_items.index');
Route::get('/inventories', [InventoryController::class, 'index'])->name('inventories.index');
Route::get('/purchase-intents', [PurchaseIntentController::class, 'index'])->name('purchase_intents.index');
Route::get('/material-allocations', [MaterialAllocationController::class, 'index'])->name('material_allocations.index');
});