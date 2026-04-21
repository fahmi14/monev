<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\KegiatanController;
    
Route::get('/kegiatan/{id}', [KegiatanController::class, 'show']);