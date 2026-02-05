<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">User Data</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="user-form">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">Assign Role</label>
                        <div class="text-muted small mb-2">Select the permissions to be granted to this member:</div>

                        <div class="d-flex gap-3">
                            {{-- These options will be fetched dynamically from the database --}}
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="role" id="role1" value="admin">
                                <label class="form-check-label" for="role1">
                                    <strong>Admin</strong>
                                    <span class="d-block small text-muted">Full Permissions</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role2" value="editor" checked>
                                <label class="form-check-label" for="role2">
                                    <strong>Editor</strong>
                                    <span class="d-block small text-muted">Write and edit articles only</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role3" value="viewer">
                                <label class="form-check-label" for="role3">
                                    <strong>Viewer</strong>
                                    <span class="d-block small text-muted">View only</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save User</button>
            </div>
        </div>
    </div>
</div>
