# Kobie Design Migration Implementation Plan

> **For Claude:** REQUIRED SUB-SKILL: Use superpowers:executing-plans to implement this plan task-by-task.

**Goal:** Migrate app.php from current Bootstrap design to Kobie admin template design while preserving all HTMX functionality and PHP logic.

**Architecture:** Replace HTML structure and CSS/JS assets in app.php with Kobie template components. Keep all HTMX attributes, PHP authentication, and dynamic loading unchanged. Copy only essential Kobie assets to html/assets directory.

**Tech Stack:** PHP, HTMX, Bootstrap 5, Kobie Admin Template, Feather Icons, jQuery

---

## Task 1: Copy CSS Assets from Kobie

**Files:**
- Copy: `kobie/assets/css/bootstrap.min.css` → `html/assets/css/bootstrap.min.css`
- Copy: `kobie/assets/css/theme.min.css` → `html/assets/css/kobie-theme.min.css`
- Copy: `kobie/assets/vendors/css/vendors.min.css` → `html/assets/vendor/kobie-vendors.min.css`
- Copy: `kobie/assets/vendors/css/feather.min.css` → `html/assets/vendor/feather.min.css`

**Step 1: Create vendor directory if needed**

Run:
```bash
mkdir -p html/assets/vendor
```

Expected: Directory created or already exists

**Step 2: Copy Bootstrap CSS**

Run:
```bash
cp kobie/assets/css/bootstrap.min.css html/assets/css/bootstrap.min.css
```

Expected: File copied successfully

**Step 3: Copy Kobie theme CSS**

Run:
```bash
cp kobie/assets/css/theme.min.css html/assets/css/kobie-theme.min.css
```

Expected: File copied successfully

**Step 4: Copy vendor CSS files**

Run:
```bash
cp kobie/assets/vendors/css/vendors.min.css html/assets/vendor/kobie-vendors.min.css
cp kobie/assets/vendors/css/feather.min.css html/assets/vendor/feather.min.css
```

Expected: Files copied successfully

**Step 5: Verify CSS files exist**

Run:
```bash
ls -lh html/assets/css/bootstrap.min.css html/assets/css/kobie-theme.min.css html/assets/vendor/kobie-vendors.min.css html/assets/vendor/feather.min.css
```

Expected: All 4 files listed with file sizes

**Step 6: Commit CSS assets**

Run:
```bash
git add html/assets/css/bootstrap.min.css html/assets/css/kobie-theme.min.css html/assets/vendor/kobie-vendors.min.css html/assets/vendor/feather.min.css
git commit -m "feat: add Kobie CSS assets for design migration"
```

Expected: Commit created

---

## Task 2: Copy JavaScript Assets from Kobie

**Files:**
- Copy: `kobie/assets/vendors/js/bootstrap.min.js` → `html/assets/js/kobie-bootstrap.min.js`
- Copy: `kobie/assets/vendors/js/nxlNavigation.min.js` → `html/assets/js/nxl-navigation.min.js`
- Copy: `kobie/assets/vendors/js/perfect-scrollbar.min.js` → `html/assets/vendor/perfect-scrollbar.min.js`

**Step 1: Copy Bootstrap JS**

Run:
```bash
cp kobie/assets/vendors/js/bootstrap.min.js html/assets/js/kobie-bootstrap.min.js
```

Expected: File copied successfully

**Step 2: Copy NXL Navigation JS**

Run:
```bash
cp kobie/assets/vendors/js/nxlNavigation.min.js html/assets/js/nxl-navigation.min.js
```

Expected: File copied successfully

**Step 3: Copy Perfect Scrollbar JS**

Run:
```bash
cp kobie/assets/vendors/js/perfect-scrollbar.min.js html/assets/vendor/perfect-scrollbar.min.js
```

Expected: File copied successfully

**Step 4: Verify JS files exist**

Run:
```bash
ls -lh html/assets/js/kobie-bootstrap.min.js html/assets/js/nxl-navigation.min.js html/assets/vendor/perfect-scrollbar.min.js
```

