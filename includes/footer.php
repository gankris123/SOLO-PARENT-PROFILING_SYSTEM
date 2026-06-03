<?php // includes/footer.php  —  Shared page footer ?>

<footer class="footer mt-auto py-3 bg-light border-top">
    <div class="container-fluid">
        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center text-muted small">
            <span>
                <i class="bi bi-people-fill text-primary me-1"></i>
                &copy; <?= date('Y') ?> <?= APP_NAME ?>. All rights reserved.
            </span>
        </div>
    </div>
</footer>

<!-- ===== SCRIPTS ===== -->
<!-- jQuery (required by DataTables) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<!-- Bootstrap 5 JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables -->
<script src="https://cdn.datatables.net/1.13.8/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.8/js/dataTables.bootstrap5.min.js"></script>
<!-- jsPDF + AutoTable for client-side PDF fallback -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
<!-- SheetJS for client-side Excel -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/xlsx/0.18.5/xlsx.full.min.js"></script>
<!-- Custom JS -->
<script src="<?= BASE_URL ?>/assets/js/app.js"></script>
</body>
</html>