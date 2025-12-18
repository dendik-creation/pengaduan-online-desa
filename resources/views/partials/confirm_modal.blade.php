{{-- 
    Reusable Confirmation Modal
    
    Usage:
    @include('partials.confirm_modal', [
        'modal_id' => 'deleteModal',
        'modal_title' => 'Konfirmasi Hapus',
        'modal_description' => 'Apakah Anda yakin ingin menghapus data ini?',
        'form_action' => '#',
        'form_method' => 'DELETE',
        'confirm_button_text' => 'Hapus',
        'confirm_button_class' => 'btn-danger',
        'cancel_button_text' => 'Batal'
    ])
--}}

<div class="modal fade" id="{{ $modal_id ?? 'confirmModal' }}" tabindex="-1" role="dialog" aria-labelledby="{{ $modal_id ?? 'confirmModal' }}Label" aria-hidden="true">
    <div class="modal-dialog {{ $modal_size ?? '' }}" role="document">
        <div class="modal-content shadow">
            <div class="modal-header {{ $header_class ?? 'bg-warning text-white' }}">
                <h5 class="modal-title font-weight-bold" id="{{ $modal_id ?? 'confirmModal' }}Label">
                    <i class="{{ $title_icon ?? 'fas fa-exclamation-triangle' }} mr-2"></i>
                    {{ $modal_title ?? 'Konfirmasi' }}
                </h5>
                <button type="button" class="close {{ isset($header_class) && str_contains($header_class, 'text-white') ? 'text-white' : '' }}" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="text-center mb-3">
                    <i class="{{ $body_icon ?? 'fas fa-question-circle fa-3x text-warning' }}"></i>
                </div>
                <p class="text-center mb-3">
                    {!! $modal_description ?? 'Apakah Anda yakin ingin melanjutkan?' !!}
                </p>
                @if(isset($additional_info))
                    <div class="alert alert-info border-left-info">
                        <div class="text-info">
                            <i class="fas fa-info-circle mr-2"></i>
                            {!! $additional_info !!}
                        </div>
                    </div>
                @endif
            </div>
            <div class="modal-footer border-0 justify-content-center">
                <button type="button" class="btn btn-light mr-2" data-dismiss="modal">
                    <i class="fas fa-times mr-1"></i>
                    {{ $cancel_button_text ?? 'Batal' }}
                </button>
                <form id="{{ $modal_id ?? 'confirmModal' }}Form" method="POST" action="{{ $form_action ?? '#' }}" style="display: inline;">
                    @csrf
                    @if(isset($form_method) && strtoupper($form_method) !== 'POST')
                        @method($form_method)
                    @endif
                    <button type="submit" class="btn {{ $confirm_button_class ?? 'btn-danger' }}">
                        <i class="{{ $confirm_button_icon ?? 'fas fa-check' }} mr-1"></i>
                        {{ $confirm_button_text ?? 'Konfirmasi' }}
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

@if(isset($auto_script) && $auto_script)
<script>
$(document).ready(function() {
    // Auto-configure modal for dynamic content
    window.showConfirmModal = function(options = {}) {
        const modal = $('#{{ $modal_id ?? "confirmModal" }}');
        const form = $('#{{ $modal_id ?? "confirmModal" }}Form');
        
        // Update form action if provided
        if (options.action) {
            form.attr('action', options.action);
        }
        
        // Update description if provided
        if (options.description) {
            modal.find('.modal-body p').html(options.description);
        }
        
        // Show modal
        modal.modal('show');
    };
});
</script>
@endif