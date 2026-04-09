<?php
/**
 * Notification List Partial
 *
 * Displays recent notifications for the user
 */

session_start();
require_once '../../../helpers/auth.php';
require_once '../../../helpers/date.php';
require_once '../../../models/Notification.php';

check_auth();
$user = get_user();

// Initialize notification model
$notificationModel = new Notification();

// Get recent notifications (last 10)
$notifications = $notificationModel->getRecentNotifications($user['id'], 10);

// If this is a POST request to mark notifications as read
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['mark_all_read'])) {
        $notificationModel->markAllAsRead($user['id']);

        // Trigger notification update event
        header('HX-Trigger: ' . json_encode([
            'notificationUpdate' => ['count' => 0]
        ]));

        // Reload the notification list
        header('HX-Refresh: true');
        exit;
    } elseif (isset($_POST['notification_id'])) {
        $notificationId = (int)$_POST['notification_id'];
        $notificationModel->markAsRead($notificationId, $user['id']);

        // Get new count
        $unreadCount = $notificationModel->getUnreadCount($user['id']);

        // Trigger notification update event
        header('HX-Trigger: ' . json_encode([
            'notificationUpdate' => ['count' => $unreadCount]
        ]));

        // Reload the notification list
        header('HX-Refresh: true');
        exit;
    }
}

// Get updated unread count
$unreadCount = $notificationModel->getUnreadCount($user['id']);

// Send notification count update via HX-Trigger for out-of-band swap
header('HX-Trigger: ' . json_encode([
    'notificationUpdate' => ['count' => $unreadCount]
]));

// Display notifications
?>

<?php if (empty($notifications)): ?>
  <div class="text-center p-4">
    <i class="feather-bell-slash fs-1 text-muted mb-2 d-block"></i>
    <p class="text-muted mb-0">No notifications</p>
  </div>
<?php else: ?>
  <div class="list-group list-group-flush" id="notification-items">
    <?php foreach ($notifications as $notification): ?>
      <div class="list-group-item list-group-item-action <?php echo empty($notification['read_at']) ? 'bg-light' : ''; ?>" id="notification-item-<?php echo $notification['id']; ?>">
        <div class="d-flex w-100 justify-content-between align-items-start">
          <div class="flex-grow-1">
            <div class="d-flex align-items-center mb-1">
              <i class="bi <?php echo $notificationModel->getNotificationIcon($notification['type']); ?> text-<?php echo $notificationModel->getNotificationColor($notification['type']); ?> me-2"></i>
              <p class="mb-0 fw-<?php echo empty($notification['read_at']) ? 'bold' : 'normal'; ?>">
                <?php echo htmlspecialchars($notification['message']); ?>
              </p>
            </div>
            <small class="text-muted">
              <i class="feather-clock me-1"></i>
              <?php echo timeAgo($notification['created_at']); ?>
            </small>
          </div>
          <?php if (empty($notification['read_at'])): ?>
            <button class="btn btn-sm btn-link text-primary p-0 ms-2"
                    hx-post="/partials/notifications/list.php"
                    hx-vals='{"notification_id": <?php echo $notification['id']; ?>}'
                    hx-swap="none"
                    title="Mark as read">
              <i class="feather-check2"></i>
            </button>
          <?php endif; ?>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <div class="border-top p-3 text-center">
    <button class="btn btn-sm btn-outline-primary me-2"
            hx-post="/partials/notifications/list.php"
            hx-vals='{"mark_all_read": true}'
            hx-swap="none">
      <i class="feather-check2-all me-1"></i> Mark All as Read
    </button>
    <a href="#" class="btn btn-sm btn-outline-secondary" hx-get="/partials/notifications/index.php" hx-target="#page-content">
      View All
    </a>
  </div>
<?php endif; ?>
