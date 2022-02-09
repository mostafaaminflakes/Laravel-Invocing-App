<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [InvoiceController::class, 'index'])->name('home');
Route::get('create', [InvoiceController::class, 'create'])->name('create');
Route::post('store', [InvoiceController::class, 'store'])->name('store');
Route::get('details/{invoice_id}', [InvoiceController::class, 'details'])->name('details');
// Search
Route::post('search/{term?}', [SearchController::class, 'search'])->name('search');
// Export
Route::get('export/{invoice_number}', [ExportController::class, 'download'])->name('download-invoice');
// Settings
Route::get('settings', [SettingsController::class, 'load_settings'])->name('settings');
Route::put('settings', [SettingsController::class, 'save_settings'])->name('save_settings');

// Route::get('change_locale', function () {
//     app()->setLocale('en');
//     return view('settings');
// });
