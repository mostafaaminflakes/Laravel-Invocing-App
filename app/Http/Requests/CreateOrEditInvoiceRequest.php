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
            // 'client_vat_number' => 'required|digits:15',
            'project_name' => 'required|string|max:255',
            'project_number' => 'required|string|max:255',
            'invoice_items.*.service_name' => 'required|string|max:255',
            'invoice_items.*.unit' => 'required|numeric',
            'invoice_items.*.completion' => 'required|numeric',
            'invoice_items.*.unit_price' => 'required|numeric',
            'invoice_items.*.quantity' => 'required|integer',
            'notes' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'client_name.required' => __('Client name is required.'),
            // 'client_vat_number.required' => __('VAT number is required.'),
            // 'client_vat_number.digits' => __('VAT number must be 15 digits.'),
            'project_name.required' => __('Project name is required.'),
            'project_number.required' => __('Project number is required.'),
            'invoice_items.*.service_name.required' => __('Service name is required.'),
            'invoice_items.*.unit.required' => __('Unit is required.'),
            'invoice_items.*.unit.numeric' => __('Unit must be a number.'),
            'invoice_items.*.completion.required' => __('Completion is required.'),
            'invoice_items.*.completion.numeric' => __('Completion must be a number.'),
            'invoice_items.*.unit_price.required' => __('Unit price is required.'),
            'invoice_items.*.unit_price.numeric' => __('Unit price must be a number.'),
            'invoice_items.*.quantity.required' => __('Quantity is required.'),
            'invoice_items.*.quantity.integer' => __('Quantity must be a number.'),
        ];
    }
}
