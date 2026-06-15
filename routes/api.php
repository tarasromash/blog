<?php

use App\Http\Controllers\Api\Blog\PostController;
use App\Http\Controllers\Api\Blog\Admin\CategoryController;
use App\Http\Controllers\Api\Blog\Admin\PostController as AdminPostController;
use App\Http\Controllers\DiggingDeeperController;
use Illuminate\Support\Facades\Route;

Route::prefix('blog')->group(function () {
    Route::apiResource('posts', PostController::class)->names('blog.posts');
});

Route::prefix('admin/blog')->group(function () {
    $methods = ['index', 'store', 'update'];

    Route::apiResource('categories', CategoryController::class)
        ->only($methods)
        ->names('blog.admin.categories');

    Route::apiResource('posts', AdminPostController::class)
        ->names('blog.admin.posts');
});

Route::prefix('digging_deeper')->group(function () {
    Route::get('process-video', [DiggingDeeperController::class, 'processVideo'])
        ->name('digging_deeper.processVideo');

    Route::get('prepare-catalog', [DiggingDeeperController::class, 'prepareCatalog'])
        ->name('digging_deeper.prepareCatalog');
});
