/* ============================================================
   assets/js/app.js  —  Solo Parent Profiling System
   ============================================================ */

'use strict';

/* ---- Initialize DataTable on any table with .datatable class ---- */
$(function () {
    if ($('.datatable').length) {
        $('.datatable').DataTable({
            responsive: true,
            pageLength: 10,
            order: [[0, 'desc']],
            language: {
                search:         "Quick Search:",
                lengthMenu:     "Show _MENU_ records",
                info:           "Showing _START_ to _END_ of _TOTAL_ entries",
                emptyTable:     "No records found.",
                zeroRecords:    "No matching records.",
                paginate: {
                    previous:   '<i class="bi bi-chevron-left"></i>',
                    next:       '<i class="bi bi-chevron-right"></i>'
                }
            },
            dom: '<"row align-items-center mb-2"<"col-sm-6"l><"col-sm-6"f>>rtip'
        });
    }
    
    /* ---- Bootstrap tooltips ---- */
    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(el => {
        new bootstrap.Tooltip(el);
    });

    /* ---- Photo preview on file input ---- */
    const photoInput = document.getElementById('photoInput');
    if (photoInput) {
        photoInput.addEventListener('change', function () {
            const file = this.files[0];
            if (!file) return;

            // Validate type and size (2 MB)
            const allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
            if (!allowed.includes(file.type)) {
                showAlert('danger', 'Only JPG, PNG, GIF, or WEBP images are allowed.');
                this.value = '';
                return;
            }
            if (file.size > 2 * 1024 * 1024) {
                showAlert('danger', 'Image must be 2 MB or smaller.');
                this.value = '';
                return;
            }

            const reader = new FileReader();
            reader.onload = e => {
                const preview = document.getElementById('photoPreview');
                const placeholder = document.getElementById('photoPlaceholder');
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
                if (placeholder) placeholder.classList.add('d-none');
            };
            reader.readAsDataURL(file);
        });
    }
    
    /* ---- Confirm delete ---- */
    document.querySelectorAll('.btn-delete').forEach(btn => {
        btn.addEventListener('click', function (e) {
            if (!confirm('Are you sure you want to delete this record? This action cannot be undone.')) {
                e.preventDefault();
            }
        });
    });

    /* ---- Auto-dismiss alerts after 5 s ---- */
    setTimeout(() => {
        document.querySelectorAll('.alert.alert-dismissible').forEach(el => {
            const bsAlert = bootstrap.Alert.getOrCreateInstance(el);
            bsAlert.close();
        });
    }, 5000);
});

/* ---- Utility: show inline alert ---- */
function showAlert(type, message, container = '#alertContainer') {
    const html = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>`;
    const el = document.querySelector(container);
    if (el) {
        el.innerHTML = html;
        el.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }
}

/* ---- Loading overlay ---- */
function showLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) { overlay.style.display = 'flex'; }
}

function hideLoading() {
    const overlay = document.getElementById('loadingOverlay');
    if (overlay) { overlay.style.display = 'none'; }
}

/* ---- Export table to Excel (client-side via SheetJS) ---- */
function exportToExcel(tableId, filename) {
    showLoading();
    try {
        const wb  = XLSX.utils.book_new();
        const ws  = XLSX.utils.table_to_sheet(document.getElementById(tableId));
        XLSX.utils.book_append_sheet(wb, ws, 'Solo Parents');
        XLSX.writeFile(wb, (filename || 'solo-parents') + '.xlsx');
    } catch (err) {
        showAlert('danger', 'Excel export failed: ' + err.message);
    } finally {
        hideLoading();
    }
}

/* ---- Print report ---- */
function printReport() {
    window.print();
}