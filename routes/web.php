<?php

use App\Http\Controllers\ImageController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});



Route::prefix('admin')->middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/addlink', [LinkController::class, 'linkPage'])->name('addlink.index');
    Route::post('/addlink', [LinkController::class, 'linkInsert'])->name('addlink.linkinsert');
});

require __DIR__.'/auth.php';

Route::get('/share/{segment}', [ImageController::class, 'showImage'])->name('image.show');
Route::get('/all', [LinkController::class, 'allLinks'])->name('all.links');
Route::get('/referrer', [LinkController::class, 'allReferrer'])->name('all.referrer');
