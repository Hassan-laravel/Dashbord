@extends('admin.layouts.app')

@section('title', __('dashboard.users.title'))
@section('header_title', __('dashboard.users.list'))

@section('content')

<div class="card shadow-sm border-0">
    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fw-bold text-secondary">
            <i class="bi bi-person-badge me-2"></i> {{ __('dashboard.users.title') }}
        </h5>
        <button type="button" class="btn btn-primary" onclick="openAddModal()">
            <i class="bi bi-person-plus-fill"></i> {{ __('dashboard.users.add_user') }}
        </button>
    </div>

    <div class="card-body p-0">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="table-light">
                    <tr>
                        <th>{{ __('dashboard.users.name') }}</th>
                        <th>{{ __('dashboard.users.email') }}</th>
                        <th>{{ __('dashboard.users.role') }}</th>
                        <th>{{ __('dashboard.general.created_at') }}</th>
                        <th class="text-end">{{ __('dashboard.general.actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($users as $user)
                    <tr>
                        <td>
                            <div class="d-flex align-items-center">
                                <div class="bg-primary bg-opacity-10 text-primary rounded-circle me-2 d-flex justify-content-center align-items-center fw-bold" style="width: 35px; height: 35px;">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>
                                <span class="fw-bold">{{ $user->name }}</span>
                            </div>
                        </td>
                        <td>{{ $user->email }}</td>
                        <td>
                            @foreach($user->roles as $role)
                                <span class="badge bg-info text-dark">{{ $role->name }}</span>
                            @endforeach
                        </td>
                        <td>{{ $user->created_at->format('Y-m-d') }}</td>
                        <td class="text-end">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-light text-primary" onclick="editUser({{ $user->id }})" title="{{ __('dashboard.general.edit') }}">
                                    <i class="bi bi-pencil-square"></i>
                                </button>

                                @if(auth()->id() != $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="d-inline" onsubmit="return confirm('{{ __('dashboard.general.confirm_delete_msg') }}')">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-light text-danger" title="{{ __('dashboard.general.delete') }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </form>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="5" class="text-center py-4 text-muted">{{ __('dashboard.general.no_data') }}</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
    <div class="card-footer bg-white">{{ $users->links() }}</div>
</div>

{{-- مودال الإضافة والتعديل --}}
<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">{{ __('dashboard.users.modal_title') }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="userForm" method="POST">
                    @csrf
                    <input type="hidden" name="_method" id="formMethod" value="POST">

                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.users.name') }}</label>
                        <input type="text" class="form-control" name="name" id="userName" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">{{ __('dashboard.users.email') }}</label>
                        <input type="email" class="form-control" name="email" id="userEmail" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('dashboard.users.password') }}</label>
                            <input type="password" class="form-control" name="password" id="userPassword" autocomplete="new-password" placeholder="{{ __('dashboard.users.password_placeholder') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">{{ __('dashboard.users.password_confirm') }}</label>
                            <input type="password" class="form-control" name="password_confirmation" id="userPasswordConfirm">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">{{ __('dashboard.users.select_role') }}</label>
                        <div class="d-flex gap-3">
                            @foreach($roles as $roleName)
                            <div class="form-check">
                                <input class="form-check-input role-radio" type="radio" name="role" id="role_{{ $roleName }}" value="{{ $roleName }}" required>
                                <label class="form-check-label" for="role_{{ $roleName }}">{{ $roleName }}</label>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="modal-footer px-0 pb-0">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('dashboard.general.close') }}</button>
                        <button type="submit" class="btn btn-primary">{{ __('dashboard.general.save') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    function openAddModal() {
        document.getElementById('userForm').reset();
        document.getElementById('userPassword').value = '';
        document.getElementById('userPasswordConfirm').value = '';
        document.getElementById('formMethod').value = 'POST';
        document.getElementById('userForm').action = "{{ route('admin.users.store') }}";
        document.getElementById('modalTitle').innerText = "{{ __('dashboard.users.add_user') }}";
        new bootstrap.Modal(document.getElementById('userModal')).show();
    }

    function editUser(id) {
        let url = "{{ route('admin.users.edit', ':id') }}".replace(':id', id);
        fetch(url)
            .then(response => response.json())
            .then(data => {
                document.getElementById('userName').value = data.user.name;
                document.getElementById('userEmail').value = data.user.email;
                document.getElementById('userPassword').value = '';
                document.getElementById('userPasswordConfirm').value = '';

                let radios = document.getElementsByClassName('role-radio');
                for(let i=0; i<radios.length; i++) {
                    radios[i].checked = (radios[i].value == data.role);
                }

                document.getElementById('formMethod').value = 'PUT';
                let updateUrl = "{{ route('admin.users.update', 'PLACEHOLDER') }}".replace('PLACEHOLDER', id);
                document.getElementById('userForm').action = updateUrl;
                document.getElementById('modalTitle').innerText = "{{ __('dashboard.users.edit_user') }}";
                new bootstrap.Modal(document.getElementById('userModal')).show();
            });
    }
</script>
@endpush
