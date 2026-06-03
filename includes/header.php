<?php
// includes/header.php  —  Shared page header / navbar
// Expects $pageTitle to be set by the including page
$pageTitle = $pageTitle ?? APP_NAME;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?> | <?= APP_NAME ?></title>

    <!-- Bootstrap 5 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.8/css/dataTables.bootstrap5.min.css">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
</head>
<body>

    <!-- ===== TOP NAVBAR ===== -->
<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top shadow-sm">
    <div class="container-fluid">
        <a class="navbar-brand fw-bold d-flex align-items-center gap-2" href="<?= BASE_URL ?>/index.php">
            <i class="bi bi-people-fill fs-4"></i>
            <span class="d-none d-sm-inline"><?= APP_NAME ?></span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav me-auto">
<li class="nav-item">
                     <a class="nav-link <?= (basename($_SERVER['PHP_SELF']) === 'home.php') ? 'active' : '' ?>"
                        href="<?= BASE_URL ?>/home.php">
                         <i class="bi bi-speedometer2 me-1"></i> Dashboard
                     </a>
                 </li>
                <li class="nav-item">
                    <a class="nav-link <?= (strpos($_SERVER['PHP_SELF'], '/parents/') !== false) ? 'active' : '' ?>"
                       href="<?= BASE_URL ?>/modules/parents/list.php">
                        <i class="bi bi-person-lines-fill me-1"></i> Solo Parents
                    </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="bi bi-file-earmark-bar-graph me-1"></i> Reports
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>/modules/reports/generate.php?type=pdf">
                                <i class="bi bi-file-pdf text-danger me-2"></i> Export PDF
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="<?= BASE_URL ?>/modules/reports/generate.php?type=excel">
                                <i class="bi bi-file-excel text-success me-2"></i> Export Excel
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Right side: admin info -->
            <ul class="navbar-nav">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button"
                       data-bs-toggle="dropdown">
                        <div class="avatar-circle bg-white text-primary">
                            <?= strtoupper(substr($_SESSION['admin_name'] ?? 'A', 0, 1)) ?>
                        </div>
                        <span class="d-none d-md-inline"><?= e($_SESSION['admin_name'] ?? 'Admin') ?></span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><h6 class="dropdown-header">Logged in as Admin</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item text-danger" href="<?= BASE_URL ?>/logout.php">
                                <i class="bi bi-box-arrow-right me-2"></i> Logout
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<!-- ===== FLASH MESSAGES ===== -->
<?php $flash = getFlash(); if ($flash): ?>
<div class="container-fluid mt-3">
    <div class="alert alert-<?= $flash['type'] === 'error' ? 'danger' : e($flash['type']) ?> alert-dismissible fade show" role="alert">
        <i class="bi bi-<?= $flash['type'] === 'success' ? 'check-circle' : 'exclamation-triangle' ?>-fill me-2"></i>
        <?= e($flash['message']) ?>
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
</div>
<?php endif; ?>