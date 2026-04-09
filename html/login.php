<?php
require_once '../helpers/session.php';
require_once '../helpers/csrf.php';

init_session();

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: /app.php');
    exit;
}

$csrf_token = generate_csrf_token();

// Check for success messages from redirects
$successMessage = $_SESSION['success_message'] ?? null;
if ($successMessage) {
    unset($_SESSION['success_message']);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - Task Tracker</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon-vt.png" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendor/kobie-vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendor/feather.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/css/kobie-theme.min.css" />

    <!-- HTMX -->
    <script src="https://unpkg.com/htmx.org@2.0.8"></script>

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
        }
        .auth-minimal-wrapper {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 20px 0;
        }
        .auth-minimal-inner {
            width: 100%;
            max-width: 500px;
        }
        .minimal-card-wrapper {
            width: 100%;
        }
        .wd-50 {
            width: 50px;
            height: 50px;
        }
        .btn-light-brand {
            background-color: #f8f9fa;
            border: 1px solid #dee2e6;
            color: #495057;
        }
        .btn-light-brand:hover {
            background-color: #e9ecef;
            border-color: #dee2e6;
            color: #495057;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(102, 126, 234, 0.4);
        }
        .border-bottom-divider {
            border-bottom: 1px solid #dee2e6;
            margin-bottom: 1rem;
        }
        .border-bottom-divider span {
            display: inline-block;
            position: relative;
            top: 0.6rem;
            background: white;
            padding: 0 1rem;
        }
    </style>
</head>
<body>
    <main class="auth-minimal-wrapper" id="auth-wrapper">
        <div class="auth-minimal-inner" id="auth-inner">
            <div class="minimal-card-wrapper" id="card-wrapper">
                <div class="card mb-4 mt-5 mx-4 mx-sm-0 position-relative" id="login-card">
                    <!-- Logo at top center -->
                    <div class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50" id="logo-container">
                        <img src="assets/images/kobie-logo-abbr.png" alt="Logo" class="img-fluid" id="logo-image">
                    </div>

                    <div class="card-body p-sm-5" id="card-body">
                        <!-- Header -->
                        <h2 class="fs-20 fw-bolder mb-4" id="login-title">Login</h2>
                        <h4 class="fs-13 fw-bold mb-2" id="login-subtitle">Login to your account</h4>
                        <p class="fs-12 fw-medium text-muted" id="login-description">
                            Thank you for getting back to <strong>Task Tracker</strong>, let's access the best task management for you.
                        </p>

                        <!-- Messages will appear here -->
                        <div id="login-messages">
                            <?php if ($successMessage): ?>
                                <div class="alert alert-success alert-dismissible fade show" role="alert" id="password-reset-success">
                                    <i class="feather-check-circle"></i>
                                    <?php echo htmlspecialchars($successMessage); ?>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                            <?php endif; ?>
                        </div>

                        <!-- Login Form -->
                        <form id="login-form"
                              class="w-100 mt-4 pt-2"
                              hx-post="/partials/auth/login.php"
                              hx-target="#login-messages"
                              hx-swap="innerHTML">
                            <?php echo csrf_field(); ?>

                            <div class="mb-4" id="email-field-group">
                                <input type="email"
                                       class="form-control"
                                       id="email"
                                       name="email"
                                       placeholder="Email or Username"
                                       required
                                       autofocus>
                            </div>

                            <div class="mb-3" id="password-field-group">
                                <input type="password"
                                       class="form-control"
                                       id="password"
                                       name="password"
                                       placeholder="Password"
                                       required>
                            </div>

                            <div class="d-flex align-items-center justify-content-between mb-4" id="remember-forgot-row">
                                <div id="remember-me-container">
                                    <div class="form-check">
                                        <input type="checkbox"
                                               class="form-check-input"
                                               id="remember"
                                               name="remember"
                                               value="1">
                                        <label class="form-check-label" for="remember">Remember Me</label>
                                    </div>
                                </div>
                                <div id="forgot-password-link-container">
                                    <a href="/forgot-password.php" class="fs-11 text-primary">Forget password?</a>
                                </div>
                            </div>

                            <div class="mt-5" id="login-button-container">
                                <button type="submit" class="btn btn-lg btn-primary w-100">
                                    Login
                                    <span class="htmx-indicator spinner-border spinner-border-sm ms-2"></span>
                                </button>
                            </div>
                        </form>

                        <!-- Social Login Section -->
                        <div class="w-100 mt-5 text-center mx-auto" id="social-login-section">
                            <div class="mb-4 border-bottom-divider position-relative" id="divider-container">
                                <span class="small py-1 px-3 text-uppercase text-muted" id="divider-text">or</span>
                            </div>
                            <div class="d-flex align-items-center justify-content-center gap-2" id="social-buttons-container">
                                <a href="javascript:void(0);"
                                   class="btn btn-light-brand flex-fill"
                                   id="facebook-login-btn"
                                   data-bs-toggle="tooltip"
                                   data-bs-trigger="hover"
                                   title="Login with Facebook">
                                    <i class="feather-facebook"></i>
                                </a>
                                <a href="javascript:void(0);"
                                   class="btn btn-light-brand flex-fill"
                                   id="twitter-login-btn"
                                   data-bs-toggle="tooltip"
                                   data-bs-trigger="hover"
                                   title="Login with Twitter">
                                    <i class="feather-twitter"></i>
                                </a>
                                <a href="javascript:void(0);"
                                   class="btn btn-light-brand flex-fill"
                                   id="github-login-btn"
                                   data-bs-toggle="tooltip"
                                   data-bs-trigger="hover"
                                   title="Login with Github">
                                    <i class="feather-github"></i>
                                </a>
                            </div>
                        </div>

                        <!-- Register Link -->
                        <div class="mt-5 text-muted" id="register-link-container">
                            <span>Don't have an account?</span>
                            <a href="/register.php" class="fw-bold">Create an Account</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Bootstrap JS -->
    <script src="assets/vendor/jquery.min.js"></script>
    <script src="assets/vendor/bootstrap.min.js"></script>

    <!-- Initialize tooltips -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</body>
</html>
