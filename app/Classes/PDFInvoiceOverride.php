<?php

namespace App\Classes;

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
        //dd($this);

        $this->pdf    = PDF::loadView('vendor.invoices.templates.emara2', ['invoice' => $this]);

        return $this->pdf->stream('document.pdf');

        //return $this;
    }
}
