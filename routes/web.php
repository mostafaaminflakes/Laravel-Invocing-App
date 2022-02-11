<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

// Invoices
Route::get('/', [InvoiceController::class, 'index'])->name('home');
Route::get('create', [InvoiceController::class, 'create'])->name('create');
Route::post('store', [InvoiceController::class, 'store'])->name('store');
Route::get('details/{invoice_id}', [InvoiceController::class, 'details'])->name('details');
Route::get('delete/{invoice_id}', [InvoiceController::class, 'delete'])->name('delete');
// Search
Route::get('search/{term?}', [SearchController::class, 'search'])->name('search');
// Export
Route::get('export/{invoice_number}', [ExportController::class, 'download'])->name('download-invoice');
// Settings
Route::get('settings', [SettingsController::class, 'load_settings'])->name('settings');
Route::put('settings', [SettingsController::class, 'save_settings'])->name('save_settings');
Route::get('password', [SettingsController::class, 'password'])->name('password');
Route::post('change_password', [SettingsController::class, 'change_password'])->name('change_password');
