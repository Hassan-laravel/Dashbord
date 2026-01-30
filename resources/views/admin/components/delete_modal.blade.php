<div class="modal fade" id="deleteModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">{{ __('dashboard.general.confirm_delete_title') }}</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p class="mb-0 fs-5">{{ __('dashboard.general.confirm_delete_msg') }}</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">{{ __('dashboard.general.cancel') }}</button>
                <button type="button" class="btn btn-danger">{{ __('dashboard.general.confirm_delete_btn') }}</button>
            </div>
        </div>
    </div>
</div>
