<?php
require_once '../../../helpers/auth.php';
require_once '../../../helpers/date.php';
require_once '../../../helpers/ui.php';
require_once '../../../models/Task.php';
require_once '../../../models/Activity.php';
require_once '../../../config/database.php';

check_auth();
$user = get_user();

// Get selected team from session
$selectedTeamId = $_SESSION['selected_team_id'] ?? null;

// Initialize models
$taskModel = new Task();
$activityModel = new Activity();

// Get task statistics
$stats = $taskModel->getTaskStats($user['id'], $selectedTeamId);

// Get team task count if team is selected
$teamTaskCount = 0;
if ($selectedTeamId) {
    // Get total team tasks (tasks created by or assigned to any team member)
    try {
        $db = Database::getInstance()->getConnection();

        // First, get all team member IDs
        $stmt = $db->prepare(
            "SELECT user_id FROM team_members WHERE team_id = :team_id"
        );
        $stmt->execute([':team_id' => $selectedTeamId]);
        $teamMemberIds = $stmt->fetchAll(PDO::FETCH_COLUMN);

        if (!empty($teamMemberIds)) {
            // Count tasks where created_by or assigned_to is a team member
            $placeholders = implode(',', array_fill(0, count($teamMemberIds), '?'));
            $sql = "SELECT COUNT(*) as count FROM tasks
                    WHERE created_by IN ($placeholders)
                    OR assigned_to IN ($placeholders)";

            $stmt = $db->prepare($sql);
            // Bind parameters twice (once for created_by, once for assigned_to)
            $params = array_merge($teamMemberIds, $teamMemberIds);
            $stmt->execute($params);
            $result = $stmt->fetch();
            $teamTaskCount = $result['count'] ?? 0;
        }
    } catch (PDOException $e) {
        error_log("Error getting team task count: " . $e->getMessage());
        $teamTaskCount = 0;
    }
}

// Get upcoming tasks (due in next 7 days)
$upcomingTasks = $taskModel->getUpcomingTasks($user['id'], 7, 5, $selectedTeamId);

// Get recent activities
$recentActivities = $activityModel->getAllRecentActivities($user['id'], 10, $selectedTeamId);
?>

<!-- Dashboard Welcome Section -->
<div class="row mt-2 mx-2 mb-0" id="dashboard-welcome">
  <div class="col-12">
    <div class="card bg-gradient" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
      <div class="card-body">
        <h4 class="mb-1 text-dark">Welcome back, <?php echo htmlspecialchars($user['first_name']); ?>!</h4>
        <p class="mb-0 text-dark"><?php echo date('l, F j, Y'); ?></p>
      </div>
    </div>
  </div>
</div>

