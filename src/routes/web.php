<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\MypageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\SellController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ItemController::class, 'index']);
Route::get('/search', [ItemController::class, 'search']);
Route::get('/items/{item}', [ItemController::class, 'show']);

Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/items/{item}/likes', [LikeController::class, 'store']);
    Route::post('/items/{item}/comments', [CommentController::class, 'store']);
    Route::get('/purchase/complete', [PurchaseController::class, 'complete'])->name('purchase.complete');
    Route::get('/purchase/address/{item}', [AddressController::class, 'edit']);
    Route::put('/purchase/address/{item}', [AddressController::class, 'update']);
    Route::get('/purchase/{item}', [PurchaseController::class, 'show'])->name('purchase.show');
    Route::post('/purchase/{item}', [PurchaseController::class, 'store']);
    Route::get('/mypage', [MypageController::class, 'index']);
    Route::get('/mypage/profile', [ProfileController::class, 'edit']);
    Route::post('/mypage/profile', [ProfileController::class, 'update']);
    Route::get('/sell', [SellController::class, 'create']);
    Route::post('/sell', [SellController::class, 'store']);
});
