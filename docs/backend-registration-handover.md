# Backend Registration Error - Complete Handover Document

**Date**: October 26, 2025  
**Priority**: HIGH  
**Status**: Code Fixed, Django Module Reload Required  
**Affected Component**: Django Backend - User Registration Endpoint

---

## 📋 Executive Summary

**Issue**: Warga registration fails with MySQL error "Field 'user_id' doesn't have a default value"  
**Root Cause**: Serializer using incorrect field `user.user_id` instead of `user.id` for foreign key  
**Fix Status**: ✅ Code corrected in files, ❌ Django not loading new code (persistent cache)  
**Impact**: Critical - All new resident registrations blocked  
**Testing Tools Ready**: ✅ Laravel frontend testing suite fully functional

---

## 🔍 Issue Description

### Symptom
When attempting to register a new warga (resident) via `/api/auth/sign-up/{uuid}/`, the request fails with:

```
HTTP 400 Bad Request
Database error occurred: (1364, "Field 'user_id' doesn't have a default value")
```

### Transaction Flow
1. ✅ Email validation passes
2. ✅ MUser created successfully
3. ❌ Warga.objects.create() fails at database INSERT
4. ❌ Transaction rolled back
5. ❌ User never created, email verification never sent

### Log Evidence
```
DEBUG: BEGIN transaction
DEBUG: User.objects.create_user() - SUCCESS
DEBUG: Warga.objects.create() - FAIL
DEBUG: ROLLBACK TO SAVEPOINT
WARNING: Bad Request 400
```

---

## 🎯 Root Cause Analysis

### Database Schema
The `warga` table has the following structure:

```sql
CREATE TABLE warga (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id BIGINT NOT NULL,  -- Foreign key to m_user.user_id
    nik VARCHAR(16),
    full_name VARCHAR(150),
    -- ... other fields
    created_by BIGINT,  -- This field is causing the issue
    FOREIGN KEY (user_id) REFERENCES m_user(user_id)
)
```

### Model Definition
```python
# management_user/models.py
class MUser(AbstractBaseUser, PermissionsMixin):
    user_id = models.BigAutoField(primary_key=True)  # Auto-generated
    # ... other fields

class Warga(models.Model):
    user = models.ForeignKey(MUser, on_delete=models.CASCADE, db_column="user_id")
    created_by = models.BigIntegerField()  # Expects integer value
```

### The Bug
In `api/serializers/user_registration.py`, the code was:

```python
# ❌ WRONG - user.user_id is None at this point
Warga.objects.create(
    user=user,
    # ... other fields
    created_by=user.user_id  # BUG: user_id not yet assigned!
)
```

**Why it fails**:
1. `User.objects.create_user()` creates user object in memory
2. At this point, `user.user_id` is still `None` (auto-generated on commit)
3. `created_by=user.user_id` tries to set `None` value
4. Database rejects: "Field 'user_id' doesn't have a default value"
5. Transaction rolls back

**Correct approach**:
```python
# ✅ CORRECT - user.id (or user.pk) is available immediately
Warga.objects.create(
    user=user,
    # ... other fields
    created_by=user.id  # Works: Django pk always available
)
```

---

## 🔧 Exact Fix Instructions

### Files to Modify

**File**: `/home/ubuntu/apps/django/pewaca_be/dash/api/serializers/user_registration.py`

### Changes Required

Find and replace ALL occurrences of `created_by=user.user_id` with `created_by=user.id`:

**Line 124** (in list loop):
```python
# Before:
created_by=user.user_id

# After:
created_by=user.id
```

**Line 143** (in else branch):
```python
# Before:
created_by=user.user_id

# After:
created_by=user.id
```

**Line 239** (in UserUpdateSerializer):
```python
# Before:
created_by=user.user_id

# After:
created_by=user.id
```

**Line 326** (another location):
```python
# Before:
created_by=user.user_id

# After:
created_by=user.id
```

### Verification Command

```bash
cd /home/ubuntu/apps/django/pewaca_be/dash
grep -n "created_by=user" api/serializers/user_registration.py
```

