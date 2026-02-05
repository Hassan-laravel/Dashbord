@extends('admin.layouts.app')

@section('title', __('dashboard.pages.edit_page'))

@section('content')

{{-- Import Text Editor Library --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data" id="pageForm">
    @csrf
    @method('PUT')

    <div class="row">
        {{-- Main Column (Content) --}}
        <div class="col-lg-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    @php
                        $currentLang = app()->getLocale();
                        $translation = $page->translateOrNew($currentLang);
                    @endphp

                    {{-- Current Locale Alert --}}
                    <div class="alert alert-info py-2 small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        {{ __('dashboard.general.entry_language') }}
                        <strong>{{ config('language.supported.'.$currentLang.'.name') }}</strong>
                    </div>

                    {{-- Page Title --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-5">{{ __('dashboard.pages.page_title') }}</label>
                        <input type="text"
                               class="form-control form-control-lg @error("$currentLang.title") is-invalid @enderror"
                               name="{{ $currentLang }}[title]"
                               id="pageTitle"
                               onkeyup="handleTitleChange(this.value)"
                               value="{{ old($currentLang.'.title', $translation->title) }}">
                        @error("$currentLang.title")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    {{-- Content --}}
                    <div class="mb-3">
                        <div class="@error("$currentLang.content") border border-danger rounded @enderror">
                            <textarea id="summernote" name="{{ $currentLang }}[content]">{{ old($currentLang.'.content', $translation->content) }}</textarea>
                        </div>
                        @error("$currentLang.content")
                            <div class="text-danger small mt-1">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>

            {{-- SEO Section --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.seo_section') }}</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">{{ __('dashboard.categories.slug') }}</label>
                        <input type="text"
                               class="form-control bg-light @error("$currentLang.slug") is-invalid @enderror"
                               name="{{ $currentLang }}[slug]"
                               id="pageSlug"
                               value="{{ old($currentLang.'.slug', $translation->slug) }}">
                        <div class="form-text text-muted small">{{ __('dashboard.general.auto_generated') }}</div>
                        @error("$currentLang.slug")
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.meta_title') }}</label>
                        <input type="text" class="form-control"
                               name="{{ $currentLang }}[meta_title]"
                               value="{{ old($currentLang.'.meta_title', $translation->meta_title) }}">
                    </div>

                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.meta_description') }}</label>
                        <textarea class="form-control"
                                  name="{{ $currentLang }}[meta_description]"
                                  rows="2">{{ old($currentLang.'.meta_description', $translation->meta_description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-lg-3">
            {{-- Publish Section --}}
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.publish_section') }}</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.posts.status') }}</label>
                        <select class="form-select" name="status">
                            <option value="published" {{ old('status', $page->status) == 'published' ? 'selected' : '' }}>{{ __('dashboard.posts.status_published') }}</option>
                            <option value="draft" {{ old('status', $page->status) == 'draft' ? 'selected' : '' }}>{{ __('dashboard.posts.status_draft') }}</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-repeat me-1"></i> {{ __('dashboard.general.update') }}
                    </button>
                </div>
            </div>

            {{-- Featured Image --}}
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.pages.featured_image') }}</div>
                <div class="card-body text-center">
                    <img id="featured-preview"
                         src="{{ $page->image ? Storage::disk('gcs')->url($page->image) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                         class="img-fluid mb-2 rounded border"
                         style="max-height: 150px; width: 100%; object-fit: cover;">
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
    $(document).ready(function() {
        $('#summernote').summernote({
            placeholder: "{{ __('dashboard.pages.content') }}",
            tabsize: 2,
            height: 350
        });
    });

    function previewImage(input, imgId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) { document.getElementById(imgId).src = e.target.result; }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Professional Slug generation supporting Arabic characters
    function handleTitleChange(text) {
        let slug = text.trim()
            .toLowerCase()
            .replace(/\s+/g, '-')
            .replace(/[^\w\u0621-\u064A-]/g, '');
        document.getElementById('pageSlug').value = slug;
        document.getElementById('pageSlug').classList.remove('is-invalid');
    }

    // Enhanced Validation System
    document.getElementById('pageForm').addEventListener('submit', function(e) {
        let isValid = true;

        const msgTitle = @json(__('dashboard.validation.title_required'));
        const msgSlug = @json(__('dashboard.validation.slug_required'));
        const msgContent = @json(__('dashboard.validation.content_required'));

        // 1. Title Validation
        const titleInput = document.getElementById('pageTitle');
        if (titleInput.value.trim() === '') {
            titleInput.classList.add('is-invalid');
            isValid = false;
        }

        // 2. Slug Validation (Prevents SQL duplicate/empty errors)
        const slugInput = document.getElementById('pageSlug');
        if (slugInput.value.trim() === '') {
            slugInput.classList.add('is-invalid');

            let feedback = slugInput.nextElementSibling;
            if (!feedback || !feedback.classList.contains('invalid-feedback')) {
                slugInput.insertAdjacentHTML('afterend', `<div class="invalid-feedback">${msgSlug}</div>`);
            }
            alert(msgSlug);
            isValid = false;
        }

        // 3. Content Validation (Summernote check)
        if ($('#summernote').summernote('isEmpty')) {
            $('.note-editor').addClass('border-danger');
            alert(msgContent);
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
            window.scrollTo(0, 0);
        }
    });
</script>
@endpush
