# Task Tracker - Build Prompts

## Overview

These prompts should be executed in order. Each prompt builds upon the previous work. Before starting, ensure you have:
- Ubuntu 24 with LAMP stack installed
- Apache configured and running
- MariaDB/MySQL installed and running
- PHP 8.x installed
- Database created (use the provided `vibe_templates_todo.sql`)

---

## Prompt 1: Environment Setup & Database Connectivity

**Prompt:**
```
I'm building a Task Tracker application using LAMP stack (Ubuntu 24, PHP 8.x, MariaDB). 

First, help me set up and verify the development environment:

1. Create a database configuration file (config/database.php) with PDO connection
2. Create a test script (test-db.php) that:
   - Connects to the database
   - Displays connection status
   - Shows all tables in the database
   - Counts records in key tables (users, tasks, teams)
   - Tests a simple SELECT query

3. Create a utility script (utils/error-log-viewer.php) that:
   - Displays the last 50 lines of Apache error log (/var/log/apache2/error.log)
   - Displays the last 50 lines of PHP error log
   - Shows current PHP error_reporting settings
   - Includes a refresh button to reload logs

4. Create a phpinfo page (info.php) to verify PHP configuration

5. Test that Apache can serve PHP files correctly

Please use the following database credentials:
- Database name: vibe_templates
- Host: localhost
- Use environment variables or a .env file for credentials

Reference files:
- tech-stack.md
- requirements.md
- vibe_templates_todo.sql (already imported)

Make sure all PHP files use proper error handling and display helpful error messages.
```

---

## Prompt 2: Project Structure & Core Files

**Prompt:**
```
Create the base project structure for the Task Tracker application following the requirements.md and tech-stack.md specifications.

Create:

1. Directory structure:
   ```
   /var/www/html/task-tracker/
   ├── config/
   │   ├── database.php
   │   └── app.php
   ├── includes/
   │   ├── functions.php
   │   └── htmx-helpers.php
   ├── views/
   │   ├── layouts/
   │   │   └── app.php (main SPA shell)
   │   └── partials/
   ├── controllers/
   ├── models/
   ├── public/
   │   ├── index.php
   │   ├── .htaccess
   │   └── assets/
   │       ├── css/
   │       │   └── custom.css (from custom.css provided)
   │       ├── js/
   │       └── images/
   └── utils/
   ```

2. Core configuration files:
   - config/app.php with site settings
   - .htaccess for URL rewriting
   - public/index.php as front controller with basic routing

3. Helper files:
   - includes/htmx-helpers.php with functions from htmx-quick-reference.md
   - includes/functions.php with common utilities (escape, redirect, etc.)

4. Main layout file:
   - views/layouts/app.php with SPA shell (navbar, sidebar, content area)
   - Include CSRF token in body tag
   - Reference custom.css from https://mist.edhonour.com/cyber_assets/css/custom.css
   - Include Bootstrap 5.3, HTMX 2.0.8, Alpine.js from CDN

5. Create a basic home page that loads in the SPA shell

Reference:
- requirements.md (SPA Shell Architecture section)
- tech-stack.md
- design-notes.md (for layout structure)
- htmx-quick-reference.md (for PHP helper functions)

Ensure all files follow PHP best practices with proper error handling.
```

---

## Prompt 3: Authentication System

**Prompt:**
```
Build the authentication system for Task Tracker following requirements.md specifications.

Implement:

1. Login system:
   - views/auth/login.php (full page with form)
   - controllers/auth/login.php (handle POST)
   - Validate email/password
   - Create session on success
   - Remember me functionality
   - CSRF protection

2. Registration system:
   - views/auth/register.php
   - controllers/auth/register.php
   - Validate input (email, password, names)
   - Hash password with bcrypt
   - Create user and default team
   - Auto-login after registration

3. Logout:
   - controllers/auth/logout.php
   - Destroy session
   - Redirect to login

4. Password reset:
   - views/auth/forgot-password.php
   - controllers/auth/forgot-password.php
   - Generate reset token (password_resets table)
   - views/auth/reset-password.php
   - controllers/auth/reset-password.php
   - Validate token and update password

5. Session management:
   - includes/auth.php with helper functions:
     - requireAuth()
     - getCurrentUser()
     - hasRole()
     - isAuthenticated()
   - Middleware to protect routes

6. Models:
   - models/User.php with methods:
     - authenticate($email, $password)
     - create($data)
     - findByEmail($email)
     - updatePassword($userId, $newPassword)
     - generateResetToken($email)

Use the users table from vibe_templates_todo.sql.

Reference:
- requirements.md (User Management section)
- tech-stack.md (Security Features section)

All pages should use Bootstrap 5.3 styling and follow design-notes.md.
```

