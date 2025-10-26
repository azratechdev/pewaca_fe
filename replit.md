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

### Warga Registration Architecture
- **Registration Flow**: UUID-based invitation system where pengurus generates unique registration codes for new residents
- **Multi-Step Process**:
  1. Pengurus creates/shares residence UUID code
  2. Warga accesses `/registration/{uuid}` link
  3. System loads residence data and master data (units, gender, religion, etc.) from Django API
  4. Warga fills comprehensive registration form with personal details
  5. Backend validates and creates user account via `POST /api/auth/sign-up/{code}/`
  6. System sends verification email with unique token
  7. Warga verifies email via link (`GET /api/auth/verify/{uidb64}/{token}/`)
  8. After verification, warga can login with email/password
- **Key Components**:
  - `RegisterController`: Handles registration form display and submission
  - Django API endpoints: residence-by-code, units/code, master data, sign-up, verify
  - Email verification system with token-based authentication
  - Frontend validation: NIK (16 digits), phone format, file size limits (2MB for photos)
  - Error handling for duplicate emails, invalid codes, expired tokens

### Registration Testing Tools
Located in `/test/registration` - comprehensive testing suite for registration flow:
- **Interactive Web UI** (`/test/registration`):
  - Tab-based interface for testing each step of registration
  - Master data viewer with all dropdown options
  - Residence & units validation
  - Registration form tester with auto-generated test data
  - Email verification simulator
  - Login tester
  - Real-time API response viewer with JSON formatting
- **Bash Testing Script** (`tests/registration-test.sh`):
  - Automated end-to-end testing of full registration flow
  - Negative testing (invalid UUID, duplicate email, file size errors)
  - Colorized output with pass/fail indicators
  - Usage: `./tests/registration-test.sh --uuid {your-uuid}`
- **Postman Collection** (`tests/registration-api.postman_collection.json`):
  - Complete API collection with 20+ endpoints
  - Pre-request scripts for auto-generating test data
  - Test scripts for response validation
  - Environment variables for easy configuration
  - Import into Postman for manual/automated testing
- **Documentation** (`docs/registration-scenario.md`):
  - Complete flow diagrams and step-by-step guides
  - All API endpoints with request/response examples
  - Error handling scenarios and troubleshooting guides
  - Common issues (413 file size, 400 validation, 401 auth errors)

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

## Important API Endpoints (Django Backend)

### Authentication & Registration
- `POST /api/auth/login/` - User login (returns JWT token)
- `POST /api/auth/sign-up/{code}/` - Register new warga (multipart/form-data)
- `GET /api/auth/verify/{uidb64}/{token}/` - Email verification
- `POST /api/auth/verify/resend/` - Resend verification email
- `POST /api/auth/password-reset/` - Request password reset
- `POST /api/auth/reset/{uidb64}/{token}/` - Reset password with token
- `GET /api/auth/profil/` - Get user profile (authenticated)
- `PUT /api/auth/profil/update/` - Update user profile

### Residence & Units
- `GET /api/residence-by-code/{uuid}/` - Get residence info by UUID code (NOT numeric ID)
- `GET /api/units/code/{uuid}/` - Get units list by residence UUID

### Master Data
- `GET /api/gender/` - Gender list
- `GET /api/religions/` - Religion list
- `GET /api/family-as/` - Family role list
- `GET /api/education/` - Education level list
- `GET /api/ocupation/` - Occupation list
- `GET /api/marital-statuses/` - Marital status list
- `GET /api/cities/` - Cities list

### Payment & Tagihan
- `GET /api/tagihan-warga/self-list/` - Get user's tagihan list
- `PATCH /api/tagihan-warga/bayar/{id}/` - Mark tagihan as paid (upload bukti)
- `POST /api/tagihan-warga/{id}/approve/` - Approve payment (pengurus)
- `POST /api/tagihan-warga/{id}/reject/` - Reject payment (pengurus)

### Common Errors
- **404 on `/api/residence-by-code/1/`**: Use UUID string, not numeric ID
- **413 Request Entity Too Large**: File upload > 2MB, compress images before upload
- **400 Bad Request on sign-up**: Missing required fields or validation errors
- **401 Unauthorized on login**: Wrong password, unverified email, or inactive account
- **user_id doesn't have default value**: Backend Django serializer bug - FIXED, awaiting Django module reload

