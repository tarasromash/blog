<?php

use App\Http\Controllers\Api\Blog\PostController;
use Illuminate\Support\Facades\Route;

Route::prefix('blog')->group(function () {
    Route::apiResource('posts', PostController::class)->names('blog.posts');
});
