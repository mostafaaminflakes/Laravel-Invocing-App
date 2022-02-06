<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\SallaController;
use Illuminate\Support\Facades\Storage;

class QRController extends Controller
{
    public function generate(array $qr_data, $invoice_number)
    {
        $base64_image_string = (new SallaController)->render($qr_data);
        $base64_image_string_without_header = $this->decode_base64($base64_image_string);
        $image_file_name = 'EFC00' . $invoice_number . '.png';
        Storage::disk('qr_images')->put($image_file_name, $base64_image_string_without_header);
    }

    public function decode_base64($base64_encoded_string)
    {
        $search = array('data:image/png;base64,', ' ');
        $replace = array('', '+');
        $string_without_base64_header = str_replace($search, $replace, $base64_encoded_string);
        $decoded_string = base64_decode($string_without_base64_header);

        return $decoded_string;
    }
}
