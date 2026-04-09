# Kobie Design Migration - Design Document

**Date:** 2025-11-17
**Status:** Approved
**Type:** Visual Design Overhaul

## Overview

Migrate the Task Tracker application (`html/app.php`) from its current Bootstrap design to use the Kobie admin template design (`kobie/index.html`), while preserving all existing HTMX functionality and PHP logic.

## Goals

1. **Complete visual overhaul** - Replace all design elements (layout, colors, typography, components)
2. **Preserve functionality** - Keep all HTMX dynamic loading and PHP authentication logic
3. **Maintain simplicity** - Migrate only essential assets, avoid complexity
4. **Keep navigation structure** - Use existing menu items with new styling

## Design Decisions

### 1. HTMX Functionality
**Decision:** Keep HTMX dynamic loading
**Rationale:** Existing HTMX implementation works well and provides better UX than traditional page navigation

### 2. Design Elements Scope
**Decision:** Complete visual overhaul
**Rationale:** Adopt all kobie design elements for consistent, professional appearance

### 3. Navigation Structure
**Decision:** Keep current navigation items
**Rationale:** Preserve existing functionality, just apply kobie's styling

### 4. Asset Organization
**Decision:** Selective migration - copy only essential files
**Rationale:** Kobie has many unused vendor libraries; keep deployment lean

### 5. PHP Integration
**Decision:** Preserve all current PHP logic
**Rationale:** Authentication and role-based access are critical

## Asset Migration Strategy

### CSS Files to Copy
From `kobie/assets/` to `html/assets/`:

- `css/bootstrap.min.css` → `html/assets/css/bootstrap.min.css`
- `css/theme.min.css` → `html/assets/css/kobie-theme.min.css`
- `vendors/css/vendors.min.css` → `html/assets/vendor/kobie-vendors.min.css`
- `vendors/css/feather.min.css` → `html/assets/vendor/feather.min.css`

### JavaScript Files to Copy

- `vendors/js/bootstrap.min.js` → `html/assets/js/kobie-bootstrap.min.js`
- `vendors/js/nxlNavigation.min.js` → `html/assets/js/nxl-navigation.min.js`
- `vendors/js/perfect-scrollbar.min.js` → `html/assets/vendor/perfect-scrollbar.min.js`

### Images to Copy

- `images/logo-full.png` → `html/assets/images/kobie-logo-full.png`
- `images/logo-abbr.png` → `html/assets/images/kobie-logo-abbr.png`
- `images/favicon.ico` → `html/assets/images/kobie-favicon.ico`

### Assets NOT Copied

- Page-specific JavaScript (dashboard-init, calendar-init, etc.)
- Unused vendor libraries (charts, calendars, email editors)
- Template images/avatars/banners

## HTML Structure Transformation

### Current Structure
```
page-wrapper
  └── main-container
      ├── sidebar (simple Bootstrap sidebar)
      └── app-container
          ├── app-header
          ├── app-body (HTMX content area)
          └── app-footer
```

### New Structure (Kobie-Inspired)
```
body
  ├── nxl-navigation (kobie sidebar)
  │   ├── navbar-wrapper
  │   │   ├── m-header (logo)
  │   │   ├── navbar-content (menu with HTMX)
  │   │   └── sidebar-settings (quick actions)
  └── nxl-container
      ├── nxl-header
      │   ├── header-left (toggle, breadcrumb)
      │   └── header-right (user dropdown with PHP)
      ├── nxl-content
      │   └── #page-content (HTMX target)
      └── nxl-footer
```

### Key Changes
- Class names: `app-*` → `nxl-*` (kobie convention)
- Richer sidebar with icon+text navigation
- Enhanced header layout
- **HTMX attributes unchanged**
- **PHP blocks unchanged**

## Navigation Menu Mapping

### Menu Items (Unchanged)
1. Dashboard
2. My Tasks
3. Team Tasks
4. My Team
5. Kanban Board
6. Calendar
7. Activity
8. Archived Tasks
9. Settings (admin only)

### Icon Changes
Swap Bootstrap Icons for Feather Icons:
- `bi bi-laptop` → `feather-airplay`
- `bi bi-check-circle` → `feather-check-circle`
- `bi bi-people` → `feather-users`
- `bi bi-person-badge` → `feather-user`
- `bi bi-kanban` → `feather-trello`
- `bi bi-calendar-event` → `feather-calendar`
- `bi bi-activity` → `feather-activity`
- `bi bi-archive` → `feather-archive`
- `bi bi-gear` → `feather-settings`

### Menu Item Structure
**Current:**
```html
<li id="nav-dashboard">
  <a href="#" hx-get="/partials/dashboard/index.php">
    <i class="bi bi-laptop"></i>
    <span>Dashboard</span>
  </a>
</li>
```

