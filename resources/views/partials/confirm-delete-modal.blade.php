{{-- Modal Konfirmasi Hapus (global) --}}
<div class="modal fade" id="confirmDeleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">
                    <i class="fas fa-exclamation-triangle"></i> Konfirmasi Hapus
                </h5>
                <button type="button" class="close text-white" data-dismiss="modal">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="mb-0" id="confirmDeleteMessage">
                    Apakah Anda yakin ingin menghapus data ini?
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                    <i class="fas fa-times"></i> Batal
                </button>
                <form id="confirmDeleteForm" method="POST" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">
                        <i class="fas fa-trash"></i> Ya, Hapus
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
    $('#confirmDeleteModal').on('show.bs.modal', function (event) {
        var button  = $(event.relatedTarget);
        var action  = button.data('action');
        var message = button.data('message') || 'Apakah Anda yakin ingin menghapus data ini?';

        $('#confirmDeleteForm').attr('action', action);
        $('#confirmDeleteMessage').text(message);
    });
});
</script>