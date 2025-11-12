# 🚀 Deployment Guide - Blok Rumah Dropdown Feature

## 📋 Overview
Deploy public registration Blok Rumah dropdown feature dengan graceful degradation ke Tencent Lighthouse production server.

---

## 🎯 **PART 1: LARAVEL FRONTEND (pewaca.id)**

### **Step 1: Commit & Push Changes**

```bash
# Di local/Replit environment
git add .
git commit -m "feat: Add Blok Rumah dropdown with graceful degradation for public registration"
git push origin main
```

### **Step 2: Deploy ke Tencent Server**

```bash
# SSH ke Tencent server
ssh root@pewaca.id
# atau
ssh ubuntu@pewaca.id

# Navigate ke Laravel project directory
cd /var/www/pewaca.id
# atau path yang sesuai

# Pull latest changes
git pull origin main

# Install/update dependencies (jika ada perubahan)
composer install --no-dev --optimize-autoloader

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Optimize for production
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Fix permissions
sudo chown -R www-data:www-data /var/www/pewaca.id
sudo chmod -R 755 /var/www/pewaca.id/storage
sudo chmod -R 755 /var/www/pewaca.id/bootstrap/cache

# Restart PHP-FPM
sudo systemctl restart php8.2-fpm

# Restart Nginx
sudo systemctl restart nginx
```

### **Step 3: Verify Laravel Deployment**

```bash
# Check if site is accessible
curl -I https://pewaca.id/register

# Expected: HTTP/2 200 OK

# Check PHP-FPM status
sudo systemctl status php8.2-fpm

# Check Nginx status
sudo systemctl status nginx

# Check Laravel logs for errors
tail -f /var/www/pewaca.id/storage/logs/laravel.log
```

---

## 🔧 **PART 2: DJANGO BACKEND (admin.pewaca.id)**

### **Step 1: Update Django Code**

**File: `dash/api/serializers/MUnit.py`** (create or update):

```python
from rest_framework import serializers
from management_user.models import MUnit

class MUnitPublicSerializer(serializers.ModelSerializer):
    """
    Simple serializer for unit dropdown in public registration
    Returns only essential fields: unit_id and unit_name
    """
    class Meta:
        model = MUnit
        fields = ['unit_id', 'unit_name']
```

**File: `dash/api/serializers/__init__.py`** (update):

```python
from .MUnit import MUnitPublicSerializer

__all__ = [
    # ... existing exports ...
    'MUnitPublicSerializer',
]
```

**File: `dash/api/views/unit.py`** (update MUnitViewSet):

```python
from rest_framework.decorators import action
from rest_framework.permissions import AllowAny
from api.serializers.MUnit import MUnitPublicSerializer

class MUnitViewSet(...):
    # ... existing code ...
    
    @action(detail=False, methods=['get'], url_path=r'residence/(?P<residence_id>[^/.]+)', permission_classes=[AllowAny])
    def residence_units(self, request, residence_id=None):
        """
        Public endpoint to get available units by residence_id
        URL: /api/units/residence/{residence_id}/
        """
        try:
            units = MUnit.objects.filter(
                unit_residence_id=residence_id,
                unit_isactive=True,
                unit_isdelete=False
            ).order_by('unit_name')
            
            if not units.exists():
                return custom_response(
                    data=[],
                    message="Tidak ada unit tersedia",
                    status_code=200
                )
            
            serializer = MUnitPublicSerializer(units, many=True)
            return custom_response(data=serializer.data)
            
        except Exception as e:
            return custom_error_response(
                f"Gagal memuat data unit: {str(e)}", 
                status_code=500
            )
```

**File: `dash/api/views/__init__.py` atau `auth.py`** (update public_sign_up):

```python
def public_sign_up(request):
    # ... existing code ...
    
    data = request.data
    unit_id = data.get('unit_id')  # NEW
    blok_rumah = data.get('blok_rumah')  # OLD (fallback)
    
    # Validate unit if provided
    unit = None
    if unit_id:
        try:
            unit = MUnit.objects.get(
                unit_id=unit_id,
                unit_residence_id=residence_id,
                unit_isactive=True,
                unit_isdelete=False
            )
        except MUnit.DoesNotExist:
            return Response({
                'status': 'error',
                'message': 'Unit tidak valid'
            }, status=400)
    
    # Create user
    user = MUser.objects.create(
        user_email=email,
        user_name=email,
        user_password=make_password(password),
        is_warga=(account_type == 'warga'),
        is_staff=(account_type == 'pengurus'),  # FIXED: was is_pengurus
        user_isactive=False,
        user_role=role,
        user_created_by=1
    )
    
    # Create Warga profile
    warga = Warga.objects.create(
        user=user,
        residence_id=residence_id,
        unit=unit,  # Link to unit if available
        full_name=full_name,
        phone_no=phone_no,
        blok_rumah=blok_rumah,  # Keep for backward compatibility
        is_active=False
    )
    
    # ... rest of code ...
```

**CRITICAL FIX**: Search and replace `is_pengurus` with `is_staff`:

```bash
# In Django project directory
grep -r "is_pengurus" --include="*.py"
# Manually replace all occurrences with is_staff
```

### **Step 2: Deploy Django to Tencent**

```bash
# SSH ke Tencent server (Django)
ssh root@43.156.75.206
# atau alamat server Django Anda

# Navigate ke Django project directory
cd /path/to/django/project

# Pull latest changes
git pull origin main

# Activate virtual environment
source venv/bin/activate
# atau
source env/bin/activate

# Install/update dependencies
pip install -r requirements.txt

# Run migrations (if any)
python manage.py migrate

# Collect static files
python manage.py collectstatic --noinput

# Restart Gunicorn
sudo systemctl restart gunicorn

# Restart Nginx
sudo systemctl restart nginx
```

