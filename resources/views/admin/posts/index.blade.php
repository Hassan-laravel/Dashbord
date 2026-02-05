@extends('admin.layouts.app')

@section('title', __('dashboard.posts.title'))

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3">
        <div class="row align-items-center">
            <div class="col-md-3">
                <h5 class="mb-0 fw-bold">{{ __('dashboard.posts.list') }}</h5>
            </div>
            <div class="col-md-9 text-end">
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-lg"></i> {{ __('dashboard.posts.add_new') }}
                </a>
            </div>
        </div>

        {{-- ============ Filters Section ============ --}}
        <div class="row mt-4 g-2">
            {{-- 1. Search by Title --}}
            <div class="col-md-4">
                <div class="input-group">
                    <span class="input-group-text bg-light border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="filterSearch" class="form-control border-start-0"
                           placeholder="{{ __('dashboard.general.search_placeholder') }}">
                </div>
            </div>

            {{-- 2. Category Filter --}}
            <div class="col-md-3">
                <select id="filterCategory" class="form-select">
                    <option value="">{{ __('dashboard.categories.all') }}</option>
                    @foreach($categories as $cat)
                        {{-- Name is displayed based on current application locale --}}
                        <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- 3. Status Filter --}}
            <div class="col-md-3">
                <select id="filterStatus" class="form-select">
                    <option value="">{{ __('dashboard.general.all_statuses') }}</option>
                    <option value="published">{{ __('dashboard.posts.status_published') }}</option>
                    <option value="draft">{{ __('dashboard.posts.status_draft') }}</option>
                </select>
            </div>

            {{-- Reset Button --}}
            <div class="col-md-2">
                <button type="button" class="btn btn-light w-100 border" onclick="resetFilters()">
                    <i class="bi bi-arrow-counterclockwise"></i> {{ __('dashboard.general.reset') }}
                </button>
            </div>
        </div>
        {{-- ========================================== --}}
    </div>

    <div class="card-body p-0">
        {{-- Loading Spinner --}}
        <div id="loadingSpinner" class="text-center py-5 d-none">
            <div class="spinner-border text-primary" role="status"></div>
            <p class="mt-2 text-muted">{{ __('dashboard.general.loading') }}</p>
        </div>

        <table class="table table-hover align-middle mb-0" id="postsTable">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>{{ __('dashboard.general.image') }}</th>
                    <th>{{ __('dashboard.posts.article_title') }}</th>
                    <th>{{ __('dashboard.categories.title') }}</th>
                    <th>{{ __('dashboard.posts.author') }}</th>
                    <th>{{ __('dashboard.general.status') }}</th>
                    <th>{{ __('dashboard.general.created_at') }}</th>
                    <th>{{ __('dashboard.general.actions') }}</th>
                </tr>
            </thead>
            {{-- Include partial file for table rows --}}
            <tbody id="tableBody">
                @include('admin.posts.partials.table_rows')
            </tbody>
        </table>
    </div>

    {{-- Pagination Area --}}
    <div class="card-footer bg-white" id="paginationLinks">
        {{ $posts->links() }}
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Elements Definition
    const filterSearch = document.getElementById('filterSearch');
    const filterCategory = document.getElementById('filterCategory');
    const filterStatus = document.getElementById('filterStatus');
    const tableBody = document.getElementById('tableBody');
    const paginationLinks = document.getElementById('paginationLinks');
    const loadingSpinner = document.getElementById('loadingSpinner');
    const postsTable = document.getElementById('postsTable');

    /**
     * Data Fetching Function (AJAX)
     * @param {number} page
     */
    function fetchPosts(page = 1) {
        // Show loader and reduce table opacity
        loadingSpinner.classList.remove('d-none');
        postsTable.style.opacity = '0.5';

        const params = new URLSearchParams({
            page: page,
            search: filterSearch.value,
            category_id: filterCategory.value,
            status: filterStatus.value
        });

        // Note: The URL is static, but returned data depends on the session locale
        fetch(`{{ route('admin.posts.index') }}?${params.toString()}`, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            tableBody.innerHTML = data.html;
            paginationLinks.innerHTML = data.pagination;
        })
        .catch(error => console.error('Error:', error))
        .finally(() => {
            loadingSpinner.classList.add('d-none');
            postsTable.style.opacity = '1';
        });
    }

    // Event Listeners
    filterCategory.addEventListener('change', () => fetchPosts());
    filterStatus.addEventListener('change', () => fetchPosts());

    let debounceTimer;
    filterSearch.addEventListener('keyup', () => {
        clearTimeout(debounceTimer);
        debounceTimer = setTimeout(() => {
            fetchPosts();
        }, 500);
    });

    // Handle AJAX Pagination clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('#paginationLinks a')) {
            e.preventDefault();
            let href = e.target.closest('a').getAttribute('href');
            if(href) {
                let page = new URL(href).searchParams.get('page');
                fetchPosts(page);
            }
        }
    });

    function resetFilters() {
        filterSearch.value = '';
        filterCategory.value = '';
        filterStatus.value = '';
        fetchPosts();
    }
</script>
@endpush
