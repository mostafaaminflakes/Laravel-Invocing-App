<?php

namespace App\Http\Requests;

use Illuminate\Http\JsonResponse;
use Illuminate\Foundation\Http\FormRequest;

class CreateOrEditInvoiceRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'client_name' => 'required|string|max:255',
            'client_vat_number' => 'required|digits:15',
            'project_name' => 'required|string|max:255',
            'project_number' => 'required|string|max:255',
            'invoice_items.*.service_name' => 'required|string|max:255',
            'invoice_items.*.unit' => 'required|numeric',
            'invoice_items.*.completion' => 'required|numeric',
            'invoice_items.*.unit_price' => 'required|numeric',
            'invoice_items.*.quantity' => 'required|integer',
        ];
    }

    public function messages()
    {
        return [
            'client_name.required' => 'Client name is required.',
            'client_vat_number.required' => 'VAT number is required.',
            'client_vat_number.digits' => 'VAT number must be 15 digits.',
            'project_name.required' => 'Project name is required.',
            'project_number.required' => 'Project number is required.',
            'invoice_items.*.service_name.required' => 'Service name is required.',
            'invoice_items.*.unit.required' => 'Unit is required.',
            'invoice_items.*.unit.numeric' => 'Unit must be a number.',
            'invoice_items.*.completion.required' => 'Completion is required.',
            'invoice_items.*.completion.numeric' => 'Completion must be a number.',
            'invoice_items.*.unit_price.required' => 'Unit price is required.',
            'invoice_items.*.unit_price.numeric' => 'Unit price must be a number.',
            'invoice_items.*.quantity.required' => 'Quantity is required.',
            'invoice_items.*.quantity.integer' => 'Quantity must be a number.',
        ];
    }
}