---

## Prompt 4: Main Dashboard & SPA Shell

**Prompt:**
```
Build the main dashboard with full SPA shell functionality using HTMX.

Create:

1. Dashboard view:
   - views/partials/dashboard.php (HTML fragment for htmx)
   - Display welcome message with user name
   - Show task statistics cards (from design-notes.md "Dashboard Stat Cards"):
     - Total tasks
     - Pending tasks
     - In Progress tasks
     - Completed tasks
     - Overdue tasks
   - Recent activity feed (last 10 activities)
   - Upcoming tasks (due in next 7 days)

2. Complete SPA shell in views/layouts/app.php:
   - Top navbar with:
     - Brand/logo
     - Team switcher dropdown
     - Notification bell with count badge
     - User menu (Profile, Settings, Logout)
   - Sidebar navigation with HTMX attributes:
     - Dashboard
     - My Tasks
     - Team Tasks
     - Kanban Board
     - Calendar
     - Activity
     - Reports (admin only)
     - Team Management (admin only)
     - Settings (admin/super_admin only)
   - Main content area with id="page-content"
   - Loading indicator

3. Navigation controller:
   - controllers/dashboard.php
   - Detect htmx request and return appropriate response
   - Fetch statistics from database
   - Fetch recent activities

4. Models:
   - models/Task.php with methods:
     - getStatsByUser($userId)
     - getStatsByTeam($teamId)
     - getUpcoming($userId, $days)
     - getOverdue($userId)
   - models/Activity.php with methods:
     - getRecent($limit, $userId)
     - create($data)

Reference:
- requirements.md (SPA Shell Architecture, Dashboard section)
- design-notes.md (Navigation, Dashboard Stat Cards)
- htmx-quick-reference.md (SPA Shell Navigation)
- custom.css for styling

Ensure all navigation links use htmx attributes (hx-get, hx-target="#page-content", hx-push-url="true").
```

---

## Prompt 5: Task List View & Search

**Prompt:**
```
Build the task list view with active search, filtering, and sorting.

Implement:

1. Task list view:
   - views/partials/tasks/list.php (HTML fragment)
   - Display tasks in a table with sortable columns:
     - Title, Status, Priority, Assignee, Due Date, Category
   - Row actions: Edit, Delete, Complete
   - Status badges with colors from design-notes.md
   - Priority indicators with colored dots
   - Highlight overdue tasks (red background)
   - Pagination (20 tasks per page)

2. Active search:
   - Search input with HTMX (htmx-quick-reference.md pattern)
   - Trigger: keyup changed delay:500ms
   - Target: #task-list
   - Search by title and description

3. Filtering:
   - Filter by status (pending, in_progress, review, completed, cancelled)
   - Filter by priority (low, medium, high, critical)
   - Filter by assignee
   - Filter by due date range
   - Filters update via HTMX

4. Sorting:
   - Click column headers to sort
   - Show sort direction indicators (↑↓)
   - Maintain sort state in URL parameters

5. Bulk operations:
   - Checkboxes for task selection
   - Bulk action bar (appears when items selected)
   - Actions: Complete, Delete, Change Status, Change Priority

6. Controller:
   - controllers/tasks/list.php
   - Handle search, filters, sorting, pagination
   - Return HTML fragment for htmx

7. Update Task model:
   - search($query, $filters, $sort, $page)
   - updateBulk($taskIds, $updates)

Reference:
- requirements.md (Task Management, List View sections)
- design-notes.md (Data Tables section)
- htmx-quick-reference.md (Active Search, Bulk Operations)
- custom.css for table styling

Use htmx for all interactions. No full page reloads.
```

---

## Prompt 6: Task CRUD Operations