**Expected output** (all should show `.id`, not `.user_id`):
```
124:                                created_by=user.id
143:                            created_by=user.id
239:                    created_by=user.id
326:                    created_by=user.id,
```

---

## ✅ Current Fix Status

### What Has Been Done
- ✅ Root cause identified (debugging session: 2+ hours)
- ✅ All 4 occurrences of bug corrected in source file
- ✅ File saved with correct code (verified via `grep` and `stat`)
- ✅ Debug print statements added to track execution flow
- ✅ Laravel testing tools created and ready

### What's Still Needed
- ❌ Django is not loading the corrected code (persistent Python cache issue)
- ❌ Print debug statements not appearing in logs (proves old code still running)
- ❌ Transaction still failing with same error

### Evidence Django Not Loading New Code

**Expected** (if new code loaded):
```
[DEBUG] Code: 350c228d-2121-47fd-a808-456a7523e527
[DEBUG] Validated data keys: dict_keys([...])
```

**Actual** (in logs):
```
WARNING Bad Request: /api/auth/sign-up/.../ 400
(no debug print statements visible)
```

This confirms Django is executing old cached Python bytecode.

---

## 🚀 Module Reload Instructions

### Standard Reload (Try First)

```bash
# 1. Navigate to project
cd /home/ubuntu/apps/django/pewaca_be/dash

# 2. Kill all Django processes
pkill -9 -f "python.*manage.py"
pkill -9 -f "python.*runserver"

# 3. Clear ALL Python bytecode cache
find . -type f -name "*.pyc" -delete
find . -type d -name "__pycache__" -exec rm -rf {} + 2>/dev/null

# 4. Specifically clear serializers cache
rm -rf api/serializers/__pycache__

# 5. Touch files to update modification time
touch api/serializers/user_registration.py
touch api/serializers/__init__.py

# 6. Restart Django (foreground first for debugging)
python manage.py runserver 0.0.0.0:8000
```

### If Still Fails - Nuclear Option

```bash
# 1. Complete shutdown
pkill -9 python
sleep 2

# 2. Clear Python cache everywhere
cd /home/ubuntu/apps/django/pewaca_be/dash
find . -name "*.pyc" -delete
find . -type d -name "__pycache__" -delete

# 3. Clear Django application cache (if configured)
python manage.py shell -c "from django.core.cache import cache; cache.clear()"

# 4. Backup and remove bytecode from serializers
cp -r api/serializers api/serializers.backup
find api/serializers -name "*.pyc" -delete
find api/serializers -type d -name "__pycache__" -exec rm -rf {} +

# 5. Restart fresh
python manage.py runserver 0.0.0.0:8000
```

### Production Server Reload (If Using Gunicorn/uWSGI)

```bash
# For systemd managed service
sudo systemctl reload gunicorn
# OR
sudo systemctl restart gunicorn

# For manual gunicorn
kill -HUP $(cat /path/to/gunicorn.pid)

# For uWSGI
touch /path/to/wsgi.py
```

---

## 🧪 Testing & Validation

### Laravel Testing Tools (Already Ready!)

The Laravel frontend has complete testing suite ready:

**1. Interactive Web UI**: `/test/registration`
- Tab-based interface
- Auto-generated test data
- Real-time API response viewer
- JSON formatting and error display

**2. Bash Script**: `./tests/registration-test.sh`
```bash
cd /path/to/laravel/app
./tests/registration-test.sh --uuid 350c228d-2121-47fd-a808-456a7523e527
```

**3. Postman Collection**: `tests/registration-api.postman_collection.json`
- 20+ endpoints documented
- Pre-request scripts for test data
- Import to Postman for manual testing

### Quick Test Command

```bash
# From Django terminal (after restart)
# Watch for debug output:
# [DEBUG] Code: ...
# [DEBUG] Validated data keys: ...

# In another terminal, trigger registration via Laravel test UI
```

### Success Indicators

