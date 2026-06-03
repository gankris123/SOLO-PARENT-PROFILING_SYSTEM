<?php
// ============================================================
// includes/config.php  —  Database & App Configuration
// ============================================================

// --- Application Settings ---
define('APP_NAME',    'Solo Parent Profiling System');
define('APP_VERSION', '1.0.0');
// Auto-detect base URL - always returns project root
if (!defined('BASE_URL')) {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
        $protocol = "https://";
    } else {
        $protocol = "http://";
    }
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $scriptName = $_SERVER['SCRIPT_NAME'] ?? '/';
    // Ensure we're working with a URL path (must start with /), not filesystem path
    if (strpos($scriptName, '/') !== 0) {
        // CLI or malformed path fallback
        $basePath = '/solo-parent-system';
    } else {
        // Find project root by looking for index.php at root level
        // or by removing known subdirectories like /modules/parents
        $basePath = str_replace('\\', '/', dirname($scriptName));
        // Strip /modules/parents or similar subdirectory paths
        $basePath = preg_replace('#/modules(/[^\/]+)?$#', '', $basePath);
        $basePath = rtrim($basePath, '/');
    }
    if ($basePath == '/') $basePath = '';
    define('BASE_URL', $protocol . $host . $basePath);
}

// --- Database Settings ---  ← Edit these to match your server
define('DB_HOST', 'localhost');
define('DB_NAME', 'solo_parent_db');
define('DB_USER', 'root');
define('DB_PASS', '');          // Your MySQL password
define('DB_CHAR', 'utf8mb4');

// --- Session Security ---
define('SESSION_NAME',    'spps_session');
define('SESSION_TIMEOUT', 3600); // 1 hour in seconds

// --- File Upload ---
define('UPLOAD_DIR',      __DIR__ . '/../uploads/');
define('UPLOAD_MAX_SIZE', 2 * 1024 * 1024); // 2 MB
define('ALLOWED_TYPES',   ['image/jpeg', 'image/png', 'image/gif', 'image/webp']);

// --- Pagination ---
define('RECORDS_PER_PAGE', 10);

// ============================================================
// Database Connection using PDO
// ============================================================
function getDB(): PDO {
    static $pdo = null;         // Singleton — only connect once

    if ($pdo === null) {
        $dsn = sprintf(
            'mysql:host=%s;dbname=%s;charset=%s',
            DB_HOST, DB_NAME, DB_CHAR
        );
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            // Show friendly error — never expose raw PDO message in production
            die('<div style="font-family:sans-serif;padding:40px;color:#c0392b;">
                    <h2>Database Connection Failed</h2>
                    <p>Please check your database settings in <code>includes/config.php</code>.</p>
                    <p><small>' . htmlspecialchars($e->getMessage()) . '</small></p>
                 </div>');
        }
    }
    return $pdo;
}

// ============================================================
// Helper Functions
// ============================================================

/** Sanitize output to prevent XSS */
function e(string $value): string {
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

/** Redirect to a URL */
function redirect(string $url): void {
    header("Location: $url");
    exit;
}

/** Flash message system */
function setFlash(string $type, string $message): void {
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash(): ?array {
    if (isset($_SESSION['flash'])) {
        $flash = $_SESSION['flash'];
        unset($_SESSION['flash']);
        return $flash;
    }
    return null;
}

/** Check if admin is logged in */
function requireLogin(): void {
    if (!isset($_SESSION['admin_id'])) {
        redirect(BASE_URL . '/login.php');
    }
    // Check session timeout
    if (isset($_SESSION['last_activity']) &&
        (time() - $_SESSION['last_activity']) > SESSION_TIMEOUT) {
        session_unset();
        session_destroy();
        redirect(BASE_URL . '/login.php?timeout=1');
    }
    $_SESSION['last_activity'] = time();
}

/** Generate the next Solo Parent ID */
function generateSpId(PDO $db): string {
    $year = date('Y');
    $stmt = $db->prepare(
        "SELECT COUNT(*) FROM solo_parents WHERE sp_id LIKE :prefix"
    );
    $stmt->execute([':prefix' => "SP-$year-%"]);
    $count = (int) $stmt->fetchColumn();
    return sprintf('SP-%s-%03d', $year, $count + 1);
}

/** Log admin activity */
function logActivity(PDO $db, string $action, string $module, string $desc): void {
    if (!isset($_SESSION['admin_id'])) return;
    $stmt = $db->prepare(
        "INSERT INTO activity_logs (admin_id, action, module, description, ip_address)
         VALUES (:admin_id, :action, :module, :desc, :ip)"
    );
    $stmt->execute([
        ':admin_id' => $_SESSION['admin_id'],
        ':action'   => $action,
        ':module'   => $module,
        ':desc'     => $desc,
        ':ip'       => $_SERVER['REMOTE_ADDR'] ?? 'unknown',
    ]);
}

/** Format date for display */
function formatDate(string $date, string $format = 'F d, Y'): string {
    return $date ? date($format, strtotime($date)) : '—';
}

/** Calculate age from birthdate */
function calculateAge(string $birthDate): int {
    return (int) (new DateTime($birthDate))->diff(new DateTime())->y;
}

/** Format currency */
function formatMoney(float $amount): string {
    return '₱ ' . number_format($amount, 2);
}

/** Status badge HTML */
function statusBadge(string $status): string {
    $map = [
        'Active'   => 'success',
        'Inactive' => 'secondary',
        'Pending'  => 'warning',
    ];
    $class = $map[$status] ?? 'secondary';
    return "<span class=\"badge bg-$class\">" . e($status) . "</span>";
}