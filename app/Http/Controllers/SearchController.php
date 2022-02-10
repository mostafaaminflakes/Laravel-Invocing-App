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
                $keyword = $request->search;
                $query->where('invoice_number', 'LIKE', '%' . $keyword . '%');

                if ($settings->get('sfc_search_meta_client_name') == 'on') {
                    $query->orWhere('client_name', 'LIKE', '%' . $keyword . '%');
                }

                if ($settings->get('sfc_search_meta_client_vat_number') == 'on') {
                    $query->orWhere('client_vat_number', 'LIKE', '%' . $keyword . '%');
                }

                if ($settings->get('sfc_search_meta_project_name') == 'on') {
                    $query->orWhere('project_name', 'LIKE', '%' . $keyword . '%');
                }

                if ($settings->get('sfc_search_meta_project_number') == 'on') {
                    $query->orWhere('project_number', 'LIKE', '%' . $keyword . '%');
                }
            })->paginate(10)->withQueryString();
        // ->toSql(); // Get SQL statement
        // ->getBindings(); // Get search params

        return view('search', compact('invoices_mini'));
    }
}
