<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\KegiatanController;
use App\Http\Controllers\DashboardController;

Route::get('/', [KegiatanController::class, 'index']);

Route::get('/kegiatan/{id}', [KegiatanController::class, 'show']);

Route::get('/download-excel/{id}', [KegiatanController::class, 'download'])
    ->name('download.excel');