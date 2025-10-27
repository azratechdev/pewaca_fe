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

### QRIS Payment Orchestrator
- **Backend**: Uses a dedicated SQLite database for payments, `QrisProvider` interface with `QrisProviderMock` and `QrisProviderMidtrans` implementations, `PaymentController` and `WebhookController`, and background jobs for payment expiry and reconciliation. Includes security features like signature verification and idempotency.
- **Frontend**: Integrates "Bayar via QRIS" option in the payment view, displaying QR codes and auto-refreshing payment status.

### UI/UX Decisions
- Consistent use of Bootstrap 5 for responsive design.
- `onerror` handlers for images for improved visual consistency.
- Graceful degradation for data display with clear error messages and pagination.

### System Design Choices
- **API Connectivity**: Interacts with a Django backend API at `https://admin.pewaca.id`.
- **Error Handling**: Robust multi-level validation for API responses.
- **Dynamic Content**: JavaScript fetch calls for dynamic data retrieval.
- **Environment Configuration**: Utilizes `.env` for sensitive settings.
- **PWA Support**: Full PWA implementation for a mobile-first experience, including an offline page and installable app functionality.

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