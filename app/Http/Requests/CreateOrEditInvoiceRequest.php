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
            'client_address' => 'required|string|max:255',
            'client_vat_number' => 'required|digits:15',
            'invoice_items.*.service_name' => 'required|string|max:255',
            //'invoice_items.*.unit_price' => ['required', 'numeric', 'regex:/^-?[0-9]+(?:.[0-9]{1,2})?$/'],
            'invoice_items.*.unit_price' => 'required|numeric',
            'invoice_items.*.quantity' => 'required|integer',
        ];

        // $rules = [];

        // $rules = [
        //     'client_name' => 'required|string|max:255',
        //     'client_address' => 'required|string|max:255',
        //     'client_vat_number' => 'required|digits:15',
        // ];

        // for ($i = 0; $i < count($this->invoice_items); $i++) {
        //     $rules['invoice_items.' . $i . '.service_name'] = 'required|string|max:255';
        //     $rules['invoice_items.' . $i . '.unit_price'] = 'required|numeric';
        //     $rules['invoice_items.' . $i . '.quantity'] = 'required|integer';
        // }
        //dd($rules);

        // return $rules;
    }

    public function messages()
    {
        return [
            'client_name.required' => 'Client name is required.',
            'client_address.required' => 'Client address is required.',
            'client_vat_number.required' => 'VAT number is required.',
            'client_vat_number.digits' => 'VAT number must be 15 digits.',
            'invoice_items.*.service_name.required' => 'Service name is required.',
            'invoice_items.*.unit_price.required' => 'Unit price is required.',
            'invoice_items.*.unit_price.numeric' => 'Unit price must be a number.',
            'invoice_items.*.quantity.required' => 'Quantity is required.',
            'invoice_items.*.quantity.integer' => 'Quantity must be a number.',
        ];

        // $messages = [
        //     'client_name.required' => 'Client name is required.',
        //     'client_address.required' => 'Client address is required.',
        //     'client_vat_number.required' => 'VAT number is required.',
        //     'client_vat_number.digits' => 'VAT number must be 15 digits.',
        // ];

        // foreach ($this->invoice_items as $key => $val) {
        //     $messages['invoice_items.' . $key . '.service_name.required'] = 'Service name is required.';
        //     $messages['invoice_items.' . $key . '.unit_price.required'] = 'Unit price is required.';
        //     $messages['invoice_items.' . $key . '.unit_price.numeric'] = 'Unit price must be a number.';
        //     $messages['invoice_items.' . $key . '.quantity.required'] = 'Quantity is required.';
        //     $messages['invoice_items.' . $key . '.quantity.integer'] = 'Quantity must be a number.';
        // }

        // return $messages;
    }

    /**
     * Get the proper failed validation response for the request.
     *
     * @param  array  $errors
     * @return \Symfony\Component\HttpFoundation\Response
     */
    // public function response(array $errors)
    // {
    //     if ($this->expectsJson()) {
    //         return new JsonResponse($errors, 200);
    //     }
    // }







    public function rules2()
    {

        $rules = [];

        $rules = [
            "title0" => "required",
            "title1" => "required"
        ];
        //dd(count($this->get('title')));
        // for ($i = 0; $i < count($this->get('title')); $i++) {
        //     $rules['title.' . $i] = 'required';
        // }
        //dd($rules);

        return $rules;
    }

    public function messages2()
    {
        $messages = [];

        $messages = [
            "title0" => 'Service name is required.',
            "title1" => 'Service name is required.'
        ];

        // foreach ($this->title as $key => $val) {
        //     $messages['title.' . $key . '.required'] = 'Service name is required.';
        // }

        return $messages;
    }
}
