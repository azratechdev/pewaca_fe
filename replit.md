# Residence Frontend Application

## Overview
Pewaca is a Laravel 9 PHP web application for residence management. It provides comprehensive administration for residents and administrators, including user authentication, member management, reporting, and a newly integrated QRIS payment orchestrator for fee collection. The project aims to streamline residence administration and enhance payment processing.

## User Preferences
I prefer simple language and detailed explanations. I want iterative development where you ask before making major changes. Do not make changes to the folder `Z`. Do not make changes to the file `Y`.

## System Architecture

### Technology Stack
- **Framework**: Laravel 9.x
- **PHP Version**: 8.2
- **Frontend**: Bootstrap 5, jQuery
- **Database**: MySQL (with SQLite for development)
- **Key Packages**: `laravel/ui`, `spatie/laravel-permission`, `realarashid/sweet-alert`, `silviolleite/laravelpwa`

### Core Features
- User authentication and role-based access control.
- Member management and payment tracking.
- Comprehensive reporting and billing functionalities.
- Progressive Web App (PWA) capabilities.
- QRIS Payment Orchestrator for residence fee collection.
- **Warungku Marketplace**: Internal marketplace for residence community.

### QRIS Payment Orchestrator
- **Backend**: Uses a dedicated SQLite database for payments, `QrisProvider` interface with `QrisProviderMock` and `QrisProviderMidtrans` implementations, `PaymentController` and `WebhookController`, and background jobs for payment expiry and reconciliation. Includes security features like signature verification and idempotency.
- **Frontend**: Integrates "Bayar via QRIS" option in the payment view, displaying QR codes and auto-refreshing payment status.
- **Service Layer**: `PaymentService` extracts business logic from controllers, enabling both API and web routes to share validation and payment processing logic without HTTP self-calls (resolves single-threaded PHP server timeout issue).

### Warungku Marketplace
- **Purpose**: Internal marketplace for residence community to buy and sell products among residents.
- **Access**: Public routes (no authentication required) accessible from login page via "Pindah ke Warungku" button.
- **Database Schema**: 
  - `stores` table: name, description, logo, address, phone, email, rating, is_active
  - `products` table: store_id (foreign key), name, description, image, price, stock, is_available
- **Models**: `Store` and `Product` with HasMany/BelongsTo relationships
- **Routes**:
  - `/warungku` - Main marketplace page (list of stores)
  - `/warungku/toko/{id}` - Store detail page with products
  - `/warungku/produk/{id}` - Product detail page
- **Controller**: `WarungkuController` handles store and product listing/viewing
- **UI Features**:
  - Store cards with logo, rating, product count
  - Product cards with image, price, stock badge
  - Responsive Bootstrap 5 design with Pewaca green theme (#5FA782)
  - "Tambah ke Keranjang" button (UI only, checkout pending implementation)
- **Data Seeding**: `WarungkuSeeder` provides 4 sample stores with 8 products each
- **Next Steps**: Run `php artisan migrate` and `php artisan db:seed --class=WarungkuSeeder` to populate marketplace data

### UI/UX Decisions
- Consistent use of Bootstrap 5 for responsive design.
- `onerror` handlers for images for improved visual consistency.
- Graceful degradation for data display with clear error messages and pagination.

### System Design Choices
- **API Connectivity**: Interacts with a Django backend API at `https://admin.pewaca.id`.
- **Error Handling**: Robust multi-level validation for API responses with comprehensive logging and user-friendly error messages.
- **Dynamic Content**: JavaScript fetch calls for dynamic data retrieval.
- **Environment Configuration**: Utilizes `.env` for sensitive settings.
- **PWA Support**: Full PWA implementation for a mobile-first experience, including an offline page and installable app functionality.
- **PWA Optimization (Oct 2025)**: Service worker updated to Network-First strategy with selective caching (only static assets like images, CSS, JS). Icon and splash screen configurations reduced to essential sizes (192x192, 512x512 icons; 3 splash sizes) to improve mobile app performance and reduce initial load size.

### Recent Bug Fixes (Oct 30, 2025)
- **Add Pengurus**: Fixed "Trying to access array offset on null" error by adding proper API response validation and error handling in `PengurusController::getRole()` and `getWarga()` methods.
- **Add Rekening**: Fixed similar null access error by adding comprehensive error handling in `AkunController::addRekening()` and `postRekening()` methods, with detailed logging and user-friendly error messages.

### Warga Registration Architecture
- **Flow**: UUID-based invitation system for residents, multi-step registration form, backend validation, email verification, and account creation via the Django API.
- **Components**: `RegisterController`, Django API endpoints for residence data and user management, email verification system.

## External Dependencies
- **Backend API**: `https://admin.pewaca.id` (Django backend)
- **Payment Providers**:
    - Mock Provider (development/testing)
    - Midtrans (production QRIS payments)
- **Libraries & Tools**:
    - Laravel 9.x
    - Bootstrap 5
    - jQuery
    - Node.js (for asset compilation)
    - Composer
    - npm
    - `laravel/ui`
    - `spatie/laravel-permission`
    - `realarashid/sweet-alert`
    - `silviolleite/laravelpwa`