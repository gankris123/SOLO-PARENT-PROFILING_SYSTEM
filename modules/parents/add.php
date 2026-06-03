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

<main>
<div class="container-fluid page-wrapper">

    <!-- Page Header -->
    <div class="page-header">
        <h2><i class="bi bi-person-plus-fill me-2 text-primary"></i>Add Solo Parent</h2>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb mb-0">
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/index.php">Dashboard</a></li>
                <li class="breadcrumb-item"><a href="<?= BASE_URL ?>/modules/parents/list.php">Solo Parents</a></li>
                <li class="breadcrumb-item active">Add New</li>
            </ol>
        </nav>
    </div>

    <!-- Validation Errors -->
    <?php if (!empty($errors)): ?>
    <div class="alert alert-danger">
        <strong><i class="bi bi-exclamation-triangle me-2"></i>Please fix the following errors:</strong>
        <ul class="mb-0 mt-1">
            <?php foreach ($errors as $err): ?>
            <li><?= e($err) ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
    <?php endif; ?>

    <form method="POST" enctype="multipart/form-data" novalidate>

        <div class="row g-3">
            <!-- ===== LEFT: MAIN FORM ===== -->
            <div class="col-lg-8">

                <!-- Personal Information -->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="bi bi-person me-2 text-primary"></i>Personal Information
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-4">
                                <label class="form-label">Last Name <span class="text-danger">*</span></label>
                                <input type="text" name="last_name" class="form-control"
                                       value="<?= e($data['last_name'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">First Name <span class="text-danger">*</span></label>
                                <input type="text" name="first_name" class="form-control"
                                       value="<?= e($data['first_name'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-3">
                                <label class="form-label">Middle Name</label>
                                <input type="text" name="middle_name" class="form-control"
                                       value="<?= e($data['middle_name'] ?? '') ?>">
                            </div>
                            <div class="col-md-1">
                                <label class="form-label">Suffix</label>
                                <input type="text" name="suffix" class="form-control"
                                       value="<?= e($data['suffix'] ?? '') ?>" placeholder="Jr.">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Gender <span class="text-danger">*</span></label>
                                <select name="gender" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <?php foreach (['Male','Female','Other'] as $g): ?>
                                    <option value="<?= $g ?>" <?= ($data['gender'] ?? '') === $g ? 'selected' : '' ?>>
                                        <?= $g ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Birth Date <span class="text-danger">*</span></label>
                                <input type="date" name="birth_date" class="form-control"
                                       value="<?= e($data['birth_date'] ?? '') ?>" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Civil Status <span class="text-danger">*</span></label>
                                <select name="civil_status" class="form-select" required>
                                    <option value="">-- Select --</option>
                                    <?php foreach (['Single','Widowed','Separated','Divorced','Annulled'] as $cs): ?>
                                    <option value="<?= $cs ?>" <?= ($data['civil_status'] ?? '') === $cs ? 'selected' : '' ?>>
                                        <?= $cs ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Address & Contact -->
                <div class="card mb-3">
                    <div class="card-header">
                        <i class="bi bi-geo-alt me-2 text-success"></i>Address & Contact
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Street / House No. <span class="text-danger">*</span></label>
                                <input type="text" name="address_street" class="form-control"
                                       value="<?= e($data['address_street'] ?? '') ?>"
                                       placeholder="e.g. 123 Rizal Street" required>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Zone / Purok <span class="text-danger">*</span></label>
                                <select name="zone_id" class="form-select" required>
                                    <option value="">-- Select Zone/Purok --</option>
                                    <?php foreach ($zones as $zone): ?>
                                    <option value="<?= $zone['id'] ?>"
                                            <?= ($data['zone_id'] ?? 0) == $zone['id'] ? 'selected' : '' ?>>
                                        <?= e($zone['name']) ?>
                                    </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Municipality / City</label>
                                <input type="text" name="municipality" class="form-control"
                                       value="<?= e($data['municipality'] ?? 'Your Municipality') ?>">
                            </div>
                            <div class="col-md-4">
                                <label class="form-label">Province</label>
                                <input type="text" name="province" class="form-control"
                                       value="<?= e($data['province'] ?? 'Your Province') ?>">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Contact Number <span class="text-danger">*</span></label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-phone"></i></span>
                                    <input type="tel" name="contact_number" class="form-control"
                                           value="<?= e($data['contact_number'] ?? '') ?>"
                                           placeholder="09XXXXXXXXX" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email Address</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                                    <input type="email" name="email" class="form-control"
                                           value="<?= e($data['email'] ?? '') ?>"
                                           placeholder="optional">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>