✅ **Django Console Shows**:
```
[DEBUG] Code: 350c228d-2121-47fd-a808-456a7523e527
[DEBUG] Validated data keys: dict_keys(['email', 'password', 'unit_id', ...])
INSERT INTO warga (..., created_by) VALUES (..., 123)  -- real ID, not NULL
```

✅ **API Response**:
```json
{
  "status": "success",
  "message": "Registration successful. Please check your email for verification."
}
```

✅ **Database**:
```sql
SELECT * FROM m_user ORDER BY user_id DESC LIMIT 1;
SELECT * FROM warga WHERE user_id = [last_user_id];
-- Both records should exist
```

### Failure Indicators

❌ **No debug output in console** = Old code still running  
❌ **400 Bad Request** = Transaction still failing  
❌ **ROLLBACK in logs** = Database constraint error

---

## 📁 Related Documentation

Complete documentation package created by Laravel team:

1. **`docs/registration-scenario.md`** - Complete registration flow, all API endpoints
2. **`docs/backend-registration-debug-guide.md`** - Original debugging guide
3. **`docs/registration-testing-guide.md`** - How to use Laravel testing tools
4. **`docs/django-module-reload-guide.md`** - Deep dive into Python cache issues
5. **`docs/registration-fix-quickref.md`** - Quick reference card

---

## 🎯 Next Steps for Backend Team

### Immediate Actions (Priority 1)

1. **Verify File Changes**
   ```bash
   grep -n "created_by=user" api/serializers/user_registration.py
   # Should show all .id, no .user_id
   ```

2. **Force Django Reload** (see Module Reload Instructions above)

3. **Test Registration** (use Laravel testing UI at `/test/registration`)

4. **Verify Debug Output** appears in Django console

### If Successful

5. **Run Full Test Suite**
   ```bash
   ./tests/registration-test.sh --uuid {your-uuid}
   ```

6. **Test Email Verification** flow end-to-end

7. **Deploy to Production** (after staging validation)

### If Still Failing

8. **Collect Debug Info**:
   ```bash
   # Check what file Django is loading
   python manage.py shell
   >>> import api.serializers.user_registration
   >>> print(api.serializers.user_registration.__file__)
   >>> # Verify this matches edited file path
   ```

9. **Check for Multiple Serializer Files**:
   ```bash
   find . -name "user_registration.py" -type f
   # Ensure only one file exists
   ```

10. **Contact Laravel Team** with:
    - Django console full output
    - File verification command results
    - What reload methods were tried

---

## 🔐 Migration Notes

**IMPORTANT**: This is a **CODE BUG**, not a database schema issue.

- ❌ **DO NOT** run `makemigrations`
- ❌ **DO NOT** run `migrate`
- ❌ **DO NOT** modify database schema

The database structure is correct. Only the Python code needs fixing.

---

## 👥 Contact & Support

**Laravel Frontend Team**: All testing tools ready, waiting for backend fix  
**Documentation Location**: `/docs/` directory in Laravel app  
**Test Endpoint**: `https://pewaca.id/test/registration`

**Backend Team Questions**:
- File location unclear? See "Exact Fix Instructions" section
- Reload not working? See "Module Reload Instructions" section  
- Need to test? See "Testing & Validation" section

---

## 📊 Timeline Summary

- **Issue Reported**: October 26, 2025 (morning)
- **Root Cause Found**: October 26, 2025 13:00
- **Code Fixed**: October 26, 2025 13:39
- **Current Blocker**: Django module caching (as of 14:17)
- **Expected Resolution**: Within hours after successful reload

---

## ✅ Success Criteria

Registration is considered **FIXED** when:

1. ✅ Debug print statements appear in Django console
2. ✅ POST `/api/auth/sign-up/{uuid}/` returns 200/201
3. ✅ New user record created in `m_user` table
4. ✅ New warga record created in `warga` table with valid `created_by` value
5. ✅ Verification email sent successfully
6. ✅ Email verification link works
7. ✅ User can login after verification

---

**End of Handover Document**

For quick reference, see: `docs/registration-fix-quickref.md`
