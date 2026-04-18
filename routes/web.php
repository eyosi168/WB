<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PublicReportController;

Route::get('/', function () {
    return view('welcome');
});
// Shows the form
Route::get('/report', [PublicReportController::class, 'create'])->name('report.create');
