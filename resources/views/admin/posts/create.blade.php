@extends('admin.layouts.app')

@section('title', __('dashboard.posts.add_new'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<form action="{{ route('admin.posts.store') }}" method="POST" enctype="multipart/form-data">
    @csrf

    <div class="row">
        <div class="col-lg-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    @php $currentLang = app()->getLocale(); @endphp

                    <div class="alert alert-info py-2 small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        {{ __('dashboard.general.entry_language') }}
                        <strong>{{ config('language.supported.'.$currentLang.'.name') }}</strong>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold fs-5">{{ __('dashboard.posts.article_title') }}</label>
                        <input type="text" class="form-control form-control-lg" name="{{ $currentLang }}[title]" id="postTitle" placeholder="{{ __('dashboard.posts.article_title_placeholder') }}" onkeyup="handleTitleChange(this.value)" value="{{ old($currentLang.'.title') }}" required>
                    </div>

                    <div class="mb-3">
                        <textarea id="summernote" name="{{ $currentLang }}[content]">{{ old($currentLang.'.content') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-youtube text-danger"></i> {{ __('dashboard.posts.youtube_link') }}</label>
                        <input type="url" class="form-control" name="youtube_link" value="{{ old('youtube_link') }}">
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.seo_section') }}</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.slug') }}</label>
                        <input type="text" class="form-control bg-light" name="{{ $currentLang }}[slug]" id="postSlug" value="{{ old($currentLang.'.slug') }}">
                        <div class="form-text text-muted small">{{ __('dashboard.general.auto_generated') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.meta_title') }}</label>
                        <input type="text" class="form-control" name="{{ $currentLang }}[meta_title]" id="postMetaTitle" value="{{ old($currentLang.'.meta_title') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.meta_description') }}</label>
                        <textarea class="form-control" name="{{ $currentLang }}[meta_description]" id="postMetaDesc" rows="2">{{ old($currentLang.'.meta_description') }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3">
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.publish_section') }}</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.posts.status') }}</label>
                        <select class="form-select" name="status">
                            <option value="published" {{ old('status') == 'published' ? 'selected' : '' }}>{{ __('dashboard.posts.status_published') }}</option>
                            <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>{{ __('dashboard.posts.status_draft') }}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-save me-1"></i> {{ __('dashboard.posts.save_btn') }}
                    </button>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.categories_section') }}</div>
                <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                    @if($categories->count() > 0)
                        @foreach($categories as $category)
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat{{ $category->id }}" {{ (is_array(old('categories')) && in_array($category->id, old('categories'))) ? 'checked' : '' }}>
                            <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->name }}</label>
                        </div>
                        @endforeach
                    @else
                        <p class="text-muted small text-center mb-0">{{ __('dashboard.posts.no_categories') }}</p>
                    @endif
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.featured_image') }}</div>
                <div class="card-body text-center">
                    <img id="featured-preview" src="https://via.placeholder.com/300x200?text=Upload" class="img-fluid mb-2 rounded border" style="max-height: 150px; width: 100%; object-fit: cover;">
                    <input type="file" class="form-control form-control-sm" name="image" accept="image/*" onchange="previewImage(this, 'featured-preview')">
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.gallery') }}</div>
                <div class="card-body">
                    <input type="file" class="form-control form-control-sm" name="gallery[]" multiple accept="image/*">
                    <small class="text-muted d-block mt-1">{{ __('dashboard.posts.gallery_help') }}</small>
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
        placeholder: "{{ __('dashboard.posts.content_placeholder') }}",
        tabsize: 2,
        height: 350,
        toolbar: [['style', ['style']], ['font', ['bold', 'underline', 'clear']], ['color', ['color']], ['para', ['ul', 'ol', 'paragraph']], ['table', ['table']], ['insert', ['link', 'picture', 'video']], ['view', ['fullscreen', 'codeview', 'help']]]
    });
    function previewImage(input, imgId) { if (input.files && input.files[0]) { var reader = new FileReader(); reader.onload = function(e) { document.getElementById(imgId).src = e.target.result; }; reader.readAsDataURL(input.files[0]); } }
    function handleTitleChange(text) {
        let slug = text.trim().replace(/\s+/g, '-').replace(/[^\w\u0621-\u064A-]/g, '');
        document.getElementById('postSlug').value = slug;
        document.getElementById('postMetaTitle').value = text;
        if (text.trim() !== '') { document.getElementById('postMetaDesc').value = text.trim().replace(/\s+/g, ','); } else { document.getElementById('postMetaDesc').value = ''; }
    }
</script>
@endpush
