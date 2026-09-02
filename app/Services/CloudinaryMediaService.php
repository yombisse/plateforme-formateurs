<?php

namespace App\Services;

use Cloudinary\Cloudinary;
use Illuminate\Http\UploadedFile;
use RuntimeException;
use Throwable;

class CloudinaryMediaService
{
    public function upload(UploadedFile $file, string $folder): array
    {
        $result = $this->client()->uploadApi()->upload($file->getRealPath(), [
            'folder' => $folder,
            'resource_type' => 'image',
        ]);

        return [
            'url' => $result['secure_url'],
            'public_id' => $result['public_id'],
        ];
    }

    public function delete(?string $publicId): void
    {
        if (! $publicId) {
            return;
        }

        try {
            $this->client()->uploadApi()->destroy($publicId, [
                'resource_type' => 'image',
                'invalidate' => true,
            ]);
        } catch (Throwable $exception) {
            report($exception);
        }
    }

    private function client(): Cloudinary
    {
        $url = config('services.cloudinary.url');

        if (! $url) {
            throw new RuntimeException('Cloudinary n’est pas configuré. Définissez CLOUDINARY_URL dans le fichier .env.');
        }

        return new Cloudinary($url);
    }
}
