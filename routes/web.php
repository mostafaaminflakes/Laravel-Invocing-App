<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

Auth::routes();

Route::get('/', [InvoiceController::class, 'index'])->name('home');
Route::get('create', [InvoiceController::class, 'create'])->name('create');
Route::post('store', [InvoiceController::class, 'store'])->name('store');
Route::get('settings', [InvoiceController::class, 'MakeInvoice1'])->name('settings');
Route::get('details/{invoice_id}', [InvoiceController::class, 'details'])->name('details');
Route::get('export/{invoice_number}', [InvoiceController::class, 'download'])->name('download-invoice');
