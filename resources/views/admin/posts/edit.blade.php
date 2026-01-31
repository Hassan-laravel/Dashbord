@extends('admin.layouts.app')

@section('title', __('dashboard.posts.edit_post'))

@section('content')

<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<form action="{{ route('admin.posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
    @csrf @method('PUT')

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
                        <input type="text" class="form-control form-control-lg" name="{{ $currentLang }}[title]" id="postTitle" onkeyup="handleTitleChange(this.value)" value="{{ old($currentLang.'.title', $post->translate($currentLang)->title ?? '') }}" required>
                    </div>

                    <div class="mb-3">
                        <textarea id="summernote" name="{{ $currentLang }}[content]">{{ old($currentLang.'.content', $post->translate($currentLang)->content ?? '') }}</textarea>
                    </div>

                    <div class="mb-3">
                        <label class="form-label"><i class="bi bi-youtube text-danger"></i> {{ __('dashboard.posts.youtube_link') }}</label>
                        <input type="url" class="form-control" name="youtube_link" value="{{ old('youtube_link', $post->youtube_link) }}">
                    </div>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.seo_section') }}</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.slug') }}</label>
                        <input type="text" class="form-control bg-light" name="{{ $currentLang }}[slug]" id="postSlug" value="{{ old($currentLang.'.slug', $post->translate($currentLang)->slug ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.meta_title') }}</label>
                        <input type="text" class="form-control" name="{{ $currentLang }}[meta_title]" id="postMetaTitle" value="{{ old($currentLang.'.meta_title', $post->translate($currentLang)->meta_title ?? '') }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.meta_description') }}</label>
                        <textarea class="form-control" name="{{ $currentLang }}[meta_description]" id="postMetaDesc" rows="2">{{ old($currentLang.'.meta_description', $post->translate($currentLang)->meta_description ?? '') }}</textarea>
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
                            <option value="published" {{ old('status', $post->status) == 'published' ? 'selected' : '' }}>{{ __('dashboard.posts.status_published') }}</option>
                            <option value="draft" {{ old('status', $post->status) == 'draft' ? 'selected' : '' }}>{{ __('dashboard.posts.status_draft') }}</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-repeat me-1"></i> {{ __('dashboard.posts.update_btn') }}
                    </button>
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.categories_section') }}</div>
                <div class="card-body" style="max-height: 250px; overflow-y: auto;">
                    @php $selectedCats = $post->categories->pluck('id')->toArray(); @endphp
                    @foreach($categories as $category)
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="categories[]" value="{{ $category->id }}" id="cat{{ $category->id }}" {{ (in_array($category->id, old('categories', $selectedCats))) ? 'checked' : '' }}>
                        <label class="form-check-label" for="cat{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                    @endforeach
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.featured_image') }}</div>
                <div class="card-body text-center">
                    @if($post->image)
                        <img id="featured-preview" src="{{ Storage::disk('gcs')->url($post->image) }}" class="img-fluid mb-2 rounded border" style="max-height: 150px; width: 100%; object-fit: cover;">
                    @else
                        <img id="featured-preview" src="https://via.placeholder.com/300x200?text=No+Image" class="img-fluid mb-2 rounded border">
                    @endif
                    <input type="file" class="form-control form-control-sm mt-2" name="image" accept="image/*" onchange="previewImage(this, 'featured-preview')">
                </div>
            </div>

            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.gallery') }}</div>
                <div class="card-body">
                    @if($post->images->count() > 0)
                    <div class="d-flex flex-wrap gap-2 mb-3">
                        @foreach($post->images as $img)
                            <div class="position-relative">
                                <img src="{{ Storage::disk('gcs')->url($img->image_path) }}" width="60" height="60" class="rounded border" style="object-fit: cover">
                            </div>
                        @endforeach
                    </div>
                    <hr>
                    @endif
                    <label class="form-label small">{{ __('dashboard.posts.select_multiple') }}:</label>
                    <input type="file" class="form-control form-control-sm" name="gallery[]" multiple accept="image/*">
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
    function handleTitleChange(text) { let slug = text.trim().replace(/\s+/g, '-').replace(/[^\w\u0621-\u064A-]/g, ''); document.getElementById('postSlug').value = slug; }
</script>
@endpush
