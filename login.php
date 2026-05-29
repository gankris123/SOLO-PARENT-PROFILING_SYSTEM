<?php
// login.php  —  Admin Login Page (Redesigned UI)
session_name('spps_session');
session_start();

require_once __DIR__ . '/includes/config.php';

// Already logged in? Go to dashboard
if (isset($_SESSION['admin_id'])) {
    redirect(BASE_URL . '/home.php');
}

$error   = '';
$timeout = isset($_GET['timeout']);

// Handle login form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username === '' || $password === '') {
        $error = 'Please enter both username and password.';
    } else {
        $db   = getDB();
        $stmt = $db->prepare("SELECT * FROM admins WHERE username = :u LIMIT 1");
        $stmt->execute([':u' => $username]);
        $admin = $stmt->fetch();

        // password_verify works with PHP's password_hash (bcrypt)
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_id']   = $admin['id'];
            $_SESSION['admin_name'] = $admin['full_name'];
            $_SESSION['last_activity'] = time();
            // Don't redirect immediately - show success message on login page
            $loginSuccess = true;
        } else {
            $error = 'Invalid username or password.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | <?= APP_NAME ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="<?= BASE_URL ?>/assets/css/style.css">
    
    
</head>
<body class="login-page">

<div class="login-viewport">
    
    <div class="brand-panel">
        <div class="brand-header">
            <div class="d-flex align-items-center gap-2">
                <i class="bi bi-people-fill fs-3 text-white"></i>
                <span class="fw-bold tracking-wider fs-5 text-uppercase">SPPS Portal</span>
            </div>
        </div>
        
        <div class="my-auto">
            <h1 class="fw-extrabold display-5 mb-3 text-white" style="font-weight: 800;">
                Solo Parent<br>Profiling System
            </h1>
            <p class="lead opacity-75 fs-6 max-w-md">
                An administrative platform dedicated to secure profiling, strategic assistance distribution, and status monitoring for Barangay Sankanan's solo parent community.
            </p>
        </div>
        
        <div class="brand-footer opacity-50 small">
            &copy; <?= date('Y') ?> Barangay Sankanan. Security Protected.
        </div>
    </div>

    <div class="form-panel">
        <div class="form-container">
            
            <div class="d-lg-none text-center mb-4">
                <div class="d-inline-flex align-items-center justify-content-center bg-primary text-white rounded-circle mb-2" style="width: 56px; height: 56px;">
                    <i class="bi bi-people-fill fs-4"></i>
                </div>
                <h4 class="fw-bold text-dark mb-1"><?= APP_NAME ?></h4>
                <p class="text-muted small">Barangay Sankanan Management System</p>
            </div>

            <div class="mb-4 d-none d-lg-block">
                <h3 class="fw-bold text-slate-900 mb-1" style="color: #0f172a;">Account Sign In</h3>
                <p class="text-muted small">Enter your administrative credentials to manage records.</p>
            </div>

            <?php if ($timeout): ?>
            <div class="alert alert-warning border-0 shadow-sm small py-2 d-flex align-items-center mb-3">
                <i class="bi bi-clock-history me-2 fs-5"></i> Session expired. Please log in again.
            </div>
            <?php endif; ?>

            <?php if ($error): ?>
            <div class="alert alert-danger border-0 shadow-sm small py-2 d-flex align-items-center mb-3">
                <i class="bi bi-exclamation-circle me-2 fs-5"></i> <?= e($error) ?>
            </div>
            <?php endif; ?>

            <form method="POST" autocomplete="off" novalidate>
                
                <div class="mb-3">
                    <label class="form-label text-secondary" for="username">Username</label>
                    <div class="custom-input-group">
                        <span class="input-icon"><i class="bi bi-person fs-5"></i></span>
                        <input type="text" id="username" name="username" class="form-control"
                               placeholder="Enter administrative username"
                               value="<?= e($_POST['username'] ?? '') ?>"
                               required autofocus>
                    </div>
                </div>

                <div class="mb-4">
                    <div class="d-flex justify-content-between align-items-center mb-1">
                        <label class="form-label text-secondary mb-0" for="password">Password</label>
                        <a href="#" class="text-decoration-none small text-primary" onclick="alert('Please contact your system super-administrator to recover credentials.'); return false;">Forgot password?</a>
                    </div>
                    <div class="custom-input-group">
                        <span class="input-icon"><i class="bi bi-lock fs-5"></i></span>
                        <input type="password" id="password" name="password" class="form-control"
                               placeholder="Enter secure password" required>
                        <button class="password-toggle-btn" type="button" id="togglePw">
                            <i class="bi bi-eye" id="eyeIcon"></i>
                        </button>
                    </div>
                </div>

                 <button type="submit" class="btn btn-primary btn-login w-100 rounded-2 shadow-sm d-flex align-items-center justify-content-center gap-2">
                     <span>Sign In to System</span>
                     <i class="bi bi-arrow-right small"></i>
                 </button>
                </form>



              <div class="text-center text-muted d-lg-none small mt-4 pt-2">
                  &copy; <?= date('Y') ?> Barangay Sankanan
              </div>
             
         </div>
     </div>

     <!-- Login Success Modal -->
     <?php if (isset($loginSuccess) && $loginSuccess): ?>
     <div class="modal fade" id="loginSuccessModal" tabindex="-1" aria-hidden="true">
       <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content border-0 shadow-lg">
           <div class="modal-header border-0 pb-0">
             <h5 class="modal-title fw-bold text-primary">
               <i class="bi bi-check-circle-fill me-2"></i>Login Successful
             </h5>
             <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
           </div>
           <div class="modal-body py-4 text-center">
             <p class="mb-4 fs-5">Welcome back, <strong><?= e($_SESSION['admin_name'] ?? 'Administrator') ?></strong>!</p>
             <p class="mb-4 opacity-75">Press continue to proceed to the dashboard.</p>
           </div>
           <div class="modal-footer justify-content-center">
             <button type="button" class="btn btn-primary btn-lg px-4" id="confirmLoginBtn">
               Continue to Dashboard
             </button>
           </div>
         </div>
       </div>
     </div>
     <?php endif; ?>
     
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
     // Optimized Toggle Password Logic
     document.getElementById('togglePw').addEventListener('click', function () {
         const pwField = document.getElementById('password');
         const eyeIcon = document.getElementById('eyeIcon');
         
         if (pwField.type === 'password') {
             pwField.type = 'text';
             eyeIcon.className = 'bi bi-eye-slash';
         } else {
             pwField.type = 'password';
             eyeIcon.className = 'bi bi-eye';
         }
     });

     // Show login success modal if applicable
     <?php if (isset($loginSuccess) && $loginSuccess): ?>
     document.addEventListener('DOMContentLoaded', function () {
         const loginSuccessModal = new bootstrap.Modal(document.getElementById('loginSuccessModal'), {
             backdrop: 'static',
             keyboard: false
         });
         loginSuccessModal.show();
         
          // Handle confirm button click
          document.getElementById('confirmLoginBtn').addEventListener('click', function () {
              window.location.href = '<?= BASE_URL ?>/home.php';
          });
     });
     <?php endif; ?>
 </script>
</body>
</html>