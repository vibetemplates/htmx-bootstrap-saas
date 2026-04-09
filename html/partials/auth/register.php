<?php
require_once '../../../helpers/session.php';
require_once '../../../helpers/csrf.php';
require_once '../../../helpers/validation.php';
require_once '../../../helpers/auth.php';
require_once '../../../models/User.php';

init_session();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Process registration

    // Verify CSRF token
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        http_response_code(403);
        echo '<div class="alert alert-danger" id="register-error-csrf">
                <i class="feather-alert-triangle-fill"></i>
                Invalid security token. Please refresh the page and try again.
              </div>';
        exit;
    }

    // Validate required fields
    $required = ['first_name', 'last_name', 'email', 'password', 'confirm_password'];
    $missing = validate_required($required, $_POST);

    if (!empty($missing)) {
        echo '<div class="alert alert-danger" id="register-error-required">
                <i class="feather-alert-triangle-fill"></i>
                Please fill in all required fields.
              </div>';
        exit;
    }

    // Sanitize inputs
    $firstName = sanitize_input($_POST['first_name']);
    $lastName = sanitize_input($_POST['last_name']);
    $email = sanitize_input($_POST['email']);
    $password = $_POST['password'];
    $confirmPassword = $_POST['confirm_password'];

    // Validate email format
    if (!validate_email($email)) {
        echo '<div class="alert alert-danger" id="register-error-email">
                <i class="feather-alert-triangle-fill"></i>
                Please enter a valid email address.
              </div>';
        exit;
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo '<div class="alert alert-danger" id="register-error-password-match">
                <i class="feather-alert-triangle-fill"></i>
                Passwords do not match. Please try again.
              </div>';
        exit;
    }

    // Validate password strength
    $passwordValidation = validate_password($password);
    if (!$passwordValidation['valid']) {
        echo '<div class="alert alert-danger" id="register-error-password-strength">
                <i class="feather-alert-triangle-fill"></i>
                ' . htmlspecialchars($passwordValidation['message']) . '
              </div>';
        exit;
    }

    // Check if email already exists
    $userModel = new User();
    if ($userModel->emailExists($email)) {
        echo '<div class="alert alert-danger" id="register-error-email-exists">
                <i class="feather-alert-triangle-fill"></i>
                An account with this email address already exists.
                <a href="/login.php" class="alert-link">Sign in instead?</a>
              </div>';
        exit;
    }

    // Create user
    $userData = [
        'email' => $email,
        'password' => $password,
        'first_name' => $firstName,
        'last_name' => $lastName
    ];

    $userId = $userModel->create($userData);

    if (!$userId) {
        echo '<div class="alert alert-danger" id="register-error-create">
                <i class="feather-alert-triangle-fill"></i>
                Failed to create account. Please try again later.
              </div>';
        error_log("Failed to create user account for email: $email");
        exit;
    }

    // Create default team for user
    $userModel->createDefaultTeam($userId);

    // Auto-login user
    $user = $userModel->findById($userId);
    if ($user) {
        login_user($user, false);

        // Log successful registration
        error_log("New user registered - ID: $userId, Email: $email");

        // Redirect to app
        header('HX-Redirect: /app.php');
        echo '<div class="alert alert-success" id="register-success">
                <i class="feather-check-circle-fill"></i>
                Account created successfully! Redirecting...
              </div>';
    } else {
        echo '<div class="alert alert-warning" id="register-warning-autologin">
                <i class="feather-check-circle-fill"></i>
                Account created successfully!
                <a href="/login.php" class="alert-link">Click here to sign in.</a>
              </div>';
    }

    exit;

} else {
    // GET request - not supported
    http_response_code(405);
    echo '<div class="alert alert-warning" id="register-error-method">
            Invalid request method.
          </div>';
}
