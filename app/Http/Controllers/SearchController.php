<?php

namespace App\Http\Controllers;

use App\Classes\Settings;
use App\Models\Invoice as InvoiceModel;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search(Request $request, Settings $settings)
    {
        $invoices_mini = InvoiceModel::select('id', 'invoice_number', 'client_name', 'project_name', 'created_at')
            ->orderBy('created_at', 'DESC')
            ->where(function ($query) use ($request, $settings) {
                dd($settings->all());
                $query->where('invoice_number', '=', 342354);
                $query->orWhere('project_name', 'LIKE', '%' . $request->input('search') . '%');
                $query->orWhere('client_name', 'LIKE', '%عبدالباقي الشافعي%');
                $query->orWhere('project_number', 'LIKE', '%cvb%');
            })->get();

        dd($invoices_mini->all());
        return view('search', compact('invoices_mini'));
    }
}
