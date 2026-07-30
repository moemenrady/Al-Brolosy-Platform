<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class FileUploadService
{
    /**
     * رفع ملف إلى public
     */
    public static function upload(
        UploadedFile $file,
        string $folder = 'images',
        ?string $oldFile = null
    ): string {

        $destination = public_path($folder);

        if (! File::exists($destination)) {
            File::makeDirectory($destination, 0755, true);
        }

        // حذف الملف القديم
        if ($oldFile && File::exists(public_path($oldFile))) {
            File::delete(public_path($oldFile));
        }

        $filename = now()->format('YmdHis')
            . '_'
            . Str::random(12)
            . '.'
            . $file->getClientOriginalExtension();

        $file->move($destination, $filename);

        return $folder.'/'.$filename;
    }

    /**
     * حذف ملف
     */
    public static function delete(?string $file): void
    {
        if (!$file) {
            return;
        }

        $path = public_path($file);

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}