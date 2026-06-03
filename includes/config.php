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