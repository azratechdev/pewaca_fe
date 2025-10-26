# Django Module Reload Troubleshooting Guide

**Purpose**: Resolve persistent Python module caching issues in Django  
**Symptom**: Code changes not reflected even after server restart  
**Common Scenario**: Serializer/model/view changes not loading

---

## 🔍 Understanding the Problem

### Why Django Caches Modules

Python and Django cache compiled bytecode for performance:

1. **`.pyc` files** - Compiled bytecode stored in `__pycache__/`
2. **`sys.modules`** - In-memory cache of imported modules
3. **Django auto-reloader** - Monitors file changes in dev mode
4. **Production servers** - WSGI servers cache modules until restart

### When Cache Becomes Stale

```
Developer edits file → Save
     ↓
File system updated ✅
     ↓
But Django still loads old .pyc from cache ❌
     ↓
Changes not visible
```

---

## 🎯 Quick Diagnosis

### Test 1: Are Changes in File?

```bash
# View the actual file content
cat api/serializers/user_registration.py | grep "created_by"

# Should show new code (created_by=user.id)
# If shows old code (created_by=user.user_id), file not saved correctly
```

### Test 2: Are .pyc Files Updated?

```bash
# Check modification time of source vs bytecode
stat api/serializers/user_registration.py
stat api/serializers/__pycache__/user_registration.*.pyc

# Source file should be NEWER than .pyc
# If .pyc is newer, Python is regenerating from outdated source
```

### Test 3: Is Django Auto-Reload Working?

```bash
# In Django console, watch for:
Watching for file changes with StatReloader
Performing system checks...

# If not visible, auto-reload may be disabled
```

### Test 4: Add Debug Prints

```python
# Top of serializer create() method
def create(self, validated_data):
    print("=" * 50)
    print("SERIALIZER VERSION: 2025-10-26-14-00")  # Update timestamp each edit
    print("=" * 50)
    # ... rest of code
```

Run test → Check Django console:
- Prints appear with correct timestamp? ✅ Code loading
- Prints don't appear? ❌ Old code still cached
- Prints appear with old timestamp? ❌ Old .pyc still loaded

---

## 🔧 Solution 1: Standard Development Server Reload

### For `python manage.py runserver`

```bash
# 1. Stop Django cleanly
# Press Ctrl+C in Django terminal

# 2. Clear bytecode cache
find . -type f -name "*.pyc" -delete
find . -type d -name "__pycache__" -exec rm -rf {} + 2>/dev/null

# 3. Verify deletion
ls -la api/serializers/__pycache__/
# Should be empty or not exist

# 4. Restart server
python manage.py runserver 0.0.0.0:8000

# 5. Watch for auto-reload messages
# Watching for file changes with StatReloader
# System check identified no issues
```

### If Auto-Reload Not Triggering

```bash
# Force file change detection with touch
touch api/serializers/user_registration.py
touch api/serializers/__init__.py

# Django should print:
# .../user_registration.py changed, reloading.
```

### If Touch Doesn't Work

```bash
# Disable/enable auto-reload manually
python manage.py runserver 0.0.0.0:8000 --noreload
# Ctrl+C
python manage.py runserver 0.0.0.0:8000
# Auto-reload re-enabled
```

---

## 🔧 Solution 2: Nuclear Cache Clear

### When Standard Methods Fail

```bash
#!/bin/bash
# nuclear_reload.sh

echo "=== Django Nuclear Cache Clear ==="

# 1. Kill ALL Python processes (careful in production!)
echo "Killing all Python processes..."
pkill -9 python
sleep 2

# 2. Clear Python bytecode EVERYWHERE
echo "Clearing all .pyc files..."
find /home/ubuntu/apps/django/pewaca_be -name "*.pyc" -delete
find /home/ubuntu/apps/django/pewaca_be -type d -name "__pycache__" -delete

# 3. Clear Django cache (if using cache backend)
echo "Clearing Django cache..."
cd /home/ubuntu/apps/django/pewaca_be/dash
python manage.py shell << EOF
from django.core.cache import cache
cache.clear()
print("Django cache cleared")
EOF

# 4. Clear pip cache (extreme measure)
# pip cache purge

# 5. Restart Django
echo "Restarting Django..."
python manage.py runserver 0.0.0.0:8000 &
echo "Django started. PID: $!"

echo "=== Cache clear complete ==="
```

