<?php

namespace App\Http\Controllers;

use App\Models\Invoice as InvoiceModel;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function search(Request $request)
    {
        $invoices_mini = InvoiceModel::select('id', 'invoice_number', 'client_name', 'project_name', 'created_at')
            ->orderBy('created_at', 'DESC')
            ->where('project_name', 'LIKE', '%اتمني%')
            ->paginate(10);
        dd($invoices_mini->all());
        return view('search', compact('invoices_mini'));
    }
}
