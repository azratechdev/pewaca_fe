# Registration Fix - Quick Reference Card

**Date**: October 26, 2025  
**Issue**: Registration fails with "user_id doesn't have default value"  
**Status**: Code fixed, awaiting Django reload

---

## ⚡ 30-Second Fix

```bash
# 1. Verify file already fixed
cd /home/ubuntu/apps/django/pewaca_be/dash
grep -n "created_by=user" api/serializers/user_registration.py
# Should show: created_by=user.id (4 times)

# 2. Force Django reload
pkill -9 -f "manage.py"
find . -name "*.pyc" -delete
find . -type d -name "__pycache__" -delete
python manage.py runserver 0.0.0.0:8000

# 3. Test at https://pewaca.id/test/registration
```

---

## 🎯 The Bug

**File**: `api/serializers/user_registration.py`

**Wrong** (4 locations):
```python
created_by=user.user_id  # ❌ NULL value
```

**Correct**:
```python
created_by=user.id  # ✅ Always available
```

**Why**: Django's `user.user_id` is `None` until transaction commits. Use `user.id` (alias for pk) instead.

---

## 📍 Exact Locations

```bash
# Line 124 - list loop
created_by=user.id

# Line 143 - else branch
created_by=user.id

# Line 239 - UserUpdateSerializer
created_by=user.id

# Line 326 - another location
created_by=user.id
```

---

## ✅ Verification Checklist

### File Fixed?
```bash
grep "user.user_id" api/serializers/user_registration.py
# Should return: (no matches)
```

### Django Loaded New Code?
```bash
# Django console should show:
[DEBUG] Code: 350c228d-...
[DEBUG] Validated data keys: ...
```

### Registration Works?
```bash
# Test response should be:
HTTP 200/201
{"status": "success", "message": "Registration successful..."}
```

### Database Records Created?
```sql
SELECT * FROM warga ORDER BY created_on DESC LIMIT 1;
-- created_by should be integer, not NULL
```

---

## 🚨 If Still Failing

### No Debug Prints in Console?
→ Django not loading new code
→ See: `docs/django-module-reload-guide.md`

### Still Getting 400 Error?
→ Transaction still rolling back
→ Check: grep output shows .user_id instead of .id

### Django Won't Restart?
```bash
ps aux | grep python  # Find PIDs
kill -9 <PID> <PID>   # Kill all
python manage.py runserver 0.0.0.0:8000
```

---

## 🧪 Quick Test

**Web UI**: `https://pewaca.id/test/registration`
1. Click "Registration Form" tab
2. Click "Generate Test Data"
3. Click "Submit Registration"
4. Check response (should be success)

**Bash Script**:
```bash
./tests/registration-test.sh --uuid 350c228d-2121-47fd-a808-456a7523e527
```

**Postman**:
Import `tests/registration-api.postman_collection.json`

---

## 📞 Need Help?

**Full Documentation**:
- `docs/backend-registration-handover.md` - Complete analysis
- `docs/registration-testing-guide.md` - Testing tools guide
- `docs/django-module-reload-guide.md` - Cache troubleshooting

**Laravel Testing Tools**:
- Web UI: `/test/registration`
- Bash: `./tests/registration-test.sh`
- Postman: `tests/registration-api.postman_collection.json`

---

## 📊 Success Criteria

- [x] Code fixed (4 occurrences)
- [ ] Django loads new code (debug prints visible)
- [ ] Registration returns 200/201
- [ ] User + Warga records created
- [ ] created_by has integer value (not NULL)
- [ ] Email verification sent
- [ ] Login works after verification

---

**IMPORTANT**: This is a **code bug**, not database schema issue.
- ❌ Do NOT run migrations
- ❌ Do NOT modify database schema
- ✅ Only reload Django with fixed code

---

**End of Quick Reference**
