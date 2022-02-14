<?php

use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\ExportController;
use App\Http\Controllers\ZipController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes(); //['register' => false]

// Invoices
Route::get('/', [InvoiceController::class, 'index'])->name('home');
Route::get('create', [InvoiceController::class, 'create'])->name('create');
Route::post('store', [InvoiceController::class, 'store'])->name('store');
Route::get('edit/{invoice_id}', [InvoiceController::class, 'edit'])->name('edit');
Route::post('save_edit', [InvoiceController::class, 'save_edit'])->name('save_edit');
Route::get('details/{invoice_id}', [InvoiceController::class, 'details'])->name('details');
Route::get('delete/{invoice_id}', [InvoiceController::class, 'delete'])->name('delete');
Route::get('download_zip', [ZipController::class, 'create'])->name('download_zip');

// Admin restore, details and permanent delete
Route::get('admin_restore', [InvoiceController::class, 'admin_restore'])->name('admin_restore');
Route::get('admin_restore_invoice/{invoice_id}', [InvoiceController::class, 'admin_restore_invoice'])->name('admin_restore_invoice');
Route::get('admin_details/{invoice_id}', [InvoiceController::class, 'admin_details'])->name('admin_details');
Route::get('admin_delete_invoice/{invoice_id}', [InvoiceController::class, 'admin_delete_invoice'])->name('admin_delete_invoice');

// Search
Route::get('search/{term?}', [SearchController::class, 'search'])->name('search');

// Export
Route::get('export/{invoice_number}', [ExportController::class, 'download'])->name('download-invoice');

// Settings
Route::get('settings', [SettingsController::class, 'load_settings'])->name('settings');
Route::put('settings', [SettingsController::class, 'save_settings'])->name('save_settings');
Route::get('password', [SettingsController::class, 'password'])->name('password');
Route::post('change_password', [SettingsController::class, 'change_password'])->name('change_password');