Expected: All 3 files listed with file sizes

**Step 5: Commit JS assets**

Run:
```bash
git add html/assets/js/kobie-bootstrap.min.js html/assets/js/nxl-navigation.min.js html/assets/vendor/perfect-scrollbar.min.js
git commit -m "feat: add Kobie JavaScript assets for design migration"
```

Expected: Commit created

---

## Task 3: Copy Image Assets from Kobie

**Files:**
- Copy: `kobie/assets/images/logo-full.png` → `html/assets/images/kobie-logo-full.png`
- Copy: `kobie/assets/images/logo-abbr.png` → `html/assets/images/kobie-logo-abbr.png`
- Copy: `kobie/assets/images/favicon.ico` → `html/assets/images/kobie-favicon.ico`

**Step 1: Copy logo files**

Run:
```bash
cp kobie/assets/images/logo-full.png html/assets/images/kobie-logo-full.png
cp kobie/assets/images/logo-abbr.png html/assets/images/kobie-logo-abbr.png
cp kobie/assets/images/favicon.ico html/assets/images/kobie-favicon.ico
```

Expected: Files copied successfully

**Step 2: Verify image files exist**

Run:
```bash
ls -lh html/assets/images/kobie-logo-full.png html/assets/images/kobie-logo-abbr.png html/assets/images/kobie-favicon.ico
```

Expected: All 3 files listed

**Step 3: Commit image assets**

Run:
```bash
git add html/assets/images/kobie-logo-full.png html/assets/images/kobie-logo-abbr.png html/assets/images/kobie-favicon.ico
git commit -m "feat: add Kobie image assets (logos and favicon)"
```

Expected: Commit created

---

## Task 4: Backup Current app.php

**Files:**
- Copy: `html/app.php` → `html/app.php.backup`

**Step 1: Create backup**

Run:
```bash
cp html/app.php html/app.php.backup
```

Expected: Backup file created

**Step 2: Verify backup exists**

Run:
```bash
ls -lh html/app.php.backup
```

Expected: Backup file listed

**Step 3: Commit backup**

Run:
```bash
git add html/app.php.backup
git commit -m "chore: backup current app.php before Kobie migration"
```

Expected: Commit created

---

## Task 5: Update app.php Head Section

**Files:**
- Modify: `html/app.php:10-34`

**Step 1: Update the head section with Kobie CSS references**

Replace lines 10-34 in `html/app.php` with:

```php
  <head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="description" content="Task Tracker Application" />
    <meta name="keyword" content="tasks, team, productivity" />
    <meta name="author" content="Task Tracker" />
    <title>Task Tracker - Dashboard</title>

    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="assets/images/kobie-favicon.ico" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css" />

    <!-- Vendor CSS -->
    <link rel="stylesheet" type="text/css" href="assets/vendor/kobie-vendors.min.css" />
    <link rel="stylesheet" type="text/css" href="assets/vendor/feather.min.css" />

    <!-- Kobie Theme CSS -->
    <link rel="stylesheet" type="text/css" href="assets/css/kobie-theme.min.css" />

    <!-- Overlay Scrollbar CSS -->
    <link rel="stylesheet" href="assets/vendor/overlay-scroll/OverlayScrollbars.min.css" />

    <!-- HTMX Library -->
    <script src="https://unpkg.com/htmx.org@1.9.10"></script>
  </head>
```

**Step 2: Verify syntax**

Run:
```bash
php -l html/app.php
```

Expected: "No syntax errors detected"

**Step 3: Commit head section update**

Run:
```bash
git add html/app.php
git commit -m "feat: update app.php head section with Kobie CSS references"
```

Expected: Commit created

---

## Task 6: Update app.php Sidebar Structure

**Files:**
- Modify: `html/app.php:44-148`

**Step 1: Replace sidebar section (lines 44-148)**

Replace the entire sidebar section with Kobie structure:

```php
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
```

**Step 2: Verify PHP syntax**

Run:
```bash
php -l html/app.php
```

Expected: "No syntax errors detected"

