# Kanban Board Implementation Plan

## Overview
Build a full-featured Kanban board view with drag-and-drop functionality using HTMX, SortableJS, and Bootstrap 5.3 following the htmx-php-backend and htmx-bootstrap-frontend patterns.

## Current State Analysis
- ✅ Navigation link exists in app.php (line 105-110)
- ✅ Task model has complete CRUD and search methods
- ✅ Activity model exists with logging capabilities
- ✅ Bootstrap 5.3 is already integrated
- ✅ HTMX is loaded and configured
- ⚠️ Need: Create /partials/kanban/ directory structure
- ⚠️ Need: Kanban board view and styling
- ⚠️ Need: Drag-and-drop functionality
- ⚠️ Need: Status update endpoint
- ⚠️ Need: Filter functionality
- ⚠️ Need: Quick actions on cards

## Todo Items

### Phase 1: Directory Structure & Files
- [ ] Create `/var/www/html/partials/kanban/` directory
- [ ] Create `index.php` - Main Kanban board view
- [ ] Create `board.php` - Board columns partial (refreshable)
- [ ] Create `update-status.php` - Drag-and-drop status update endpoint
- [ ] Create `card.php` - Individual task card template

### Phase 2: Main Kanban Board View (index.php)
- [ ] Create container with unique IDs for all divs
- [ ] Add page header with title "Kanban Board"
- [ ] Add filter controls:
  - Filter by assignee dropdown
  - Filter by priority dropdown
  - Filter by category dropdown (if applicable)
  - Show/hide completed toggle
  - Clear filters button
- [ ] Add view toggle (could switch to list view later)
- [ ] Add "Create Task" button (reuse existing modal)
- [ ] Include SortableJS from CDN
- [ ] Add loading indicator
- [ ] HTMX load board.php into main container
- [ ] Include filter state in HTMX requests

### Phase 3: Board Columns Partial (board.php)
- [ ] Get filtered tasks from Task model using search()
- [ ] Group tasks by status (pending, in_progress, review, completed)
- [ ] Create four column layout using Bootstrap grid:
  - Column 1: To Do (pending) - Blue theme
  - Column 2: In Progress (in_progress) - Yellow theme
  - Column 3: Review (review) - Purple theme
  - Column 4: Done (completed) - Green theme
- [ ] Each column has:
  - Header with status name
  - Task count badge
  - Color-coded background/border
  - Sortable task card container
  - Empty state message if no tasks
- [ ] All divs have unique IDs
- [ ] Apply Bootstrap classes for responsive design

### Phase 4: Task Card Component (card.php)
- [ ] Accept task data as parameter
- [ ] Display card with:
  - Unique ID: `kanban-card-{task_id}`
  - Data attributes: data-task-id, data-status, data-priority
  - Color-coded left border by priority:
    - Critical: Red border-left
    - High: Orange border-left
    - Medium: Yellow border-left
    - Low: Green border-left
- [ ] Card content:
  - Task title (clickable to view details)
  - Priority indicator badge
  - Due date with icon (show overdue in red)
  - Assignee avatar/initials (if assigned)
  - Tags (if present)
  - Category badge (if present)
- [ ] Hover effects:
  - Shadow elevation
  - Cursor: move
  - Slight scale/transform
- [ ] Quick action buttons (show on hover or always visible):
  - View button (modal) - hx-get="/partials/tasks/view.php?id=X"
  - Edit button (modal) - hx-get="/partials/tasks/edit-form.php?id=X"
  - Delete button (confirmation) - hx-delete="/partials/tasks/delete.php?id=X"
- [ ] All elements have unique IDs

### Phase 5: Drag-and-Drop Integration
- [ ] Include SortableJS from CDN:
  ```html
  <script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
  ```
- [ ] Initialize SortableJS for each column:
  - Set group: 'kanban' (allows dragging between columns)
  - Set animation: 300ms
  - Set ghostClass for drag preview
  - Set dragClass for dragging state
  - Handle onEnd event
- [ ] On drop (onEnd event):
  - Get task ID from card data attribute
  - Get new status from target column data attribute
  - Use HTMX to call update-status endpoint
  - Show loading indicator
  - Update activity log
- [ ] Visual feedback during drag:
  - Ghost card styling
  - Highlight drop zones
  - Smooth animations

### Phase 6: Update Status Endpoint (update-status.php)
- [ ] Accept POST/PATCH request
- [ ] Get parameters: task_id, new_status
- [ ] Verify user authorization (owns or assigned to task)
- [ ] Validate status value (pending, in_progress, review, completed)
- [ ] Update task status using Task->update()
- [ ] Log activity: 'task_status_changed' with description
- [ ] Return updated card HTML or success response
- [ ] Handle errors gracefully
- [ ] Add CSRF protection

