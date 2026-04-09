<?php
/**
 * Logout Handler
 *
 * Destroys user session and redirects to login page
 */

require_once '../helpers/session.php';
require_once '../helpers/auth.php';
require_once '../models/User.php';

init_session();

// Clear remember me token from database if user is logged in
if (isset($_SESSION['user_id'])) {
    $userModel = new User();
    $userModel->updateRememberToken($_SESSION['user_id'], null);

    // Log logout
    error_log("User logged out - ID: {$_SESSION['user_id']}");
}

// Destroy session
logout_user();

// Redirect to login page
header('Location: /login.php');
exit;
