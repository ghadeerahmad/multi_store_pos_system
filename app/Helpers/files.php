<?php

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

if (!function_exists('uploadArray')) {
    function uploadArray(array $files, $filePath)
    {
        $paths = [];
        foreach ($files as  $file) {
            $fileName = microtime(true) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs($filePath, $fileName, 'public');
            $paths[] = $path;
        }

        return $paths;
    }
}

if (!function_exists('deleteFile')) {
    function deleteFile($path)
    {
        Storage::disk('public')->delete($path);
    }
}

if (!function_exists('upload')) {
    function upload(UploadedFile $file, $filePath)
    {
        $fileName = time() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs($filePath, $fileName, 'public');

        return $path;
    }
}
