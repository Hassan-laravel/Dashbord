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
        if (!$file->isValid()) {
            throw new \Exception("File is not valid: " . $file->getErrorMessage());
        }

        // إجبار الرفع مع خاصية public وتحديد القرص بدقة
        $path = Storage::disk('gcs')->putFile($folder, $file, 'public');

        if (!$path) {
            throw new \Exception("Storage::disk('gcs')->putFile returned false");
        }

        return [
            'path' => $path,
            'url' => Storage::disk('gcs')->url($path),
        ];

 } catch (Exception $e) {
    // هذا السطر سيسجل السبب الحقيقي في ملف لارافل (مثل SSL error أو Timeout)
    \Log::error('Full GCS Error: ' . $e->getMessage());
    throw $e;
}
}

    /**
     * حذف صورة من Google Cloud Storage
     */
public function deleteImageFromGcs(string $path): bool
{
    try {
        if (empty($path)) return false;
        // تحقق من وجود الملف قبل محاولة الحذف
        if (Storage::disk('gcs')->exists($path)) {
            return Storage::disk('gcs')->delete($path);
        }
        return true; // نعتبرها ناجحة حتى لو لم يجد الملف لكي لا يتوقف الـ Controller
    } catch (Exception $e) {
        \Log::error('GCS Delete Error: ' . $e->getMessage());
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
