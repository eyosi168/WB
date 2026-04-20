<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicReportController;
use App\Http\Controllers\StatusController;

// 1. Submit Report Routes
Route::get('/report', [PublicReportController::class, 'create'])->name('report.create');
Route::post('/report', [PublicReportController::class, 'store'])->name('report.store');
Route::get('/report/success', [PublicReportController::class, 'success'])->name('report.success');

// 2. Status Tracking Routes (We deleted the placeholder!)
Route::get('/status', [StatusController::class, 'index'])->name('report.status.index');
Route::post('/status/auth', [StatusController::class, 'authenticate'])->name('report.status.auth');
Route::get('/status/details', [StatusController::class, 'show'])->name('report.status.show');
Route::post('/status/logout', [StatusController::class, 'logout'])->name('report.status.logout');