### Usage

```bash
chmod +x nuclear_reload.sh
./nuclear_reload.sh
```

---

## 🔧 Solution 3: Production Server Reload

### For Gunicorn (systemd)

```bash
# Graceful reload (no downtime)
sudo systemctl reload gunicorn

# Full restart (brief downtime)
sudo systemctl restart gunicorn

# Check status
sudo systemctl status gunicorn

# View logs
sudo journalctl -u gunicorn -f
```

### For Gunicorn (manual)

```bash
# Find Gunicorn master process
ps aux | grep gunicorn

# Send HUP signal (graceful reload)
kill -HUP <master-pid>

# Or kill all and restart
pkill -9 gunicorn
gunicorn --config gunicorn_config.py myproject.wsgi:application
```

### For uWSGI

```bash
# Touch wsgi.py to trigger reload
touch /path/to/project/wsgi.py

# Or restart uWSGI service
sudo systemctl restart uwsgi

# Or send SIGHUP
kill -HUP $(cat /var/run/uwsgi.pid)
```

### For mod_wsgi (Apache)

```bash
# Touch wsgi.py
touch /path/to/project/wsgi.py

# Or reload Apache
sudo systemctl reload apache2
# OR
sudo service apache2 reload
```

---

## 🔧 Solution 4: Import Path Verification

### Problem: Wrong File Being Imported

```bash
# Check what Django actually imports
python manage.py shell

>>> import api.serializers.user_registration
>>> print(api.serializers.user_registration.__file__)
/home/ubuntu/apps/django/pewaca_be/dash/api/serializers/user_registration.py

>>> # This should match the file you edited!
>>> # If different path shown, you're editing wrong file
```

### Check for Duplicate Files

```bash
# Find all files with same name
find . -name "user_registration.py" -type f

# Expected: Only one file
# If multiple found, determine which is actually imported
```

### Check Import Chain

```python
# In shell
>>> import api.serializers
>>> print(api.serializers.__file__)
# Should show: .../api/serializers/__init__.py

>>> # Check __init__.py imports correct module
>>> with open('api/serializers/__init__.py') as f:
...     print(f.read())
# Should show: from .user_registration import *
```

---

## 🔧 Solution 5: Environment-Specific Issues

### Virtual Environment Cache

```bash
# If using venv/virtualenv
deactivate
source venv/bin/activate  # or conda activate

# Clear venv cache
find venv/lib -name "*.pyc" -delete
```

### Python Version Mismatch

```bash
# Check Python version
python --version
which python

# Check shebang in manage.py
head -1 manage.py
# Should match your Python version

# If mismatch, explicitly run with correct Python
python3.11 manage.py runserver 0.0.0.0:8000
```

### PYTHONDONTWRITEBYTECODE

```bash
# Prevent .pyc creation entirely (debugging only)
export PYTHONDONTWRITEBYTECODE=1
python manage.py runserver 0.0.0.0:8000

# Unset after debugging
unset PYTHONDONTWRITEBYTECODE
```

---

## 🔧 Solution 6: File System Issues

### Permissions

```bash
# Ensure files are readable
chmod 644 api/serializers/user_registration.py
chmod 755 api/serializers/

# Check ownership
ls -la api/serializers/user_registration.py
# Should be owned by current user

# Fix if needed
sudo chown ubuntu:ubuntu api/serializers/user_registration.py
```

### File System Sync (NFS/Network Drives)

```bash
# Force file system sync
sync

# Wait for NFS cache to update
sleep 5

# Then restart Django
```

### Symbolic Links

```bash
# Check for symlinks
ls -la api/serializers/user_registration.py

# If symlink, follow to actual file
readlink -f api/serializers/user_registration.py

# Edit actual file, not symlink
```

---

## 🧪 Verification Methods

### Method 1: Version Stamps

```python
# Add to serializer
VERSION = "2025-10-26-15-30-FIXED"

def create(self, validated_data):
    print(f"Running serializer version: {VERSION}")
    # ... rest of code
```

