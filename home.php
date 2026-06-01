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