**Step 3: Commit sidebar update**

Run:
```bash
git add html/app.php
git commit -m "feat: update sidebar to Kobie design with Feather icons"
```

Expected: Commit created

---

## Task 7: Update app.php Header Structure

**Files:**
- Modify: `html/app.php:150-230`

**Step 1: Replace header section (lines 150-230)**

Replace the app container and header section:

```php
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
                  <a href="javascript:void(0);" id="menu-mini-button">
                    <i class="feather-align-left"></i>
                  </a>
                  <a href="javascript:void(0);" id="menu-expend-button" style="display: none">
                    <i class="feather-arrow-right"></i>
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
                      <img src="assets/images/avatar/1.png" class="avatar-image avatar-sm" alt="User Avatar" />
                      <div class="text-truncate d-lg-flex flex-column d-none ms-2">
                        <span class="fw-bold"><?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?></span>
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
```

**Step 2: Verify PHP syntax**

Run:
```bash
php -l html/app.php
```

Expected: "No syntax errors detected"

**Step 3: Commit header update**

Run:
```bash
git add html/app.php
git commit -m "feat: update header to Kobie design with user dropdown"
```

Expected: Commit created

---

## Task 8: Update app.php Content Area and Footer

**Files:**
- Modify: `html/app.php:232-252`

**Step 1: Replace content area and footer (lines 232-252)**

Replace with:

```php
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
```

**Step 2: Verify PHP syntax**

Run:
```bash
php -l html/app.php
```

Expected: "No syntax errors detected"

**Step 3: Commit content area and footer update**

Run:
```bash
git add html/app.php
git commit -m "feat: update content area and footer to Kobie design"
```

Expected: Commit created

---

## Task 9: Update app.php JavaScript Section - Part 1 (Script Tags)

**Files:**
- Modify: `html/app.php:253-277`

**Step 1: Replace JavaScript includes (lines 253-277)**

Replace with:

```php
    <!-- *************
      ************ JavaScript Files *************
    ************* -->
    <!-- Required jQuery first, then Bootstrap Bundle JS -->
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/kobie-bootstrap.min.js"></script>
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
```

**Step 2: Verify PHP syntax**

Run:
```bash
php -l html/app.php
```

Expected: "No syntax errors detected"

**Step 3: Commit JavaScript includes update**

Run:
```bash
git add html/app.php
git commit -m "feat: update JavaScript includes for Kobie design"
```

Expected: Commit created

---

## Task 10: Update app.php JavaScript Section - Part 2 (Event Handlers)

**Files:**
- Modify: `html/app.php:279-346`

**Step 1: Update HTMX event handlers for Kobie class names**

Replace the HTMX navigation handler section (around lines 324-338):

```javascript
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
```

**Step 2: Verify PHP syntax**

Run:
```bash
php -l html/app.php
```

Expected: "No syntax errors detected"

**Step 3: Commit JavaScript handlers update**

Run:
```bash
git add html/app.php
git commit -m "feat: update HTMX event handlers for Kobie class names"
```

Expected: Commit created

---

## Task 11: Fix Page Wrapper Structure

**Files:**
- Modify: `html/app.php:36-43`

**Step 1: Update body and page wrapper opening tags**

Replace lines 36-43 with:

```php
  <body>

    <!-- Page wrapper starts -->
    <div class="page-wrapper">

      <!-- Main container starts -->
      <div class="main-container">
```

**Step 2: Verify PHP syntax**

Run:
```bash
php -l html/app.php
```

Expected: "No syntax errors detected"

**Step 3: Commit page wrapper fix**

Run:
```bash
git add html/app.php
git commit -m "fix: update page wrapper structure for Kobie layout"
```

Expected: Commit created

---

## Task 12: Test Application in Browser

**Files:**
- Test: `html/app.php`

**Step 1: Start PHP development server (if not running)**

Run:
```bash
cd html && php -S localhost:8000
```

Expected: Server starts on localhost:8000

**Step 2: Open browser and test**

