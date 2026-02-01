<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Default Filesystem Disk
    |--------------------------------------------------------------------------
    |
    | Here you may specify the default filesystem disk that should be used
    | by the framework. The "local" disk, as well as a variety of cloud
    | based disks are available to your application for file storage.
    |
    */

    'default' => env('FILESYSTEM_DISK', 'local'),

    /*
    |--------------------------------------------------------------------------
    | Filesystem Disks
    |--------------------------------------------------------------------------
    |
    | Below you may configure as many filesystem disks as necessary, and you
    | may even configure multiple disks for the same driver. Examples for
    | most supported storage drivers are configured here for reference.
    |
    | Supported drivers: "local", "ftp", "sftp", "s3"
    |
    */

    'disks' => [

        'local' => [
            'driver' => 'local',
            'root' => storage_path('app/private'),
            'serve' => true,
            'throw' => false,
            'report' => false,
        ],

        'public' => [
            'driver' => 'local',
            'root' => storage_path('app/public'),
            'url' => rtrim(env('APP_URL'), '/') . '/storage',
            'visibility' => 'public',
            'throw' => false,
            'report' => false,
        ],

        's3' => [
            'driver' => 's3',
            'key' => env('AWS_ACCESS_KEY_ID'),
            'secret' => env('AWS_SECRET_ACCESS_KEY'),
            'region' => env('AWS_DEFAULT_REGION'),
            'bucket' => env('AWS_BUCKET'),
            'url' => env('AWS_URL'),
            'endpoint' => env('AWS_ENDPOINT'),
            'use_path_style_endpoint' => env('AWS_USE_PATH_STYLE_ENDPOINT', false),
            'throw' => false,
            'report' => false,
        ],
'gcs' => [
    'driver' => 'gcs',
    'project_id' => env('GCS_PROJECT_ID'),
    // Allow GCS credentials to be provided either as:
    // 1) a relative path (e.g. storage/app/google-auth.json),
    // 2) a raw JSON string (paste the JSON into the GCS_KEY_FILE env),
    // 3) a base64-encoded JSON string.
    'key_file' => (function () {
        $gcsKey = env('GCS_KEY_FILE');
        if (!$gcsKey) {
            return null;
        }

        // 1) If it looks like a path on the project, try reading it
        $possiblePath = base_path($gcsKey);
        if (file_exists($possiblePath)) {
            $content = file_get_contents($possiblePath);
            $decoded = json_decode($content, true);
            return $decoded ?: null;
        }

        // 2) Try decoding as raw JSON
        $decoded = json_decode($gcsKey, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        // 3) Try decoding as base64-encoded JSON
        $base = base64_decode($gcsKey, true);
        if ($base !== false) {
            $decodedBase = json_decode($base, true);
            if (json_last_error() === JSON_ERROR_NONE && is_array($decodedBase)) {
                return $decodedBase;
            }
        }

        return null;
    })(),
    'bucket' => env('GCS_BUCKET'),
    'path_prefix' => env('GCS_PATH_PREFIX', ''),
    'storage_api_uri' => env('GCS_STORAGE_API_URI', null),
    'visibility' => 'public',
],


    ],

    /*
    |--------------------------------------------------------------------------
    | Symbolic Links
    |--------------------------------------------------------------------------
    |
    | Here you may configure the symbolic links that will be created when the
    | `storage:link` Artisan command is executed. The array keys should be
    | the locations of the links and the values should be their targets.
    |
    */

    'links' => [
        public_path('storage') => storage_path('app/public'),
    ],

];
