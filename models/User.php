<?php
/**
 * User Model
 *
 * Handles all database operations related to users and authentication
 */

require_once __DIR__ . '/../config/database.php';

class User {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance()->getConnection();
    }

    /**
     * Create a new user
     *
     * @param array $data User data (email, password, first_name, last_name)
     * @return int|false User ID on success, false on failure
     */
    public function create($data) {
        try {
            // Hash password
            $hashedPassword = password_hash($data['password'], PASSWORD_DEFAULT);

            // Generate username from email if not provided
            $username = $data['username'] ?? explode('@', $data['email'])[0];

            $stmt = $this->db->prepare("
                INSERT INTO users (email, password, first_name, last_name, username, role, status, created_at)
                VALUES (?, ?, ?, ?, ?, 'user', 'active', NOW())
            ");

            $result = $stmt->execute([
                $data['email'],
                $hashedPassword,
                $data['first_name'] ?? null,
                $data['last_name'] ?? null,
                $username
            ]);

            return $result ? $this->db->lastInsertId() : false;
        } catch (PDOException $e) {
            error_log("User creation error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Find user by email
     *
     * @param string $email User email
     * @return array|false User data or false if not found
     */
    public function findByEmail($email) {
        try {
            $stmt = $this->db->prepare("
                SELECT id, email, password, first_name, last_name, username, role, status, remember_token
                FROM users
                WHERE email = ?
            ");

            $stmt->execute([$email]);
            $user = $stmt->fetch();

            return $user ?: false;
        } catch (PDOException $e) {
            error_log("User lookup error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Find user by ID
     *
     * @param int $id User ID
     * @return array|false User data or false if not found
     */
    public function findById($id) {
        try {
            $stmt = $this->db->prepare("
                SELECT id, email, first_name, last_name, username, role, status, remember_token
                FROM users
                WHERE id = ?
            ");

            $stmt->execute([$id]);
            $user = $stmt->fetch();

            return $user ?: false;
        } catch (PDOException $e) {
            error_log("User lookup error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify user credentials
     *
     * @param string $email User email
     * @param string $password Plain text password
     * @return array|false User data on success, false on failure
     */
    public function verifyPassword($email, $password) {
        $user = $this->findByEmail($email);

        if (!$user) {
            return false;
        }

        // Check if account is active
        if ($user['status'] !== 'active') {
            return false;
        }

        // Verify password
        if (password_verify($password, $user['password'])) {
            // Remove password from returned data
            unset($user['password']);
            return $user;
        }

        return false;
    }

    /**
     * Update remember me token
     *
     * @param int $userId User ID
     * @param string|null $token Remember token or null to clear
     * @return bool Success status
     */
    public function updateRememberToken($userId, $token) {
        try {
            $stmt = $this->db->prepare("
                UPDATE users
                SET remember_token = ?
                WHERE id = ?
            ");

            return $stmt->execute([$token, $userId]);
        } catch (PDOException $e) {
            error_log("Remember token update error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Create password reset token
     *
     * @param string $email User email
     * @return string|false Reset token on success, false on failure
     */
    public function createPasswordResetToken($email) {
        try {
            // Check if user exists
            $user = $this->findByEmail($email);
            if (!$user) {
                return false;
            }

            // Generate secure token
            $token = bin2hex(random_bytes(32));

            // Set expiry to 1 hour from now
            $expiresAt = date('Y-m-d H:i:s', time() + 3600);

            $stmt = $this->db->prepare("
                INSERT INTO password_resets (email, token, created_at, expires_at)
                VALUES (?, ?, NOW(), ?)
            ");

            $result = $stmt->execute([$email, $token, $expiresAt]);

            return $result ? $token : false;
        } catch (PDOException $e) {
            error_log("Password reset token creation error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Verify password reset token
     *
     * @param string $token Reset token
     * @return array|false Token data if valid, false otherwise
     */
    public function verifyPasswordResetToken($token) {
        try {
            $stmt = $this->db->prepare("
                SELECT id, email, token, expires_at, used_at
                FROM password_resets
                WHERE token = ?
                AND expires_at > NOW()
                AND used_at IS NULL
                ORDER BY created_at DESC
                LIMIT 1
            ");

            $stmt->execute([$token]);
            $resetData = $stmt->fetch();

            return $resetData ?: false;
        } catch (PDOException $e) {
            error_log("Password reset token verification error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Reset password using token
     *
     * @param string $token Reset token
     * @param string $newPassword New password (plain text, will be hashed)
     * @return bool Success status
     */
    public function resetPassword($token, $newPassword) {
        try {
            // Verify token
            $resetData = $this->verifyPasswordResetToken($token);
            if (!$resetData) {
                return false;
            }

            // Begin transaction
            $this->db->beginTransaction();

            // Hash new password
            $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

            // Update user password
            $stmt = $this->db->prepare("
                UPDATE users
                SET password = ?, updated_at = NOW()
                WHERE email = ?
            ");
            $stmt->execute([$hashedPassword, $resetData['email']]);

            // Mark token as used
            $stmt = $this->db->prepare("
                UPDATE password_resets
                SET used_at = NOW()
                WHERE id = ?
            ");
            $stmt->execute([$resetData['id']]);

            // Commit transaction
            $this->db->commit();

            return true;
        } catch (PDOException $e) {
            // Rollback on error
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Password reset error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Check if email exists
     *
     * @param string $email Email to check
     * @return bool True if exists
     */
    public function emailExists($email) {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM users WHERE email = ?");
            $stmt->execute([$email]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            error_log("Email check error: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Get all active users
     *
     * @return array Array of users
     */
    public function getAllUsers() {
        try {
            $stmt = $this->db->prepare("
                SELECT id, first_name, last_name, email, username, avatar, status
                FROM users
                WHERE status = 'active'
                ORDER BY first_name ASC, last_name ASC
            ");

            $stmt->execute();
            return $stmt->fetchAll();
        } catch (PDOException $e) {
            error_log("Get all users error: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Create default team for new user
     *
     * @param int $userId User ID
     * @return bool Success status
     */
    public function createDefaultTeam($userId) {
        try {
            $this->db->beginTransaction();

            // Create team
            $stmt = $this->db->prepare("
                INSERT INTO teams (name, created_by, created_at)
                VALUES (?, ?, NOW())
            ");
            $stmt->execute(['My Team', $userId]);
            $teamId = $this->db->lastInsertId();

            // Add user as team member with owner role
            $stmt = $this->db->prepare("
                INSERT INTO team_members (team_id, user_id, role, joined_at)
                VALUES (?, ?, 'owner', NOW())
            ");
            $stmt->execute([$teamId, $userId]);

            $this->db->commit();
            return true;
        } catch (PDOException $e) {
            if ($this->db->inTransaction()) {
                $this->db->rollBack();
            }
            error_log("Default team creation error: " . $e->getMessage());
            return false;
        }
    }
}