### **Step 3: Verify Django Deployment**

```bash
# Test units endpoint
curl https://admin.pewaca.id/api/units/residence/3/

# Expected response:
# {
#   "success": true,
#   "data": [
#     {"unit_id": 1, "unit_name": "A-1"},
#     {"unit_id": 2, "unit_name": "A-2"}
#   ]
# }

# Test registration endpoint
curl -X POST https://admin.pewaca.id/api/auth/public-sign-up/ \
  -H "Content-Type: application/json" \
  -d '{
    "full_name": "Test User",
    "phone_no": "081234567890",
    "residence_id": 3,
    "unit_id": 1,
    "blok_rumah": "A-1",
    "email": "test@example.com",
    "password": "password123",
    "account_type": "warga",
    "is_warga": true,
    "is_staff": false
  }'

# Check Django logs
tail -f /path/to/django/logs/gunicorn-error.log
```

---

## 🧪 **TESTING CHECKLIST**

### **Before Django Deploy (Fallback Mode)**
- [ ] Visit https://pewaca.id/register
- [ ] Pilih residence
- [ ] Verify: Text input muncul dengan warning "Mode Manual Aktif"
- [ ] Ketik blok rumah manual (misal: A-12)
- [ ] Submit form
- [ ] Verify: Registrasi berhasil

### **After Django Deploy (Dropdown Mode)**
- [ ] Visit https://pewaca.id/register
- [ ] Pilih residence
- [ ] Verify: Dropdown muncul dengan list units
- [ ] Pilih unit dari dropdown
- [ ] Submit form
- [ ] Verify: Registrasi berhasil dengan unit_id

---

## 📊 **MONITORING**

### **Laravel Logs**
```bash
# Real-time Laravel logs
ssh root@pewaca.id
tail -f /var/www/pewaca.id/storage/logs/laravel.log

# Search for registration attempts
grep "Public registration" /var/www/pewaca.id/storage/logs/laravel.log
```

### **Django Logs**
```bash
# Real-time Django logs
ssh root@43.156.75.206
tail -f /path/to/django/logs/gunicorn-error.log

# Check units endpoint access
grep "units/residence" /var/log/nginx/access.log
```

### **Nginx Logs**
```bash
# Access logs
tail -f /var/log/nginx/access.log | grep register

# Error logs
tail -f /var/log/nginx/error.log
```

---

## 🔥 **ROLLBACK PLAN**

Jika ada masalah setelah deploy:

### **Laravel Rollback**
```bash
ssh root@pewaca.id
cd /var/www/pewaca.id

# Revert to previous commit
git log --oneline  # Find previous commit hash
git revert <commit-hash>

# Or reset to previous commit
git reset --hard <previous-commit-hash>
git push -f origin main

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Restart services
sudo systemctl restart php8.2-fpm
sudo systemctl restart nginx
```

### **Django Rollback**
```bash
ssh root@43.156.75.206
cd /path/to/django

# Revert to previous commit
git log --oneline
git revert <commit-hash>
# atau
git reset --hard <previous-commit-hash>

# Restart services
sudo systemctl restart gunicorn
sudo systemctl restart nginx
```

---

## ⚠️ **TROUBLESHOOTING**

### **Issue: Dropdown tidak muncul**
**Solution:**
- Cek Django endpoint: `curl https://admin.pewaca.id/api/units/residence/3/`
- Cek browser console untuk error AJAX
- Verify CORS settings di Django (jika ada)

### **Issue: Registrasi gagal dengan unit_id**
**Solution:**
- Cek Django logs untuk error `is_pengurus`
- Pastikan sudah replace semua `is_pengurus` dengan `is_staff`
- Verify Warga model punya field `unit` (ForeignKey to MUnit)

### **Issue: Permission denied errors**
**Solution:**
```bash
sudo chown -R www-data:www-data /var/www/pewaca.id
sudo chmod -R 755 /var/www/pewaca.id/storage
sudo chmod -R 755 /var/www/pewaca.id/bootstrap/cache
```

### **Issue: 500 Internal Server Error**
**Solution:**
```bash
# Check Laravel logs
tail -f /var/www/pewaca.id/storage/logs/laravel.log

# Check PHP-FPM logs
tail -f /var/log/php8.2-fpm.log

# Check Nginx error logs
tail -f /var/log/nginx/error.log
```

---

## ✅ **POST-DEPLOYMENT VERIFICATION**

1. **Functional Test**
   - [ ] Registration form loads
   - [ ] Residence dropdown works
   - [ ] Unit dropdown populates
   - [ ] Fallback text input works
   - [ ] Form submission succeeds
   - [ ] User data saved correctly

2. **Performance Test**
   - [ ] Page load < 3 seconds
   - [ ] AJAX call < 2 seconds
   - [ ] Form submission < 5 seconds

3. **Error Handling**
   - [ ] API failure shows fallback
   - [ ] Validation errors display correctly
   - [ ] Network errors handled gracefully

---

## 📞 **SUPPORT CONTACTS**

- **Laravel Server**: pewaca.id
- **Django API**: admin.pewaca.id (43.156.75.206)
- **Database**: MySQL at 43.156.75.206

---

## 🎯 **DEPLOYMENT SUMMARY**

| Component | Status | Action Required |
|-----------|--------|----------------|
| Laravel Frontend | ✅ Ready | Deploy to pewaca.id |
| Django Backend | 🔴 Needs Update | Add unit endpoint & fix is_staff |
| Database | ✅ Ready | No changes needed |
| Testing | ⏳ Pending | Test after deploy |

---

**Last Updated:** November 12, 2025
**Feature:** Public Registration Blok Rumah Dropdown with Graceful Degradation
**Production Ready:** ✅ YES (with backward compatibility)
