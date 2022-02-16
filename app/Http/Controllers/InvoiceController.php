<?php

namespace App\Http\Controllers;

use App\Classes\Settings;
use Illuminate\Http\Request;
use App\Http\Requests\CreateOrEditInvoiceRequest;
use App\Models\Invoice as InvoiceModel;
use App\Models\InvoiceItems;
use App\Http\Controllers\QRController;
use App\Http\Controllers\ExportController;
use Illuminate\Support\Facades\Storage;
use NumberFormatter;

class InvoiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $invoices_mini = InvoiceModel::select('id', 'invoice_number', 'client_name', 'project_name', 'created_at')->orderBy('created_at', 'DESC')->paginate(10);
        return view('home', compact('invoices_mini'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(CreateOrEditInvoiceRequest $request, Settings $settings)
    {
        $invoice_id = $settings->get('next_id');

        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['invoice_number'] = $invoice_id; //random_int(100000, 999999); // EFC00
        // $request->merge(['name' => $request->real_name]);
        $invoice = InvoiceModel::create($data);

        foreach ($request->invoice_items as $item) {
            $item['invoice_id'] = $invoice->id;
            InvoiceItems::create($item);
        }

        // Set next invoice id
        $settings->put('next_id', $invoice_id + 1);

        // Generate QR image
        (new QRController)->generate($invoice->zatca_data, $invoice->invoice_number);

        // Generate PDF
        (new ExportController)->save_pdf_invoice($settings->get('sfc_serial') . $invoice->invoice_number);

        return response()->json(['success' => true, 'invoice' => $settings->get('sfc_serial') . $invoice->invoice_number]);
    }

    public function edit($invoice_number)
    {
        $invoice = $this->invoice_data($invoice_number);
        return view('edit', $invoice);
    }

    public function save_edit(CreateOrEditInvoiceRequest $request, Settings $settings)
    {
        $invoice_id = $request->i_n;

        $data = $request->all();
        $invoice = InvoiceModel::where('invoice_number', $invoice_id)->firstOrFail();
        $invoice->update($data);
        $invoice->items()->forceDelete();

        foreach ($request->invoice_items as $item) {
            $item['invoice_id'] = $invoice->id;
            InvoiceItems::create($item);
        }

        // Generate QR image
        (new QRController)->generate($invoice->zatca_data, $invoice->invoice_number);

        // Generate PDF
        (new ExportController)->save_pdf_invoice($settings->get('sfc_serial') . $invoice->invoice_number);

        return response()->json(['success' => true, 'invoice' => $settings->get('sfc_serial') . $invoice->invoice_number]);
    }

    public function details($invoice_number)
    {
        $invoice = $this->invoice_data($invoice_number);

        return view('details', $invoice);
    }

    public function invoice_data($invoice_number)
    {
        $id = substr($invoice_number, 5);
        $invoice = InvoiceModel::where('invoice_number', $id)->firstOrFail();
        $invoice_items = $invoice->items()->get();

        return ['invoice' => $invoice, 'invoice_items' => $invoice_items];
    }

    public function delete($invoice_number)
    {
        $id = substr($invoice_number, 5);
        $invoice = InvoiceModel::where('invoice_number', $id)->firstOrFail();
        $invoice->delete();

        return back()->with('status', __('Invoice deleted successfully.'));
    }

    /* Admin */
    public function admin_restore()
    {
        $invoices_mini = InvoiceModel::select('id', 'invoice_number', 'client_name', 'project_name', 'created_at')->orderBy('created_at', 'DESC')->onlyTrashed()->paginate(10);
        return view('restore', compact('invoices_mini'));
    }

    public function admin_details($invoice_number)
    {
        $id = substr($invoice_number, 5);
        $invoice = InvoiceModel::withTrashed()->where('invoice_number', $id)->firstOrFail();
        $invoice_items = $invoice->items()->withTrashed()->get();

        return view('details', ['invoice' => $invoice, 'invoice_items' => $invoice_items]);
    }

    public function admin_restore_invoice($invoice_number)
    {
        $id = substr($invoice_number, 5);
        $invoice = InvoiceModel::withTrashed()->where('invoice_number', $id)->firstOrFail();
        $invoice->restore();

        return back()->with('status', __('Invoice restored successfully.'));
    }

    public function admin_delete_invoice($invoice_number)
    {
        $id = substr($invoice_number, 5);
        $invoice = InvoiceModel::withTrashed()->where('invoice_number', $id)->firstOrFail();
        $invoice->forceDelete();
        $invoice->items()->withTrashed()->forceDelete();

        // Delete PDF file and QR image
        $this->admin_delete_invoice_files($invoice_number);

        return back()->with('status', __('Invoice deleted permanently.'));
    }

    public function admin_delete_invoice_files($invoice_number): void
    {
        $pdf_file = 'invoices/' . $invoice_number . '.pdf';
        $png_file = 'qr_images/' . $invoice_number . '.png';
        if (Storage::disk('public')->exists($pdf_file)) {
            Storage::disk('public')->delete($pdf_file);
        }

        if (Storage::disk('public')->exists($png_file)) {
            Storage::disk('public')->delete($png_file);
        }
    }

    // public function getAmountInWords($amount, $locale = 'ar_SA')
    // {
    //     return $this->getAmountInWordsWithLocale($amount, $locale);
    //     return $this;
    // }

    public static function get_amount_in_words($total_amount_after_vat)
    {
        return (new self)->amount_in_words($total_amount_after_vat, 'ar_SA');
    }

    public function amount_in_words(float $amount, ?string $locale = null)
    {
        $decimals = '2';
        $currency_code = 'ريال سعودي';
        $currency_fraction = 'هللة';
        $amount    = number_format($amount, $decimals, '.', '');
        $formatter = new NumberFormatter($locale ?? App::getLocale(), NumberFormatter::SPELLOUT);
        //echo $formatter->getPattern();

        $value = explode('.', $amount);

        $integer_value  = (int) $value[0] !== 0 ? $formatter->format($value[0]) : 0;
        $fraction_value = isset($value[1]) ? $formatter->format($value[1]) : 0;

        if ($value[1] == 0) {
            //if ($decimals <= 0) {
            return sprintf('%s %s', ucfirst($integer_value), strtoupper($currency_code));
            // }
        }

        return sprintf(
            trans('invoices::invoice.amount_in_words_format'),
            ucfirst($integer_value),
            strtoupper($currency_code),
            $fraction_value,
            $currency_fraction
        );
    }
}
