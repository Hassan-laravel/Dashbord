<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
    dir="{{ config('language.supported.' . app()->getLocale() . '.dir', 'ltr') }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    {{-- استخدام مفتاح الترجمة للعنوان --}}
    <title>{{ __('dashboard.nav.dashboard') }} - @yield('title')</title>

    @if (config('language.supported.' . app()->getLocale() . '.dir') == 'rtl')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <style>
        .sidebar {
            min-height: 100vh;
            background: #343a40;
            color: #fff;
        }

        .sidebar a {
            color: #adb5bd;
            text-decoration: none;
            padding: 10px 15px;
            display: block;
        }

        .sidebar a:hover,
        .sidebar a.active {
            background: #495057;
            color: #fff;
        }

        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-3 col-lg-2 d-md-block sidebar collapse px-0">
                @include('admin.partials.sidebar')
            </div>
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                @include('admin.partials.header')

                {{-- عنوان الصفحة الديناميكي --}}
                <div class="pt-3 pb-2 mb-3 border-bottom">
                    <h1 class="h2">@yield('header_title')</h1>
                </div>
                @include('admin.partials.flash')
                @yield('content')

            </main>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>
