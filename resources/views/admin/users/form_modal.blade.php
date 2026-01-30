<div class="modal fade" id="userModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">بيانات المستخدم</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="user-form">
                    <div class="mb-3">
                        <label class="form-label">الاسم الكامل</label>
                        <input type="text" class="form-control" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">البريد الإلكتروني</label>
                        <input type="email" class="form-control" name="email" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">كلمة المرور</label>
                            <input type="password" class="form-control" name="password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label">تأكيد كلمة المرور</label>
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label fw-bold d-block">تعيين الدور (Role)</label>
                        <div class="text-muted small mb-2">اختر الصلاحيات التي ستمنح لهذا العضو:</div>

                        <div class="d-flex gap-3">
                            {{-- هذه الخيارات ستأتي ديناميكياً من قاعدة البيانات --}}
                            <div class="form-check card-radio">
                                <input class="form-check-input" type="radio" name="role" id="role1" value="admin">
                                <label class="form-check-label" for="role1">
                                    <strong>Admin</strong>
                                    <span class="d-block small text-muted">كامل الصلاحيات</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role2" value="editor" checked>
                                <label class="form-check-label" for="role2">
                                    <strong>Editor</strong>
                                    <span class="d-block small text-muted">كتابة وتعديل المقالات فقط</span>
                                </label>
                            </div>

                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="role" id="role3" value="viewer">
                                <label class="form-check-label" for="role3">
                                    <strong>Viewer</strong>
                                    <span class="d-block small text-muted">مشاهدة فقط</span>
                                </label>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
                <button type="button" class="btn btn-primary">حفظ المستخدم</button>
            </div>
        </div>
    </div>
</div>