<!-- Quick Actions Bar -->
<div class="row mt-0 mx-2 mb-2" id="dashboard-quick-actions-top">
  <div class="col-12">
    <div class="card">
      <div class="card-body py-3">
        <div class="d-flex gap-2 flex-wrap align-items-center">
          <h6 class="mb-0 me-3">Quick Actions:</h6>
          <button class="btn btn-primary"
                  hx-get="/partials/tasks/create-form.php"
                  hx-target="#modal-container"
                  hx-swap="innerHTML">
            <i class="feather-plus-circle me-1"></i> Create New Task
          </button>
          <button class="btn btn-outline-primary" hx-get="/partials/tasks.php" hx-target="#page-content">
            <i class="feather-check-square me-1"></i> View All Tasks
          </button>
          <button class="btn btn-outline-secondary" hx-get="/partials/team/my-team.php" hx-target="#page-content">
            <i class="feather-users me-1"></i> My Team
          </button>
          <button class="btn btn-outline-secondary" hx-get="/partials/settings.php" hx-target="#page-content">
            <i class="feather-settings me-1"></i> Settings
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Task Statistics Cards -->
<div class="row gx-4 mt-0 mx-2">
  <!-- Total Tasks Card -->
  <div class="col-xl-4 col-md-6 mb-2">
    <div class="card stretch stretch-full" id="stat-card-total">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-4">
          <div class="d-flex gap-4 align-items-center">
            <div class="avatar-text avatar-lg bg-primary-subtle">
              <i class="feather-check-square text-primary"></i>
            </div>
            <div>
              <div class="fs-4 fw-bold text-dark">
                <span class="counter"><?php echo $stats['completed']; ?></span>/<span class="counter"><?php echo $stats['total']; ?></span>
              </div>
              <h3 class="fs-13 fw-semibold text-truncate-1-line">Total Tasks</h3>
            </div>
          </div>
          <a href="#" hx-get="/partials/tasks/my-tasks.php" hx-target="#page-content">
            <i class="feather-more-vertical"></i>
          </a>
        </div>
        <div class="pt-4">
          <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="fs-12 fw-medium text-muted text-truncate-1-line" hx-get="/partials/tasks/my-tasks.php?status=completed" hx-target="#page-content">Completed Tasks</a>
            <div class="w-100 text-end">
              <span class="fs-12 text-dark"><?php echo $stats['completed']; ?></span>
              <span class="fs-11 text-muted">(<?php echo $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0; ?>%)</span>
            </div>
          </div>
          <div class="progress mt-2 ht-3">
            <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0; ?>%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Pending Tasks Card -->
  <div class="col-xl-4 col-md-6 mb-2">
    <div class="card stretch stretch-full" id="stat-card-pending">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-4">
          <div class="d-flex gap-4 align-items-center">
            <div class="avatar-text avatar-lg bg-warning-subtle">
              <i class="feather-clock text-warning"></i>
            </div>
            <div>
              <div class="fs-4 fw-bold text-dark">
                <span class="counter"><?php echo $stats['pending']; ?></span>/<span class="counter"><?php echo $stats['total']; ?></span>
              </div>
              <h3 class="fs-13 fw-semibold text-truncate-1-line">Pending Tasks</h3>
            </div>
          </div>
          <a href="#" hx-get="/partials/tasks/my-tasks.php?status=pending" hx-target="#page-content">
            <i class="feather-more-vertical"></i>
          </a>
        </div>
        <div class="pt-4">
          <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="fs-12 fw-medium text-muted text-truncate-1-line" hx-get="/partials/tasks/my-tasks.php?status=pending" hx-target="#page-content">Awaiting Action</a>
            <div class="w-100 text-end">
              <span class="fs-12 text-dark"><?php echo $stats['pending']; ?></span>
              <span class="fs-11 text-muted">(<?php echo $stats['total'] > 0 ? round(($stats['pending'] / $stats['total']) * 100) : 0; ?>%)</span>
            </div>
          </div>
          <div class="progress mt-2 ht-3">
            <div class="progress-bar bg-warning" role="progressbar" style="width: <?php echo $stats['total'] > 0 ? round(($stats['pending'] / $stats['total']) * 100) : 0; ?>%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- In Progress Tasks Card -->
  <div class="col-xl-4 col-md-6 mb-2">
    <div class="card stretch stretch-full" id="stat-card-progress">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-4">
          <div class="d-flex gap-4 align-items-center">
            <div class="avatar-text avatar-lg bg-info-subtle">
              <i class="feather-refresh-cw text-info"></i>
            </div>
            <div>
              <div class="fs-4 fw-bold text-dark">
                <span class="counter"><?php echo $stats['in_progress']; ?></span>/<span class="counter"><?php echo $stats['total']; ?></span>
              </div>
              <h3 class="fs-13 fw-semibold text-truncate-1-line">In Progress</h3>
            </div>
          </div>
          <a href="#" hx-get="/partials/tasks/my-tasks.php?status=in_progress" hx-target="#page-content">
            <i class="feather-more-vertical"></i>
          </a>
        </div>
        <div class="pt-4">
          <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="fs-12 fw-medium text-muted text-truncate-1-line" hx-get="/partials/tasks/my-tasks.php?status=in_progress" hx-target="#page-content">Active Tasks</a>
            <div class="w-100 text-end">
              <span class="fs-12 text-dark"><?php echo $stats['in_progress']; ?></span>
              <span class="fs-11 text-muted">(<?php echo $stats['total'] > 0 ? round(($stats['in_progress'] / $stats['total']) * 100) : 0; ?>%)</span>
            </div>
          </div>
          <div class="progress mt-2 ht-3">
            <div class="progress-bar bg-info" role="progressbar" style="width: <?php echo $stats['total'] > 0 ? round(($stats['in_progress'] / $stats['total']) * 100) : 0; ?>%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Completed Tasks Card -->
  <div class="col-xl-4 col-md-6 mb-2">
    <div class="card stretch stretch-full" id="stat-card-completed">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-4">
          <div class="d-flex gap-4 align-items-center">
            <div class="avatar-text avatar-lg bg-success-subtle">
              <i class="feather-check-circle text-success"></i>
            </div>
            <div>
              <div class="fs-4 fw-bold text-dark">
                <span class="counter"><?php echo $stats['completed']; ?></span>/<span class="counter"><?php echo $stats['total']; ?></span>
              </div>
              <h3 class="fs-13 fw-semibold text-truncate-1-line">Completed</h3>
            </div>
          </div>
          <a href="#" hx-get="/partials/tasks/my-tasks.php?status=completed" hx-target="#page-content">
            <i class="feather-more-vertical"></i>
          </a>
        </div>
        <div class="pt-4">
          <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="fs-12 fw-medium text-muted text-truncate-1-line" hx-get="/partials/tasks/my-tasks.php?status=completed" hx-target="#page-content">Finished Tasks</a>
            <div class="w-100 text-end">
              <span class="fs-12 text-dark"><?php echo $stats['completed']; ?></span>
              <span class="fs-11 text-muted">(<?php echo $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0; ?>%)</span>
            </div>
          </div>
          <div class="progress mt-2 ht-3">
            <div class="progress-bar bg-success" role="progressbar" style="width: <?php echo $stats['total'] > 0 ? round(($stats['completed'] / $stats['total']) * 100) : 0; ?>%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Overdue Tasks Card -->
  <div class="col-xl-4 col-md-6 mb-2">
    <div class="card stretch stretch-full" id="stat-card-overdue">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-4">
          <div class="d-flex gap-4 align-items-center">
            <div class="avatar-text avatar-lg bg-danger-subtle">
              <i class="feather-alert-triangle text-danger"></i>
            </div>
            <div>
              <div class="fs-4 fw-bold text-dark">
                <span class="counter"><?php echo $stats['overdue']; ?></span>/<span class="counter"><?php echo $stats['total']; ?></span>
              </div>
              <h3 class="fs-13 fw-semibold text-truncate-1-line">Overdue</h3>
            </div>
          </div>
          <a href="#" hx-get="/partials/tasks/my-tasks.php?overdue=1" hx-target="#page-content">
            <i class="feather-more-vertical"></i>
          </a>
        </div>
        <div class="pt-4">
          <div class="d-flex align-items-center justify-content-between">
            <a href="#" class="fs-12 fw-medium text-muted text-truncate-1-line" hx-get="/partials/tasks/my-tasks.php?overdue=1" hx-target="#page-content">Past Due Tasks</a>
            <div class="w-100 text-end">
              <span class="fs-12 text-dark"><?php echo $stats['overdue']; ?></span>
              <span class="fs-11 text-muted">(<?php echo $stats['total'] > 0 ? round(($stats['overdue'] / $stats['total']) * 100) : 0; ?>%)</span>
            </div>
          </div>
          <div class="progress mt-2 ht-3">
            <div class="progress-bar bg-danger" role="progressbar" style="width: <?php echo $stats['total'] > 0 ? round(($stats['overdue'] / $stats['total']) * 100) : 0; ?>%"></div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Team Tasks Card -->
  <div class="col-xl-4 col-md-6 mb-2">
    <div class="card stretch stretch-full" id="stat-card-team-tasks">
      <div class="card-body">
        <div class="d-flex align-items-start justify-content-between mb-4">
          <div class="d-flex gap-4 align-items-center">
            <div class="avatar-text avatar-lg bg-primary-subtle">
              <i class="feather-users text-primary"></i>
            </div>
            <div>
              <div class="fs-4 fw-bold text-dark">
                <span class="counter"><?php echo $teamTaskCount; ?></span>
              </div>
              <h3 class="fs-13 fw-semibold text-truncate-1-line">Team Tasks</h3>
            </div>
          </div>
          <?php if ($selectedTeamId): ?>
            <a href="#" hx-get="/partials/tasks/team-tasks.php" hx-target="#page-content">
              <i class="feather-more-vertical"></i>
            </a>
          <?php else: ?>
            <span class="text-muted">
              <i class="feather-more-vertical"></i>
            </span>
          <?php endif; ?>
        </div>
        <div class="pt-4">
          <?php if ($selectedTeamId): ?>
            <div class="d-flex align-items-center justify-content-between">
              <a href="#" class="fs-12 fw-medium text-muted text-truncate-1-line" hx-get="/partials/tasks/team-tasks.php" hx-target="#page-content">View All Team Tasks</a>
              <div class="w-100 text-end">
                <span class="fs-12 text-dark"><?php echo $teamTaskCount; ?></span>
              </div>
            </div>
            <div class="progress mt-2 ht-3">
              <div class="progress-bar bg-primary" role="progressbar" style="width: 100%"></div>
            </div>
          <?php else: ?>
            <div class="text-center text-muted">
              <small>Select a team to view tasks</small>
            </div>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Second Row: Upcoming Tasks and Recent Activity -->