**Prompt:**
```
Build complete task CRUD (Create, Read, Update, Delete) functionality with HTMX.

Implement:

1. Create task:
   - views/partials/tasks/create-form.php (modal form)
   - Form fields: title, description, status, priority, due_date, category, tags, assigned_to
   - HTMX form submission (hx-post="/tasks/create")
   - Inline validation for required fields
   - Success: Add new task to list (hx-swap="afterbegin")
   - Log activity in activities table

2. View task details:
   - views/partials/tasks/details.php (modal)
   - Show all task information
   - Show activity timeline
   - Quick actions: Edit, Delete, Complete

3. Edit task (inline):
   - views/partials/tasks/edit-form.php
   - Click task title to edit (pattern from htmx-quick-reference.md)
   - HTMX: hx-get="/tasks/{id}/edit" hx-target="this" hx-swap="outerHTML"
   - Submit: hx-put="/tasks/{id}"
   - Cancel returns to display mode
   - Log activity

4. Delete task:
   - HTMX: hx-delete="/tasks/{id}"
   - hx-confirm="Are you sure?"
   - hx-target="closest tr" hx-swap="delete"
   - Log activity

5. Complete/uncomplete toggle:
   - Quick action button
   - HTMX: hx-patch="/tasks/{id}/complete"
   - Update UI immediately
   - Update completed_at timestamp
   - Log activity

6. Controllers:
   - controllers/tasks/create.php
   - controllers/tasks/update.php
   - controllers/tasks/delete.php
   - controllers/tasks/complete.php
   - controllers/tasks/show.php

7. Expand Task model:
   - create($data)
   - update($id, $data)
   - delete($id)
   - markComplete($id)
   - markIncomplete($id)
   - findById($id)

8. Activity logging:
   - Log all CRUD operations
   - Include user, action, target_type, target_id, description

Reference:
- requirements.md (Task Management section)
- htmx-quick-reference.md (Task Creation Form, Inline Task Edit, Delete with Confirmation)
- design-notes.md (Forms, Modals)

All forms must include CSRF protection. Use htmx for all interactions.
```

---

## Prompt 7: Kanban Board View

**Prompt:**
```
Build the Kanban board view with drag-and-drop functionality.

Implement:

1. Kanban board view:
   - views/partials/kanban/board.php
   - Four columns: To Do (pending), In Progress (in_progress), Review (review), Done (completed)
   - Column headers with task count
   - Column styling from design-notes.md

2. Kanban cards:
   - views/partials/kanban/card.php
   - Show: title, priority indicator, due date, assignee avatar, tags
   - Color-coded left border by priority
   - Hover effects
   - Click to view details (modal)

3. Drag-and-drop:
   - Integrate SortableJS library
   - Allow dragging between columns
   - On drop: update task status via HTMX
   - HTMX: hx-patch="/tasks/{id}/status" with new status
   - Visual feedback during drag
   - Update activity log

4. Filter options:
   - Filter by assignee
   - Filter by priority
   - Filter by category
   - Show/hide completed tasks
   - Filters update via HTMX

5. Quick actions on cards:
   - Edit (opens modal)
   - Delete (with confirmation)
   - Assign to user
   - Change priority

6. Controllers:
   - controllers/kanban/board.php (load board)
   - controllers/tasks/update-status.php (handle drag-drop)

7. Update Task model:
   - getByStatus($teamId, $status, $filters)
   - updateStatus($id, $newStatus)

Reference:
- requirements.md (Kanban Board View section)
- design-notes.md (Kanban Board section)
- htmx-quick-reference.md (Kanban Board Updates pattern)

Include SortableJS from CDN. Use htmx for status updates. Follow custom.css kanban styling.
```

---

## Prompt 8: Calendar View & Events

