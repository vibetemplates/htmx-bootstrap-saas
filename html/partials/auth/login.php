<?php
require_once '../../../helpers/session.php';
require_once '../../../helpers/csrf.php';
require_once '../../../helpers/validation.php';
require_once '../../../helpers/auth.php';
require_once '../../../models/User.php';

init_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process login

    // Verify CSRF token
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        echo '<div class="alert alert-danger" id="login-error-csrf">
                <i class="feather-alert-triangle-fill"></i>
                Invalid security token. Please refresh the page and try again.
              </div>';
        exit;
    }

    // Validate required fields
    $required = ['email', 'password'];
    $missing = validate_required($required, $_POST);

    if (!empty($missing)) {
        echo '<div class="alert alert-danger" id="login-error-required">
                <i class="feather-alert-triangle-fill"></i>
                Please fill in all required fields.
              </div>';
        exit;
    }

    // Sanitize inputs
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password']; // Don't sanitize password
    $remember = isset($_POST['remember']) && $_POST['remember'] === '1';

    // Validate email format
    if (!validate_email($email)) {
        echo '<div class="alert alert-danger" id="login-error-email">
                <i class="feather-alert-triangle-fill"></i>
                Please enter a valid email address.
              </div>';
        exit;
    }

    // Verify credentials
    $userModel = new User();
    $user = $userModel->verifyPassword($email, $password);

    if (!$user) {
        // Log failed login attempt
        error_log("Failed login attempt for email: $email");

        echo '<div class="alert alert-danger" id="login-error-credentials">
                <i class="feather-alert-triangle-fill"></i>
                Invalid email or password. Please try again.
              </div>';
        exit;
    }

    // Handle remember me
    if ($remember) {
        $token = login_user($user, true);
        $userModel->updateRememberToken($user['id'], $token);
    } else {
        login_user($user, false);
    }

    // Log successful login
    error_log("Successful login for user ID: {$user['id']}");

    // Redirect to app
    header('HX-Redirect: /app.php');
    echo '<div class="alert alert-success" id="login-success">
            <i class="feather-check-circle-fill"></i>
            Login successful! Redirecting...
          </div>';
    exit;

} else {
    // GET request - return login form (not needed for login page, but good pattern)
    http_response_code(405);
    echo '<div class="alert alert-warning" id="login-error-method">
            Invalid request method.
          </div>';
}
