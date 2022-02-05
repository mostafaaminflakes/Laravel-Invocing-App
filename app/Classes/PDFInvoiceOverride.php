<?php

namespace App\Classes;

error_reporting(0);

use \App\Http\Controllers\InvoiceController;
use LaravelDaily\Invoices\Invoice;
use PDF;

class PDFInvoiceOverride extends Invoice
{
    public function render()
    {
        if ($this->pdf) {
            return $this;
        }

        $this->beforeRender();

        $invoice_array = new InvoiceController;
        $invoice_data = (object) $invoice_array->invoice_data();

        $this->pdf    = PDF::loadView('vendor.invoices.templates.details', ['invoice' => $invoice_data->invoice, 'invoice_items' => $invoice_data->invoice_items]);

        return $this->pdf->stream('document.pdf');
    }
}