## Registration Bug Fix Status (October 26, 2025)

### Current Status: CODE FIXED, AWAITING DJANGO RELOAD

**Issue**: Registration fails with MySQL error "Field 'user_id' doesn't have a default value"  
**Root Cause**: Django serializer using `user.user_id` (NULL) instead of `user.id` for foreign key  
**Fix Applied**: ✅ All 4 occurrences corrected in `api/serializers/user_registration.py`  
**Blocker**: ❌ Django not loading new code due to persistent Python module cache

### Backend Fix Details

**File**: `/home/ubuntu/apps/django/pewaca_be/dash/api/serializers/user_registration.py`  
**Changes**: Lines 124, 143, 239, 326 - Changed `created_by=user.user_id` → `created_by=user.id`  
**Verified**: ✅ File content correct (confirmed via grep)  
**Next Step**: Django needs module reload to load corrected code

### Complete Documentation Package

Laravel team has created comprehensive handover documentation for backend team:

1. **`docs/backend-registration-handover.md`** - Complete handover document
   - Executive summary with root cause analysis
   - Exact fix instructions with file paths and line numbers
   - Module reload instructions (standard and nuclear options)
   - Testing and validation procedures
   - Success criteria checklist

2. **`docs/registration-testing-guide.md`** - Testing tools guide
   - Step-by-step instructions for Web UI testing (`/test/registration`)
   - Bash script usage guide (`tests/registration-test.sh`)
   - Postman collection documentation
   - Complete testing workflow (smoke test → automated → database verification)
   - Regression testing checklist

3. **`docs/django-module-reload-guide.md`** - Troubleshooting guide
   - Understanding Python/Django module caching
   - Quick diagnosis methods (4 tests to identify cache issues)
   - 6 solution approaches (development server, nuclear clear, production reload, etc.)
   - Environment-specific issues and file system problems
   - Advanced debugging techniques

4. **`docs/registration-fix-quickref.md`** - Quick reference card
   - 30-second fix instructions
   - Exact code locations and changes
   - Verification checklist
   - Quick test commands
   - Troubleshooting if still failing

5. **`docs/registration-scenario.md`** - Registration flow documentation (existing)
   - Complete registration flow diagrams
   - All API endpoints with examples
   - Error handling scenarios

6. **`docs/backend-registration-debug-guide.md`** - Original debugging guide (existing)
   - Detailed debugging process
   - Step-by-step troubleshooting

### Laravel Testing Tools (Ready to Use)

All testing tools are fully functional and ready for validation once backend fix is loaded:

- **Web UI**: `https://pewaca.id/test/registration` - Interactive testing interface
- **Bash Script**: `./tests/registration-test.sh --uuid {uuid}` - Automated testing
- **Postman Collection**: `tests/registration-api.postman_collection.json` - API testing

### For Backend Team

**Immediate Action Required**:
```bash
# 1. Verify file is correct
grep -n "created_by=user" api/serializers/user_registration.py
# Should show: created_by=user.id (4 occurrences)

# 2. Force Django reload
pkill -9 -f "manage.py"
find . -name "*.pyc" -delete
find . -type d -name "__pycache__" -delete
python manage.py runserver 0.0.0.0:8000

# 3. Test using Laravel tools
```

See `docs/registration-fix-quickref.md` for immediate action or `docs/backend-registration-handover.md` for complete details.

## Backend Debugging Resources

For backend Django developers:
- **Registration Bug Fix**: See "Registration Bug Fix Status" section above
- **Quick Reference**: `docs/registration-fix-quickref.md` (30-second fix)
- **Complete Handover**: `docs/backend-registration-handover.md` (full analysis)
- **Testing Guide**: `docs/registration-testing-guide.md` (validation procedures)
- **Module Reload**: `docs/django-module-reload-guide.md` (cache troubleshooting)
- **Flow Documentation**: `docs/registration-scenario.md` (API endpoints and flows)