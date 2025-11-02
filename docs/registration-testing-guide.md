# Registration Testing Guide

**Purpose**: Step-by-step guide to validate the registration fix using Laravel testing tools  
**Audience**: Backend developers, QA testers  
**Prerequisites**: Django backend running with fixed code

---

## 🎯 Overview

The Laravel frontend team has created three comprehensive testing tools for the registration flow:

1. **Interactive Web UI** - Best for manual testing and debugging
2. **Bash Script** - Best for automated testing and CI/CD
3. **Postman Collection** - Best for API documentation and manual testing

---

## 🌐 Tool 1: Interactive Web UI

### Access

Navigate to: `https://pewaca.id/test/registration`

Or locally: `http://localhost/test/registration`

### Features

- **Tab-based interface** for each registration step
- **Auto-generated test data** - Click "Generate Test Data" button
- **Real-time API response viewer** with JSON formatting
- **Master data viewer** - See all dropdown options
- **Error highlighting** - Clear display of validation errors

### Testing Steps

#### Step 1: View Master Data
1. Click **"Master Data"** tab
2. Review all gender, religion, education, occupation options
3. Verify data loads correctly from Django API

#### Step 2: Test Residence Lookup
1. Click **"Residence & Units"** tab
2. UUID pre-filled: `350c228d-2121-47fd-a808-456a7523e527`
3. Click **"Get Residence Info"**
4. ✅ Should show residence name, address, units list
5. ❌ If 404: Check UUID format or residence exists

#### Step 3: Test Registration Form
1. Click **"Registration Form"** tab
2. Click **"Generate Test Data"** button
3. Form auto-fills with valid test data
4. Review data (NIK, email, phone, etc.)
5. Click **"Submit Registration"**

**Expected Success**:
```json
{
  "status": "success",
  "message": "Registration successful. Please check your email for verification.",
  "data": {
    "email": "test.warga.123456@example.com",
    "user_id": 45
  }
}
```

**Expected Failure (if bug still exists)**:
```json
{
  "error": "Database error occurred: (1364, \"Field 'user_id' doesn't have a default value\")"
}
```

#### Step 4: Test Email Verification
1. Click **"Email Verification"** tab
2. Check email inbox (test email from registration)
3. Copy verification link: `/api/auth/verify/{uidb64}/{token}/`
4. Paste `uidb64` and `token` values
5. Click **"Verify Email"**

**Expected Success**:
```json
{
  "message": "Email verified successfully. You can now login."
}
```

#### Step 5: Test Login
1. Click **"Login"** tab
2. Enter registered email and password
3. Click **"Login"**

**Expected Success**:
```json
{
  "access": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "refresh": "eyJ0eXAiOiJKV1QiLCJhbGc...",
  "user": {
    "user_id": 45,
    "email": "test.warga.123456@example.com"
  }
}
```

### Troubleshooting Web UI

**Issue**: "Network Error" or "Failed to fetch"
- **Solution**: Check Django backend is running
- **Solution**: Verify CORS settings allow frontend domain

**Issue**: "404 Not Found" on residence lookup
- **Solution**: Use UUID string, not numeric ID
- **Solution**: Verify residence with that UUID exists

**Issue**: "413 Request Entity Too Large"
- **Solution**: Image file > 2MB, compress before upload
- **Solution**: Increase Django `DATA_UPLOAD_MAX_MEMORY_SIZE`

---

## 🔧 Tool 2: Bash Testing Script

### Location

```bash
cd /path/to/laravel/app
./tests/registration-test.sh
```

### Usage

```bash
# Basic usage
./tests/registration-test.sh --uuid 350c228d-2121-47fd-a808-456a7523e527

# With custom API base URL
./tests/registration-test.sh --uuid {uuid} --base-url https://admin.pewaca.id

# Verbose mode (show full responses)
./tests/registration-test.sh --uuid {uuid} --verbose
```

### What It Tests

1. ✅ Residence lookup by UUID
2. ✅ Units list retrieval
3. ✅ All master data endpoints (gender, religion, etc.)
4. ✅ Registration with auto-generated data
5. ✅ Email verification (simulated)
6. ✅ User login
7. ❌ Negative tests (invalid UUID, duplicate email, etc.)

### Output Format

```
========================================
  PEWACA REGISTRATION API TEST SUITE
========================================

[✓] Test 1: Residence Lookup - PASS
[✓] Test 2: Units List - PASS
[✓] Test 3: Gender Master Data - PASS
[✓] Test 4: Religion Master Data - PASS
[✓] Test 5: Registration - PASS
[✗] Test 6: Duplicate Email - FAIL (expected)
[✓] Test 7: Email Verification - PASS
[✓] Test 8: Login - PASS

========================================
  RESULTS: 7/8 tests passed
========================================
```

### Exit Codes

- `0` = All tests passed
- `1` = One or more tests failed
- `2` = Script error (missing dependencies, etc.)

### CI/CD Integration

```yaml
# .gitlab-ci.yml example
test_registration:
  script:
    - cd laravel_app
    - ./tests/registration-test.sh --uuid $RESIDENCE_UUID
  only:
    - develop
    - staging
```

---

## 📮 Tool 3: Postman Collection

### Location

`tests/registration-api.postman_collection.json`

### Import to Postman

1. Open Postman
2. Click **Import** button
3. Select `registration-api.postman_collection.json`
4. Collection appears in sidebar

### Configure Environment

Create Postman environment with variables:

```json
{
  "base_url": "https://admin.pewaca.id",
  "residence_uuid": "350c228d-2121-47fd-a808-456a7523e527",
  "test_email": "test@example.com",
  "test_password": "testpass123"
}
```

