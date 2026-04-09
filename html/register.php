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
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register - Task Tracker</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11/font/bootstrap-icons.css" rel="stylesheet">

    <!-- HTMX -->
    <script src="https://unpkg.com/htmx.org@2.0.8"></script>

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px 0;
        }
        .register-container {
            max-width: 500px;
            width: 100%;
        }
        .register-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
        }
        .register-header {
            text-align: center;
            margin-bottom: 30px;
        }
        .register-header h2 {
            color: #333;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .register-header p {
            color: #666;
            font-size: 14px;
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            padding: 12px;
            font-weight: 500;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, #5568d3 0%, #6a3f8f 100%);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .password-requirements {
            font-size: 12px;
            color: #666;
            margin-top: 5px;
        }
        .password-requirements li {
            margin-bottom: 2px;
        }
        .divider {
            text-align: center;
            margin: 20px 0;
            position: relative;
        }
        .divider::before {
            content: "";
            position: absolute;
            left: 0;
            top: 50%;
            width: 100%;
            height: 1px;
            background: #ddd;
        }
        .divider span {
            background: white;
            padding: 0 15px;
            position: relative;
            color: #999;
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="register-container" id="register-page-container">
        <div class="register-card" id="register-card">
            <div class="register-header" id="register-header">
                <h2><i class="bi bi-person-plus-fill text-primary"></i> Create Account</h2>
                <p>Join Task Tracker to manage your tasks</p>
            </div>

            <!-- Messages will appear here -->
            <div id="register-messages"></div>

            <!-- Registration Form -->
            <form id="register-form" hx-post="/partials/auth/register.php" hx-target="#register-messages" hx-swap="innerHTML">
                <?php echo csrf_field(); ?>

                <div class="row" id="name-fields-row">
                    <div class="col-md-6 mb-3" id="first-name-field-group">
                        <label for="first_name" class="form-label">First Name</label>
                        <input type="text"
                               class="form-control"
                               id="first_name"
                               name="first_name"
                               placeholder="John"
                               required
                               autofocus>
                    </div>
                    <div class="col-md-6 mb-3" id="last-name-field-group">
                        <label for="last_name" class="form-label">Last Name</label>
                        <input type="text"
                               class="form-control"
                               id="last_name"
                               name="last_name"
                               placeholder="Doe"
                               required>
                    </div>
                </div>

                <div class="mb-3" id="email-field-group">
                    <label for="email" class="form-label">Email Address</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-envelope"></i></span>
                        <input type="email"
                               class="form-control"
                               id="email"
                               name="email"
                               placeholder="john@example.com"
                               required>
                    </div>
                </div>

                <div class="mb-3" id="password-field-group">
                    <label for="password" class="form-label">Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock"></i></span>
                        <input type="password"
                               class="form-control"
                               id="password"
                               name="password"
                               placeholder="Create a strong password"
                               required>
                    </div>
                    <div class="password-requirements" id="password-requirements">
                        <small>Password must contain:</small>
                        <ul class="mb-0 ps-3">
                            <li>At least 8 characters</li>
                            <li>One uppercase letter</li>
                            <li>One lowercase letter</li>
                            <li>One number</li>
                        </ul>
                    </div>
                </div>

                <div class="mb-3" id="confirm-password-field-group">
                    <label for="confirm_password" class="form-label">Confirm Password</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                        <input type="password"
                               class="form-control"
                               id="confirm_password"
                               name="confirm_password"
                               placeholder="Re-enter your password"
                               required>
                    </div>
                </div>

                <div class="d-grid mb-3" id="register-button-group">
                    <button type="submit" class="btn btn-primary btn-lg">
                        <span>Create Account</span>
                        <span class="htmx-indicator spinner-border spinner-border-sm ms-2"></span>
                    </button>
                </div>
            </form>

            <div class="divider" id="register-divider">
                <span>OR</span>
            </div>

            <div class="text-center" id="register-footer-links">
                <p class="mb-0">
                    Already have an account?
                    <a href="/login.php" class="text-decoration-none fw-bold">
                        Sign In
                    </a>
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