**Prompt:**
```
Build the calendar view with tasks and events using FullCalendar.

Implement:

1. Calendar view:
   - views/partials/calendar/calendar.php
   - Integrate FullCalendar library (month, week, day views)
   - Display tasks on due dates
   - Display events on scheduled dates
   - Color-code by priority or status (toggle option)
   - Click task/event to view details (modal)

2. Task display on calendar:
   - Show task title (truncated)
   - Color by priority (default) or status
   - Click opens task details modal
   - Drag to reschedule (updates due_date)

3. Event management:
   - Create event form (modal)
   - views/partials/events/create-form.php
   - Fields: title, description, location, start_datetime, end_datetime, all_day, color, type
   - HTMX: hx-post="/events/create"

4. Event details:
   - views/partials/events/details.php (modal)
   - Show all event info
   - List attendees with response status
   - Edit/Delete actions

5. Attendee management:
   - Add attendees (team members)
   - Response status: pending, accepted, declined, tentative
   - Send invitations (log as activity)
   - Update response status

6. Controllers:
   - controllers/calendar/calendar.php (load calendar page)
   - controllers/calendar/events.php (get events for date range - JSON)
   - controllers/events/create.php
   - controllers/events/update.php
   - controllers/events/delete.php
   - controllers/events/rsvp.php

7. Models:
   - models/Event.php:
     - create($data)
     - update($id, $data)
     - delete($id)
     - getByDateRange($teamId, $start, $end)
     - addAttendee($eventId, $userId)
     - updateRsvp($eventId, $userId, $status)
   - Update Task model:
     - getByDateRange($teamId, $start, $end)
     - updateDueDate($id, $newDate)

8. Calendar filters:
   - Toggle: Tasks only, Events only, Both
   - Filter by team member
   - Filter by event type

Reference:
- requirements.md (Calendar View section)
- design-notes.md (Calendar View section)
- vibe_templates_todo.sql (events and event_attendees tables)

Include FullCalendar from CDN. Use htmx for form submissions. Return JSON for calendar event feed.
```

---

## Prompt 9: Team Management

**Prompt:**
```
Build team management functionality for creating teams, managing members, and switching teams.

Implement:

1. Team list view:
   - views/partials/teams/list.php
   - Display user's teams
   - Show team name, member count, role
   - Actions: View, Edit (admin), Leave, Delete (admin)

2. Create team:
   - views/partials/teams/create-form.php (modal)
   - Fields: name, description
   - HTMX: hx-post="/teams/create"
   - Auto-add creator as admin
   - Create default team on user registration

3. Team details:
   - views/partials/teams/details.php
   - Show team info
   - Member list with roles
   - Team statistics (task counts)
   - Add member form (admin only)

4. Add team member:
   - Search users by email/username
   - Assign role (member or admin)
   - HTMX: hx-post="/teams/{id}/add-member"
   - Enforce max members limit (from settings)

5. Remove team member:
   - HTMX: hx-delete="/teams/{id}/members/{userId}"
   - Confirmation required
   - Cannot remove last admin

6. Change member role:
   - Toggle between member and admin
   - HTMX: hx-patch="/teams/{id}/members/{userId}/role"

7. Team switcher (in navbar):
   - Dropdown with user's teams
   - Current team highlighted
   - HTMX: hx-post="/switch-team/{id}"
   - Update session
   - Refresh page content

8. Leave team:
   - HTMX: hx-post="/teams/{id}/leave"
   - Confirmation required
   - Cannot leave if last member

9. Delete team (admin only):
   - HTMX: hx-delete="/teams/{id}"
   - Confirmation required
   - Check if user has other teams

10. Controllers:
    - controllers/teams/list.php
    - controllers/teams/create.php
    - controllers/teams/details.php
    - controllers/teams/add-member.php
    - controllers/teams/remove-member.php
    - controllers/teams/update-role.php
    - controllers/teams/switch.php
    - controllers/teams/leave.php
    - controllers/teams/delete.php

11. Models:
    - models/Team.php:
      - create($name, $description, $createdBy)
      - findById($id)
      - getByUser($userId)
      - addMember($teamId, $userId, $role)
      - removeMember($teamId, $userId)
      - updateMemberRole($teamId, $userId, $role)
      - delete($id)
      - getMemberCount($teamId)
      - isMember($teamId, $userId)
      - isAdmin($teamId, $userId)

Reference:
- requirements.md (Team Management section)
- vibe_templates_todo.sql (teams and team_members tables)
- settings table for max_team_members and max_teams_per_user

All team operations should respect role permissions. Use htmx for all interactions.
```

---

## Prompt 10: Activity Feed & Notifications

