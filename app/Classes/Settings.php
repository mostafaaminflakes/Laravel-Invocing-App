<?php

namespace App\Classes;

use Illuminate\Support\Facades\Storage;
use Spatie\Valuestore\Valuestore;

class Settings extends Valuestore
{
    // Creating the config file
    public static function create_valuestore_default_settings()
    {
        if (!Storage::exists('settings.json')) {
            $settings = Valuestore::make(storage_path('app/settings.json'));
            $settings->flush();
            $settings->put([
                'sfc_vat' => '15',
                'sfc_allow_edit' => false,
                'sfc_allow_delete' => false,
                'sfc_search_meta' => [
                    'invoice_number' => [
                        'ui_text' => 'Invoice Number',
                        'enabled' => false,
                        'checked' => true
                    ],
                    'client_name' => [
                        'ui_text' => 'Client Name',
                        'enabled' => true,
                        'checked' => true
                    ],
                    'client_vat_number' => [
                        'ui_text' => 'Client VAT Number',
                        'enabled' => true,
                        'checked' => false
                    ],
                    'project_name' => [
                        'ui_text' => 'Project Name',
                        'enabled' => true,
                        'checked' => true
                    ],
                    'project_number' => [
                        'ui_text' => 'Project Number',
                        'enabled' => true,
                        'checked' => false
                    ]
                ],

                // Bank Settings
                'sfc_bank_name' => 'بنك البلاد',
                'sfc_iban' => 'SA6115000437109427260004',

                // Invoice Settings
                'sfc_seller_name' => 'العمارة والفن للمقاولات العامة',
                'sfc_seller_vat' => '300821464500003',
                'sfc_cr_number' => '1010154364',
                'sfc_serial_number' => 'EFC00',

                // Controller Specific
                'next_id' => 1
            ]);
        }
    }

    // Extending class with private constructor
    // https://stackoverflow.com/questions/22847871/extending-class-with-private-constructor-in-php-different-from-version-5-1-to-5
    //
    // static function getInstance()
    // {
    //     if (isset(self::$instance)) {
    //         return self::$instance;
    //     } else {
    //         self::$instance = new static();
    //         return self::$instance;
    //     }
    // }
}