Check console for version string after restart.

### Method 2: Syntax Error Test

```python
# Temporarily add syntax error
def create(self, validated_data):
    THIS_WILL_CAUSE_ERROR  # Intentional syntax error
    # ... rest of code
```

Restart Django:
- Error appears? ✅ New code loading
- No error? ❌ Still loading old code

Remove syntax error after test.

### Method 3: Import in Shell

```bash
python manage.py shell

>>> import importlib
>>> import api.serializers.user_registration
>>> importlib.reload(api.serializers.user_registration)

>>> # Check if new code visible
>>> import inspect
>>> source = inspect.getsource(api.serializers.user_registration.UserRegistrationSerializer.create)
>>> print(source)
# Should show new code with created_by=user.id
```

---

## 📊 Common Scenarios & Solutions

| Symptom | Likely Cause | Solution |
|---------|--------------|----------|
| No debug prints appear | Old code cached | Solution 1: Clear .pyc files |
| Prints appear with old timestamp | .pyc outdated | Solution 2: Nuclear cache clear |
| Django not restarting on file changes | Auto-reload disabled | Check runserver args, remove --noreload |
| Changes visible in shell but not API | WSGI server cached | Solution 3: Reload gunicorn/uwsgi |
| Multiple files with same name | Import path confusion | Solution 4: Verify import path |
| File edited but stat shows old time | Editor not saving | Force save, check file system |
| Works locally, not on server | File sync delay | Solution 6: Check NFS/permissions |

---

## 🚨 Last Resort: Server Reboot

If ALL above solutions fail:

```bash
# Backup current state
tar -czf backup_$(date +%Y%m%d_%H%M%S).tar.gz api/

# Reboot server
sudo reboot

# After reboot
cd /home/ubuntu/apps/django/pewaca_be/dash
python manage.py runserver 0.0.0.0:8000
```

---

## 📝 Prevention Best Practices

### 1. Always Use Version Control

```bash
# Commit before major changes
git add api/serializers/user_registration.py
git commit -m "Fix: Use user.id instead of user.user_id for created_by"

# Easy rollback if needed
git diff HEAD~1  # See what changed
```

### 2. Add Version Strings

```python
# In every critical file
__version__ = "1.0.1"
__last_modified__ = "2025-10-26"
```

### 3. Use Logging Instead of Print

```python
import logging
logger = logging.getLogger(__name__)

def create(self, validated_data):
    logger.info(f"UserRegistrationSerializer.create called - version {__version__}")
    # ... code
```

### 4. Automated Tests

```python
# tests/test_registration.py
def test_warga_created_with_created_by():
    # Register user
    response = client.post('/api/auth/sign-up/...')
    
    # Check warga has created_by
    warga = Warga.objects.latest('id')
    assert warga.created_by is not None, "created_by should not be NULL"
    assert warga.created_by == warga.user.id, "created_by should match user.id"
```

### 5. CI/CD Cache Clearing

```yaml
# .gitlab-ci.yml
deploy:
  script:
    - find . -name "*.pyc" -delete
    - find . -type d -name "__pycache__" -delete
    - python manage.py migrate
    - touch wsgi.py  # Trigger reload
```

---

## 🔬 Advanced Debugging

### Enable Django Debug Toolbar

```python
# settings.py
if DEBUG:
    INSTALLED_APPS += ['debug_toolbar']
    MIDDLEWARE += ['debug_toolbar.middleware.DebugToolbarMiddleware']
    INTERNAL_IPS = ['127.0.0.1']
```

Shows exactly which modules are imported for each request.

### Use strace to Monitor File Access

```bash
# See what files Python actually reads
strace -e trace=open,openat python manage.py runserver 2>&1 | grep user_registration

# Should show reads from correct file path
```

### Python Import Hooks

```python
# Add to manage.py for debugging
import sys

class ImportLogger:
    def find_module(self, fullname, path=None):
        if 'user_registration' in fullname:
            print(f"Importing: {fullname} from {path}")
        return None

sys.meta_path.insert(0, ImportLogger())
```

---

**End of Django Module Reload Guide**

Related: `docs/backend-registration-handover.md` | `docs/registration-testing-guide.md`
