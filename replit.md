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
  - **Configured TrustProxies** to trust all proxies (required for Replit)
  - **Connected to backend API** at https://admin.pewaca.id
  - **Fixed JavaScript syntax errors** in 4 view files (env() → Blade syntax)
  - Fixed API URL references in:
    - home/index.blade.php
    - pengurus/report/index.blade.php
    - pengurus/warga/detail_warga.blade.php
    - pengurus/tagihan/detail_approval.blade.php
  - **Improved image handling**:
    - Added fallback default avatar for broken profile images
    - Added error handling with onerror attribute on all images
    - Changed alt text from "No images uploaded" to descriptive text
    - Created placeholder message for unavailable story images
    - Generated 5 default avatars in public/placeholder_avatars/
    - Generated 6 story images in public/placeholder_story_images/
  - **Fixed posting story error handling**:
    - Added response validation before accessing array keys
    - Added detailed logging for debugging (status, body, parsed data)
    - Improved error messages to show specific errors from backend
    - Fixed "Trying to access array offset on value of type null" error
    - Added file size validation: max 5MB for story images
    - Added specific error message for 413 (file too large) errors
    - Improved error detection for non-JSON responses from backend
  - **October 26, 2025**: Fixed database AUTO_INCREMENT issue for story table
    - Added AUTO_INCREMENT to story.id field in MySQL database
    - Fixed IntegrityError: Field 'id' doesn't have a default value
    - Story posting now works successfully with image uploads
  - **October 26, 2025**: Comprehensive error handling improvements
    - **HomeController**: Added 3-level validation (HTTP status, JSON decode, type checking) to:
      - `getStories()`: Validates 'data' key exists, returns empty array on error
      - `getReplays()`: Validates 'results' is array, normalizes response structure
      - `getReplaysMore()`: Validates 'results' is array, prevents foreach crashes
    - **PengurusController**: Fixed `list_biaya()` to validate 'count' key exists
    - All functions now log errors with full context for debugging
    - Graceful degradation: No more "Trying to access array offset on null" errors
    - User sees clear error messages instead of application crashes
    - Added Log facade import for proper error logging
  - **October 26, 2025**: Fixed incorrect API URLs across all view files
    - **Problem**: JavaScript fetch calls used incorrect URL `api.pewaca.id` instead of `admin.pewaca.id`
    - **Fixed 10 endpoints across 6 files**:
      - `list_biaya.blade.php`: publish-tagihan, unpublish-tagihan, list_banks endpoints
      - `verify.blade.php`: auth/verify endpoint
      - `rekeninginfo.blade.php`: residence-banks DELETE and activate endpoints
      - `detail_tunggakan.blade.php`: report/tunggakan endpoint
      - `detail_by_type.blade.php`: report/bytype endpoint
      - `detail_by_cashout.blade.php`: report/cashout endpoint
    - All JavaScript fetch calls now correctly use `https://admin.pewaca.id`
    - Fixed "Gagal menghubungi server" error when clicking ADD button on biaya page
  - **October 26, 2025**: Fixed JavaScript errors in add tagihan page
    - **Problem**: JavaScript tried to access calendar popup elements that were commented out in HTML
    - **Error**: "Cannot read properties of null (reading 'appendChild')" on page load
    - **Fixed**: 
      - Commented out unused calendar popup JavaScript (lines 388-432)
      - Removed dead CSS for calendar popup (83 lines)
      - Removed commented-out calendar popup HTML
      - Page now uses standard HTML5 date inputs
      - Retained Flatpickr only for periode range field (used with repeat toggle)
    - Result: Page loads without JavaScript errors, cleaner codebase
  - **October 26, 2025**: Fixed missing Authorization headers in report pages
    - **Problem**: Report endpoints returned HTTP 401 Unauthorized errors
    - **Root Cause**: Fetch calls to `/api/report/index/` and `/api/report/cashout/` did not include Authorization token
    - **Fixed 2 endpoints**:
      - `index.blade.php`: Added Authorization header to `/api/report/index/` fetch call
      - `detail_by_cashout.blade.php`: Added Authorization header to `/api/report/cashout/` fetch call
    - Both fetch calls now send `Authorization: Token {{ Session::get("token") }}` header
    - Report pages now load data successfully instead of showing 401 errors
  - **October 26, 2025**: Implemented pagination for report cashout page
    - **Problem**: Chart showed 80 warga sudah bayar, but list only displayed 2 records
    - **Root Cause**: Backend API returns paginated data (e.g., total=12 but only sends 2 records per page)
    - **Solution**: Implemented frontend pagination in `detail_by_cashout.blade.php`:
      - Track pagination state: currentPage, totalData, isLoading for each tab
      - "More" button now fetches next page from API with `?page=2`, `?page=3`, etc.
      - Appends new data to existing cached data
      - Button shows progress: "More (2/12)" and auto-hides when all data loaded
      - Loading state prevents double-clicks
    - Result: Users can now load all records progressively by clicking "More" button

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
