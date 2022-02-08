<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use LaravelDaily\Invoices\Invoice;
use LaravelDaily\Invoices\Classes\Party;
use LaravelDaily\Invoices\Classes\InvoiceItem;
use LaravelDaily\Invoices\Traits\CurrencyFormatter;
use App\Classes\PDFInvoiceOverride;
use App\Http\Requests\CreateOrEditInvoiceRequest;
use App\Models\Invoice as InvoiceModel;
use App\Models\InvoiceItems;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\QRController;
use App\Http\Requests\SettingsRequest;
use App\Models\User;
use App\Classes\Settings;
// use Illuminate\Support\Facades\Config;
// use Spatie\Valuestore\Valuestore;
use NumberFormatter;

class InvoiceController extends Controller
{
    // Overriding trait function
    // use CurrencyFormatter;
    // use CurrencyFormatter {
    //     getAmountInWords as protected getAmountInWordsWithLocale;
    //     //currency_code as protected currency_code1;
    // }

    public function getAmountInWords($amount, $locale = 'ar_SA')
    {
        return $this->getAmountInWordsWithLocale($amount, $locale);
        return $this;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
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

    public function settings()
    {
        return view('settings');
    }

    public function save_settings(SettingsRequest $request, Settings $settings)
    {
        // Update Users table
        $data = $request->only(['name', 'email']);
        $user = User::find(auth()->id());
        $user->update($data);

        //Update the config file
        $values = $request->except(['_token', '_method']);
        // dd($request->except(['_token', '_method']));
        $x = '';
        foreach ($values as $key => $value) {
            $x .= $key . '--';
            if ($settings->has('client_name')) {
            } elseif ($settings->has('client_name')) {
            }
        }
        dd($x);

        $settings->put('sfc_vat', $request->vat);
        // dd($settings->get('sfc_search_meta'));
        // dd($settings->get('client_name'));
        dd($settings->has('client_name'));
        // dd($settings['sfc_search_meta']['client_name']['checked']);

        return redirect('settings')->with('status', __('Settings saved successfully.'));
    }

    public function store(CreateOrEditInvoiceRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['invoice_number'] = Config('efc.next_id'); //random_int(100000, 999999); // EFC00
        // $request->merge(['name' => $request->real_name]);
        $invoice = InvoiceModel::create($data);

        foreach ($request->invoice_items as $item) {
            $item['invoice_id'] = $invoice->id;
            InvoiceItems::create($item);
        }

        // Generate QR image
        (new QRController)->generate($invoice->zatca_data, $invoice->invoice_number);

        // Generate PDF
        $this->make_invoice(Config::get('efc.serial') . $invoice->invoice_number);

        return response()->json(['success' => true]);
    }

    public function invoice_data($invoice_number)
    {
        $id = substr($invoice_number, 5);
        $invoice = InvoiceModel::where('invoice_number', $id)->firstOrFail();
        $invoice_items = $invoice->items()->get();

        return ['invoice' => $invoice, 'invoice_items' => $invoice_items];
    }

    public function details($invoice_number)
    {
        $id = substr($invoice_number, 5);
        $invoice = InvoiceModel::where('invoice_number', $id)->firstOrFail();
        $invoice_items = $invoice->items()->get();
        // $this->invoice = $invoice;
        // $this->invoice_items = $invoice_items;
        // dd($invoice->toArray());
        // dd($invoice_items->toArray());
        return view('details', compact('invoice', 'invoice_items'));
    }

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

    public function download($invoice_number)
    {
        $file_name = $invoice_number . '.pdf';
        if (Storage::disk('invoices')->exists($file_name)) {
            // $file = Storage::disk('invoices')->get($file_name);
            // $url = Storage::url($file_name);
            return Storage::disk('invoices')->download($file_name);
        } else abort(404);
    }

    public function make_invoice($invoice_number)
    {
        $client = new Party([
            'name'          => 'Roosevelt Lloyd',
            'phone'         => '(520) 318-9486',
            'custom_fields' => [
                'note'        => 'IDDQD',
                'business id' => '365#GG',
            ],
        ]);

        $customer = new Party([
            'name'          => 'Ashley Medina',
            'address'       => 'The Green Street 12',
            'code'          => '#22663214',
            'custom_fields' => [
                'order number' => '> 654321 <',
            ],
        ]);

        $items = [
            (new InvoiceItem())
                ->title('خدمة 1')
                ->description('Your product or service description')
                ->pricePerUnit(47.79)
                ->quantity(2)
                ->discount(10),
            (new InvoiceItem())->title('خدمة 2')->pricePerUnit(71.96)->quantity(2),
            (new InvoiceItem())->title('خدمة 3')->pricePerUnit(4.56),
            (new InvoiceItem())->title('خدمة 4')->pricePerUnit(87.51)->quantity(7)->discount(4)->units('kg'),
            (new InvoiceItem())->title('خدمة 5')->pricePerUnit(71.09)->quantity(7)->discountByPercent(9),
            (new InvoiceItem())->title('خدمة 6')->pricePerUnit(76.32)->quantity(9),
            (new InvoiceItem())->title('خدمة 7')->pricePerUnit(58.18)->quantity(3)->discount(3),
            (new InvoiceItem())->title('خدمة 8')->pricePerUnit(42.99)->quantity(4)->discountByPercent(3),
            (new InvoiceItem())->title('خدمة 9')->pricePerUnit(33.24)->quantity(6)->units('m2'),
            (new InvoiceItem())->title('خدمة 11')->pricePerUnit(97.45)->quantity(2),
            (new InvoiceItem())->title('خدمة 12')->pricePerUnit(92.82),
            (new InvoiceItem())->title('خدمة 13')->pricePerUnit(12.98),
            (new InvoiceItem())->title('خدمة 14')->pricePerUnit(160)->units('hours'),
            (new InvoiceItem())->title('خدمة 15')->pricePerUnit(62.21)->discountByPercent(5),
            (new InvoiceItem())->title('خدمة 16')->pricePerUnit(2.80),
            (new InvoiceItem())->title('خدمة 17')->pricePerUnit(56.21),
            (new InvoiceItem())->title('خدمة 18')->pricePerUnit(66.81)->discountByPercent(8),
            (new InvoiceItem())->title('خدمة 19')->pricePerUnit(76.37),
            (new InvoiceItem())->title('خدمة 20')->pricePerUnit(55.80),
        ];

        $notes = [
            'your multiline',
            'additional notes',
            'in regards of delivery or something else',
        ];
        $notes = implode("<br>", $notes);

        $invoice = PDFInvoiceOverride::make('فاتورة')
            // $invoice = Invoice::make('فاتورة')
            ->withInvoiceNumber($invoice_number)
            // ->series('BIG')
            // ability to include translated invoice status
            // in case it was paid
            // ->status(__('invoices::invoice.paid'))
            // ->sequence(667)
            // ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            // ->date(now()->subWeeks(3))
            // ->dateFormat('m/d/Y')
            // ->payUntilDays(14)
            // ->currencySymbol('SAR ')
            // ->currencyCode('ريال سعودي')
            // ->currencyFraction('هللة')
            // ->currencyFormat('{SYMBOL}{VALUE}')
            // ->currencyThousandsSeparator(',')
            // ->currencyDecimalPoint('.')
            ->filename($invoice_number)
            ->addItems($items)
            // ->notes($notes)
            // ->logo(public_path('vendor/invoices/sample-logo.png'))
            // ->template('details_new')
            // You can additionally save generated invoice to configured disk
            ->save_file('invoices');
        // ->url();

        //$link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        //return $invoice->stream();
    }

    /**
     * Write code on Method
     *
     * @return response()
     */
    // public function generateUniqueCode()
    // {
    //     do {
    //         $code = random_int(100000, 999999);
    //     } while (InvoiceModel::where("invoice_number", "=", $code)->first());

    //     return $code;
    // }
}
