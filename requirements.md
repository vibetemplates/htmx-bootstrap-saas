# Requirements Document - HTMX PHP Application Template

## Project Overview

A standardized template for building web applications using HTMX, PHP, and Bootstrap 5.3 with a modern design system. This template provides a foundation for rapid development of interactive, server-driven web applications following the LAMP stack architecture.

## Core Requirements

### 1. Technology Stack
- **Backend:** PHP 8+ with traditional LAMP stack architecture
- **Frontend:** HTMX 2.0 for dynamic interactions
- **Styling:** Bootstrap 5.3 with custom design system
- **Optional Enhancement:** Alpine.js for client-side reactivity
- **Server:** Apache with mod_rewrite enabled
- **Database:** MariaDB/MySQL with PDO

### 2. Project Structure Requirements

#### Directory Organization
```
/var/www/html/                 # Web root (publicly accessible)
├── index.php                  # Landing/redirect page
├── login.php                  # Authentication page
├── register.php               # User registration
├── logout.php                 # Logout handler
├── app.php                    # Main SPA entry point (protected)
├── partials/                  # HTMX endpoint targets
│   ├── auth/                  # Authentication handlers
│   ├── dashboard/             # Dashboard components
│   └── components/            # Reusable UI components
├── assets/
│   ├── css/
│   │   ├── custom.css         # Custom design system
│   │   └── bootstrap.min.css  # Bootstrap 5.3
│   ├── js/
│   │   └── custom.js          # Additional JavaScript
│   └── images/
└── uploads/                   # User-uploaded files

/var/www/                      # Above web root (secure)
├── config/
│   ├── database.php           # Database configuration
│   └── config.php             # Application settings
├── models/
│   ├── Database.php           # Database singleton
│   └── User.php               # User model (example)
├── helpers/
│   ├── functions.php          # General utilities
│   ├── validation.php         # Input validation
│   ├── auth.php               # Authentication helpers
│   └── csrf.php               # CSRF protection
└── views/
    └── layouts/
        ├── main.php           # Main SPA layout
        └── auth.php           # Authentication layout
```

#### Design Directory
```
design/                        # Bootstrap template for reference
└── [template files]           # DO NOT MODIFY - inspiration only
```

### 3. Architecture Requirements

#### Backend (PHP)

**Partials Pattern:**
- All partials must be dual-purpose (handle GET and POST)
- Each partial checks `$_SERVER['REQUEST_METHOD']`
- GET returns HTML fragments
- POST processes data and returns HTML response
- All partials must start with `session_start()`
- Authentication check required for protected partials

**Model Layer:**
- Models handle database operations only
- No HTML generation in models
- Use prepared statements exclusively (PDO)
- Return arrays or objects, never HTML
- Implement singleton pattern for database connections

**Security:**
- CSRF tokens on all forms
- Input validation and sanitization
- SQL injection prevention (prepared statements)
- XSS prevention (htmlspecialchars on output)
- Session-based authentication
- Secure session configuration (httponly, secure cookies)

#### Frontend (HTMX)

**SPA Behavior:**
- Single URL `/app` for authenticated users
- All navigation uses `hx-push-url="/app"`
- Browser URL stays clean
- Content swaps into `#page-content` div
- Sidebar navigation triggers HTMX requests

**HTMX Patterns:**
- Use HTMX attributes for all AJAX interactions
- Progressive enhancement where possible
- Loading indicators with `htmx-indicator` class
- Proper swap strategies (innerHTML, outerHTML, etc.)
- Event-driven updates using `HX-Trigger` header

**Bootstrap Integration:**
- Bootstrap 5.3 for all UI components
- Custom design system via CSS variables
- Responsive grid layout
- Mobile-first approach
- Consistent component usage

### 4. Design System Requirements

#### CSS Variables
Must define and use the following CSS variable categories:
- Primary brand colors (primary, secondary)
- Status colors (success, warning, danger, info)
- Background colors and shades
- Text colors (primary, light)
- Shadow levels (subtle, normal, hover, focus)
- Border radius values (sm, normal, lg)
- Form colors (borders, backgrounds)
- Sidebar and navigation colors

#### Component Standards
- All cards use box-shadow (no borders)
- Hover effects with transform: translateY(-2px)
- Consistent border-radius using CSS variables
- Smooth transitions (0.3s ease standard)
- Gradient backgrounds for primary actions
- Fixed sidebar (210px width)
- Gradient navbar (primary to secondary)

### 5. Feature Requirements

#### Authentication System
- User login with email/password
- User registration
- Password reset flow (forgot password, reset with token)
- Email verification (optional)
- Session management
- Logout functionality
- Remember me (optional)

