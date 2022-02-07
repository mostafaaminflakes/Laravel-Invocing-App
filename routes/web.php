<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [InvoiceController::class, 'index'])->name('home');
Route::get('create', [InvoiceController::class, 'create'])->name('create');
Route::post('store', [InvoiceController::class, 'store'])->name('store');
Route::get('settings', [InvoiceController::class, 'settings'])->name('settings');
Route::put('settings', [InvoiceController::class, 'save_settings'])->name('save_settings');
Route::get('details/{invoice_id}', [InvoiceController::class, 'details'])->name('details');
Route::get('export/{invoice_number}', [InvoiceController::class, 'download'])->name('download-invoice');
// Route::get('change_locale', function () {
//     app()->setLocale('en');
//     return view('settings');
// });
