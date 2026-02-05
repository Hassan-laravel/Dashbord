@extends('admin.layouts.app')

@section('title', __('dashboard.pages.add_new'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<form action="{{ route('admin.pages.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        {{-- Main Column (Content) --}}
        <div class="col-lg-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    @php $currentLang = app()->getLocale(); @endphp

                    {{-- Language Alert --}}
                    <div class="alert alert-info py-2 small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        {{ __('dashboard.general.entry_language') }}
                        <strong>{{ config('language.supported.'.$currentLang.'.name') }}</strong>
                    </div>

                    {{-- Title --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-5">{{ __('dashboard.pages.page_title') }}</label>
                        <input type="text" class="form-control form-control-lg"
                               name="{{ $currentLang }}[title]"
                               id="pageTitle"
                               onkeyup="handleTitleChange(this.value)"
                               value="{{ old($currentLang.'.title') }}"
                               required>
                    </div>

                    {{-- Content --}}
                    <div class="mb-3">
                        <textarea id="summernote" name="{{ $currentLang }}[content]">{{ old($currentLang.'.content') }}</textarea>
                    </div>
                </div>
            </div>

            {{-- SEO --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.seo_section') }}</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.slug') }}</label>
                        <input type="text" class="form-control bg-light" name="{{ $currentLang }}[slug]" id="pageSlug" value="{{ old($currentLang.'.slug') }}">
                        <div class="form-text text-muted small">{{ __('dashboard.general.auto_generated') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.meta_title') }}</label>
                        <input type="text" class="form-control" name="{{ $currentLang }}[meta_title]" id="pageMetaTitle" value="{{ old($currentLang.'.meta_title') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.meta_description') }}</label>
                        <textarea class="form-control" name="{{ $currentLang }}[meta_description]" id="pageMetaDesc" rows="2">{{ old($currentLang.'.meta_description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-3">
            {{-- Publish --}}
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.publish_section') }}</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.posts.status') }}</label>
                        <select class="form-select" name="status">
                            <option value="published">{{ __('dashboard.posts.status_published') }}</option>
                            <option value="draft">{{ __('dashboard.posts.status_draft') }}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i> {{ __('dashboard.general.save') }}
                    </button>
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.pages.featured_image') }}</div>
                <div class="card-body text-center">
                    <img id="featured-preview" src="https://via.placeholder.com/300x200?text=Upload" class="img-fluid mb-2 rounded border">
                    <input type="file" class="form-control form-control-sm mt-2" name="image" accept="image/*" onchange="previewImage(this, 'featured-preview')">
                </div>
            </div>
        </div>
    </div>
</form>

@endsection

@push('scripts')
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $('#summernote').summernote({
        placeholder: 'Page content...',
        tabsize: 2,
        height: 350
    });

    function previewImage(input, imgId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) { document.getElementById(imgId).src = e.target.result; }
            reader.readAsDataURL(input.files[0]);
        }
    }

    function handleTitleChange(text) {
        // Generates a slug while supporting Arabic/Multi-lang characters
        let slug = text.trim().replace(/\s+/g, '-').replace(/[^\w\u0621-\u064A-]/g, '');
        document.getElementById('pageSlug').value = slug;
        document.getElementById('pageMetaTitle').value = text;
        if (text.trim() !== '') {
            document.getElementById('pageMetaDesc').value = text.trim().replace(/\s+/g, ',');
        }
    }
</script>
@endpush
