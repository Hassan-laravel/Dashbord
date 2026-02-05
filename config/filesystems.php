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


    'key_file' => [
                "type" => "service_account",
                "project_id" => "laravel-gcs-project",
                "private_key_id" => "d1da4acb0b0e20480523f253379ad1b7be4d3609",
                "private_key" => "-----BEGIN PRIVATE KEY-----\nMIIEvQIBADANBgkqhkiG9w0BAQEFAASCBKcwggSjAgEAAoIBAQCfbIrF2+dzaibG\nf6uMAxD/XFlvuiIzRsef2XNO7jJYRnFcabXZXP+2IAEydxHo3IgApVnsUb/t3qID\nLtLyUuClh4DC2CtZecD+yMrtHMpOtUDXBo0ZQ7UIqNn4C/HQcFfmvaH4lrm+K14i\nEhNqIKgXG678OmxhHM50CT2cnLmD4w1YVb7kzoIlZyyyOvlzQx7PUTdxC2meEvEn\n5klHc1tr0yvyRRFbtX+eLZ6jijF60cnQH7bd0oSlnRmiAZ2L8FO01SdjtlKbeRbS\ntgB8Cv1HhMSc5K/DLPTMvSeLm+RS8iEDjaLR5ZHTm4JzWGYkk3ZFsH0zx9AYAYl6\n6yn3G/f3AgMBAAECggEABH4znwXmjPsl4pxAgm6nsPqyTpLJWfaZs6iWNlhCNPiv\nQzJ7fIfBcSmPvxNZ/t0QPCxsz1sydIq8uCg+q7OoPyIFf/hFqHzk8olIJsyT6wny\nrNyzZ03gMUFI+1Oi2gQAhjE7+lyNGY3xVjZ6M5h+BEC0eslOuqHsM5r7EIneNJhL\nGUFqr1LUlQ33kB+UigODp/R7rcpg+c0jwFeN3WTm5CmSA9qUCudF07rkWCns/6UB\n2NZZje9EFF2t2TSlsLsgn7jkAv5sbFCvxvgMZjqwpk6zN+PMHfOvDZBhhYOxou4r\nP9VO+NNvtfH0RWnBAymaci+SXFm87/1V0mW9IQy8wQKBgQDgyNmaKAhgGrxPLLBH\nHa/Z0DFvxwZOL6hFF+LVUr2P11FzWoEbpC1ZL9DFanVN6pKG1KlnGjR5ZOllvRou\nbg4/lJXM/GPATJiYDaZ2oSgAaOIsS8+KwNSJVZ1NHMepk3x4CGtXFaVepoUKHpgq\n8LYLBVZbjLnINwNnXpNEWqK14QKBgQC1kBtEpvEc7eaEhqF5bLbvsMtIY3aEVDRm\n1TQS8NyQhriVVC75zul8pFF5BlC+Mz5cpTlFm08Jx3UpuQln/tx8PN3ztvWC0h5w\nICWp+PN/kqHUQAhA5zTvzAcrh79rCKtGS5XHfUSzDc9WLwwgdrmTMsQ5x8Bfg4lR\nIl06viw41wKBgQC0lyibfQYdj90yDskgmW0qJOVS1CbwscESoXoPwIWjBm3dqxyG\nxIPaX1vu/vR3QLmvsTLYLmlyDeylXCOooaq40fr30N2jJOaDYpQWQqsMiTcMN2vq\nIbmfDDVwOmr+hgs9tCXotO9C961yz9mYxgK7H/KdYpXvkKMfbRALnnWSgQKBgHnx\ntO7SNWUZv9bI2dFFHEU2eAJBk4tjRuK+VcBW9702Tuk05mwv9ZAaiQIBJN/qaPsu\nmZ3PpzFJPr7sIY4wlgP3mZckDhd0aq8iWEmmBF1trbVx4Fk/MMXSQgqRnRYVd3u6\nLnoS/75HCze2V63CL/fWhAbOy70bCnJs4zMeIXN3AoGAfXEWVvTISpYMeyCg/FSB\ndQtI4x2Yi++AJ2l3W6s3TJ3KX3QD57P9B2zhy0yJLkLndKo9SU+sJw/aqMWxhezO\n61olBgXBJR5gxA3ySVzHx7G0aGM0MFzp14Rah2pvgOxYxYo3XP2qQ3eL3sM867bI\nsXCc83+v5dVSRfpLTcQ4+Ic=\n-----END PRIVATE KEY-----\n",
                "client_email" => "laravel-access@laravel-gcs-project.iam.gserviceaccount.com",
                "client_id" => "111150319775402435194",
                "auth_uri" => "https=>//accounts.google.com/o/oauth2/auth",
                "token_uri" => "https=>//oauth2.googleapis.com/token",
                "auth_provider_x509_cert_url" => "https=>//www.googleapis.com/oauth2/v1/certs",
                "client_x509_cert_url" => "https=>//www.googleapis.com/robot/v1/metadata/x509/laravel-access%40laravel-gcs-project.iam.gserviceaccount.com",
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
