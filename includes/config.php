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