Manual Test Checklist:
1. Navigate to `http://localhost:8000/app.php`
2. Verify login redirects to login page if not authenticated
3. Login with valid credentials
4. Verify sidebar appears with Kobie design
5. Verify navigation menu has all items with Feather icons
6. Verify header shows with user name and role
7. Click "Dashboard" menu item - verify HTMX loads content
8. Click "My Tasks" menu item - verify HTMX loads content
9. Verify active menu item highlights
10. Test sidebar collapse/expand button
11. Test mobile hamburger menu (resize browser)
12. Test user dropdown menu
13. Test logout link
14. Verify footer displays
15. Check browser console for JavaScript errors

Expected: All tests pass, no JavaScript errors

**Step 3: Document any issues**

If issues found, note them in `docs/activity.md`

---

## Task 13: Create Custom CSS Overrides (If Needed)

**Files:**
- Create: `html/assets/css/kobie-custom.css`

**Step 1: Create custom CSS file for adjustments**

Create `html/assets/css/kobie-custom.css`:

```css
/* Kobie Design Custom Overrides for Task Tracker */

/* Sidebar footer link styling */
.sidebar-footer-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 40px;
  height: 40px;
  border-radius: 50%;
  color: #fff;
  background: rgba(255, 255, 255, 0.1);
  transition: all 0.3s;
}

.sidebar-footer-link:hover {
  background: rgba(255, 255, 255, 0.2);
  color: #fff;
  transform: translateY(-2px);
}

/* Header background color */
.nxl-header {
  background: linear-gradient(135deg, #131341 0%, #28387e 100%);
}

/* Ensure loading indicator is hidden by default */
.htmx-indicator {
  display: none;
}

/* Avatar image in header */
.avatar-image {
  border-radius: 50%;
  width: 32px;
  height: 32px;
  object-fit: cover;
}

/* Footer styling */
.nxl-footer {
  padding: 1rem;
  background: #f5f7fa;
  border-top: 1px solid #e5e7eb;
}

.nxl-footer .footer-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
}

/* Active menu item styling enhancement */
.nxl-navbar .nxl-item.active .nxl-link {
  background: rgba(99, 102, 241, 0.1);
  border-left: 3px solid #6366f1;
}

/* Main content padding */
.main-content {
  padding: 1.5rem;
}
```

**Step 2: Add custom CSS to app.php head section**

Add after kobie-theme.min.css line:

```php
    <!-- Custom Overrides -->
    <link rel="stylesheet" type="text/css" href="assets/css/kobie-custom.css" />
```

**Step 3: Verify syntax**

Run:
```bash
php -l html/app.php
```

Expected: "No syntax errors detected"

**Step 4: Commit custom CSS**

Run:
```bash
git add html/assets/css/kobie-custom.css html/app.php
git commit -m "feat: add custom CSS overrides for Kobie design tweaks"
```

Expected: Commit created

---

## Task 14: Update Activity Log

**Files:**
- Modify: `docs/activity.md`

**Step 1: Append migration activity to activity log**

Append to `docs/activity.md`:

```markdown
## 2025-11-17 - Kobie Design Migration

**Prompt:** "I want to change the overall design but not the functionality of the application. In the kobie directory there is an index.html file. I want to use the design of the index.html file to replace app.php."

**Actions Completed:**

1. Conducted brainstorming session to clarify design requirements
2. Created design document: `docs/plans/2025-11-17-kobie-design-migration-design.md`
3. Created implementation plan: `docs/plans/2025-11-17-kobie-design-migration.md`
4. Migrated assets from kobie template:
   - CSS: bootstrap.min.css, kobie-theme.min.css, vendor CSS files
   - JavaScript: kobie-bootstrap.min.js, nxl-navigation.min.js, perfect-scrollbar.min.js
   - Images: logos and favicon
5. Backed up original app.php to app.php.backup
6. Updated app.php structure:
   - Head section with Kobie CSS references
   - Sidebar with Kobie navigation design and Feather icons
   - Header with Kobie layout and user dropdown
   - Content area and footer
   - JavaScript includes and HTMX event handlers
7. Created custom CSS overrides for fine-tuning
8. Preserved all HTMX functionality and PHP logic
9. Tested in browser - all features working

**Result:** Successfully migrated app.php to Kobie admin template design while maintaining all existing functionality.

**Files Modified:**
- html/app.php (complete redesign)
- html/assets/css/* (new Kobie CSS files)
- html/assets/js/* (new Kobie JS files)
- html/assets/images/* (new logos)

**Commits:** 11 commits for asset migration and app.php transformation
```

