# EventBuddy

## Overview
EventBuddy is a simple, web-based event management system that allows users to create, manage, and view events, register attendees, and generate event reports. It includes secure authentication, event filtering, pagination, and an admin panel for monitoring users and events.

## Features
- **User Authentication**: Secure login and registration with password hashing and email verification.
- **Event Management**: Users can create, update, view, and delete events.
- **Attendee Registration**: Users can enroll and unenroll from events while ensuring unique registrations per event.
- **Event Filtering & Pagination**: Users can search and filter events by name, date, and availability.
- **Admin Panel**:
  - Monitor users and manually activate, reactivate, or delete accounts.
  - Manage blogs (add, edit, delete) and events (delete, update capacity, change status).
  - View a dashboard with the total count of users, blogs, and events.
- **CSV Export**: Hosts can download event details, including participant lists.
- **Password Management**: Users can change passwords and recover lost passwords via email verification.
- **Secure Sessions**: Enhanced session management to prevent unauthorized access.

## Security Features
- **Password Hashing**: Uses `password_hash()` for secure storage.
- **Email Verification**: Prevents fake registrations and ensures account security.
- **Client & Server Validation**: Protects against SQL injection and invalid inputs.
- **Secure Sessions**: Uses `session_regenerate_id()` to protect against session hijacking.

## Installation Guide
### Prerequisites
- PHP 7.4 or higher
- MySQL Database
- Apache Server with mod_rewrite enabled

### Steps
1. **Clone Repository**:
   ```sh
   git clone https://github.com/wahidrana2108/EventBuddy.git
   ```
2. **Configure Database**:
   - Create a MySQL database.
   - Import `database.sql` (if provided).
   - Update `db/config.php` with database credentials.
3. **Run Locally**:
   - Place the project in `htdocs/` (XAMPP) or your server's root directory.
   - Start Apache and MySQL.
   - Navigate to `http://localhost/EventBuddy/` in a browser.

## Project Structure
```
EventBuddy/
|-- css/                   # Stylesheets
|-- js/                    # JavaScript files
|-- images/                # Image assets
|-- pages/                 # Application pages
|   |-- index.php          # Homepage
|   |-- events.php         # Event listing
|   |-- login.php          # User authentication
|   |-- register.php       # User registration
|   |-- admin_panel.php    # Admin dashboard
|-- db/                    # Database configuration
|-- event_pagination.php   # Paginated events
|-- download.php           # CSV export
|-- README.md              # Documentation
```

## Usage
- **Users**: Register, verify email, browse events, enroll, and change password.
- **Hosts**: Manage events, update details, and export attendee lists.
- **Admins**: Oversee users, blogs, events, and access advanced filtering.

## Live Demo
[EventBuddy Live](http://eventbuddy.kesug.com)

## Author
Md. Wahiduzzaman

## License
MIT License