**Prompt:**
```
Build the activity feed and notification system.

Implement:

1. Activity feed view:
   - views/partials/activity/feed.php
   - Display activities with timeline design (design-notes.md)
   - Show: user avatar, action, target, timestamp
   - Activity types: created, updated, completed, assigned, deleted
   - Filter by action type
   - Filter by user
   - Filter by date range
   - Pagination

2. Activity timeline component:
   - views/partials/activity/timeline-item.php
   - Circular avatar/icon nodes
   - Colored by action type
   - Expandable for details
   - Links to related objects

3. Polling for updates:
   - HTMX: hx-get="/activity/feed" hx-trigger="every 30s"
   - Only fetch new activities since last update
   - Smooth insertion of new items

4. Notification system:
   - Notification bell in navbar
   - Unread count badge
   - Click to view notifications dropdown
   - Mark as read functionality

5. Notification types:
   - Task assigned to me
   - Task due soon (24 hours)
   - Task overdue
   - Task completed
   - Event invitation
   - Mentioned in comment
   - Team member added

6. Notification preferences:
   - views/partials/settings/notifications.php
   - Enable/disable email notifications
   - Frequency: immediate, daily digest, weekly digest
   - Select which events trigger notifications

7. Controllers:
   - controllers/activity/feed.php
   - controllers/notifications/list.php
   - controllers/notifications/mark-read.php
   - controllers/notifications/preferences.php

8. Models:
   - models/Activity.php:
     - create($userId, $action, $targetType, $targetId, $description)
     - getRecent($limit, $filters)
     - getByUser($userId, $limit)
     - getByTeam($teamId, $limit)
     - getSince($timestamp)
   - models/Notification.php:
     - create($userId, $type, $message, $relatedId)
     - getUnread($userId)
     - markAsRead($notificationId)
     - markAllAsRead($userId)
     - getCount($userId)

9. Helper functions:
   - includes/notifications.php:
     - createNotification($userId, $type, $data)
     - notifyTaskAssigned($taskId, $assigneeId)
     - notifyTaskDueSoon($taskId)
     - notifyEventInvitation($eventId, $attendeeId)

10. Out-of-band updates:
    - Update notification count badge via hx-swap-oob
    - Include in any response: `<span id="notification-count" hx-swap-oob="true">5</span>`

Reference:
- requirements.md (Activity Tracking & Notifications section)
- design-notes.md (Activity Timeline, Notification Badge)
- htmx-quick-reference.md (Notification Counter, Activity Feed with Polling)
- vibe_templates_todo.sql (activities table)

Use htmx for polling and updates. Include out-of-band swaps for notification count.
```

---

## Prompt 11: User Settings & Preferences

**Prompt:**
```
Build user settings and system settings (admin only).

Implement:

1. User profile settings:
   - views/partials/settings/profile.php
   - Edit: first_name, last_name, username, email
   - Change password section
   - HTMX: hx-put="/settings/profile"
   - Inline validation

2. Notification preferences:
   - views/partials/settings/notifications.php
   - Toggle email notifications
   - Select notification frequency
   - Choose which events trigger notifications
   - HTMX: hx-post="/settings/notifications"

3. System settings (super_admin only):
   - views/partials/settings/system.php
   - Organized by category (from settings table):
     - General (site_name, site_description)
     - Security (allow_registration, require_email_verification, session_timeout, password_min_length)
     - Limits (max_file_size, max_team_members, max_teams_per_user)
     - Features (enable_notifications, enable_api, api_rate_limit)
     - Email (SMTP settings)
     - Localization (date_format, time_format, timezone)
   - HTMX: hx-post="/settings/system"

4. Task settings (admin):
   - Task auto-archive days
   - Custom priority levels
   - Custom status options
   - Default priority

5. Controllers:
   - controllers/settings/profile.php
   - controllers/settings/password.php
   - controllers/settings/notifications.php
   - controllers/settings/system.php (super_admin only)

6. Models:
   - models/Setting.php:
     - get($key, $default)
     - set($key, $value)
     - getByCategory($category)
     - updateMultiple($settings)
   - Update User model:
     - updateProfile($userId, $data)
     - updatePassword($userId, $currentPassword, $newPassword)

7. Settings cache:
   - Cache settings in session
   - Refresh on update

8. Validation:
   - Password complexity (minimum length from settings)
   - Email uniqueness
   - Username uniqueness

Reference:
- requirements.md (Settings & Configuration section)
- vibe_templates_todo.sql (settings table)

Use htmx for form submissions. Require current password to change password.
```

---

## Prompt 12: Search & Filters Global