### Available Requests

**Authentication & Registration** (6 requests)
- POST Sign Up (with pre-request script for test data)
- GET Verify Email
- POST Resend Verification
- POST Login
- POST Password Reset Request
- POST Password Reset Confirm

**Master Data** (7 requests)
- GET Gender List
- GET Religion List
- GET Family Roles
- GET Education Levels
- GET Occupations
- GET Marital Statuses
- GET Cities

**Residence & Units** (3 requests)
- GET Residence by UUID
- GET Units by Residence UUID
- GET Unit Details

**Testing Features** (4 requests)
- Negative Test: Invalid UUID
- Negative Test: Duplicate Email
- Negative Test: File Too Large
- Negative Test: Invalid Token

### Pre-Request Scripts

Auto-generate test data before each request:

```javascript
// Generates unique email like test.warga.1234567890@example.com
pm.environment.set("test_email", `test.warga.${Date.now()}@example.com`);

// Generates random 16-digit NIK
pm.environment.set("test_nik", Math.floor(1000000000000000 + Math.random() * 9000000000000000));
```

### Test Scripts

Automatically validate responses:

```javascript
pm.test("Status code is 200", function () {
    pm.response.to.have.status(200);
});

pm.test("Response has user_id", function () {
    var jsonData = pm.response.json();
    pm.expect(jsonData.data).to.have.property('user_id');
});
```

---

## 🧪 Complete Testing Workflow

### Phase 1: Backend Verification (Django Team)

```bash
# 1. Verify code fix
cd /home/ubuntu/apps/django/pewaca_be/dash
grep -n "created_by=user" api/serializers/user_registration.py
# Should show: created_by=user.id (4 occurrences)

# 2. Restart Django (see reload guide)
pkill -9 -f "manage.py"
find . -name "*.pyc" -delete
python manage.py runserver 0.0.0.0:8000

# 3. Watch console for debug output
# Should see: [DEBUG] Code: ... when registration attempted
```

### Phase 2: Quick Smoke Test (Laravel UI)

```
1. Open https://pewaca.id/test/registration
2. Click "Registration Form" tab
3. Click "Generate Test Data"
4. Click "Submit Registration"
5. Check response for success/error
```

### Phase 3: Full Automated Test (Bash Script)

```bash
cd /path/to/laravel/app
./tests/registration-test.sh --uuid 350c228d-2121-47fd-a808-456a7523e527

# Review results
# All tests should pass except expected negative tests
```

### Phase 4: Database Verification

```sql
-- Check user was created
SELECT * FROM m_user 
WHERE user_email LIKE 'test.warga%' 
ORDER BY user_created_on DESC 
LIMIT 5;

-- Check warga was created with correct created_by
SELECT w.*, u.user_email 
FROM warga w
JOIN m_user u ON w.user_id = u.user_id
WHERE u.user_email LIKE 'test.warga%'
ORDER BY w.created_on DESC
LIMIT 5;

-- Verify created_by is NOT NULL
SELECT COUNT(*) as should_be_zero
FROM warga 
WHERE created_by IS NULL;
```

### Phase 5: End-to-End Flow Test

1. ✅ Register new user (Web UI or Postman)
2. ✅ Receive verification email
3. ✅ Click verification link
4. ✅ Email verified successfully
5. ✅ Login with email + password
6. ✅ Receive JWT tokens
7. ✅ Access protected endpoints with token

---

## 📊 Test Results Checklist

### ✅ Success Indicators

- [ ] Django console shows `[DEBUG]` statements
- [ ] Registration returns 200/201 status
- [ ] User record created in `m_user`
- [ ] Warga record created with valid `created_by` value
- [ ] Verification email sent
- [ ] Email verification link works
- [ ] Login returns JWT tokens
- [ ] Protected endpoints accessible with token

### ❌ Failure Indicators

- [ ] No debug output in Django console = Old code still cached
- [ ] 400 Bad Request = Database error still occurring
- [ ] Transaction ROLLBACK in logs = Bug not fixed
- [ ] created_by is NULL in database = Wrong field used

---

## 🔄 Regression Testing

After fix is deployed, test these scenarios:

### Happy Path
- [ ] Single warga registration
- [ ] Multiple family members (3+ warga)
- [ ] With profile photos
- [ ] Without profile photos
- [ ] All master data combinations (gender, religion, etc.)

### Edge Cases
- [ ] Minimum data (required fields only)
- [ ] Maximum data (all optional fields filled)
- [ ] Special characters in names
- [ ] International phone numbers
- [ ] Long addresses

### Error Handling
- [ ] Duplicate email (should fail gracefully)
- [ ] Invalid UUID (should return 404)
- [ ] Missing required fields (should return validation errors)
- [ ] File size > 2MB (should return 413)
- [ ] Invalid verification token (should return error)

---

## 📞 Support & Escalation

**If Tests Fail After Fix:**

1. **Check Django console** for debug output
   - Not visible? Code not reloaded (see reload guide)

2. **Check database** for created records
   - Records missing? Transaction still rolling back

3. **Check API response** for error details
   - Shows field name? Validation issue
   - Shows "user_id"? Serializer bug still exists

4. **Collect evidence**:
   ```bash
   # Django logs
   tail -n 100 nohup.out > django_error.log
   
   # Database state
   mysql -u root -p -e "SELECT * FROM warga ORDER BY created_on DESC LIMIT 5" > db_state.sql
   
   # File verification
   grep -n "created_by" api/serializers/user_registration.py > code_check.txt
   ```

5. **Contact Laravel team** with evidence files

---

**End of Testing Guide**

Related: `docs/backend-registration-handover.md` | `docs/django-module-reload-guide.md`
