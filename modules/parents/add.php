<?php
// modules/parents/add.php  —  Add New Solo Parent
session_name('spps_session');
session_start();

require_once __DIR__ . '/../../includes/config.php';
requireLogin();

$db = getDB();

// Load lookups
$categories = $db->query("SELECT * FROM categories ORDER BY name")->fetchAll();
$zones = $db->query("SELECT * FROM zones ORDER BY name")->fetchAll();

$errors = [];
$data   = []; // holds POST data on validation failure

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // ---- Collect & sanitize ----
    $data = [
        'last_name'      => trim($_POST['last_name']      ?? ''),
        'first_name'     => trim($_POST['first_name']     ?? ''),
        'middle_name'    => trim($_POST['middle_name']    ?? ''),
        'suffix'         => trim($_POST['suffix']         ?? ''),
        'gender'         => trim($_POST['gender']         ?? ''),
        'birth_date'     => trim($_POST['birth_date']     ?? ''),
        'civil_status'   => trim($_POST['civil_status']   ?? ''),
        'address_street' => trim($_POST['address_street'] ?? ''),
        'zone_id'    => (int)($_POST['zone_id']   ?? 0),
        'municipality'   => trim($_POST['municipality']   ?? ''),
        'province'       => trim($_POST['province']       ?? ''),
        'contact_number' => trim($_POST['contact_number'] ?? ''),
        'email'          => trim($_POST['email']          ?? ''),
        'occupation'     => trim($_POST['occupation']     ?? ''),
        'monthly_income' => (float)($_POST['monthly_income'] ?? 0),
        'category_id'    => (int)($_POST['category_id']   ?? 0),
        'num_children'   => (int)($_POST['num_children']  ?? 1),
        'id_number'      => trim($_POST['id_number']      ?? ''),
        'date_registered'=> trim($_POST['date_registered']?? ''),
        'status'         => trim($_POST['status']         ?? 'Active'),
        'remarks'        => trim($_POST['remarks']        ?? ''),
    ];

    // ---- Validate required fields ----
    if ($data['last_name']      === '') $errors[] = 'Last name is required.';
    if ($data['first_name']     === '') $errors[] = 'First name is required.';
    if ($data['gender']         === '') $errors[] = 'Gender is required.';
    if ($data['birth_date']     === '') $errors[] = 'Birth date is required.';
    if ($data['civil_status']   === '') $errors[] = 'Civil status is required.';
    if ($data['address_street'] === '') $errors[] = 'Street address is required.';
    if ($data['zone_id']    === 0)  $errors[] = 'Zone/Purok is required.';
    if ($data['contact_number'] === '') $errors[] = 'Contact number is required.';
    if ($data['occupation']     === '') $errors[] = 'Occupation is required.';
    if ($data['category_id']    === 0)  $errors[] = 'Solo parent category is required.';
    if ($data['num_children']   < 1)    $errors[] = 'Number of children must be at least 1.';

    // ---- Handle photo upload ----
    $photoFilename = null;
    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $file     = $_FILES['photo'];
        $mimeType = mime_content_type($file['tmp_name']);

        if (!in_array($mimeType, ALLOWED_TYPES)) {
            $errors[] = 'Photo must be a JPG, PNG, GIF, or WEBP image.';
        } elseif ($file['size'] > UPLOAD_MAX_SIZE) {
            $errors[] = 'Photo must be 2 MB or smaller.';
        } else {
            $ext           = pathinfo($file['name'], PATHINFO_EXTENSION);
            $photoFilename = 'photo_' . uniqid() . '.' . strtolower($ext);
            if (!move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $photoFilename)) {
                $errors[] = 'Failed to save photo. Check uploads/ folder permissions.';
                $photoFilename = null;
            }
        }
    }

    if (empty($errors)) {
        $spId = generateSpId($db);

        $stmt = $db->prepare("
            INSERT INTO solo_parents
                (sp_id, last_name, first_name, middle_name, suffix,
                 gender, birth_date, civil_status,
                 address_street, zone_id, municipality, province,
                 contact_number, email, occupation, monthly_income,
                 category_id, num_children, id_number, date_registered,
                 status, photo, remarks)
            VALUES
                (:sp_id, :last, :first, :mid, :suf,
                 :gender, :bdate, :civil,
                 :addr, :zone, :muni, :prov,
                 :contact, :email, :occ, :income,
                 :cat, :kids, :idnum, :dreg,
                 :status, :photo, :remarks)
        ");
        $stmt->execute([
            ':sp_id'   => $spId,
            ':last'    => $data['last_name'],
            ':first'   => $data['first_name'],
            ':mid'     => $data['middle_name'] ?: null,
            ':suf'     => $data['suffix']      ?: null,
            ':gender'  => $data['gender'],
            ':bdate'   => $data['birth_date'],
            ':civil'   => $data['civil_status'],
            ':addr'    => $data['address_street'],
            ':zone'    => $data['zone_id'],
            ':muni'    => $data['municipality'],
            ':prov'    => $data['province'],
            ':contact' => $data['contact_number'],
            ':email'   => $data['email'] ?: null,
            ':occ'     => $data['occupation'],
            ':income'  => $data['monthly_income'],
            ':cat'     => $data['category_id'],
            ':kids'    => $data['num_children'],
            ':idnum'   => $data['id_number']       ?: null,
            ':dreg'    => $data['date_registered'] ?: null,
            ':status'  => $data['status'],
            ':photo'   => $photoFilename,
            ':remarks' => $data['remarks'] ?: null,
        ]);

        $newId = $db->lastInsertId();
        logActivity($db, 'ADD', 'Solo Parents', "Added solo parent: $spId – {$data['first_name']} {$data['last_name']}");
        setFlash('success', "Solo parent record <strong>$spId</strong> added successfully!");
        redirect(BASE_URL . '/modules/parents/view.php?id=' . $newId);
    }
}

$pageTitle = 'Add Solo Parent';
require_once __DIR__ . '/../../includes/header.php';
?>
