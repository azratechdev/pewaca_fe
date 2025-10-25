# Residence Frontend Application

## Overview
This is a Laravel 9 PHP web application called "Pewaca" - a residence management system for managing residents and administrators. The application handles user authentication, member management, reports, and various administrative functions.

## Recent Changes
- **October 25, 2025**: Initial setup in Replit environment
  - Installed PHP 8.2 and Composer
  - Installed all Laravel and Node.js dependencies
  - Generated application key
  - Created SQLite database file (as alternative to MySQL)
  - Configured Laravel development server to run on 0.0.0.0:5000
  - Set up workflow to automatically serve the application

## Project Architecture

### Technology Stack
- **Framework**: Laravel 9.x
- **PHP Version**: 8.2
- **Frontend**: Bootstrap 5, jQuery, various UI components
- **Database**: Configured for MySQL (can use SQLite for development)
- **Key Packages**:
  - laravel/ui - Authentication scaffolding
  - spatie/laravel-permission - Role and permission management
  - realrashid/sweet-alert - Beautiful alerts
  - silviolleite/laravelpwa - Progressive Web App support

### Directory Structure
- `/app` - Application logic (Controllers, Models, Middleware)
- `/config` - Configuration files
- `/database` - Migrations, seeders, factories
- `/public` - Web root with assets
- `/resources` - Views, language files, raw assets
- `/routes` - Application routes (web.php, api.php)
- `/storage` - Generated files, logs, cache
- `/vendor` - Composer dependencies

### Key Features
- User authentication (login, registration, password reset)
- Role-based access control (pengurus/administrator role)
- Member management
- Payment tracking
- Reports and billing
- Progressive Web App capabilities

## Development Setup

### Running the Application
The application is configured to run automatically via the workflow:
```bash
php artisan serve --host=0.0.0.0 --port=5000
```

### Database Configuration
The application is configured to use MySQL by default but has SQLite available for development. Database migrations are located in `/database/migrations`.

To run migrations:
```bash
php artisan migrate
```

### Important Commands
- `composer install` - Install PHP dependencies
- `npm install` - Install Node.js dependencies
- `php artisan key:generate` - Generate application key
- `php artisan config:clear` - Clear configuration cache
- `php artisan cache:clear` - Clear application cache

## Environment Configuration
The application uses environment variables in `.env` file for configuration. Key variables:
- `APP_KEY` - Application encryption key (auto-generated)
- `APP_URL` - Application URL
- `DB_*` - Database connection settings
- Session and security settings

## Notes
- The application locale is set to Indonesian (id)
- Session lifetime is configured for 129,600 minutes
- The application includes PWA manifest for mobile installation
- Public assets include extensive UI component libraries in `/public/assets/plugins`
