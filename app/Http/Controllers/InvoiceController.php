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

class InvoiceController extends Controller
{
    // Overriding trait function
    use CurrencyFormatter {
        getAmountInWords as protected getAmountInWordsWithLocale;
    }

    public function getAmountInWords($amount, $locale = 'ar_SA')
    {
        return $this->getAmountInWordsWithLocale($amount, $locale);
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

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        // $invoices_mini = InvoiceModel::select('invoice_number', 'client_name', 'project_name', 'created_at')->orderBy('created_at', 'DESC')->get();
        $invoices_mini = InvoiceModel::select('id', 'invoice_number', 'client_name', 'project_name', 'created_at')->orderBy('created_at', 'DESC')->paginate(10);
        //$invoices_count = $invoices_mini->count();
        return view('home', compact('invoices_mini'));
    }

    public function create()
    {
        return view('create');
    }

    public function store(CreateOrEditInvoiceRequest $request)
    {
        $data = $request->all();
        $data['user_id'] = auth()->id();
        $data['invoice_number'] = random_int(100000, 999999); // EFC00
        $invoice = InvoiceModel::create($data);

        foreach ($request->invoice_items as $item) {
            $item['invoice_id'] = $invoice->id;
            InvoiceItems::create($item);
        }

        // return redirect('home');
        // return back()->withInput();

        return response()->json(['success' => true]);
        // }

        // return back()->with('success', 'Invoice Created Successfully.');
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

    public function MakeInvoice()
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
            ->series('BIG')
            // ability to include translated invoice status
            // in case it was paid
            ->status(__('invoices::invoice.paid'))
            ->sequence(667)
            ->serialNumberFormat('{SEQUENCE}/{SERIES}')
            ->seller($client)
            ->buyer($customer)
            ->date(now()->subWeeks(3))
            ->dateFormat('m/d/Y')
            ->payUntilDays(14)
            ->currencySymbol('SAR ')
            ->currencyCode('ريال سعودي')
            ->currencyFraction('هللة')
            ->currencyFormat('{SYMBOL}{VALUE}')
            ->currencyThousandsSeparator(',')
            ->currencyDecimalPoint('.')
            ->filename($client->name . ' ' . $customer->name)
            ->addItems($items)
            ->notes($notes)
            ->logo(public_path('vendor/invoices/sample-logo.png'))
            ->template('emara')
            // You can additionally save generated invoice to configured disk
            ->save('public');

        $link = $invoice->url();
        // Then send email to party with link

        // And return invoice itself to browser or have a different view
        //return $invoice->stream();
        return $invoice->stream();
        // PDFInvoice
    }
}
