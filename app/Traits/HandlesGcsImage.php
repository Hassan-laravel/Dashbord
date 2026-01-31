<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Exception;

trait HandlesGcsImage
{
    /**
     * رفع صورة إلى Google Cloud Storage
     */
    public function uploadImageToGcs(UploadedFile $file, string $folder = 'uploads'): ?array
    {
        try {
            // التحقق من صحة الملف
            if (!$file->isValid()) {
                return null;
            }

            // رفع الملف
            $path = Storage::disk('gcs')->putFile($folder, $file);

            if (!$path) {
                return null;
            }

            // توليد الرابط
            $url = Storage::disk('gcs')->url($path);

            return [
                'path' => $path,
                'url' => $url,
                'filename' => $file->getClientOriginalName(),
                'size' => $file->getSize(),
                'mime_type' => $file->getMimeType()
            ];

        } catch (Exception $e) {
            \Log::error('GCS Upload Error: ' . $e->getMessage(), [
                'file' => $file->getClientOriginalName(),
                'exception' => $e
            ]);
            return null;
        }
    }

    /**
     * حذف صورة من Google Cloud Storage
     */
    public function deleteImageFromGcs(string $path): bool
    {
        try {
            if (empty($path)) {
                return false;
            }

            return Storage::disk('gcs')->delete($path);

        } catch (Exception $e) {
            \Log::error('GCS Delete Error: ' . $e->getMessage(), [
                'path' => $path,
                'exception' => $e
            ]);
            return false;
        }
    }

    /**
     * تحديث صورة (حذف القديمة ورفع الجديدة)
     */
    public function updateImageInGcs(string $oldPath, UploadedFile $newFile, string $folder = 'uploads'): ?array
    {
        try {
            // رفع الصورة الجديدة
            $uploadResult = $this->uploadImageToGcs($newFile, $folder);

            if (!$uploadResult) {
                return null;
            }

            // حذف الصورة القديمة
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
     * الحصول على رابط الصورة
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
