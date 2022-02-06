<?php

namespace App\Classes;

error_reporting(0);

use \App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Storage;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Traits\SavesFiles;
use PDF;

class PDFInvoiceOverride extends Invoice
{
    private $invoice_object;

    // Overriding trait function
    use SavesFiles {
        save as protected save_file;
    }

    // Temp save in C:\Users\adjus\AppData\Local\Temp
    public function save_file(string $disk = '')
    {
        if ($disk !== '') {
            $this->disk = $disk;
        }

        $this->render();

        //Storage::disk($this->disk)->put($this->filename, $this->output);

        return $this;
    }

    public function render()
    {
        if ($this->pdf) {
            return $this;
        }

        $this->beforeRender();

        $invoice_data = $this->invoice_object;

        $this->pdf = PDF::loadView('vendor.invoices.templates.details', ['invoice' => $invoice_data->invoice, 'invoice_items' => $invoice_data->invoice_items]);
        $output = $this->pdf->output();
        Storage::disk('invoices')->put('EFC00' . $invoice_data->invoice->invoice_number . '.pdf', $output);

        return Storage::disk('invoices')->put('-EFC00' . $invoice_data->invoice->invoice_number . '.pdf', $output);
    }

    public function withInvoiceNumber($invoice_number)
    {
        $invoice_array = new InvoiceController;
        $invoice_data = (object) $invoice_array->invoice_data($invoice_number);
        //dd($invoice_data);
        $this->invoice_object = $invoice_data;

        return $this;
    }
}
