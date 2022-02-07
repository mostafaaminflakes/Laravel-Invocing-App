<?php

return [
    // General Settings
    // 'default_language' => 'ar',
    'vat' => '15',
    'allow_edit' => false,
    'allow_delete' => false,
    'search_meta' => [
        'invoice_number' => [
            'ui_text' => 'Invoice Number1',
            'enabled' => false,
            'checked' => true
        ],
        'client_name' => [
            'ui_text' => 'Client Name1',
            'enabled' => true,
            'checked' => true
        ],
        'client_vat_number' => [
            'ui_text' => 'Client VAT Number1',
            'enabled' => true,
            'checked' => false
        ],
        'project_name' => [
            'ui_text' => 'Project Name1',
            'enabled' => true,
            'checked' => true
        ],
        'project_number' => [
            'ui_text' => 'Project Number1',
            'enabled' => true,
            'checked' => false
        ]
    ],

    // Bank Settings
    'bank_name' => 'بنك البلاد',
    'iban' => 'SA6115000437109427260004',

    // Invoice Settings
    'seller_name' => 'العمارة والفن للمقاولات العامة',
    'seller_vat' => '300821464500003',
    'cr_number' => '1010154364',
    'serial' => 'EFC00',

    // Controller Specific
    'next_id' => 1
];
