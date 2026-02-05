@forelse($posts as $post)
    <tr>
        <td>{{ $posts->firstItem() + $loop->index }}</td> {{-- Sequential numbering based on pagination --}}
        <td>
            @if($post->image)
                <img src="{{ Storage::disk('gcs')->url($post->image) }}" width="50" class="rounded" alt="img">
            @else
                <span class="text-muted small">{{ __('dashboard.general.no_image') }}</span>
            @endif
        </td>
        <td>
            {{-- Note: $post->title is automatically translated based on the current app locale --}}
            <span class="fw-bold d-block">{{ $post->title }}</span>
            <span class="small text-muted">{{ $post->slug }}</span>
        </td>
        <td>
            @foreach($post->categories as $cat)
                {{-- Note: $cat->name is also automatically translated --}}
                <span class="badge bg-light text-dark border">{{ $cat->name }}</span>
            @endforeach
        </td>
        <td>{{ $post->author->name ?? __('dashboard.general.unknown') }}</td>
        <td>
            @if($post->status == 'published')
                <span class="badge bg-success">{{ __('dashboard.posts.status_published') }}</span>
            @else
                <span class="badge bg-secondary">{{ __('dashboard.posts.status_draft') }}</span>
            @endif
        </td>
        <td dir="ltr">{{ $post->created_at->format('Y-m-d') }}</td>
        <td>
            <a href="{{ route('admin.posts.edit', $post->id) }}" class="btn btn-sm btn-outline-primary" title="{{ __('dashboard.general.edit') }}">
                <i class="bi bi-pencil"></i>
            </a>

            {{-- Delete button (example) --}}
            <form action="{{ route('admin.posts.destroy', $post->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('{{ __('dashboard.messages.confirm_delete') }}')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-sm btn-outline-danger">
                    <i class="bi bi-trash"></i>
                </button>
            </form>
        </td>
    </tr>
@empty
    <tr>
        <td colspan="8" class="text-center py-5 text-muted">
            <i class="bi bi-search fs-1 d-block mb-2"></i>
            {{ __('dashboard.general.no_results') }}
        </td>
    </tr>
@endforelse