**Prompt:**
```
Build global search functionality and advanced filtering system.

Implement:

1. Global search (in navbar):
   - Search input with autocomplete
   - HTMX: hx-get="/search" hx-trigger="keyup changed delay:300ms"
   - Search across: tasks, teams, users, events
   - Display results dropdown
   - Group by type
   - Click result to navigate

2. Advanced task filters:
   - views/partials/tasks/filter-panel.php
   - Collapsible filter sidebar
   - Filters:
     - Status (multi-select checkboxes)
     - Priority (multi-select checkboxes)
     - Assignee (select)
     - Created by (select)
     - Due date range (date pickers)
     - Category (select)
     - Tags (multi-select)
     - Project (select)
   - Active filter count badge
   - Clear all filters button
   - HTMX: filters update content area

3. Saved filters:
   - Save filter combinations
   - Quick access to saved filters
   - Edit/delete saved filters

4. Filter persistence:
   - Save filter state in session
   - Restore filters on page load
   - URL parameters for shareable filters

5. Controllers:
   - controllers/search/global.php
   - controllers/tasks/filter.php
   - controllers/filters/save.php
   - controllers/filters/load.php

6. Models:
   - models/Search.php:
     - searchAll($query, $userId)
     - searchTasks($query, $filters)
     - searchTeams($query, $userId)
     - searchUsers($query)
     - searchEvents($query, $teamId)

Reference:
- requirements.md (Task Filtering & Search section)
- design-notes.md (Filter Panel section)
- htmx-quick-reference.md (Active Search pattern)

Use htmx for all search and filter interactions. Include Flatpickr for date range pickers.
```

---

## Prompt 13: Reports & Analytics

**Prompt:**
```
Build reporting and analytics dashboard for team admins.

Implement:

1. Reports dashboard:
   - views/partials/reports/dashboard.php
   - Overview cards:
     - Task completion rate (this month)
     - Average time to completion
     - Overdue tasks count
     - Team productivity score
   - Date range selector
   - Export button (CSV)

2. Task completion report:
   - views/partials/reports/completion.php
   - Chart: completed tasks over time (line chart)
   - Breakdown by user
   - Breakdown by priority
   - Breakdown by category

3. User productivity report:
   - views/partials/reports/productivity.php
   - Table: user, tasks created, tasks completed, completion rate
   - Average time to complete
   - Current workload (assigned tasks)

4. Overdue tasks report:
   - views/partials/reports/overdue.php
   - List of overdue tasks
   - Sort by due date, priority, assignee
   - Group by assignee

5. Team performance metrics:
   - Total tasks by status
   - Tasks by priority distribution (pie chart)
   - Tasks created vs completed trend (line chart)
   - Average tasks per team member

6. Export functionality:
   - Export reports to CSV
   - Include filters in export
   - controllers/reports/export.php

7. Controllers:
   - controllers/reports/dashboard.php
   - controllers/reports/completion.php
   - controllers/reports/productivity.php
   - controllers/reports/overdue.php
   - controllers/reports/export.php

8. Models:
   - models/Report.php:
     - getCompletionRate($teamId, $startDate, $endDate)
     - getAverageCompletionTime($teamId, $startDate, $endDate)
     - getOverdueTasks($teamId)
     - getUserProductivity($teamId, $startDate, $endDate)
     - getTasksByStatus($teamId, $startDate, $endDate)
     - getTasksByPriority($teamId, $startDate, $endDate)
     - exportToCsv($data, $filename)

9. Charts:
   - Use Chart.js for visualizations
   - Line charts for trends
   - Pie charts for distributions
   - Bar charts for comparisons

Reference:
- requirements.md (Dashboard & Reporting section)
- design-notes.md (Dashboard Stat Cards section)

Include Chart.js from CDN. Use htmx for date range filtering. Admin/super_admin only.
```

---

## Prompt 14: Error Handling & Validation

