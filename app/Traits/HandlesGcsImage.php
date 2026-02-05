<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Exception;

trait HandlesGcsImage
{
    /**
     * Upload an image to Google Cloud Storage
     */
    public function uploadImageToGcs(UploadedFile $file, string $folder = 'uploads'): ?array
    {
        try {
            if (!$file->isValid()) {
                throw new \Exception("File is not valid: " . $file->getErrorMessage());
            }

            // Force upload with public visibility and specify the GCS disk
            $path = Storage::disk('gcs')->putFile($folder, $file, 'public');

            if (!$path) {
                throw new \Exception("Storage::disk('gcs')->putFile returned false");
            }

            return [
                'path' => $path,
                'url' => Storage::disk('gcs')->url($path),
            ];

        } catch (Exception $e) {
            // This logs the actual root cause in Laravel logs (e.g., SSL error or Timeout)
            \Log::error('Full GCS Error: ' . $e->getMessage());
            throw $e;
        }
    }

    /**
     * Delete an image from Google Cloud Storage
     */
    public function deleteImageFromGcs(string $path): bool
    {
        try {
            if (empty($path)) return false;

            // Check if the file exists before attempting to delete
            if (Storage::disk('gcs')->exists($path)) {
                return Storage::disk('gcs')->delete($path);
            }

            // Return true even if the file is not found to prevent the Controller from stopping
            return true;
        } catch (Exception $e) {
            \Log::error('GCS Delete Error: ' . $e->getMessage());
            return false;
        }
    }

    /**
     * Update an image (Delete the old one and upload the new one)
     */
    public function updateImageInGcs(string $oldPath, UploadedFile $newFile, string $folder = 'uploads'): ?array
    {
        try {
            // Upload the new image
            $uploadResult = $this->uploadImageToGcs($newFile, $folder);

            if (!$uploadResult) {
                return null;
            }

            // Delete the old image
            if (!empty($oldPath)) {
                $this->deleteImageFromGcs($oldPath);
            }

            return $uploadResult;

        } catch (Exception $e) {
            \Log::error('GCS Update Image Error: ' . $e->getMessage(), [
                'old_path' => $oldPath,
                'exception' => $e
            ]);
            return null;
        }
    }

    /**
     * Get the image URL
     */
    public function getImageUrl(string $path): ?string
    {
        try {
            if (empty($path)) {
                return null;
            }

            return Storage::disk('gcs')->url($path);

        } catch (Exception $e) {
            \Log::error('GCS Get URL Error: ' . $e->getMessage());
            return null;
        }
    }
}
