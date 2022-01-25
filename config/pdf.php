<?php

return [
    'mode'                     => '',
    'format'                   => 'A4',
    'default_font_size'        => '12',
    'default_font'             => 'sans-serif',
    'margin_left'              => 10,
    'margin_right'             => 10,
    'margin_top'               => 10,
    'margin_bottom'            => 10,
    'margin_header'            => 0,
    'margin_footer'            => 0,
    'orientation'              => 'P',
    'title'                    => 'Laravel mPDF',
    'subject'                  => '',
    'author'                   => '',
    'watermark'                => '',
    'show_watermark'           => false,
    'show_watermark_image'     => false,
    'watermark_font'           => 'sans-serif',
    'display_mode'             => 'fullpage',
    'watermark_text_alpha'     => 0.1,
    'watermark_image_path'     => '',
    'watermark_image_alpha'    => 0.2,
    'watermark_image_size'     => 'D',
    'watermark_image_position' => 'P',
    'custom_font_dir'  => base_path('resources/fonts/'), // don't forget the trailing slash!
    'custom_font_data' => [
        'tajawal' => [
            'R'  => 'Tajawal/Tajawal-Regular.ttf',    // regular font
            'useOTL' => 0xFF,
            'useKashida' => 75,
        ],
        'cairo' => [
            'R'  => 'Cairo/Cairo.ttf',    // regular font
        ],
        'roboto' => [
            'R'  => 'Roboto/Roboto-Regular.ttf',    // regular font
        ],
        'poppins' => [
            'R'  => 'Poppins/Poppins-Regular.ttf',    // regular font
        ],
        'aref_ruqaa' => [
            'R'  => 'Aref_Ruqaa/ArefRuqaa-Regular.ttf',    // regular font
        ],
        'mochiy' => [
            'R'  => 'Mochiy_Pop_P_One/MochiyPopPOne-Regular.ttf',    // regular font
        ]
        // ...add as many as you want.
    ],
    // 'custom_font_dir'          => '',
    // 'custom_font_data'         => [],
    'auto_language_detection'  => false,
    'temp_dir'                 => rtrim(sys_get_temp_dir(), DIRECTORY_SEPARATOR),
    'pdfa'                     => false,
    'pdfaauto'                 => false,
    'use_active_forms'         => false,
];
