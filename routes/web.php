<?php

use App\Http\Controllers\AddRemoveFieldController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/', [InvoiceController::class, 'index'])->name('home');
Route::get('create', [InvoiceController::class, 'create'])->name('create');
Route::post('store', [InvoiceController::class, 'store'])->name('store');
// Route::get('/', [InvoiceController::class, 'MakeInvoice']);
Route::get('/mpdf', [InvoiceController::class, 'MakeInvoice'])->name('download-invoice');
Route::get('/settings', [InvoiceController::class, 'MakeInvoice'])->name('settings');
Route::get('/details/{$invoice_id}', [InvoiceController::class, 'details'])->name('details');

// Route::get('add-remove-input-fields', [AddRemoveFieldController::class, 'index']);
// Route::post('add-remove-input-fields', [AddRemoveFieldController::class, 'store']);
