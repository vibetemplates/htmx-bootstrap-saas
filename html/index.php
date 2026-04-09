<?php
/**
 * Landing Page
 *
 * Redirects to app.php if authenticated, otherwise to login.php
 */

require_once '../helpers/session.php';

init_session();

if (isset($_SESSION['user_id'])) {
    // User is logged in, redirect to app
    header('Location: /app.php');
} else {
    // User is not logged in, redirect to login
    header('Location: /login.php');
}
exit;
