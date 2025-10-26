# Residence Frontend Application

## Overview
Pewaca is a Laravel 9 PHP web application designed as a residence management system. It facilitates the management of residents and administrators, handling user authentication, member management, reporting, and various administrative functions. The project aims to provide a comprehensive platform for residence administration, including a newly integrated QRIS payment orchestrator for fee collection.

## User Preferences
I prefer simple language and detailed explanations. I want iterative development where you ask before making major changes. Do not make changes to the folder `Z`. Do not make changes to the file `Y`.

## System Architecture

### Technology Stack
- **Framework**: Laravel 9.x
- **PHP Version**: 8.2
- **Frontend**: Bootstrap 5, jQuery, various UI components
- **Database**: Configured for MySQL (with SQLite option for development)
- **Key Packages**: `laravel/ui`, `spatie/laravel-permission`, `realarashid/sweet-alert`, `silviolleite/laravelpwa`

### Key Features
- User authentication and role-based access control (pengurus/administrator)
- Member management and payment tracking
- Comprehensive reporting and billing functionalities
- Progressive Web App (PWA) capabilities
- **QRIS Payment Orchestrator**: Integrated service for QRIS payment processing for residence fees, allowing residents to pay via QR code scanning.

### Payment Orchestrator Architecture
- **Database**: Dedicated SQLite database (`database/payment_local.sqlite`) for payments, payment logs, webhook events, and settlements.
- **Provider Pattern**: Abstract `QrisProvider` interface with `QrisProviderMock` (for testing) and `QrisProviderMidtrans` (production-ready stub).
- **Controllers**: `PaymentController` for QR payment creation and status checks, `WebhookController` for handling provider notifications with signature verification.
- **Background Jobs**: `ExpirePendingPayments` for auto-expiring pending payments and `ReconcileDaily` for daily settlement reconciliation.
- **Security Features**: Signature verification for webhooks (HMAC-SHA256), idempotency for webhook events, amount validation, rate limiting, and signed outbound callbacks.

### UI/UX Decisions
- Consistent use of Bootstrap 5 for responsive design.
- Implementation of `onerror` handlers on images to provide fallback default avatars and placeholder images, improving visual consistency and user experience when external assets fail to load.
- Graceful degradation in data display: User sees clear error messages instead of application crashes, and complex data (like reports) implements pagination for better usability.

### System Design Choices
- **API Connectivity**: Frontend application interacts with a backend API located at `https://admin.pewaca.id`.
- **Error Handling**: Implemented robust, multi-level validation (HTTP status, JSON decode, type checking) for API responses across controllers to prevent crashes and provide informative error messages.
- **Dynamic Content**: JavaScript fetch calls are used to retrieve dynamic data from the backend.
- **Environment Configuration**: Utilizes `.env` for sensitive configurations like API keys and database credentials.
- **PWA Support**: Includes manifest for Progressive Web App features.

## External Dependencies
- **Backend API**: `https://admin.pewaca.id` (Django backend)
- **Payment Providers**:
    - Mock Provider (for development/testing)
    - Midtrans (production-ready integration for QRIS payments)
- **Libraries**:
    - Laravel 9.x (PHP framework)
    - Bootstrap 5 (CSS framework)
    - jQuery (JavaScript library)
    - Node.js (for frontend asset compilation)
    - Composer (PHP dependency manager)
    - npm (Node.js package manager)
    - `laravel/ui`
    - `spatie/laravel-permission`
    - `realarashid/sweet-alert`
    - `silviolleite/laravelpwa`