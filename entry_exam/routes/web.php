<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TopController;
use App\Http\Controllers\HotelController;
use App\Http\Controllers\Admin\TopController as AdminTopController;
use App\Http\Controllers\Admin\HotelController as AdminHotelController;


    /** user screen */
Route::get('/', [TopController::class, 'index'])->name('top');
Route::get('/{prefecture_name_alpha}/hotellist', [HotelController::class, 'showList'])->name('hotelList');
Route::get('/hotel/{hotel_id}', [HotelController::class, 'showDetail'])->name('hotelDetail');

/** admin screen */
Route::get('/admin', [AdminTopController::class, 'index'])->name('adminTop');

Route::prefix('admin/hotel')->controller(AdminHotelController::class)->group(function () {
    Route::get('search', 'showSearch')->name('adminHotelSearchPage');
    Route::delete('delete/{id}', 'delete')->name('adminHotelDeleteProcess');

    Route::prefix('create')->group(function () {
        Route::get('/', 'showCreate')->name('adminHotelCreatePage');
        Route::post('/submit', 'postHotelCreateSubmit')->name('adminHotelCreateSubmit');
        Route::get('/confirm', 'showHotelCreateConfirm')->name('adminHotelCreateConfirm');
        Route::get('/confirm/back', 'adminHotelBackFromConfirm')->name('adminHotelBackFromConfirm');
        Route::post('/store', 'postHotelCreateStore')->name('adminHotelCreateStore');
    });

    Route::prefix('edit')->group(function () {
        Route::get('/{id}', 'showEdit')->name('adminHotelEditPage');
        Route::post('/submit/{id}', 'postHotelEditSubmit')->name('adminHotelEditSubmit');
        Route::get('/{id}/confirm', 'showHotelEditConfirm')->name('adminHotelEditConfirm');
        Route::get('/confirm/back', 'adminHotelBackFromEditConfirm')->name('adminHotelBackFromEditConfirm');
        Route::post('/{id}', 'postHotelEditStore')->name('adminHotelEditStore');
    });
});

//Route::post('/admin/hotel/edit', [AdminHotelController::class, 'edit'])->name('adminHotelEditProcess');