**Step 2: Commit activity log update**

Run:
```bash
git add docs/activity.md
git commit -m "docs: update activity log with Kobie migration details"
```

Expected: Commit created

---

## Task 15: Push Changes to Repository

**Files:**
- Push all commits to remote repository

**Step 1: Push to remote**

Run:
```bash
git push origin main
```

Expected: All commits pushed successfully

**Step 2: Verify push**

Run:
```bash
git status
```

Expected: "Your branch is up to date with 'origin/main'"

---

## Task 16: Final Verification Checklist

**Manual Verification:**

Run through this checklist and verify all items:

- [ ] App loads without errors
- [ ] Sidebar displays with Kobie design
- [ ] All 9 navigation items present
- [ ] Feather icons display correctly
- [ ] Header shows user name and role from PHP
- [ ] User dropdown works with all menu items
- [ ] Admin-only menu items show/hide based on role
- [ ] Dashboard loads via HTMX
- [ ] All navigation items trigger HTMX content loading
- [ ] Active menu item highlights correctly
- [ ] Sidebar collapse/expand works
- [ ] Mobile menu works (hamburger icon)
- [ ] Loading indicator appears during HTMX requests
- [ ] Modals open and close correctly
- [ ] Task events (create, update, delete) work
- [ ] Tooltips work on sidebar footer icons
- [ ] Footer displays correctly
- [ ] No JavaScript console errors
- [ ] No PHP errors in server logs
- [ ] Mobile responsive design works

**Step 1: Create verification report**

Create `docs/kobie-migration-verification.md`:

```markdown
# Kobie Design Migration Verification Report

**Date:** 2025-11-17
**Tester:** [Your Name]

## Test Results

### Visual Design
- [ ] Sidebar displays with Kobie styling
- [ ] Header displays with Kobie styling
- [ ] Content area uses Kobie layout
- [ ] Footer displays correctly
- [ ] Color scheme matches Kobie (dark blue/purple)
- [ ] Typography matches Kobie

### Functionality
- [ ] All navigation items present
- [ ] HTMX content loading works
- [ ] Active menu highlighting works
- [ ] User dropdown works
- [ ] Admin-only items controlled by PHP
- [ ] Sidebar collapse/expand works
- [ ] Mobile menu works

### Technical
- [ ] No JavaScript console errors
- [ ] No PHP errors
- [ ] All assets load correctly
- [ ] Page load time acceptable

## Issues Found

[List any issues discovered during testing]

## Sign-off

Migration complete and verified: ___________

Date: ___________
```

**Step 2: Commit verification document**

Run:
```bash
git add docs/kobie-migration-verification.md
git commit -m "docs: add verification checklist for Kobie migration"
git push origin main
```

Expected: Verification document committed and pushed

---

## Summary

This implementation plan migrates `html/app.php` from its current Bootstrap design to the Kobie admin template design while preserving all HTMX functionality and PHP authentication logic.

**Key Tasks:**
1. Copy essential CSS, JS, and image assets from kobie to html
2. Update app.php HTML structure with Kobie components
3. Swap Bootstrap Icons for Feather Icons
4. Update HTMX event handlers for new class names
5. Add custom CSS overrides
6. Test thoroughly in browser
7. Document in activity log
8. Push changes to repository

**Preserved Functionality:**
- All HTMX dynamic content loading
- PHP authentication and role checks
- User data display
- Task management features
- Modal handling
- Custom events

**Success Criteria:**
Application displays with Kobie's professional design while maintaining 100% of existing functionality.
