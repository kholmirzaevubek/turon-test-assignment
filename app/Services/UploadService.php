<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

final class UploadService
{
    public function upload(UploadedFile $file, string $folder): string
    {
        // Generate a unique filename using uniqid and append the original file's extension
        $filename = uniqid() . '.' . $file->getClientOriginalExtension();

        // Store the uploaded file in the specified folder with the generated unique filename
        // The 'public' disk indicates that the file will be stored in the public storage
        return $file->storeAs($folder, $filename, 'public');
    }
}