**New:**
```html
<li class="nxl-item" id="nav-dashboard">
  <a href="#" class="nxl-link" hx-get="/partials/dashboard/index.php" hx-target="#page-content">
    <span class="nxl-micon"><i class="feather-airplay"></i></span>
    <span class="nxl-mtext">Dashboard</span>
  </a>
</li>
```

## Header Area Design

### Left Section
- Mobile hamburger toggle (kobie's animated hamburger)
- Desktop sidebar toggle (minimize/expand)
- Page title/breadcrumb area

### Right Section
- Global loading indicator (HTMX spinner)
- User profile dropdown:
  - Avatar/initials placeholder
  - User name: `<?php echo htmlspecialchars($user['first_name'] . ' ' . $user['last_name']); ?>`
  - Role badge: `<?php echo ucfirst($user['role']); ?>`
  - Dropdown menu: Settings, Reset Password, Add Team Members (admin), Logout

### Visual Changes
- Background: Dark blue/purple gradient (`#131341`, `#28387e`)
- Typography: Larger, bolder fonts
- Spacing: More generous padding
- Dropdowns: Kobie-styled with icons

### PHP Logic Preserved
- `<?php if (is_admin()): ?>` checks
- User data display
- All functionality unchanged

## Content Area & JavaScript

### Content Area Structure
**Current:**
```html
<div class="app-body" id="page-content" hx-get="/partials/dashboard/index.php" hx-trigger="load">
```

**New:**
```html
<main class="nxl-content" id="page-content" hx-get="/partials/dashboard/index.php" hx-trigger="load">
  <div class="main-content">
    <!-- HTMX content loads here -->
  </div>
</main>
```

### JavaScript Changes

**Keep (Current Scripts):**
- HTMX library
- All HTMX event handlers
- Bootstrap tooltips
- Custom event listeners (teamSwitched, taskCreated, etc.)

**Add (From Kobie):**
- `nxlNavigation.min.js` - Sidebar functionality
- `perfect-scrollbar.min.js` - Smooth scrolling

**Update:**
Navigation handler class names:
```javascript
// Change: .sidebar-menu → .nxl-navbar
document.querySelectorAll('.nxl-navbar li').forEach(...)
```

## Color Scheme

### Primary Colors
- Deep blue/purple: `#131341`, `#28387e`
- Sidebar: Dark gradient
- Header: Dark blue `#131341`
- Text on dark: White `#ffffff`
- Content area: Light `#f5f7fa` or white

### Accent Colors
- Active states: Blue
- Hover effects: Lighter blue
- Alerts/badges: Bootstrap color palette

## Typography
- Font family: System fonts
- Headings: Bolder, more prominent
- Icons: Larger with better spacing

## Component Styling

HTMX-loaded partials will automatically inherit kobie's CSS for:
- Cards
- Buttons
- Forms
- Tables
- Modals
- Alerts
- Badges
- Inputs
- Dropdowns

## Unique IDs (Per CLAUDE.md #11)

All major divs will have unique IDs:
- `#kobie-sidebar` - Main sidebar
- `#kobie-header` - Header area
- `#kobie-nav-wrapper` - Navigation wrapper
- `#kobie-logo-area` - Logo section
- `#kobie-nav-menu` - Navigation menu
- `#kobie-sidebar-settings` - Quick actions
- `#kobie-user-dropdown` - User dropdown
- `#kobie-content-wrapper` - Main content wrapper
- `#page-content` - (existing) HTMX target
- `#kobie-footer` - Footer area

## Footer
Simple footer bar with copyright text (existing or updated branding)

## Success Criteria

1. ✅ App.php uses kobie's visual design
2. ✅ All HTMX functionality works unchanged
3. ✅ PHP authentication and role checks work
4. ✅ Navigation maintains current menu items
5. ✅ Only essential assets migrated
6. ✅ All major divs have unique IDs
7. ✅ Mobile responsive (kobie's responsive design)
8. ✅ Sidebar collapse/expand works
9. ✅ User dropdown displays correct data
10. ✅ HTMX partials load and display correctly

## Risks & Mitigation

### Risk: CSS Conflicts
**Mitigation:** Kobie CSS may conflict with existing styles in HTMX partials. Test thoroughly and adjust as needed.

### Risk: JavaScript Conflicts
**Mitigation:** Kobie's jQuery-based scripts may conflict with existing code. Load scripts in correct order and namespace if needed.

### Risk: Breaking HTMX
**Mitigation:** Preserve all HTMX attributes exactly; only change wrapper HTML/CSS.

### Risk: Mobile Responsiveness
**Mitigation:** Test on mobile devices; kobie is responsive but verify all features work.

## Out of Scope

- Modifying HTMX partial content files
- Changing database schema
- Updating backend PHP logic
- Adding new features
- Modifying authentication system

## Next Steps

1. Create detailed implementation plan
2. Set up git worktree for isolated development
3. Execute implementation in batches
4. Test thoroughly
5. Commit and merge changes
