<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use File;

class ZipController extends Controller
{
    public function create()
    {
        $zip_file_name = public_path('storage/invoices.zip');
        $zip = new ZipArchive;

        if ($zip->open($zip_file_name, ZipArchive::CREATE) === TRUE) {
            $files = File::files(public_path('storage/invoices'));

            foreach ($files as $file) {
                $relative_name_in_zip_file = basename($file);
                $zip->addFile($file, $relative_name_in_zip_file);
            }

            $zip->close();
        }

        return response()->download($zip_file_name);
    }
}
