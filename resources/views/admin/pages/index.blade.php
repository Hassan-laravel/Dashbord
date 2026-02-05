@extends('admin.layouts.app')
@section('title', __('dashboard.pages.list'))
@section('content')

    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
            <h5 class="mb-0 fw-bold text-secondary">{{ __('dashboard.pages.list') }}</h5>
            <a href="{{ route('admin.pages.create') }}" class="btn btn-primary">{{ __('dashboard.pages.add_new') }}</a>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('dashboard.general.image') }}</th>
                        <th>{{ __('dashboard.pages.page_title') }}</th>
                        <th>{{ __('dashboard.general.status') }}</th>
                        <th class="text-end">{{ __('dashboard.general.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pages as $page)
                        <tr>
                            <td>
                                @if ($page->image)
                                    <img src="{{ Storage::disk('gcs')->url($page->image) }}" width="50" class="rounded">
                                @else
                                    <div class="bg-light rounded text-center" style="width: 50px; height: 35px; line-height: 35px;">
                                        <i class="bi bi-image text-muted"></i>
                                    </div>
                                @endif
                            </td>
                            <td>
                                <span class="fw-bold">{{ $page->title }}</span>
                                <div class="small text-muted">{{ $page->slug }}</div>
                            </td>
                            <td>
                                @if ($page->status == 'published')
                                    <span class="badge bg-success">{{ __('dashboard.posts.status_published') }}</span>
                                @else
                                    <span class="badge bg-secondary">{{ __('dashboard.posts.status_draft') }}</span>
                                @endif
                            </td>
                            <td class="text-end">
                                <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-sm btn-light">
                                    <i class="bi bi-pencil-square"></i>
                                </a>
                                <div class="d-inline-block">
                                    <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST"
                                        onsubmit="return confirm('{{ __('dashboard.general.confirm_delete') }}')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4 text-muted">
                                {{ __('dashboard.general.no_records_found') }}
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if($pages->hasPages())
            <div class="card-footer bg-white">
                {{ $pages->links() }}
            </div>
        @endif
    </div>
@endsection
