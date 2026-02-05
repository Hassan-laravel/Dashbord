<header class="navbar navbar-dark sticky-top bg-dark flex-md-nowrap p-0 shadow">

    {{-- Project Name / Logo --}}
    <a class="navbar-brand col-md-3 col-lg-2 me-0 px-3 fs-6" href="{{ route('admin.dashboard') }}">
        {{ config('app.name', 'Laravel Admin') }}
    </a>

    {{-- Mobile Menu Toggle --}}
    <button class="navbar-toggler position-absolute d-md-none collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#sidebarMenu" aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    {{-- Spacer (Placeholder for a future search bar) --}}
    <div class="w-100"></div>

    {{-- Right Menu (Language + Logout) --}}
    <div class="navbar-nav">
        <div class="nav-item text-nowrap d-flex align-items-center gap-3 px-3">

            {{-- Visit Main Website Button --}}
            <a class="nav-link px-0" href="{{ route('home') }}" target="_blank" title="{{ __('dashboard.general.home') }}">
                <i class="bi bi-box-arrow-up-right"></i>
            </a>

            {{-- Language Switcher --}}
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="bi bi-globe2 me-1"></i>
                    {{ strtoupper(app()->getLocale()) }}
                </a>
                <ul class="dropdown-menu dropdown-menu-end position-absolute">
                    @foreach(config('language.supported') as $key => $lang)
                        <li>
                            <a class="dropdown-item d-flex justify-content-between align-items-center {{ app()->getLocale() == $key ? 'active' : '' }}"
                               href="{{ route('switch.language', $key) }}">
                                <span>{{ $lang['name'] }}</span>
                                @if(app()->getLocale() == $key)
                                    <i class="bi bi-check-lg"></i>
                                @endif
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>

            {{-- Vertical Separator --}}
            <div class="vr text-white opacity-25"></div>

            {{-- Logout --}}
            <form action="{{ route('logout') }}" method="POST" class="d-inline">
                @csrf
                <button type="submit" class="nav-link px-0 bg-transparent border-0 text-danger" title="{{ __('dashboard.nav.logout') }}">
                    {{ __('dashboard.nav.logout') }} <i class="bi bi-box-arrow-right ms-1"></i>
                </button>
            </form>
        </div>
    </div>
</header>
