<?php
require_once '../helpers/auth.php';

check_auth();
$user = get_user();
?>
<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Task Tracker Application" />
    <meta name="keyword" content="tasks, team, productivity" />
    <meta name="author" content="Task Tracker" />
    <title>Task Tracker - Dashboard</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/favicon-vt.png" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />

    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/kobie-vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendor/feather.min.css" />

    <!-- Kobie Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/kobie-theme.min.css" />

    <!-- Custom Overrides -->
    <link rel="stylesheet" type="text/css" href="assets/css/kobie-custom.css" />

    <!-- Overlay Scrollbar CSS -->
    <link rel="stylesheet" href="assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />

    <!-- HTMX Library -->
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
  </head>

  <body>

    <!-- Page wrapper starts -->
    <div class="page-wrapper">

      <!-- Main container starts -->
      <div class="main-container">

        <!-- Sidebar wrapper starts -->
        <nav id="kobie-sidebar" class="nxl-navigation">
          <div id="kobie-nav-wrapper" class="navbar-wrapper">

            <!-- Logo starts -->
            <div id="kobie-logo-area" class="m-header">
              <a href="app.php" class="b-brand">
                <img src="assets/images/kobie-logo-full.png" alt="Task Tracker" class="logo logo-lg" />
                <img src="assets/images/kobie-logo-abbr.png" alt="Task Tracker" class="logo logo-sm" />
              </a>
            </div>
            <!-- Logo ends -->

            <!-- Navigation menu starts -->
            <div id="kobie-nav-menu" class="navbar-content">
              <ul class="nxl-navbar">
                <li class="nxl-item nxl-caption">
                  <label>Navigation</label>
                </li>
                <li class="nxl-item active current-page" id="nav-dashboard">
                  <a href="#" class="nxl-link" hx-get="/partials/dashboard/index.php" hx-target="#page-content">
                    <span class="nxl-micon"><i class="feather-airplay"></i></span>
                    <span class="nxl-mtext">Dashboard</span>
                  </a>
                </li>
                <li class="nxl-item" id="nav-my-tasks">
                  <a href="#" class="nxl-link" hx-get="/partials/tasks/my-tasks.php" hx-target="#page-content">
                    <span class="nxl-micon"><i class="feather-check-circle"></i></span>
                    <span class="nxl-mtext">My Tasks</span>
                  </a>
                </li>
                <li class="nxl-item" id="nav-team-tasks">
                  <a href="#" class="nxl-link" hx-get="/partials/tasks/team-tasks.php" hx-target="#page-content">
                    <span class="nxl-micon"><i class="feather-users"></i></span>
                    <span class="nxl-mtext">Team Tasks</span>
                  </a>
                </li>
                <li class="nxl-item" id="nav-my-team">
                  <a href="#" class="nxl-link" hx-get="/partials/team/my-team.php" hx-target="#page-content">
                    <span class="nxl-micon"><i class="feather-user"></i></span>
                    <span class="nxl-mtext">My Team</span>
                  </a>
                </li>
                <li class="nxl-item" id="nav-kanban">
                  <a href="#" class="nxl-link" hx-get="/partials/kanban/index.php" hx-target="#page-content">
                    <span class="nxl-micon"><i class="feather-trello"></i></span>
                    <span class="nxl-mtext">Kanban Board</span>
                  </a>
                </li>
                <li class="nxl-item" id="nav-calendar">
                  <a href="#" class="nxl-link" hx-get="/partials/calendar/index.php" hx-target="#page-content">
                    <span class="nxl-micon"><i class="feather-calendar"></i></span>
                    <span class="nxl-mtext">Calendar</span>
                  </a>
                </li>
                <li class="nxl-item" id="nav-activity">
                  <a href="#" class="nxl-link" hx-get="/partials/activity/index.php" hx-target="#page-content">
                    <span class="nxl-micon"><i class="feather-activity"></i></span>
                    <span class="nxl-mtext">Activity</span>
                  </a>
                </li>
                <li class="nxl-item" id="nav-archived-tasks">
                  <a href="#" class="nxl-link" hx-get="/partials/tasks/archived.php" hx-target="#page-content">
                    <span class="nxl-micon"><i class="feather-archive"></i></span>
                    <span class="nxl-mtext">Archived Tasks</span>
                  </a>
                </li>
                <?php if (is_admin()): ?>
                <li class="nxl-item" id="nav-settings">
                  <a href="#" class="nxl-link" hx-get="/partials/settings.php" hx-target="#page-content">
                    <span class="nxl-micon"><i class="feather-settings"></i></span>
                    <span class="nxl-mtext">Settings</span>
                  </a>
                </li>
                <?php endif; ?>
              </ul>
            </div>
            <!-- Navigation menu ends -->

            <!-- Sidebar settings starts -->
            <div id="kobie-sidebar-settings" class="sidebar-footer gap-1 d-lg-flex d-none">
              <a href="#" class="sidebar-footer-link" data-bs-toggle="tooltip" data-bs-placement="top"
                hx-get="/partials/tasks/my-tasks.php" hx-target="#page-content" hx-swap="innerHTML"
                data-bs-custom-class="custom-tooltip-danger" title="My Tasks">
                <i class="feather-check-circle"></i>
              </a>
              <a href="#" class="sidebar-footer-link" data-bs-toggle="tooltip" data-bs-placement="top"
                hx-get="/partials/team/my-team.php" hx-target="#page-content" hx-swap="innerHTML"
                data-bs-custom-class="custom-tooltip-warning" title="My Team">
                <i class="feather-users"></i>
              </a>
              <a href="#" class="sidebar-footer-link" data-bs-toggle="tooltip" data-bs-placement="top"
                hx-get="/partials/kanban/index.php" hx-target="#page-content" hx-swap="innerHTML"
                data-bs-custom-class="custom-tooltip-success" title="Kanban Board">
                <i class="feather-trello"></i>
              </a>
              <a href="#" class="sidebar-footer-link" data-bs-toggle="tooltip" data-bs-placement="top"
                hx-get="/partials/calendar/index.php" hx-target="#page-content" hx-swap="innerHTML"
                data-bs-custom-class="custom-tooltip-info" title="Calendar">
                <i class="feather-calendar"></i>
              </a>
              <a href="/logout.php" class="sidebar-footer-link" data-bs-toggle="tooltip" data-bs-placement="top"
                data-bs-custom-class="custom-tooltip-secondary" title="Logout">
                <i class="feather-power"></i>
              </a>
            </div>
            <!-- Sidebar settings ends -->

          </div>
        </nav>
        <!-- Sidebar wrapper ends -->

        <!-- App container starts -->
        <div id="kobie-content-wrapper" class="nxl-container">

          <!-- App header starts -->
          <header id="kobie-header" class="nxl-header">
            <div class="header-wrapper">

              <!-- Header left starts -->
              <div class="header-left d-flex align-items-center gap-4">
                <!-- Mobile toggler -->
                <a href="javascript:void(0);" class="nxl-head-mobile-toggler" id="mobile-collapse">
                  <div class="hamburger hamburger--arrowturn">
                    <div class="hamburger-box">
                      <div class="hamburger-inner"></div>
                    </div>
                  </div>
                </a>

                <!-- Navigation toggle -->
                <div class="nxl-navigation-toggle">
                  <a href="javascript:void(0);" id="vertical-nav-toggle">
                    <i class="feather-align-left"></i>
                  </a>
                </div>

                <!-- Page title -->
                <div class="d-flex align-items-center">
                  <h5 class="fw-bold text-white m-0" id="page-title">Task Tracker</h5>
                </div>
              </div>
              <!-- Header left ends -->

              <!-- Header right starts -->
              <div class="header-right ms-auto">
                <div class="d-flex align-items-center">

                  <!-- Global loading indicator -->
                  <div class="htmx-indicator me-3" id="global-loading-indicator">
                    <div class="spinner-border spinner-border-sm text-white" role="status">
                      <span class="visually-hidden">Loading...</span>
                    </div>
                  </div>

                  <!-- User dropdown -->
                  <div class="dropdown" id="kobie-user-dropdown">
                    <a id="userSettings" class="dropdown-toggle d-flex py-2 align-items-center text-white"
                       href="#!" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                      <div class="text-truncate d-lg-flex flex-column d-none ms-2">
                        <span class="fw-bold fs-18"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></span>
                        <span class="fs-11 text-white-50"><?php echo ucfirst(htmlspecialchars($user['role'])); ?></span>
                      </div>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end shadow-lg">
                      <a class="dropdown-item d-flex align-items-center" href="#"
                         hx-get="/partials/settings.php" hx-target="#page-content" hx-swap="innerHTML">
                        <i class="feather-settings fs-5 me-2"></i>Settings
                      </a>
                      <a class="dropdown-item d-flex align-items-center" href="#"
                         hx-get="/partials/reset-password.php" hx-target="#page-content" hx-swap="innerHTML">
                        <i class="feather-lock fs-5 me-2"></i>Reset Password
                      </a>
                      <?php if (is_admin()): ?>
                      <a class="dropdown-item d-flex align-items-center" href="#"
                         hx-get="/partials/team/add-member.php" hx-target="#page-content" hx-swap="innerHTML">
                        <i class="feather-user-plus fs-5 me-2"></i>Add Team Members
                      </a>
                      <a class="dropdown-item d-flex align-items-center" href="#"
                         hx-get="/partials/teams/index.php" hx-target="#page-content" hx-swap="innerHTML">
                        <i class="feather-users fs-5 me-2"></i>Team Management
                      </a>
                      <?php endif; ?>
                      <div class="dropdown-divider"></div>
                      <div class="mx-3 mt-2 d-grid">
                        <a href="/logout.php" class="btn btn-primary">Logout</a>
                      </div>
                    </div>
                  </div>

                </div>
              </div>
              <!-- Header right ends -->

            </div>
          </header>
          <!-- App header ends -->

          <!-- App body starts -->
          <main class="nxl-content" id="page-content"
                hx-get="/partials/dashboard/index.php"
                hx-trigger="load">
            <div class="main-content">
              <!-- Content will be loaded here via HTMX -->
            </div>
          </main>
          <!-- App body ends -->

          <!-- App footer starts -->
          <footer id="kobie-footer" class="nxl-footer">
            <div class="footer-wrapper">
              <p class="mb-0 text-muted">© Task Tracker 2025. All Rights Reserved.</p>
            </div>
          </footer>
          <!-- App footer ends -->

        </div>
        <!-- App container ends -->

      </div>
      <!-- Main container ends -->

    </div>
    <!-- Page wrapper ends -->

    <!-- *************
      ************ JavaScript Files *************
    ************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/moment.min.js"></script>

    <!-- *************
      ************ Vendor Js Files *************
    ************* -->

    <!-- Perfect Scrollbar JS -->
    <script src="assets/vendor/perfect-scrollbar.min.js"></script>

    <!-- NXL Navigation JS -->
    <script src="assets/js/nxl-navigation.min.js"></script>

    <!-- Overlay Scroll JS -->
    <script src="assets/vendor/overlay-scroll/jquery.overlayScrollbars.min.js"></script>
    <script src="assets/vendor/overlay-scroll/custom-scrollbar.js"></script>

    <!-- Apex Charts - Loaded dynamically per page -->
    <script src="assets/vendor/apex/apexcharts.min.js"></script>

    <!-- Rating - Loaded dynamically per page -->
    <script src="assets/vendor/rating/raty.js"></script>

    <!-- Custom JS files -->
    <script src="assets/js/custom.js"></script>

    <!-- HTMX Navigation Handler -->
    <script>
      // Helper function to dynamically load scripts
      function loadScript(src) {
        return new Promise(function(resolve, reject) {
          var script = document.createElement('script');
          script.src = src;
          script.onload = resolve;
          script.onerror = reject;
          document.body.appendChild(script);
        });
      }

      // Initialize page content (charts, tooltips, etc.)
      function initializePageContent() {
        // Reinitialize Bootstrap tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
          return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Reinitialize rating stars if raty is available
        if (typeof $.fn.raty === 'function') {
          $('.readonly3').raty({ readOnly: true, score: 3 });
          $('.readonly4').raty({ readOnly: true, score: 4 });
          $('.readonly5').raty({ readOnly: true, score: 5 });
        }

        // Load chart scripts if dashboard elements exist
        if (document.getElementById('visits-conversions')) {
          loadScript('assets/vendor/apex/custom/home/visits-conversions.js');
        }
        if (document.getElementById('sales')) {
          loadScript('assets/vendor/apex/custom/home/sales.js');
        }
        if (document.getElementById('income')) {
          loadScript('assets/vendor/apex/custom/home/income.js');
        }
        if (document.getElementById('income2')) {
          loadScript('assets/vendor/apex/custom/home/income2.js');
        }
        if (document.getElementById('option1') || document.getElementById('option2') || document.getElementById('option3')) {
          loadScript('assets/vendor/apex/custom/home/sparkline.js');
        }
      }

      // Handle navigation active state - UPDATED FOR KOBIE
      document.addEventListener('htmx:afterRequest', function(evt) {
        if (evt.detail.target.id === 'page-content') {
          // Remove active class from all menu items - UPDATED CLASS SELECTOR
          document.querySelectorAll('.nxl-navbar .nxl-item').forEach(function(li) {
            li.classList.remove('active', 'current-page');
          });

          // Add active class to clicked menu item
          const trigger = evt.detail.elt;
          if (trigger && trigger.closest('.nxl-item')) {
            trigger.closest('.nxl-item').classList.add('active', 'current-page');
          }
        }
      });

      // Initialize dashboard scripts after HTMX loads content
      document.addEventListener('htmx:afterSwap', function(evt) {
        if (evt.detail.target.id === 'page-content') {
          initializePageContent();
        }
      });

      // Handle team switch event - reload current page
      document.body.addEventListener('teamSwitched', function(evt) {
        // Update team name in header
        if (evt.detail && evt.detail.teamName) {
          const teamNameEl = document.getElementById('selected-team-name');
          if (teamNameEl) {
            teamNameEl.textContent = evt.detail.teamName;
          }
        }

        // Reload dashboard or current view
        const pageContent = document.getElementById('page-content');
        if (pageContent) {
          // Find the active menu item and trigger its click - UPDATED CLASS SELECTOR
          const activeLink = document.querySelector('.nxl-navbar .nxl-item.active .nxl-link');
          if (activeLink) {
            htmx.trigger(activeLink, 'click');
          } else {
            // Default to dashboard
            htmx.ajax('GET', '/partials/dashboard/index.php', {target: '#page-content'});
          }
        }
      });

      // Handle notification updates
      document.body.addEventListener('notificationUpdate', function(evt) {
        if (evt.detail && evt.detail.count !== undefined) {
          const badge = document.getElementById('notification-count');
          const count = parseInt(evt.detail.count);

          if (count > 0) {
            if (badge) {
              badge.textContent = count > 99 ? '99+' : count;
            } else {
              // Create badge if it doesn't exist
              const bell = document.getElementById('notificationBell');
              if (bell) {
                const newBadge = document.createElement('span');
                newBadge.id = 'notification-count';
                newBadge.className = 'position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger';
                newBadge.textContent = count > 99 ? '99+' : count;
                bell.appendChild(newBadge);
              }
            }
          } else {
            // Remove badge if count is 0
            if (badge) {
              badge.remove();
            }
          }
        }
      });

      // Set global HTMX indicator
      document.body.addEventListener('htmx:beforeRequest', function() {
        document.getElementById('global-loading-indicator').style.display = 'block';
      });

      document.body.addEventListener('htmx:afterRequest', function() {
        document.getElementById('global-loading-indicator').style.display = 'none';
      });

      // Handle modal events
      document.body.addEventListener('closeModal', function() {
        // Close any open Bootstrap modals
        const modals = document.querySelectorAll('.modal.show');
        modals.forEach(function(modal) {
          const bsModal = bootstrap.Modal.getInstance(modal);
          if (bsModal) {
            bsModal.hide();
          }
        });
        // Clear modal container
        const container = document.getElementById('modal-container');
        if (container) {
          container.innerHTML = '';
        }
      });

      // Handle task list refresh events
      document.body.addEventListener('refreshTaskList', function() {
        // Trigger refresh of task list table if it exists
        const taskTable = document.getElementById('my-tasks-list-table') ||
                         document.getElementById('team-tasks-list-table') ||
                         document.getElementById('task-list-table');
        if (taskTable) {
          htmx.trigger(taskTable, 'refresh');
        }
      });

      // Handle task created event
      document.body.addEventListener('taskCreated', function(evt) {
        // Close modal
        htmx.trigger(document.body, 'closeModal');
        // Refresh task list
        htmx.trigger(document.body, 'refreshTaskList');
      });

      // Handle task updated event
      document.body.addEventListener('taskUpdated', function(evt) {
        // Refresh task list
        htmx.trigger(document.body, 'refreshTaskList');
      });

      // Handle task deleted event
      document.body.addEventListener('taskDeleted', function(evt) {
        // Close modal if open
        htmx.trigger(document.body, 'closeModal');
        // Refresh task list
        htmx.trigger(document.body, 'refreshTaskList');
      });

      // Auto-show modals loaded into modal-container
      document.body.addEventListener('htmx:afterSwap', function(evt) {
        if (evt.detail.target.id === 'modal-container') {
          // Find any modal in the container and show it
          const modal = evt.detail.target.querySelector('.modal');
          if (modal) {
            const bsModal = new bootstrap.Modal(modal);
            bsModal.show();

            // Focus on first input when modal is shown
            modal.addEventListener('shown.bs.modal', function() {
              const firstInput = modal.querySelector('input:not([type="hidden"]), textarea, select');
              if (firstInput) {
                firstInput.focus();
              }
            });

            // Clean up on close
            modal.addEventListener('hidden.bs.modal', function() {
              evt.detail.target.innerHTML = '';
            });
          }
        }
      });
    </script>

    <!-- Modal Container for HTMX-loaded modals -->
    <div id="modal-container"></div>
  </body>

</html>