#### User Interface
- Fixed sidebar navigation (210px)
- Top navbar with gradient
- Responsive design (mobile-friendly)
- Loading states and indicators
- Error handling and display
- Success/failure notifications
- Modal dialogs for forms
- Toast notifications (optional)

#### Content Management
- Dynamic content loading via HTMX
- Form submission without page reload
- Inline editing capabilities
- File upload support
- Search and filter functionality
- Pagination support
- Sortable lists/tables

### 6. Development Requirements

#### Code Standards
- PHP 8+ syntax and features
- PSR-12 coding standards
- Meaningful variable and function names
- Comments for complex logic
- DRY (Don't Repeat Yourself) principle
- KISS (Keep It Simple, Stupid) principle

#### File Organization
- One class per file
- Logical grouping of related functions
- Separate concerns (MVC-like pattern)
- Reusable components
- Modular structure

#### Documentation
- Every HTML element has unique `id` attribute
- Inline comments for complex sections
- README for setup instructions
- CLAUDE.md for AI assistance guidance
- docs/activity.md for development log

### 7. Performance Requirements

- Minimal database queries (use joins, avoid N+1)
- Debounced search inputs (500ms delay)
- Lazy loading where appropriate
- Optimized asset loading
- Gzip compression enabled
- Browser caching configured
- CDN for Bootstrap and HTMX (or local copies)

### 8. Security Requirements

#### Input Validation
- Server-side validation on all inputs
- Type checking for all parameters
- Length restrictions enforced
- Email format validation
- Password strength requirements

#### Output Encoding
- HTML escape all user-generated content
- Context-appropriate encoding
- Prevent XSS attacks
- Sanitize file uploads

#### Authentication & Authorization
- Secure password hashing (password_hash)
- Session regeneration on login
- Timeout inactive sessions
- Role-based access control (if needed)
- Prevent brute force attacks

### 9. Database Requirements

#### Structure
- Users table (minimum: id, email, password_hash, name, created_at)
- Password reset tokens table (if using password reset)
- Proper indexing on frequently queried columns
- Foreign key constraints where applicable
- UTC timestamps for all datetime fields

#### Access
- PDO for all database operations
- Prepared statements exclusively
- Transaction support where needed
- Connection pooling via singleton
- Error logging (not display)

### 10. Deployment Requirements

#### Apache Configuration
- mod_rewrite enabled
- .htaccess for clean URLs
- Error pages (404, 500)
- Security headers configured
- File upload limits set

#### PHP Configuration
- Error reporting off in production
- Error logging enabled
- Session security configured
- Upload limits set appropriately
- Memory limits configured

#### File Permissions
- Web root: 755 for directories, 644 for files
- Uploads directory: 775 (web server writable)
- Config files: 640 (readable by web server only)
- No execution permission on uploads

### 11. Testing Requirements

- Manual testing of all user flows
- Test HTMX interactions in multiple browsers
- Mobile responsiveness testing
- Form validation testing
- Authentication flow testing
- Error handling verification

### 12. Documentation Requirements

#### Project Documentation
- README.md with setup instructions
- requirements.md (this file)
- tech-stack.md with technology details
- design-notes.md with design decisions
- CLAUDE.md for AI development guidance

#### Code Documentation
- Function/method docblocks
- Complex algorithm explanations
- Configuration file comments
- Database schema documentation
- API endpoint documentation (for partials)

### 13. Git Requirements

- Initialize git repository
- Commit after each successful feature
- Meaningful commit messages
- .gitignore for sensitive files
- Regular pushes to remote

### 14. Future Considerations

#### Scalability
- Structure supports adding new features
- Modular design for easy extension
- Database schema allows growth
- Caching strategy can be added

#### Maintenance
- Code is maintainable and readable
- Dependencies are minimal
- Updates are straightforward
- Documentation supports handoff

## Success Criteria

1. ✅ Application loads and displays correctly
2. ✅ User can register and login
3. ✅ Authentication protects app routes
4. ✅ HTMX interactions work smoothly
5. ✅ Design matches template inspiration
6. ✅ Responsive on mobile and desktop
7. ✅ Forms validate and submit properly
8. ✅ Security measures are in place
9. ✅ Code is clean and documented
10. ✅ Project structure matches specification

## Constraints

- Must use traditional LAMP stack (no Node.js, no modern frameworks)
- Must use HTMX for dynamic interactions (no React, Vue, etc.)
- Must follow directory structure exactly as specified
- Must not modify files in `design/` directory
- Must keep all changes simple and minimal
- Must document all changes in docs/activity.md

## Deliverables

1. Fully functional template application
2. Complete documentation set
3. Git repository with clean history
4. Tested and working authentication
5. Example CRUD functionality
6. Design system implemented
7. Ready for feature development
