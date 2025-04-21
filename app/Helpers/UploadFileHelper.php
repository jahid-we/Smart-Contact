<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class UploadFileHelper
{
    /**
     * Uploads a file and returns the URL.
     *
     * @param  \Illuminate\Http\Request  $fileRequest
     * @return string
     */

    // Upload Original File Start ********************************
    public static function uploadFile($fileRequest)
    {
        $timestamp = time();
        $extension = strtolower($fileRequest->getClientOriginalExtension());
        $safeName = pathinfo($fileRequest->getClientOriginalName(), PATHINFO_FILENAME);
        $safeName = preg_replace('/[^A-Za-z0-9_\-]/', '_', $safeName);
        $img_name = "{$timestamp}_{$safeName}.{$extension}";

        // Store file in 'public/uploads' disk
        $path = $fileRequest->storeAs('uploads', $img_name, 'public');

        // Return the relative URL path
        return Storage::url($path); // Example: /storage/uploads/1680000000_photo.jpg
    }
    // Upload Original File End **********************************

}
