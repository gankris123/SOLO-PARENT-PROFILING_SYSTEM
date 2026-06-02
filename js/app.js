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