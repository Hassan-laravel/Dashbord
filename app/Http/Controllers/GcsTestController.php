<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Exception;
use Illuminate\Http\JsonResponse;

class GcsTestController extends Controller
{
    /**
     * تجربة رفع ملف إلى Google Cloud Storage
     */
    public function uploadTest(Request $request): JsonResponse
    {
        try {
            // التحقق من وجود الملف
            if (!$request->hasFile('image')) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'لم يتم إرسال أي صورة'
                ], 400);
            }

            // التحقق من صحة الملف
            $validated = $request->validate([
                'image' => 'required|image|mimes:jpeg,png,gif,webp|max:5120' // 5MB max
            ]);

            $file = $request->file('image');

            // التحقق من إعدادات GCS
            $keyFile = env('GCS_KEY_FILE');
            $projectId = env('GCS_PROJECT_ID');
            $bucket = env('GCS_BUCKET');

            if (!$keyFile || !$projectId || !$bucket) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'إعدادات Google Cloud Storage غير مكتملة'
                ], 500);
            }

            if (!file_exists($keyFile)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'ملف المفاتيح غير موجود',
                    'expected_path' => $keyFile,
                    'debug' => env('APP_DEBUG') ? [
                        'check_storage_app_folder' => glob(storage_path('app/*'))
                    ] : null
                ], 500);
            }

            // رفع الملف إلى Google Cloud Storage
            $path = Storage::disk('gcs')->putFile('uploads', $file);

            if (!$path) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'فشل رفع الملف إلى Google Cloud Storage',
                    'debug' => env('APP_DEBUG') ? [
                        'key_file' => $keyFile,
                        'project_id' => $projectId,
                        'bucket' => $bucket,
                        'file_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize()
                    ] : null
                ], 500);
            }

            // توليد الرابط الكامل
            $url = Storage::disk('gcs')->url($path);

            return response()->json([
                'status' => 'success',
                'message' => 'تم رفع الصورة بنجاح',
                'path' => $path,
                'url' => $url,
                'filename' => $file->getClientOriginalName()
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'الملف المرسل غير صحيح',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            \Log::error('GCS Upload Error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'status' => 'error',
                'message' => 'حدث خطأ أثناء رفع الملف',
                'error' => $e->getMessage(),
                'debug' => env('APP_DEBUG') ? [
                    'file' => $e->getFile(),
                    'line' => $e->getLine(),
                    'trace' => $e->getTraceAsString()
                ] : null
            ], 500);
        }
    }

    /**
     * اختبار الاتصال بـ Google Cloud Storage
     */
    // public function testConnection(): JsonResponse
    // {
    //     try {
    //         $keyFile = env('GCS_KEY_FILE');
    //         $projectId = env('GCS_PROJECT_ID');
    //         $bucket = env('GCS_BUCKET');

    //         // التحقق من المتغيرات البيئية
    //         if (!$keyFile || !$projectId || !$bucket) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'المتغيرات البيئية غير مكتملة',
    //                 'config' => [
    //                     'key_file' => $keyFile ? 'موجود' : 'غير موجود',
    //                     'project_id' => $projectId ? 'موجود' : 'غير موجود',
    //                     'bucket' => $bucket ? 'موجود' : 'غير موجود'
    //                 ]
    //             ], 400);
    //         }

    //         // التحقق من وجود ملف المفاتيح
    //         if (!file_exists($keyFile)) {
    //             return response()->json([
    //                 'status' => 'error',
    //                 'message' => 'ملف المفاتيح غير موجود',
    //                 'key_file_path' => $keyFile
    //             ], 400);
    //         }

    //         // محاولة الاتصال
    //         $disk = Storage::disk('gcs');
    //         $files = $disk->listContents('/');

    //         return response()->json([
    //             'status' => 'success',
    //             'message' => 'تم الاتصال بـ Google Cloud Storage بنجاح',
    //             'config' => [
    //                 'project_id' => $projectId,
    //                 'bucket' => $bucket,
    //                 'key_file' => basename($keyFile),
    //                 'files_count' => iterator_count($files)
    //             ]
    //         ]);

    //     } catch (Exception $e) {
    //         \Log::error('GCS Connection Test Error: ' . $e->getMessage());

    //         return response()->json([
    //             'status' => 'error',
    //             'message' => 'فشل الاتصال بـ Google Cloud Storage',
    //             'error' => $e->getMessage(),
    //             'debug' => env('APP_DEBUG') ? $e->getTraceAsString() : null
    //         ], 500);
    //     }
    // }
}
