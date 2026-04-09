<?php
/**
 * Session Management Helper
 *
 * Provides secure session initialization, management, and cleanup
 */

/**
 * Initialize secure session with proper security settings
 */
function init_session() {
    if (session_status() === PHP_SESSION_NONE) {
        // Set secure session configuration
        ini_set('session.cookie_httponly', 1);
        ini_set('session.use_only_cookies', 1);
        ini_set('session.cookie_samesite', 'Strict');

        // Set session cookie parameters
        session_set_cookie_params([
            'lifetime' => 0,
            'path' => '/',
            'domain' => '',
            'secure' => isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on',
            'httponly' => true,
            'samesite' => 'Strict'
        ]);

        session_start();

        // Set session timeout (30 minutes of inactivity)
        if (!isset($_SESSION['created'])) {
            $_SESSION['created'] = time();
        } else if (time() - $_SESSION['created'] > 1800) {
            // Session started more than 30 minutes ago
            session_regenerate_id(true);
            $_SESSION['created'] = time();
        }

        // Track last activity for timeout
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1800)) {
            // Last request was more than 30 minutes ago
            destroy_session();
            return false;
        }
        $_SESSION['last_activity'] = time();
    }

    return true;
}

/**
 * Regenerate session ID to prevent session fixation
 */
function regenerate_session() {
    if (session_status() === PHP_SESSION_ACTIVE) {
        session_regenerate_id(true);
        $_SESSION['created'] = time();
    }
}

/**
 * Properly destroy session and clear all data
 */
function destroy_session() {
    if (session_status() === PHP_SESSION_ACTIVE) {
        // Unset all session variables
        $_SESSION = array();

        // Delete session cookie
        if (isset($_COOKIE[session_name()])) {
            setcookie(session_name(), '', time() - 3600, '/');
        }

        // Destroy session
        session_destroy();
    }
}
