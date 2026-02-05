<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"
      dir="{{ config('language.supported.' . app()->getLocale() . '.dir', 'ltr') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('dashboard.auth.login_title') }} - News CMS</title>
    @if(config('language.supported.' . app()->getLocale() . '.dir') == 'rtl')
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.rtl.min.css">
    @else
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    @endif
    <style>
        body { background-color: #f5f7fb; height: 100vh; display: flex; align-items: center; justify-content: center; }
        .login-card { width: 100%; max-width: 400px; border: none; border-radius: 10px; box-shadow: 0 4px 20px rgba(0,0,0,0.05); }
        .login-header { background: #343a40; color: #fff; padding: 20px; border-radius: 10px 10px 0 0; text-align: center; }
    </style>
</head>
<body>

<div class="card login-card">
    <div class="login-header">
        <h4 class="mb-0 fw-bold">News CMS</h4>
        <small>{{ __('dashboard.auth.admin_panel') }}</small>
    </div>
    <div class="card-body p-4">

        {{-- Display error messages --}}
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0 small">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf
            <div class="mb-3">
                <label class="form-label">{{ __('dashboard.auth.email') }}</label>
                <input type="email" name="email" class="form-control" placeholder="admin@app.com" required>
            </div>
            <div class="mb-3">
                <label class="form-label">{{ __('dashboard.auth.password') }}</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" class="form-check-input" id="remember" name="remember">
                <label class="form-check-label" for="remember">{{ __('dashboard.auth.remember_me') }}</label>
            </div>
            <button type="submit" class="btn btn-primary w-100">{{ __('dashboard.auth.login_btn') }}</button>
        </form>
    </div>
    <div class="card-footer text-center bg-white py-3 border-0">
        <small class="text-muted">&copy; {{ date('Y') }} News CMS</small>

        {{-- Language switcher links --}}
        <div class="mt-2">
            <a href="{{ route('switch.language', 'ar') }}" class="text-decoration-none mx-1 {{ app()->getLocale() == 'ar' ? 'fw-bold' : '' }}">العربية</a> |
            <a href="{{ route('switch.language', 'en') }}" class="text-decoration-none mx-1 {{ app()->getLocale() == 'en' ? 'fw-bold' : '' }}">English</a> |
            <a href="{{ route('switch.language', 'nl') }}" class="text-decoration-none mx-1 {{ app()->getLocale() == 'nl' ? 'fw-bold' : '' }}">Nederlands</a>
        </div>
    </div>
</div>

</body>
</html>
