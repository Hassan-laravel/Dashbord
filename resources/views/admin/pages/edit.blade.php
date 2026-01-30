@extends('admin.layouts.app')

@section('title', __('dashboard.pages.edit_page'))

@section('content')

{{-- استدعاء مكتبة المحرر النصي --}}
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">

<form action="{{ route('admin.pages.update', $page->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT') {{-- ضروري لعملية التحديث --}}

    <div class="row">
        {{-- العمود الرئيسي (المحتوى) --}}
        <div class="col-lg-9">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    @php
                        $currentLang = app()->getLocale();
                        // نستخدم translateOrNew لتجنب الأخطاء إذا كانت الترجمة غير موجودة لهذه اللغة بعد
                        $translation = $page->translateOrNew($currentLang);
                    @endphp

                    {{-- تنبيه اللغة الحالية --}}
                    <div class="alert alert-info py-2 small mb-3">
                        <i class="bi bi-info-circle me-1"></i>
                        {{ __('dashboard.general.entry_language') }}
                        <strong>{{ config('language.supported.'.$currentLang.'.name') }}</strong>
                    </div>

                    {{-- عنوان الصفحة --}}
                    <div class="mb-3">
                        <label class="form-label fw-bold fs-5">{{ __('dashboard.pages.page_title') }}</label>
                        <input type="text" class="form-control form-control-lg"
                               name="{{ $currentLang }}[title]"
                               id="pageTitle"
                               {{-- ملاحظة: في التعديل يفضل عدم تغيير الرابط تلقائياً للحفاظ على SEO، لذا أزلنا onkeyup --}}
                               {{-- يمكنك إعادتها إذا أردت: onkeyup="handleTitleChange(this.value)" --}}
                               value="{{ old($currentLang.'.title', $translation->title) }}"
                               required>
                    </div>

                    {{-- المحتوى --}}
                    <div class="mb-3">
                        <textarea id="summernote" name="{{ $currentLang }}[content]">{{ old($currentLang.'.content', $translation->content) }}</textarea>
                    </div>
                </div>
            </div>

            {{-- قسم SEO --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.posts.seo_section') }}</div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.slug') }}</label>
                        <input type="text" class="form-control bg-light"
                               name="{{ $currentLang }}[slug]"
                               id="pageSlug"
                               value="{{ old($currentLang.'.slug', $translation->slug) }}">
                        <div class="form-text text-muted small">{{ __('dashboard.general.auto_generated') }}</div>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.meta_title') }}</label>
                        <input type="text" class="form-control"
                               name="{{ $currentLang }}[meta_title]"
                               id="pageMetaTitle"
                               value="{{ old($currentLang.'.meta_title', $translation->meta_title) }}">
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.categories.meta_description') }}</label>
                        <textarea class="form-control"
                                  name="{{ $currentLang }}[meta_description]"
                                  id="pageMetaDesc"
                                  rows="2">{{ old($currentLang.'.meta_description', $translation->meta_description) }}</textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- العمود الجانبي --}}
        <div class="col-lg-3">
            {{-- حالة النشر --}}
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

                    {{-- معلومات الإضافة والتعديل --}}
                    <div class="mb-3 small text-muted border-top pt-2">
                        <div><i class="bi bi-calendar3"></i> أنشئت: {{ $page->created_at->format('Y-m-d') }}</div>
                        <div><i class="bi bi-clock"></i> آخر تعديل: {{ $page->updated_at->diffForHumans() }}</div>
                    </div>

                    <button type="submit" class="btn btn-primary w-100">
                        <i class="bi bi-arrow-repeat me-1"></i> {{ __('dashboard.general.update') }}
                    </button>
                </div>
            </div>

            {{-- الصورة البارزة --}}
            <div class="card shadow-sm border-0 mb-3">
                <div class="card-header bg-white fw-bold">{{ __('dashboard.pages.featured_image') }}</div>
                <div class="card-body text-center">
                    @if($page->image)
                        <img id="featured-preview" src="{{ asset('storage/'.$page->image) }}" class="img-fluid mb-2 rounded border" style="max-height: 150px; width: 100%; object-fit: cover;">
                    @else
                        <img id="featured-preview" src="https://via.placeholder.com/300x200?text=No+Image" class="img-fluid mb-2 rounded border">
                    @endif

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
    // تفعيل المحرر النصي
    $('#summernote').summernote({
        placeholder: 'محتوى الصفحة...',
        tabsize: 2,
        height: 350
    });

    // معاينة الصورة قبل الرفع
    function previewImage(input, imgId) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) { document.getElementById(imgId).src = e.target.result; }
            reader.readAsDataURL(input.files[0]);
        }
    }

    // دالة توليد Slug (اختيارية في التعديل، يمكن استدعاؤها يدوياً إذا أردت)
    function handleTitleChange(text) {
        let slug = text.trim().replace(/\s+/g, '-').replace(/[^\w\u0621-\u064A-]/g, '');
        document.getElementById('pageSlug').value = slug;
    }
</script>
@endpush
