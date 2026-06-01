<?php
// setup.php  —  First-time setup & admin password creation
// ⚠️  DELETE THIS FILE after setup is complete!

require_once __DIR__ . '/includes/config.php';

$message = '';
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // ---- Create/Reset admin password ----
    if ($action === 'set_password') {
        $username = trim($_POST['username'] ?? 'admin');
        $password = trim($_POST['password'] ?? '');
        $confirm  = trim($_POST['confirm']  ?? '');

        if (strlen($password) < 6) {
            $message = '❌ Password must be at least 6 characters.';
        } elseif ($password !== $confirm) {
            $message = '❌ Passwords do not match.';
        } else {
            $db   = getDB();
            $hash = password_hash($password, PASSWORD_BCRYPT);

            // Check if admin exists
            $check = $db->prepare("SELECT id FROM admins WHERE username = :u");
            $check->execute([':u' => $username]);
            $existing = $check->fetch();

            if ($existing) {
                $stmt = $db->prepare("UPDATE admins SET password = :pw WHERE username = :u");
                $stmt->execute([':pw' => $hash, ':u' => $username]);
                $message = "✅ Password for '<strong>$username</strong>' updated successfully!";
            } else {
                $stmt = $db->prepare(
                    "INSERT INTO admins (username, password, full_name) VALUES (:u, :pw, :name)"
                );
                $stmt->execute([':u' => $username, ':pw' => $hash, ':name' => 'Administrator']);
                $message = "✅ Admin '<strong>$username</strong>' created successfully!";
            }
            $success = true;
        }
    }

    // ---- Run SQL schema ----
    if ($action === 'run_sql') {
        $sqlFile = __DIR__ . '/database.sql';
        if (!file_exists($sqlFile)) {
            $message = '❌ database.sql not found.';
        } else {
            try {
                $db  = getDB();
                $sql = file_get_contents($sqlFile);
                // Split on semicolons, skip empty
                $statements = array_filter(
                    array_map('trim', explode(';', $sql)),
                    fn($s) => $s !== ''
                );
                $count = 0;
                foreach ($statements as $s) {
                    $db->exec($s);
                    $count++;
                }
                $message = "✅ SQL executed successfully ($count statements). Database is ready!";
                $success = true;
            } catch (PDOException $e) {
                $message = '❌ SQL Error: ' . htmlspecialchars($e->getMessage());
            }
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Setup | <?= APP_NAME ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-light">
<div class="container py-5" style="max-width:600px;">
    <div class="text-center mb-4">
        <i class="bi bi-people-fill text-primary" style="font-size:3rem;"></i>
        <h2 class="fw-bold mt-2"><?= APP_NAME ?></h2>
        <p class="text-muted">First-Time Setup Utility</p>
    </div>

    <?php if ($message): ?>
    <div class="alert alert-<?= $success ? 'success' : 'danger' ?> mb-4">
        <?= $message ?>
    </div>
    <?php endif; ?>

    <!-- ===== Step 1: Database ===== -->
    <div class="card mb-3">
        <div class="card-header fw-bold">
            <i class="bi bi-database me-2"></i>Step 1 — Initialize Database
        </div>
        <div class="card-body">
            <p class="small text-muted">
                This will run <code>database.sql</code> and create all tables + sample data.
                Make sure you have configured <code>includes/config.php</code> first.
            </p>
            <form method="POST">
                <input type="hidden" name="action" value="run_sql">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-play-circle me-1"></i> Run Database Setup
                </button>
            </form>
        </div>
    </div>

    <!-- ===== Step 2: Password ===== -->
    <div class="card mb-3">
        <div class="card-header fw-bold">
            <i class="bi bi-key me-2"></i>Step 2 — Set Admin Password
        </div>
        <div class="card-body">
            <p class="small text-muted">
                Create or reset an admin account. The password will be securely hashed.
            </p>
            <form method="POST">
                <input type="hidden" name="action" value="set_password">
                <div class="mb-2">
                    <label class="form-label small fw-semibold">Username</label>
                    <input type="text" name="username" class="form-control form-control-sm"
                           value="admin" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-semibold">New Password</label>
                    <input type="password" name="password" class="form-control form-control-sm"
                           placeholder="Minimum 6 characters" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-semibold">Confirm Password</label>
                    <input type="password" name="confirm" class="form-control form-control-sm" required>
                </div>
                <button type="submit" class="btn btn-success btn-sm">
                    <i class="bi bi-check-circle me-1"></i> Set Password
                </button>
            </form>
        </div>
    </div>

    <!-- ===== Step 3: Done ===== -->
    <div class="card mb-3 border-warning">
        <div class="card-header fw-bold text-warning">
            <i class="bi bi-exclamation-triangle me-2"></i>Step 3 — Delete This File
        </div>
        <div class="card-body">
            <p class="small mb-2">
                After setup is complete, <strong>delete <code>setup.php</code></strong> from your server
                for security. Leaving it accessible is a security risk.
            </p>
            <a href="<?= BASE_URL ?>/login.php" class="btn btn-outline-primary btn-sm">
                <i class="bi bi-box-arrow-in-right me-1"></i> Go to Login
            </a>
        </div>
    </div>

    <p class="text-center text-muted small mt-4">
        <?= APP_NAME ?> v<?= APP_VERSION ?>
    </p>
</div>
</body>
</html>