<?php
/**
 * Notification Preferences Settings Page
 *
 * Allows users to configure notification settings and preferences
 */

session_start();
require_once __DIR__ . '/../../../helpers/auth.php';
require_once __DIR__ . '/../../../models/User.php';
require_once __DIR__ . '/../../../helpers/csrf.php';

check_auth();
$user = get_user();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!verify_csrf_token($_POST['csrf_token'] ?? '')) {
        $error = "Invalid security token";
    } else {
        try {
            $db = Database::getInstance()->getConnection();

            // Update notification settings
            $settings = [
                'task_assigned' => isset($_POST['notify_task_assigned']) ? 1 : 0,
                'task_completed' => isset($_POST['notify_task_completed']) ? 1 : 0,
                'task_due_soon' => isset($_POST['notify_task_due_soon']) ? 1 : 0,
                'task_overdue' => isset($_POST['notify_task_overdue']) ? 1 : 0,
                'comment_mention' => isset($_POST['notify_comment_mention']) ? 1 : 0,
                'team_invite' => isset($_POST['notify_team_invite']) ? 1 : 0,
                'email_notifications' => isset($_POST['email_notifications']) ? 1 : 0,
                'notification_frequency' => $_POST['notification_frequency'] ?? 'immediate'
            ];

            // Save settings to session (in production, would save to database)
            $_SESSION['notification_settings'] = $settings;

            $success = "Notification preferences updated successfully!";
        } catch (Exception $e) {
            error_log("Error saving notification settings: " . $e->getMessage());
            $error = "Failed to save notification preferences";
        }
    }
}

// Get current settings from session or defaults
$settings = $_SESSION['notification_settings'] ?? [
    'task_assigned' => 1,
    'task_completed' => 1,
    'task_due_soon' => 1,
    'task_overdue' => 1,
    'comment_mention' => 1,
    'team_invite' => 1,
    'email_notifications' => 1,
    'notification_frequency' => 'immediate'
];

$csrf_token = generate_csrf_token();
?>

