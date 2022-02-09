<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Classes\PDFInvoiceOverride;
// use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Classes\Party;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\Invoices\Classes\InvoiceItem;
// use LaravelDaily\Invoices\Invoice;

class ExportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function download($invoice_number)
    {
        $file_name = $invoice_number . '.pdf';
        if (Storage::disk('invoices')->exists($file_name)) {
            // $file = Storage::disk('invoices')->get($file_name);
            // $url = Storage::url($file_name);
            return Storage::disk('invoices')->download($file_name);
        } else abort(404);
    }

    public function save_pdf_invoice($invoice_number)
    {
        $invoice = PDFInvoiceOverride::make('invoice')
            ->withInvoiceNumber($invoice_number)
            ->seller(new Party([]))
            ->buyer(new Party([]))
            ->filename($invoice_number)
            ->addItems([(new InvoiceItem())->title('default')->pricePerUnit(1)])
            ->save_file('invoices');

        // And return invoice itself to browser or have a different view
        //return $invoice->stream();
    }
}
