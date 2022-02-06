<?php

use App\Http\Controllers\AddRemoveFieldController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\HomeController;
use Facade\FlareClient\Http\Response;
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
// Route::get('/mpdf', [InvoiceController::class, 'MakeInvoice'])->name('download-invoice');
Route::get('settings', [InvoiceController::class, 'MakeInvoice1'])->name('settings');
Route::get('details/{invoice_id}', [InvoiceController::class, 'details'])->name('details');
// Route::get('export/{invoice_number}', [InvoiceController::class, 'make_invoice'])->name('download-invoice');
// Route::get('export/{invoice_number}', [InvoiceController::class, 'download_invoice'])->name('download-invoice');
Route::get('export/{invoice_number1}', function ($invoice_number) {
    // $fileName = storage_path(public_path('invoices/' . $invoice_number . '.pdf'));
    // $fileName = public_path('storage/invoices/' . $invoice_number . '.pdf');
    // dd($fileName);
    // $fileName = storage_path(public_path('invoices/' . $invoice_number . '.pdf'));
    // return Storage::disk('invoices')->download($fileName);
    // return response()->download($fileName);

    // return Storage::disk('invoices')->url('EFC00' . $invoice_number . '.pdf');
    // $fileName = 'http://127.0.0.1:8000/public/storage/invoices/EFC00' . $invoice_number . '.pdf';
    $file_name = $invoice_number . '.pdf';

    //return Storage::download($fileName);

    $file = Storage::disk('invoices')->get($file_name);
    return (new Response($file, 200, ''))->header('Content-Type', 'application/pdf');
})->name('download-invoice');
