@props(['title', 'value', 'icon', 'color' => 'primary', 'link' => '#'])

<div class="card shadow-sm border-0 h-100">
    <div class="card-body p-3">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h6 class="text-muted text-uppercase fw-semibold mb-1 small">{{ $title }}</h6>
                <h2 class="mb-0 fw-bold text-{{ $color }}">{{ $value }}</h2>
            </div>
            <div class="icon-shape bg-{{ $color }} bg-opacity-10 text-{{ $color }} rounded-3 p-3">
                <i class="bi {{ $icon }} fs-3"></i>
            </div>
        </div>
        <div class="mt-3 mb-0 text-sm">
            {{-- مثال: عرض نسبة التحسن (يمكن جعلها ديناميكية لاحقاً) --}}
            <span class="text-success fw-bold me-2">
                <i class="bi bi-arrow-up"></i> 3.48%
            </span>
            <span class="text-nowrap text-muted small">{{ __('dashboard.since_last_month') }}</span>
        </div>
    </div>
    {{-- رابط التفاصيل --}}
    <a href="{{ $link }}" class="card-footer bg-transparent border-0 text-end small text-muted hover-link">
        {{ __('dashboard.view_details') }} <i class="bi bi-arrow-right ms-1"></i>
    </a>
</div>
