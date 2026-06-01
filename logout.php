<?php
session_name('spps_session');
session_start();
require_once __DIR__ . '/includes/config.php';
session_unset();
session_destroy();
redirect(BASE_URL . '/login.php');
?>