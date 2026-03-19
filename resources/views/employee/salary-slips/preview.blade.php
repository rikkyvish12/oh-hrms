<div class="modal fade" id="previewModal" tabindex="-1">
    <div class="modal-dialog modal-lg modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Salary Slip Preview - {{ $salarySlip->formatted_month_year }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                @include('admin.salary-slips._slip_preview', ['salarySlip' => $salarySlip])
            </div>
            <div class="modal-footer">
                <a href="{{ route('employee.salary-slips.download', $salarySlip->id) }}" 
                   class="btn btn-success" target="_blank">
                    <i class="fas fa-download"></i> Download PDF
                </a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<script>
// Auto-show modal on load
document.addEventListener('DOMContentLoaded', function() {
    var previewModal = new bootstrap.Modal(document.getElementById('previewModal'));
    previewModal.show();
});
</script>
