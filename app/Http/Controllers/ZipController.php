<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use ZipArchive;
use Illuminate\Support\Facades\Storage;

class ZipController extends Controller
{
    public function create()
    {
        $zip = new ZipArchive;
        $directory = 'invoices';
        $zip_file_name = 'invoices.zip';
        $zip_file_path = 'storage/' . $zip_file_name;

        // Delete old ZIP file if exists
        $this->delete_file_if_exists($zip_file_name);

        // Create ZIP file
        if ($zip->open(public_path($zip_file_path), ZipArchive::CREATE) === TRUE) {

            // Create INVOICES directory if not exists
            $this->create_directory_if_not_exists($directory);

            // Add files inside directory to ZIP archive
            $files = Storage::disk('public')->files($directory);

            if (empty($files)) {
                $zip->addEmptyDir($directory);
            } else {
                foreach ($files as $key => $file) {
                    $relative_path = basename($file);
                    $file_url = public_path('storage/' . $file);
                    $zip->addFile($file_url, $relative_path);
                }
            }

            $zip->close();
        }

        // Stream ZIP file
        return response()->download(public_path($zip_file_path));
    }

    public function delete_file_if_exists($file): void
    {
        if (Storage::disk('public')->exists($file)) {
            Storage::disk('public')->delete($file);
        }
    }

    public function create_directory_if_not_exists($directory): void
    {
        if (!Storage::disk('public')->exists($directory)) {
            // File::makeDirectory($path, 0777, true, true);
            Storage::disk('public')->makeDirectory($directory);
        }
    }
}
