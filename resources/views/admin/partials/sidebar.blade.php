<nav >
    <div class="position-sticky pt-3">
        <ul class="nav flex-column">

            {{-- لوحة التحكم --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}">
                    <i class="bi bi-speedometer2 me-2"></i>
                    {{ __('dashboard.general.dashboard') }}
                </a>
            </li>

            {{-- المقالات --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.posts.*') ? 'active' : '' }}" href="{{ route('admin.posts.index') }}">
                    <i class="bi bi-journal-text me-2"></i>
                    {{ __('dashboard.nav.posts') }}
                </a>
            </li>

            {{-- قسم المدير العام فقط --}}
            @role('Super Admin')
            <h6 class="sidebar-heading d-flex justify-content-between align-items-center px-3 mt-4 mb-1 text-muted">
                <span>{{ __('dashboard.general.actions') }}</span>
            </h6>

            {{-- المستخدمين --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.users.*') ? 'active' : '' }}" href="{{ route('admin.users.index') }}">
                    <i class="bi bi-people me-2"></i>
                    {{ __('dashboard.nav.users') }}
                </a>
            </li>

            {{-- التصنيفات --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}" href="{{ route('admin.categories.index') }}">
                    <i class="bi bi-tags me-2"></i>
                    {{ __('dashboard.nav.categories') }}
                </a>
            </li>

            {{-- الصفحات والإعدادات --}}
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}" href="{{ route('admin.pages.index') }}">
                    <i class="bi bi-file-earmark me-2"></i>
                    {{ __('dashboard.nav.pages') }}
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}" href="{{ route('admin.settings.index') }}">
                    <i class="bi bi-gear me-2"></i>
                    {{ __('dashboard.nav.settings') }}
                </a>
            </li>
            @endrole

        </ul>
    </div>
</nav>
