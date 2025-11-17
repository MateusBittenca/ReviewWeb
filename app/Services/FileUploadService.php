<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class FileUploadService
{
    public function uploadLogo(UploadedFile $file): string
    {
        $filename = uniqid('logo_') . '.' . $file->getClientOriginalExtension();
        $path = 'companies/logos/' . $filename;

        // Redimensionar logo (máx 500x500)
        $image = Image::make($file)
            ->resize(500, 500, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

        Storage::disk('public')->put($path, (string) $image->encode());

        return $path;
    }

    public function uploadBackground(UploadedFile $file): string
    {
        $filename = uniqid('bg_') . '.' . $file->getClientOriginalExtension();
        $path = 'companies/backgrounds/' . $filename;

        // Redimensionar imagem de fundo (máx 1920x1080)
        $image = Image::make($file)
            ->resize(1920, 1080, function ($constraint) {
                $constraint->aspectRatio();
                $constraint->upsize();
            });

        Storage::disk('public')->put($path, (string) $image->encode());

        return $path;
    }

    public function delete(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }

        return false;
    }
}