<div id="notification-preferences-container">
  <!-- Header -->
  <div class="mb-4">
    <h3 id="notification-settings-title" class="mb-1">Notification Preferences</h3>
    <p class="text-muted" id="notification-settings-desc">Customize how and when you receive notifications</p>
  </div>

  <!-- Alert Messages -->
  <?php if (isset($success)): ?>
  <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
    <i class="feather-check-circle me-2"></i>
    <?php echo htmlspecialchars($success); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>

  <?php if (isset($error)): ?>
  <div class="alert alert-danger alert-dismissible fade show" role="alert" id="error-alert">
    <i class="feather-alert-circle me-2"></i>
    <?php echo htmlspecialchars($error); ?>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
  <?php endif; ?>

  <!-- Form -->
  <form method="POST" id="notification-preferences-form">
    <input type="hidden" name="csrf_token" value="<?php echo htmlspecialchars($csrf_token); ?>" />

    <!-- In-App Notifications -->
    <div class="card mb-4 shadow-sm" id="in-app-notifications-card">
      <div class="card-header bg-light border-bottom">
        <h5 class="mb-0">
          <i class="feather-bell me-2"></i>In-App Notifications
        </h5>
      </div>
      <div class="card-body">
        <p class="text-muted mb-3" id="in-app-desc">Choose which events trigger in-app notifications in your notification bell.</p>

        <div class="row g-3">
          <!-- Task Assigned -->
          <div class="col-12">
            <div class="form-check form-switch" id="task-assigned-check">
              <input class="form-check-input" type="checkbox" name="notify_task_assigned" id="notify_task_assigned"
                     <?php echo $settings['task_assigned'] ? 'checked' : ''; ?> />
              <label class="form-check-label" for="notify_task_assigned">
                <strong>Task Assigned to Me</strong>
                <br />
                <small class="text-muted">Notify when a task is assigned to me</small>
              </label>
            </div>
          </div>

          <!-- Task Completed -->
          <div class="col-12">
            <div class="form-check form-switch" id="task-completed-check">
              <input class="form-check-input" type="checkbox" name="notify_task_completed" id="notify_task_completed"
                     <?php echo $settings['task_completed'] ? 'checked' : ''; ?> />
              <label class="form-check-label" for="notify_task_completed">
                <strong>Task Completed</strong>
                <br />
                <small class="text-muted">Notify when a task I'm assigned to is completed</small>
              </label>
            </div>
          </div>

          <!-- Task Due Soon -->
          <div class="col-12">
            <div class="form-check form-switch" id="task-due-soon-check">
              <input class="form-check-input" type="checkbox" name="notify_task_due_soon" id="notify_task_due_soon"
                     <?php echo $settings['task_due_soon'] ? 'checked' : ''; ?> />
              <label class="form-check-label" for="notify_task_due_soon">
                <strong>Task Due Soon</strong>
                <br />
                <small class="text-muted">Notify 24 hours before a task is due</small>
              </label>
            </div>
          </div>

          <!-- Task Overdue -->
          <div class="col-12">
            <div class="form-check form-switch" id="task-overdue-check">
              <input class="form-check-input" type="checkbox" name="notify_task_overdue" id="notify_task_overdue"
                     <?php echo $settings['task_overdue'] ? 'checked' : ''; ?> />
              <label class="form-check-label" for="notify_task_overdue">
                <strong>Task Overdue</strong>
                <br />
                <small class="text-muted">Notify when a task I'm assigned to is overdue</small>
              </label>
            </div>
          </div>

          <!-- Comment Mention -->
          <div class="col-12">
            <div class="form-check form-switch" id="comment-mention-check">
              <input class="form-check-input" type="checkbox" name="notify_comment_mention" id="notify_comment_mention"
                     <?php echo $settings['comment_mention'] ? 'checked' : ''; ?> />
              <label class="form-check-label" for="notify_comment_mention">
                <strong>Mentioned in Comment</strong>
                <br />
                <small class="text-muted">Notify when I'm mentioned in a task comment</small>
              </label>
            </div>
          </div>

          <!-- Team Invite -->
          <div class="col-12">
            <div class="form-check form-switch" id="team-invite-check">
              <input class="form-check-input" type="checkbox" name="notify_team_invite" id="notify_team_invite"
                     <?php echo $settings['team_invite'] ? 'checked' : ''; ?> />
              <label class="form-check-label" for="notify_team_invite">
                <strong>Team Invitations</strong>
                <br />
                <small class="text-muted">Notify when I'm invited to a team</small>
              </label>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Email Notifications -->
    <div class="card mb-4 shadow-sm" id="email-notifications-card">
      <div class="card-header bg-light border-bottom">
        <h5 class="mb-0">
          <i class="feather-mail me-2"></i>Email Notifications
        </h5>
      </div>
      <div class="card-body">
        <!-- Enable/Disable Email Notifications -->
        <div class="form-check form-switch mb-3" id="email-notifications-toggle">
          <input class="form-check-input" type="checkbox" name="email_notifications" id="email_notifications"
                 <?php echo $settings['email_notifications'] ? 'checked' : ''; ?> />
          <label class="form-check-label" for="email_notifications">
            <strong>Enable Email Notifications</strong>
            <br />
            <small class="text-muted">Receive email notifications in addition to in-app notifications</small>
          </label>
        </div>

        <!-- Notification Frequency -->
        <div class="mb-0" id="frequency-selection">
          <label for="notification_frequency" class="form-label">
            <strong>Notification Frequency</strong>
            <br />
            <small class="text-muted">How often you'd like to receive email digests</small>
          </label>
          <select class="form-select" id="notification_frequency" name="notification_frequency">
            <option value="immediate" <?php echo $settings['notification_frequency'] === 'immediate' ? 'selected' : ''; ?>>
              <i class="feather-zap me-2"></i>Immediate - Send each notification right away
            </option>
            <option value="daily" <?php echo $settings['notification_frequency'] === 'daily' ? 'selected' : ''; ?>>
              <i class="feather-calendar-day me-2"></i>Daily Digest - Send once per day at 9:00 AM
            </option>
            <option value="weekly" <?php echo $settings['notification_frequency'] === 'weekly' ? 'selected' : ''; ?>>
              <i class="feather-calendar-week me-2"></i>Weekly Digest - Send once per week on Monday
            </option>
          </select>
          <small class="text-muted d-block mt-2 text-danger">
            <i class="feather-info me-1"></i>This setting only applies to email notifications, not in-app notifications.
          </small>
        </div>
      </div>
    </div>

    <!-- Information Card -->
    <div class="card bg-light border-0 mb-4" id="notification-info-card">
      <div class="card-body">
        <h6 class="card-title mb-2">
          <i class="feather-info me-2"></i>About Notifications
        </h6>
        <ul class="mb-0 ps-3 small text-muted" id="notification-info-list">
          <li>In-app notifications always appear in your notification bell when enabled</li>
          <li>Email notifications can be sent immediately or as daily/weekly digests</li>
          <li>You can enable/disable individual notification types</li>
          <li>Critical notifications (like overdue tasks) may still be sent regardless of settings</li>
          <li>To disable all notifications, uncheck "Enable Email Notifications"</li>
        </ul>
      </div>
    </div>

    <!-- Form Actions -->
    <div class="d-flex gap-2" id="notification-form-actions">
      <button type="submit" class="btn btn-primary" id="save-preferences-btn">
        <i class="feather-check-circle me-2"></i>Save Preferences
      </button>
      <button type="reset" class="btn btn-outline-secondary" id="reset-preferences-btn">
        <i class="feather-rotate-cw me-2"></i>Reset
      </button>
    </div>
  </form>
</div>

<style>
.form-check-input:checked {
  background-color: var(--bs-primary);
  border-color: var(--bs-primary);
}

.form-check-label {
  cursor: pointer;
  transition: color 0.2s ease;
}

.form-check-label:hover {
  color: var(--bs-primary);
}

.card {
  border: none;
  border-radius: var(--bs-border-radius);
}

.card-header {
  border-radius: var(--bs-border-radius) var(--bs-border-radius) 0 0;
}
</style>
