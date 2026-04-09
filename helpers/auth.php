<?php
/**
 * Authentication Helper
 *
 * Provides authentication and authorization functions
 */

require_once __DIR__ . '/session.php';

/**
 * Check if user is authenticated
 * Redirects to login page if not authenticated (for HTMX requests uses HX-Redirect header)
 *
 * @return bool True if authenticated
 */
function check_auth() {
    init_session();

    if (!isset($_SESSION['user_id'])) {
        // Check if this is an HTMX request
        if (isset($_SERVER['HTTP_HX_REQUEST'])) {
            http_response_code(401);
            header('HX-Redirect: /login.php');
            exit;
        } else {
            header('Location: /login.php');
            exit;
        }
    }

    return true;
}

/**
 * Get current user ID from session
 *
 * @return int|null User ID or null if not logged in
 */
function get_user_id() {
    init_session();
    return $_SESSION['user_id'] ?? null;
}

/**
 * Get current user data from session
 *
 * @return array|null User data array or null if not logged in
 */
function get_user() {
    init_session();

    if (!isset($_SESSION['user_id'])) {
        return null;
    }

    return [
        'id' => $_SESSION['user_id'] ?? null,
        'email' => $_SESSION['user_email'] ?? null,
        'first_name' => $_SESSION['user_first_name'] ?? null,
        'last_name' => $_SESSION['user_last_name'] ?? null,
        'username' => $_SESSION['user_username'] ?? null,
        'role' => $_SESSION['user_role'] ?? 'user',
    ];
}

/**
 * Check if current user has admin role
 *
 * @return bool True if user is admin or super_admin
 */
function is_admin() {
    init_session();

    if (!isset($_SESSION['user_role'])) {
        return false;
    }

    return in_array($_SESSION['user_role'], ['admin', 'super_admin']);
}

/**
 * Require admin access - exit with error if not admin
 */
function require_admin() {
    check_auth();

    if (!is_admin()) {
        http_response_code(403);
        if (isset($_SERVER['HTTP_HX_REQUEST'])) {
            echo '<div class="alert alert-danger">Access denied. Admin privileges required.</div>';
        } else {
            header('Location: /app.php');
        }
        exit;
    }
}

/**
 * Login user and create session
 *
 * @param array $user User data from database
 * @param bool $remember Whether to set remember me token
 */
function login_user($user, $remember = false) {
    init_session();
    regenerate_session();

    // Set session variables
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['user_email'] = $user['email'];
    $_SESSION['user_first_name'] = $user['first_name'];
    $_SESSION['user_last_name'] = $user['last_name'];
    $_SESSION['user_username'] = $user['username'];
    $_SESSION['user_role'] = $user['role'];
    $_SESSION['logged_in_at'] = time();

    // Handle remember me
    if ($remember) {
        $token = bin2hex(random_bytes(32));
        $_SESSION['remember_token'] = $token;

        // Set cookie for 30 days
        setcookie(
            'remember_token',
            $token,
            time() + (30 * 24 * 60 * 60),
            '/',
            '',
            isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
            true
        );

        return $token;
    }

    return null;
}

/**
 * Logout user and destroy session
 */
function logout_user() {
    init_session();

    // Clear remember me cookie if exists
    if (isset($_COOKIE['remember_token'])) {
        setcookie('remember_token', '', time() - 3600, '/');
    }

    destroy_session();
}
