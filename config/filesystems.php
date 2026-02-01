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
    'project_id' => env('GCS_PROJECT_ID', 'laravel-gcs-project'),

    // الحل الجذري: نضع محتوى الـ JSON مباشرة هنا
    'key_file' => [
        "type" => "service_account",
        "project_id" => "laravel-gcs-project",
        "private_key_id" => "19e9bfc71283ad29c37d5aee570cd6b9f2e3ac3c",
        "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvgIBADANBgkqhkiG9w0BAQEFAASCBKgwggSkAgEAAoIBAQCqKPBVZZDrHl1s/\ndLc5aXXPe5zSQ5RJAMMZ9UvnDk8HvQGm6CLrSY9SAKlBJY5O3tIdzYMBzuDC4Dcw\nDU60tv5aK8SBMjwAjo8yPFLW/lCHJA4RzobEqxSXxLX4OybtjPnQxPLzrqvun+BuH\nmWzZJQwlTlhOc705+sjkISecfWMUuxvpyref+AOxSwagO7yHm+BpkSP7drmWoYfi\nyIZcei2CjyYSaOKAAPdjLt+q7MEWErXXyCNCNdbSf0knHQ8trKnHaNQXx0ai/0V/\nu8mvu6AAYJEu5m7QCFE1SZffR0YCZMfHLf5ate/77ojeQWuUmgJ2w5YapAnuIdhJWZ\nBYl+v1YZAgMBAAECggEACc5aK1GzGRmi4KeWESTWurvlvOhQGPTsr9StdYW8xpr9\nZ61kQPL2qdvvTP//d323z8F4/BdJZ9dApuBDybGFO8UR8GNO3ewmEtfb6xZOCOga\nMRFQPioHCC4GuDHdSHG7Y9PPYuOwWQ S/WUZzspenZ/vGP9JTSurjV0iupuh2JH4C\nYgz2d+8IFkuykrw9KariRHnzA9OC+PrPVjvPkjF8t/uA9hS9JEGpueaJPrILl02Y\n19AitllkmAWK+DguSGRLkHeUCK0IUO3wKv7s+2f2wSbHkvuKcpavKv5nkTt3Jeqa\n0l4NDw5Cmrf5OeDE1QND7+NSojlVSwnwT+WQBi/3kQKBgQDe9IZSJjvESD3ZfVE/\n/FLIS7bLqHH72y12hvUewD+JSYhJQCxmOc5Xoh+r7/yGLPUPUZq8K+M72T1ycX1a\nVl7iLBK0Uks3EBPQQRpTLI7oCR1rgp+ugeXVHIAPxU0E/nBYetXemRvPTXMlBKE\n2QjLpeswRLUC3QKP4bhDxoArDwKBgQDYTr68VmEkZjt9WsiUomYax9l7bKqK3L\n/MWCUPI dIRkgfv4tsBLFfp1wpjp9Dle2/rbbSY8VruIMzbIL0QS9X0eUFuUkoT4A\nMNzc8TBPWtgVgfE9X2F6GTg28o+7PDUgqORCqBZon5FXlF6r690RkuhP0OmBr+4\nl0o9thQMVwKBgQDGpaxS3r/H4E8JYhEhtBJpyd2r7AU696UQ6/mIByMoJbP4a8Nz\n+qAn7lDZ8dRdDiKYBTUG4r8M2cuXx3uqPKLfLMzEn+osoYVo4XT5nR9Evqfk61/K\nXI/ig1FuQrvKDkgUl/GP8fScDR4XBoee9e/mNa9H0Dr+C8tZtDwKBgBlk28ud7uqi\nGjZFwaT2K0ZaNMN/Ioz4m441zl3/s1hB4wgsOVEq32WWp1Pq81uAr7njJVUfHG/P\nCf6zBX8vrZQHfEAtMZ8vLeXMdAhreMIFKxywhlcGqUfsSqBHMOQdTb/xMt05Klo\n8Gnldpu1xRDaypEXS+THtEqIlV8rpjXWFAoGBANtQAY+Fti+awnQDy4TiKjvbxc+s\ntQatYx+lcdeEZeoJkFV9kHD0f5itw8MXpe2SA4LRwsHngslnXaEF3qxfZDE4eXcz\np4esEnUHMhitBl4untqdaIvZ8oDyrYvx3DUGAyrsugsDGcsNiZ24SNe56NBDKlA\n2tREMFepAMvt0Hy5J\n-----END PRIVATE KEY-----\n",
        "client_email" => "laravel-access@laravel-gcs-project.iam.gserviceaccount.com",
        "client_id" => "111150319775402435194",
        "auth_uri" => "https://accounts.google.com/o/oauth2/auth",
        "token_uri" => "https://oauth2.googleapis.com/token",
        "auth_provider_x509_cert_url" => "https://www.googleapis.com/oauth2/v1/certs",
        "client_x509_cert_url" => "https://www.googleapis.com/robot/v1/metadata/x509/laravel-access%40laravel-gcs-project.iam.gserviceaccount.com",
        "universe_domain" => "googleapis.com"
    ],

    'bucket' => env('GCS_BUCKET', 'laravel-media-storage-2026'),
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