### Phase 7: Filter Functionality
- [ ] Implement filter controls in index.php
- [ ] Get assignable users for assignee filter
- [ ] Filter controls trigger HTMX request to board.php:
  - hx-get="/partials/kanban/board.php"
  - hx-target="#kanban-board-container"
  - hx-include all filter inputs
  - hx-trigger="change" for selects
- [ ] board.php processes filter parameters:
  - Read $_GET parameters
  - Build filters array for Task->search()
  - Filter: assignee, priority, category
  - Optional: hide completed tasks
- [ ] Update URL parameters to maintain filter state
- [ ] Clear filters resets all and reloads board

### Phase 8: Quick Actions on Cards
- [ ] View task details (modal):
  - Click card title or view button
  - hx-get="/partials/tasks/view.php?id=X"
  - hx-target="#modal-container"
  - Opens in Bootstrap modal
- [ ] Edit task (modal):
  - Click edit icon/button
  - hx-get="/partials/tasks/edit-form.php?id=X"
  - hx-target="#modal-container"
  - Reuses existing edit form
- [ ] Delete task:
  - Click delete icon/button
  - hx-delete="/partials/tasks/delete.php?id=X"
  - hx-confirm="Delete this task?"
  - hx-target="#kanban-card-{id}"
  - hx-swap="outerHTML"
  - On success: remove card from board
- [ ] Assign to user:
  - Dropdown or modal with user selection
  - Update assignee via HTMX
  - Refresh card or board
- [ ] Change priority:
  - Dropdown or buttons
  - Update priority via HTMX
  - Update card color coding

### Phase 9: Styling & Design
- [ ] Add custom CSS for Kanban board (in main.min.css or inline):
  - Column styles with color themes
  - Card styles with shadows and hover effects
  - Priority color coding (border-left)
  - Drag-and-drop visual feedback
  - Responsive breakpoints
  - Empty state styling
- [ ] Column headers:
  - Bold text with icon
  - Count badge (Bootstrap badge)
  - Subtle background color
- [ ] Cards:
  - White background
  - Box shadow
  - Rounded corners
  - Padding
  - Hover: elevation increase
  - Border-left color by priority
- [ ] Priority colors:
  - Critical: #dc3545 (red)
  - High: #fd7e14 (orange)
  - Medium: #ffc107 (yellow)
  - Low: #28a745 (green)
- [ ] Responsive design:
  - Desktop: 4 columns side by side
  - Tablet: 2 columns (2x2 grid)
  - Mobile: 1 column (stack vertically)

### Phase 10: Activity Logging
- [ ] Log all status changes in update-status.php:
  - Action: 'task_status_changed'
  - Description: "Changed status from {old_status} to {new_status}"
  - Use Activity->logActivity()
- [ ] Log task updates from quick actions:
  - Assignee change
  - Priority change
  - Task edit
  - Task delete (before deletion)
- [ ] Ensure all activities include:
  - User ID (from session)
  - Target type: 'task'
  - Target ID: task ID
  - Timestamp (auto)

### Phase 11: Error Handling & Validation
- [ ] Validate all inputs:
  - Task ID is numeric
  - Status is valid enum value
  - User is authorized
- [ ] Handle errors gracefully:
  - 400: Invalid input
  - 403: Unauthorized
  - 404: Task not found
  - 500: Server error
- [ ] Return user-friendly error messages:
  - Bootstrap alert HTML
  - Show in modal or toast
- [ ] Log errors for debugging (error_log)

### Phase 12: Testing
- [ ] Test Kanban board loads correctly
- [ ] Test filtering:
  - Filter by assignee
  - Filter by priority
  - Filter by category
  - Clear filters
  - Multiple filters combined
- [ ] Test drag-and-drop:
  - Drag within same column
  - Drag between columns
  - Status updates correctly
  - Activity logged
  - Visual feedback works
- [ ] Test quick actions:
  - View task (modal opens)
  - Edit task (modal, then updates)
  - Delete task (confirmation, then removes)
  - Assign user (updates card)
  - Change priority (updates card color)
- [ ] Test responsive design:
  - Desktop view (4 columns)
  - Tablet view (2 columns)
  - Mobile view (1 column)
- [ ] Test with different data:
  - Empty board
  - Many tasks
  - Long task titles
  - Missing assignees
  - Overdue tasks

### Phase 13: Documentation & Commit
- [ ] Update docs/activity.md with:
  - This prompt
  - List all files created/modified
  - Describe Kanban board features
  - Note drag-and-drop implementation
  - Security measures applied
