# Residence Frontend Application

## Overview
The Residence Frontend Application, developed by PT HEMITECH KARYA INDONESIA, is a Laravel 9 PHP web application designed for comprehensive residence management. It streamlines administration for residents and administrators, offering features such as user authentication, member management, reporting, and a QRIS payment orchestrator for fee collection. The project aims to enhance efficiency in residence administration and payment processing, including an internal marketplace (Warungku) and a public voting system (Pemilu-TC). The application also incorporates a modern company profile page for PT HEMITECH KARYA INDONESIA.

## User Preferences
I prefer simple language and detailed explanations. I want iterative development where you ask before making major changes. Do not make changes to the folder `Z`. Do not make changes to the file `Y`.

## System Architecture

### Technology Stack
- **Framework**: Laravel 9.x
- **PHP Version**: 8.2
- **Frontend**: Bootstrap 5, jQuery
- **Database**: MySQL (main), SQLite (development, QRIS payments, voting system)
- **Key Packages**: `laravel/ui`, `spatie/laravel-permission`, `realarashid/sweet-alert`, `silviolleite/laravelpwa`

### Core Features
- User authentication and role-based access control.
- Member management and payment tracking.
- Comprehensive reporting and billing functionalities.
- Progressive Web App (PWA) capabilities with optimized service worker.
- QRIS Payment Orchestrator using a dedicated SQLite database and flexible provider interface.
- **Warungku Marketplace**: Internal marketplace for residents, publicly accessible, with product listing and store management. Seller registration includes an approval workflow.
- **Company Profile Page**: Modern, responsive landing page for PT HEMITECH KARYA INDONESIA.
- **Voting System (Pemilu-TC)**: Public voting system for neighborhood association leader elections using a dedicated SQLite database.

### UI/UX Decisions
- Consistent use of Bootstrap 5 for responsive design.
- Image `onerror` handlers for visual consistency.
- Graceful degradation for data display with error messages and pagination.

### System Design Choices
- **API Connectivity**: Interacts with a Django backend API.
- **Error Handling**: Robust multi-level validation and logging for API responses.
- **Dynamic Content**: JavaScript fetch calls for data retrieval.
- **Environment Configuration**: Utilizes `.env` for sensitive settings.
- **PWA Support**: Full PWA implementation with offline page and installable app functionality.
- **Authentication**: Custom session-based authentication leveraging `Session::get('cred')` for user data, compatible with the Django backend.
- **Warga Registration**: UUID-based invitation system, multi-step registration, backend validation, email verification, and account creation via Django API.

## External Dependencies
- **Backend API**: `https://admin.pewaca.id` (Django backend)
- **Payment Providers**:
    - Mock Provider (development/testing)
    - Midtrans (production QRIS payments)
- **Libraries & Tools**:
    - Laravel 9.x
    - Bootstrap 5
    - jQuery
    - Node.js
    - Composer
    - npm
    - `laravel/ui`
    - `spatie/laravel-permission`
    - `realarashid/sweet-alert`
    - `silviolleite/laravelpwa`
    - `browser-image-compression` (for client-side image compression)