<div class="row gx-4 mx-2">
  <!-- Upcoming Tasks -->
  <div class="col-xl-6 col-12 mb-4">
    <div class="card h-100" id="dashboard-upcoming-tasks">
      <div class="card-header">
        <h5 class="card-title mb-0">Upcoming Tasks</h5>
        <small class="text-muted">Due in the next 7 days</small>
      </div>
      <div class="card-body">
        <?php if (empty($upcomingTasks)): ?>
          <?php echo getEmptyState(
            'bi-calendar-check',
            'No Upcoming Tasks',
            'You have no tasks due in the next 7 days. Great job staying on top of things!',
            '<a href="#" class="btn btn-sm btn-primary" hx-get="/partials/tasks/create.php" hx-target="#page-content">Create New Task</a>'
          ); ?>
        <?php else: ?>
          <div class="list-group list-group-flush">
            <?php foreach ($upcomingTasks as $task): ?>
              <div class="list-group-item px-0" id="upcoming-task-<?php echo $task['id']; ?>">
                <div class="d-flex justify-content-between align-items-start">
                  <div class="flex-grow-1">
                    <h6 class="mb-1"><?php echo htmlspecialchars($task['title']); ?></h6>
                    <div class="d-flex gap-2 align-items-center">
                      <?php echo getPriorityBadge($task['priority']); ?>
                      <?php echo getStatusBadge($task['status']); ?>
                      <?php if (isOverdue($task['due_date'], $task['status'])): ?>
                        <span class="badge bg-danger">
                          <i class="feather-alert-triangle me-1"></i>
                          <?php echo getFriendlyDueDate($task['due_date'], $task['status']); ?>
                        </span>
                      <?php else: ?>
                        <span class="text-muted small">
                          <i class="feather-calendar me-1"></i>
                          <?php echo getFriendlyDueDate($task['due_date'], $task['status']); ?>
                        </span>
                      <?php endif; ?>
                    </div>
                    <?php if (!empty($task['first_name'])): ?>
                      <small class="text-muted">
                        <i class="feather-user me-1"></i>
                        Assigned to: <?php echo htmlspecialchars($task['first_name'] . ' ' . $task['last_name']); ?>
                      </small>
                    <?php endif; ?>
                  </div>
                  <a href="#" class="btn btn-sm btn-outline-primary ms-2">View</a>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
          <div class="mt-3 text-center">
            <a href="#" class="btn btn-sm btn-outline-primary" hx-get="/partials/tasks/my-tasks.php" hx-target="#page-content">
              View All Tasks
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <!-- Recent Activity -->
  <div class="col-xl-6 col-12 mb-4">
    <div class="card h-100" id="dashboard-recent-activity">
      <div class="card-header">
        <h5 class="card-title mb-0">Recent Activity</h5>
        <small class="text-muted">Latest updates from your tasks</small>
      </div>
      <div class="card-body">
        <?php if (empty($recentActivities)): ?>
          <?php echo getEmptyState(
            'bi-activity',
            'No Recent Activity',
            'No recent activity to display. Start working on tasks to see activity here.',
            null
          ); ?>
        <?php else: ?>
          <div class="scroll400">
            <div class="activity-feed">
              <?php foreach ($recentActivities as $activity): ?>
                <div class="feed-item" id="activity-<?php echo $activity['id']; ?>">
                  <div class="d-flex align-items-start">
                    <div class="flex-shrink-0 me-3">
                      <div class="icon-box sm bg-<?php echo $activityModel->getActivityColor($activity['action']); ?> bg-opacity-10 rounded-circle d-flex align-items-center justify-content-center" style="width: 40px; height: 40px;">
                        <i class="bi <?php echo $activityModel->getActivityIcon($activity['action']); ?> text-<?php echo $activityModel->getActivityColor($activity['action']); ?>"></i>
                      </div>
                    </div>
                    <div class="flex-grow-1">
                      <p class="mb-1">
                        <?php echo $activityModel->formatActivity($activity); ?>
                      </p>
                      <small class="text-muted">
                        <i class="feather-clock me-1"></i>
                        <?php echo timeAgo($activity['created_at']); ?>
                      </small>
                    </div>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>
          </div>
          <div class="mt-3 text-center">
            <a href="#" class="btn btn-sm btn-outline-primary" hx-get="/partials/activity/index.php" hx-target="#page-content">
              View All Activity
            </a>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>

<style>
.scroll400 {
  max-height: 400px;
  overflow-y: auto;
}

.activity-feed .feed-item {
  padding: 1rem 0;
  border-bottom: 1px solid rgba(0,0,0,0.1);
}

.activity-feed .feed-item:last-child {
  border-bottom: none;
}

.card:hover {
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
  transition: box-shadow 0.3s ease;
}
</style>
