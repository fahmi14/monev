<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\PostController;

// di routes/api.php

Route::post('/post', [PostController::class, 'store']);