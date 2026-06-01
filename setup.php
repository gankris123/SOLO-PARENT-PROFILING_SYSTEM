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
