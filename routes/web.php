<?php

use App\Http\Controllers\Admin\DashBoardController;
use App\Http\Controllers\Admin\ProjectController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/', [DashBoardController::class, 'index'])->name('dashboard');
        Route::resource('project', ProjectController::class)->parameters(['project' => 'project:slug']);
    });

require __DIR__.'/auth.php';