- [ ] Create git commit:
  - Add all new files
  - Descriptive commit message
  - Push to remote

## File Structure

### New Files to Create
```
/var/www/html/partials/kanban/
├── index.php           # Main Kanban board page with filters
├── board.php           # Board columns partial (refreshable)
├── update-status.php   # Drag-drop status update endpoint
└── card.php            # Task card template (reusable)
```

### Files to Reference (Existing)
```
/var/www/html/partials/tasks/
├── view.php            # Task details modal (reuse)
├── edit-form.php       # Edit task modal (reuse)
├── delete.php          # Delete endpoint (reuse)
└── create-form.php     # Create task modal (reuse)

/var/www/models/
├── Task.php            # Task model with search() method
└── Activity.php        # Activity logging

/var/www/html/
└── app.php             # Has Kanban nav link (line 105-110)
```

## Technical Requirements

### SortableJS Integration
- CDN: https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js
- Initialize on each `.kanban-column-cards` container
- Settings:
  - group: 'kanban'
  - animation: 300
  - handle: '.kanban-card' (entire card is draggable)
  - ghostClass: 'sortable-ghost'
  - dragClass: 'sortable-drag'
  - onEnd: function(evt) - handle status update

### HTMX Patterns
- hx-get for loading board and filters
- hx-post/hx-patch for status updates
- hx-delete for task deletion
- hx-target for specifying swap location
- hx-swap for swap strategy
- hx-trigger for event-driven updates
- hx-include for including filter values
- hx-indicator for loading states
- HX-Trigger header for server events

### Bootstrap Components
- Grid system for columns
- Cards for tasks
- Badges for counts, priority, tags
- Buttons for actions
- Modals for view/edit
- Dropdowns for filters
- Alerts for messages
- Tooltips for icons

### Security Requirements
- CSRF tokens on all forms
- Authorization checks (user owns/assigned to task)
- Input validation and sanitization
- XSS prevention (htmlspecialchars)
- SQL injection prevention (prepared statements)
- Error logging (not displaying to user)

### Activity Logging
- Log all status changes
- Include old and new status in description
- Log task updates, deletions
- Format: "Changed status from 'Pending' to 'In Progress'"
- Auto-timestamp

### UI/UX Requirements
- Smooth animations (300ms)
- Visual feedback during drag
- Loading indicators
- Empty states
- Responsive design
- Accessible (ARIA labels)
- Color-coded by priority
- Hover effects
- All divs have unique IDs

## Success Criteria
- ✅ Kanban board displays with 4 columns
- ✅ Tasks grouped by status correctly
- ✅ Drag-and-drop works smoothly
- ✅ Status updates on drop
- ✅ Activity logged for status changes
- ✅ Filters work (assignee, priority, category)
- ✅ Quick actions work (view, edit, delete)
- ✅ Cards show priority color coding
- ✅ Responsive on mobile, tablet, desktop
- ✅ No page reloads (all HTMX)
- ✅ Proper error handling
- ✅ Authorization enforced

## Design Guidelines
- Follow existing Bootstrap 5.3 theme
- Match design of existing task views
- Use existing modals for create/edit/view
- Color-coded columns and priority borders
- Icon-based action buttons
- Responsive grid layout
- Loading spinners during requests
- Empty state messages

## Notes
- Keep implementation simple
- Follow HTMX patterns from skills
- Reuse existing task CRUD partials
- Use existing Activity model for logging
- Match existing code style
- All queries use prepared statements
- Log all errors for debugging
- User-friendly error messages
- Test all functionality manually

## Libraries & CDN
- SortableJS: https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js
- HTMX: Already loaded in app.php
- Bootstrap 5.3: Already loaded
- Bootstrap Icons: Already loaded

---

# Login Page Redesign Plan

## Overview
Update the login page to match the minimal authentication design pattern with logo-centered card layout.

## Current State
- ✅ Login page exists at `/html/login.php`
- ✅ HTMX integration working
- ✅ Bootstrap 5.3 loaded
- ✅ Logo file available at `/html/assets/images/kobie-logo-abbr.png`
- ⚠️ Need: Update HTML structure to minimal card design
- ⚠️ Need: Update CSS to match new design
- ⚠️ Need: Add logo at top center of card
- ⚠️ Need: Integrate Feather icons
- ⚠️ Need: Update form layout and styling

## Design Requirements
Based on the provided HTML template:
- Centered card with logo positioned at top center (translate-middle)
- Logo in circular white background with shadow
- Clean minimal design with auth-minimal-wrapper
- Form with simple input fields (no input-group icons)
- "Remember Me" checkbox and "Forget password?" link on same row
- Social login buttons (Facebook, Twitter, Github) with Feather icons
- "Don't have an account?" link to register
- All divs must have unique IDs per CLAUDE.md requirement

