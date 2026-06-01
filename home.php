<?php

session_name('spps_session');
session_start();

require_once __DIR__ . '/includes/config.php';
requireLogin();

$db = getDB();

// ---- Fetch summary statistics ----
$stats = [];

$stats['total']    = $db->query("SELECT COUNT(*) FROM solo_parents")->fetchColumn();
$stats['active']   = $db->query("SELECT COUNT(*) FROM solo_parents WHERE status='Active'")->fetchColumn();
$stats['inactive'] = $db->query("SELECT COUNT(*) FROM solo_parents WHERE status='Inactive'")->fetchColumn();
$stats['pending']  = $db->query("SELECT COUNT(*) FROM solo_parents WHERE status='Pending'")->fetchColumn();
$stats['children'] = $db->query("SELECT SUM(num_children) FROM solo_parents")->fetchColumn() ?? 0;

// Breakdown by category
$categories = $db->query(
    "SELECT c.name, COUNT(sp.id) AS total
     FROM categories c
     LEFT JOIN solo_parents sp ON sp.category_id = c.id
     GROUP BY c.id, c.name
     ORDER BY total DESC"
)->fetchAll();

// Breakdown by zone
$zones = $db->query(
    "SELECT z.name, COUNT(sp.id) AS total
     FROM zones z
     LEFT JOIN solo_parents sp ON sp.zone_id = z.id
     GROUP BY z.id, z.name
     ORDER BY total DESC
     LIMIT 8"
)->fetchAll();

// Recent registrations
$recent = $db->query(
    "SELECT sp.*, c.name AS category_name, z.name AS zone_name
     FROM solo_parents sp
     JOIN categories c ON c.id = sp.category_id
     JOIN zones  z ON z.id = sp.zone_id
     ORDER BY sp.created_at DESC
     LIMIT 5"
)->fetchAll();

$pageTitle = 'Dashboard';
require_once __DIR__ . '/includes/header.php';
?>

<main>
<div class="container-fluid page-wrapper">

    <!-- Page Header -->
    <div class="page-header d-flex justify-content-between align-items-start flex-wrap gap-2">
        <div>
            <h2><i class="bi bi-speedometer2 me-2 text-primary"></i>Dashboard</h2>
        </div>
    </div>

    <!-- ===== STAT CARDS ===== -->
    <div class="row g-3 mb-4">
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card bg-primary h-100">
                <div class="stat-value"><?= number_format($stats['total']) ?></div>
                <div class="stat-label">Total Solo Parents</div>
                <i class="bi bi-people stat-icon"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card bg-success h-100">
                <div class="stat-value"><?= number_format($stats['active']) ?></div>
                <div class="stat-label">Active</div>
                <i class="bi bi-person-check stat-icon"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card bg-warning h-100">
                <div class="stat-value"><?= number_format($stats['pending']) ?></div>
                <div class="stat-label">Pending</div>
                <i class="bi bi-hourglass-split stat-icon"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card bg-danger h-100">
                <div class="stat-value"><?= number_format($stats['inactive']) ?></div>
                <div class="stat-label">Inactive</div>
                <i class="bi bi-person-dash stat-icon"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card bg-info h-100">
                <div class="stat-value"><?= number_format($stats['children']) ?></div>
                <div class="stat-label">Total Children</div>
                <i class="bi bi-emoji-smile stat-icon"></i>
            </div>
        </div>
        <div class="col-6 col-md-4 col-lg-2">
            <div class="stat-card bg-purple h-100">
                <div class="stat-value"><?= count($categories) ?></div>
                <div class="stat-label">Categories</div>
                <i class="bi bi-tags stat-icon"></i>
            </div>
        </div>
    </div>
    
    <!-- ===== MAIN CONTENT ROW ===== -->
    <div class="row g-3 mb-4">

        <!-- Category Breakdown -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <span><i class="bi bi-pie-chart me-2 text-primary"></i>By Category</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th class="text-center">Count</th>
                                    <th style="width:40%">Distribution</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($categories as $cat): ?>
                                <?php $pct = $stats['total'] > 0 ? round($cat['total'] / $stats['total'] * 100) : 0; ?>
                                <tr>
                                    <td class="small"><?= e($cat['name']) ?></td>
                                    <td class="text-center fw-bold"><?= $cat['total'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <div class="progress flex-grow-1" style="height:8px;">
                                                <div class="progress-bar bg-primary" style="width:<?= $pct ?>%"></div>
                                            </div>
                                            <small class="text-muted"><?= $pct ?>%</small>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Zone/Purok Breakdown -->
        <div class="col-md-6">
            <div class="card h-100">
                <div class="card-header">
                    <i class="bi bi-geo-alt me-2 text-success"></i>By Zone/Purok
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-sm mb-0">
                            <thead>
                                <tr>
                                    <th>Zone/Purok</th>
                                    <th class="text-center">Count</th>
                                    <th style="width:40%">Distribution</th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($zones as $zone): ?>
                                <?php $pct = $stats['total'] > 0 ? round($zone['total'] / $stats['total'] * 100) : 0; ?>
                                <tr>
                                    <td class="small"><?= e($zone['name']) ?></td>
                                    <td class="text-center fw-bold"><?= $zone['total'] ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-1">
                                            <div class="progress flex-grow-1" style="height:8px;">
                                                <div class="progress-bar bg-success" style="width:<?= $pct ?>%"></div>
                                            </div>
                                            <small class="text-muted"><?= $pct ?>%</small>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- ===== RECENT REGISTRATIONS ===== -->
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span><i class="bi bi-clock-history me-2 text-primary"></i>Recent Registrations</span>
            <a href="<?= BASE_URL ?>/modules/parents/list.php" class="btn btn-sm btn-outline-primary">
                View All <i class="bi bi-arrow-right ms-1"></i>
            </a>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th>SP-ID</th>
                            <th>Full Name</th>
                            <th>Zone/Purok</th>
                            <th>Category</th>
                            <th class="text-center">Children</th>
                            <th>Status</th>
                            <th>Registered</th>
                            <th></th>
                        </tr>
                        </thead>
                    <tbody>
                    <?php if (empty($recent)): ?>
                        <tr><td colspan="8" class="text-center text-muted py-4">No records yet.</td></tr>
                    <?php else: ?>
                        <?php foreach ($recent as $row): ?>
                        <tr>
                            <td><span class="badge bg-primary-subtle text-primary"><?= e($row['sp_id']) ?></span></td>
                            <td class="fw-semibold">
                                <?= e($row['last_name'] . ', ' . $row['first_name']) ?>
                            </td>
                            <td><?= e('Purok ' . $row['zone_name']) ?></td>
                            <td class="small text-muted"><?= e($row['category_name']) ?></td>
                            <td class="text-center"><?= (int)$row['num_children'] ?></td>
                            <td><?= statusBadge($row['status']) ?></td>
                            <td class="small text-muted"><?= formatDate($row['date_registered'] ?? $row['created_at']) ?></td>
                            <td>
                                <a href="<?= BASE_URL ?>/modules/parents/view.php?id=<?= $row['id'] ?>"
                                   class="btn btn-sm btn-outline-secondary py-0">
                                    <i class="bi bi-eye"></i>
                                </a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>
<?php require_once __DIR__ . '/includes/footer.php'; ?>