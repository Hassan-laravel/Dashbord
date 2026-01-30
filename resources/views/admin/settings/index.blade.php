@extends('admin.layouts.app')

@section('title', __('dashboard.settings.title'))
@section('header_title', __('dashboard.settings.title'))

@section('content')

<form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        {{-- العمود الأيمن: الإعدادات المترجمة --}}
        <div class="col-lg-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold"><i class="bi bi-translate me-2"></i> المحتوى المترجم</h6>
                </div>
                <div class="card-body">

                    <ul class="nav nav-tabs mb-3" id="settingTabs" role="tablist">
                        @foreach(config('language.supported') as $key => $lang)
                            <li class="nav-item" role="presentation">
                                <button class="nav-link {{ $loop->first ? 'active' : '' }}"
                                        id="{{ $key }}-tab"
                                        data-bs-toggle="tab"
                                        data-bs-target="#lang-{{ $key }}"
                                        type="button">
                                    {{ $lang['name'] }}
                                </button>
                            </li>
                        @endforeach
                    </ul>

                    <div class="tab-content">
                        @foreach(config('language.supported') as $key => $lang)
                            <div class="tab-pane fade {{ $loop->first ? 'show active' : '' }}" id="lang-{{ $key }}">

                                {{-- استخدام translateOrNew لتجنب الأخطاء --}}
                                <div class="mb-3">
                                    <label class="form-label fw-bold">{{ __('dashboard.settings.site_name') }} ({{ $lang['name'] }})</label>
                                    <input type="text" class="form-control"
                                           name="{{ $key }}[site_name]"
                                           value="{{ $setting->translateOrNew($key)->site_name }}">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">{{ __('dashboard.settings.site_description') }} ({{ $lang['name'] }})</label>
                                    <textarea class="form-control" rows="3"
                                           name="{{ $key }}[site_description]">{{ $setting->translateOrNew($key)->site_description }}</textarea>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">{{ __('dashboard.settings.copyright') }} ({{ $lang['name'] }})</label>
                                    <input type="text" class="form-control"
                                           name="{{ $key }}[copyright]"
                                           value="{{ $setting->translateOrNew($key)->copyright }}">
                                </div>

                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- العمود الأيسر --}}
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">{{ __('dashboard.settings.site_logo') }}</h6>
                </div>
                <div class="card-body text-center">
                    @if($setting->site_logo)
                        <img src="{{ asset('storage/'.$setting->site_logo) }}" class="img-fluid mb-3 rounded border p-1" style="max-height: 100px;">
                    @else
                        <div class="bg-light border rounded p-3 text-muted mb-3">No Logo</div>
                    @endif
                    <input type="file" class="form-control form-control-sm" name="site_logo" accept="image/*">
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">إعدادات النظام</h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('dashboard.settings.site_email') }}</label>
                        <input type="email" class="form-control" name="site_email" value="{{ $setting->site_email }}">
                    </div>

                    <div class="form-check form-switch p-0 mt-4 border rounded p-3 d-flex justify-content-between align-items-center">
                        <label class="form-check-label ms-2 mb-0 fw-bold" for="maintenanceSwitch">
                            {{ __('dashboard.settings.maintenance_mode') }}
                        </label>
                        <input class="form-check-input ms-0" type="checkbox" id="maintenanceSwitch"
                               name="maintenance_mode" value="1"
                               {{ $setting->maintenance_mode ? 'checked' : '' }}>
                    </div>
                </div>
            </div>

            <div class="d-grid">
                <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-save me-2"></i> {{ __('dashboard.settings.save_settings') }}
                </button>
            </div>
        </div>
    </div>
</form>

@endsection