**Prompt:**
```
Implement comprehensive error handling, validation, and user feedback.

Create:

1. Global error handler:
   - includes/error-handler.php
   - Custom error pages:
     - views/errors/404.php
     - views/errors/403.php
     - views/errors/500.php
   - Log errors to file
   - Display user-friendly messages
   - Different handling for htmx vs full page requests

2. Form validation:
   - includes/validation.php with functions:
     - validateRequired($value, $field)
     - validateEmail($email)
     - validateLength($value, $min, $max)
     - validateDate($date)
     - validateUnique($table, $column, $value, $excludeId)
   - Client-side validation (HTML5)
   - Server-side validation (required)
   - Real-time validation via htmx (blur event)

3. HTMX error handling:
   - Global event listeners:
     - htmx:responseError (4xx, 5xx)
     - htmx:sendError (network issues)
     - htmx:timeout
   - Display error messages via toast notifications
   - 401: Redirect to login
   - 403: Permission denied message
   - 422: Display validation errors inline
   - 500: Generic error message

4. Toast notification system:
   - views/components/toast.php
   - Types: success, error, warning, info
   - Auto-dismiss after 4 seconds
   - Queue multiple toasts
   - Positioned bottom-right

5. Loading states:
   - Global HTMX indicator
   - Button-specific spinners
   - Skeleton screens for slow-loading content
   - Disable form during submission

6. Validation error display:
   - Inline error messages under fields
   - Error summary at top of form
   - Highlight invalid fields (red border)
   - Clear errors on input change

7. Success feedback:
   - Toast notifications for actions
   - Optimistic UI updates
   - Smooth animations on success

8. CSRF validation:
   - Verify token on all POST/PUT/PATCH/DELETE
   - Return 403 if token invalid
   - Regenerate token periodically

9. Rate limiting:
   - Limit login attempts (5 per 15 minutes)
   - Limit API requests (from settings)
   - Return 429 Too Many Requests

Reference:
- requirements.md (NFR-4: Reliability section)
- tech-stack.md (Security Features)
- htmx skill events.md for error event handling

Use Bootstrap 5 toast component. All validation must be server-side with optional client-side enhancement.
```

---

## Prompt 15: Testing, Optimization & Documentation

**Prompt:**
```
Final phase: testing, optimization, and documentation.

Implement:

1. Testing:
   - Create test-suite.php with tests for:
     - Database connection
     - User authentication
     - Task CRUD operations
     - Team operations
     - HTMX request detection
     - CSRF token validation
     - Session management
   - Test all critical user flows
   - Test error handling
   - Cross-browser testing checklist

2. Performance optimization:
   - Database indexes (verify from schema)
   - Query optimization (use EXPLAIN)
   - Enable gzip compression (.htaccess)
   - Cache static assets (set expires headers)
   - Minify CSS/JS for production
   - Optimize images
   - Add loading indicators to slow queries

3. Security audit:
   - Verify all user input is escaped
   - Check all queries use prepared statements
   - Verify CSRF protection on all forms
   - Test authentication/authorization
   - Review session configuration
   - Check file upload restrictions
   - Verify password hashing

4. Accessibility:
   - Add ARIA labels where needed
   - Verify keyboard navigation works
   - Check color contrast ratios
   - Test with screen reader
   - Add skip navigation link
   - Verify form labels

5. Documentation:
   - Create INSTALL.md with setup instructions
   - Create API.md documenting all endpoints
   - Create DEPLOYMENT.md for production setup
   - Document database schema
   - Create troubleshooting guide
   - Add inline code comments

6. Production readiness:
   - Remove development tools (phpinfo, test scripts)
   - Disable error display (log only)
   - Enable production mode
   - Set secure session settings
   - Configure HTTPS redirect
   - Set proper file permissions
   - Create backup script

7. User guide:
   - Create USER-GUIDE.md with:
     - Getting started
     - Creating tasks
     - Using Kanban board
     - Calendar features
     - Team management
     - Reports
   - Include screenshots

Reference:
- requirements.md (Testing Requirements, NFR sections)
- tech-stack.md

Create a production-ready application. All security best practices must be followed.
```

---

## Notes

- Execute prompts in order - each builds on previous work
- Test thoroughly after each prompt
- Use the htmx skill when implementing any HTMX features
- Reference design-notes.md for all UI/styling decisions
- Reference requirements.md for feature specifications
- Use htmx-quick-reference.md for implementation patterns
- Always check Apache and PHP error logs when troubleshooting
- Commit code after each major prompt completion

## Post-Build Checklist

After completing all prompts:
- [ ] All CRUD operations work correctly
- [ ] Authentication system is secure
- [ ] HTMX navigation works without page reloads
- [ ] Kanban drag-drop functions properly
- [ ] Calendar displays tasks and events
- [ ] Team management works correctly
- [ ] Activity logging is comprehensive
- [ ] Reports generate accurate data
- [ ] Error handling provides good UX
- [ ] All security measures implemented
- [ ] Application is production-ready