## Todo Items

### Phase 1: Update HTML Structure
- [ ] Replace current login-container structure with auth-minimal-wrapper
- [ ] Add auth-minimal-inner container
- [ ] Add minimal-card-wrapper container
- [ ] Update card structure with proper positioning classes
- [ ] Add logo div with position-absolute, translate-middle, top-0, start-50
- [ ] Set logo container: wd-50, bg-white, p-2, rounded-circle, shadow-lg
- [ ] Update card-body padding to p-sm-5
- [ ] Add unique IDs to all div elements

### Phase 2: Update Form Layout
- [ ] Update heading structure (h2 and h4)
- [ ] Add welcome/description paragraph
- [ ] Remove input-group wrappers (icons inside inputs)
- [ ] Update input fields to simple form-control
- [ ] Update Remember Me checkbox layout
- [ ] Add "Forget password?" link aligned right
- [ ] Use d-flex justify-content-between for checkbox/link row
- [ ] Update submit button text and styling

### Phase 3: Add Social Login Section
- [ ] Add divider with "or" text (border-bottom with positioned span)
- [ ] Add social login buttons container (d-flex with gap-2)
- [ ] Add Facebook login button with feather-facebook icon
- [ ] Add Twitter login button with feather-twitter icon
- [ ] Add Github login button with feather-github icon
- [ ] Use btn-light-brand class (may need to verify this exists)
- [ ] Add tooltips with data-bs-toggle="tooltip"

### Phase 4: Update CSS & Styling
- [ ] Update body gradient background (may keep existing or update)
- [ ] Add auth-minimal-wrapper styles if needed
- [ ] Add logo container styles (wd-50 width class)
- [ ] Update card styles to match minimal design
- [ ] Add border-bottom styles for divider
- [ ] Add translate-middle positioning styles if not in Bootstrap
- [ ] Ensure responsive design (mx-4 mx-sm-0 for mobile margins)
- [ ] Add btn-light-brand styles if not in theme

### Phase 5: Update External Links
- [ ] Verify CSS files include Feather icons (assets/vendor/feather.min.css)
- [ ] Update logo src to use /assets/images/kobie-logo-abbr.png
- [ ] Update forgot password link href
- [ ] Update register link href to match existing routes
- [ ] Add favicon link if not present

### Phase 6: Testing & Verification
- [ ] Test login page loads correctly
- [ ] Verify logo displays and is centered
- [ ] Test form submission with HTMX
- [ ] Verify responsive design on mobile
- [ ] Test "Remember Me" functionality
- [ ] Verify all links work correctly
- [ ] Check that all divs have unique IDs
- [ ] Test tooltip functionality on social buttons

### Phase 7: Documentation & Commit
- [ ] Update docs/activity.md with changes made
- [ ] Create git commit with descriptive message
- [ ] Push changes to remote

## File Changes

### Files to Modify
- `/html/login.php` - Main login page HTML and CSS

### Assets Referenced
- `/html/assets/images/kobie-logo-abbr.png` - Logo file
- `/html/assets/vendor/feather.min.css` - Feather icons (verify loaded)
- Existing Bootstrap CSS

## Key Design Elements

### Logo Positioning
```html
<div class="wd-50 bg-white p-2 rounded-circle shadow-lg position-absolute translate-middle top-0 start-50">
    <img src="assets/images/kobie-logo-abbr.png" alt="" class="img-fluid">
</div>
```

### Divider with Text
```html
<div class="border-bottom position-relative">
    <span class="small py-1 px-3 text-uppercase text-muted bg-white position-absolute translate-middle">or</span>
</div>
```

### Social Buttons
```html
<a href="javascript:void(0);" class="btn btn-light-brand flex-fill" data-bs-toggle="tooltip" title="Login with Facebook">
    <i class="feather-facebook"></i>
</a>
```

## Success Criteria
- ✅ Login page matches minimal design pattern
- ✅ Logo centered at top of card
- ✅ Form layout clean and simple
- ✅ Social login buttons present with icons
- ✅ Responsive design works on mobile
- ✅ All divs have unique IDs
- ✅ HTMX functionality preserved
- ✅ Links navigate correctly

## Notes
- Keep existing PHP logic and HTMX integration
- Only update HTML structure and CSS
- Verify Feather icons are available
- May need to add custom CSS for wd-50 class if not in theme
- Social login buttons are UI only (no backend implementation needed)
- Maintain CSRF protection and security features

