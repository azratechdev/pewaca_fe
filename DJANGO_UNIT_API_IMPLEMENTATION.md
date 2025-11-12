# Django Unit API Implementation Guide

## ✅ Laravel Side - SUDAH SELESAI!

Laravel sudah diupdate untuk menggunakan dropdown Blok Rumah dari API.

---

## 📋 Django Side - YANG PERLU DITAMBAHKAN

Berikut adalah code yang perlu Anda tambahkan ke Django backend:

### 1. Create Serializer untuk Unit Dropdown

**File:** `dash/api/serializers/MUnit.py` (atau tambahkan ke file serializer yang sudah ada)

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

**IMPORTANT:** Tambahkan import di `dash/api/serializers/__init__.py`:

```python
from .MUnit import MUnitPublicSerializer

__all__ = [
    # ... existing exports ...
    'MUnitPublicSerializer',
]
```

---

### 2. Add Endpoint ke Unit ViewSet

**File:** `dash/api/views/unit.py`

Tambahkan method ini ke class `MUnitViewSet`:

```python
from rest_framework.decorators import action
from rest_framework.permissions import AllowAny
from api.serializers.MUnit import MUnitPublicSerializer  # Import serializer baru

class MUnitViewSet(...):
    # ... existing code ...
    
    @action(detail=False, methods=['get'], url_path=r'residence/(?P<residence_id>[^/.]+)', permission_classes=[AllowAny])
    def residence_units(self, request, residence_id=None):
        """
        Public endpoint to get available units by residence_id
        URL: /api/units/residence/{residence_id}/
        Used by public registration form
        """
        try:
            # Filter units by residence_id
            units = MUnit.objects.filter(
                unit_residence_id=residence_id,
                unit_isactive=True,
                unit_isdelete=False
            ).order_by('unit_name')
            
            if not units.exists():
                return custom_response(
                    data=[],
                    message="Tidak ada unit tersedia untuk residence ini",
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

---

### 3. Update URL Configuration

**File:** `dash/api/urls.py`

Pastikan URL pattern untuk MUnitViewSet sudah include router default actions.
Jika sudah ada, tidak perlu perubahan karena `@action` decorator otomatis register URL.

```python
from rest_framework.routers import DefaultRouter
from api.views import MUnitViewSet

router = DefaultRouter()
router.register(r'units', MUnitViewSet, basename='unit')

urlpatterns = [
    # ... existing patterns ...
]

urlpatterns += router.urls
```

---

### 4. Update Django Public Sign Up Endpoint

**File:** File yang punya function `public_sign_up` (kemungkinan di `dash/api/views/__init__.py` atau `auth.py`)

Update untuk handle `unit_id` dan **hapus reference ke `is_pengurus`**:

```python
def public_sign_up(request):
    # ... existing code ...
    
    data = request.data
    email = data.get('email')
    password = data.get('password')
    full_name = data.get('full_name')
    phone_no = data.get('phone_no')
    residence_id = data.get('residence_id')
    unit_id = data.get('unit_id')  # ← TAMBAH INI
    account_type = data.get('account_type')
    
    # Validate unit exists
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
            'message': 'Unit tidak valid atau tidak tersedia'
        }, status=400)
    
    # Create user
    try:
        # Get role based on account type
        if account_type == 'warga':
            role = MRole.objects.get(role_name='warga')
        else:
            role = MRole.objects.get(role_name='pengurus')
        
        # Create user account
        user = MUser.objects.create(
            user_email=email,
            user_name=email,
            user_password=make_password(password),
            is_warga=(account_type == 'warga'),
            is_staff=(account_type == 'pengurus'),  # ← GANTI dari is_pengurus ke is_staff
            user_isactive=False,  # Inactive until activated
            user_role=role,
            user_created_by=1,
            user_created_on=timezone.now()
        )
        
        # Create Warga profile
        warga = Warga.objects.create(
            user=user,
            residence_id=residence_id,
            unit=unit,  # ← Link to unit
            full_name=full_name,
            phone_no=phone_no,
            is_active=False
        )
        
        return Response({
            'status': 'success',
            'message': 'Registrasi berhasil! Akun Anda akan diaktivasi setelah diverifikasi oleh admin.',
            'data': {
                'user_id': user.user_id,
                'email': user.user_email,
                'full_name': full_name
            }
        }, status=201)
        
    except Exception as e:
        return Response({
            'status': 'error',
            'message': f'Terjadi kesalahan saat registrasi: {str(e)}'
        }, status=500)
```

---

## 🧪 Testing Checklist

Setelah deploy Django, test dengan curl:

### Test 1: Get Units by Residence

```bash
curl -X GET "https://admin.pewaca.id/api/units/residence/3/" \
  -H "Accept: application/json"
```

**Expected Success Response:**
```json
{
  "success": true,
  "data": [
    {"unit_id": 1, "unit_name": "A-1"},
    {"unit_id": 2, "unit_name": "A-2"},
    {"unit_id": 3, "unit_name": "A-3"}
  ],
  "message": "Success"
}
```

### Test 2: Registration with Unit ID

```bash
curl -X POST "https://admin.pewaca.id/api/auth/public-sign-up/" \
  -H "Content-Type: application/json" \
  -d '{
    "full_name": "Test User",
    "phone_no": "081234567890",
    "residence_id": 3,
    "unit_id": 1,
    "email": "test@example.com",
    "password": "password123",
    "account_type": "warga",
    "is_warga": true,
    "is_staff": false
  }'
```

**Expected Success Response:**
```json
{
  "status": "success",
  "message": "Registrasi berhasil! Akun Anda akan diaktivasi setelah diverifikasi oleh admin.",
  "data": {
    "user_id": 123,
    "email": "test@example.com",
    "full_name": "Test User"
  }
}
```

---

## 🚀 Deployment Steps

1. **Update Django Code:**
   ```bash
   cd /path/to/django/project
   # Add the code snippets above
   git add .
   git commit -m "Add unit dropdown API for public registration"
   git push origin main
   ```

2. **Deploy to Server:**
   ```bash
   ssh user@pewaca.id
   cd /path/to/django
   git pull
   source venv/bin/activate
   pip install -r requirements.txt  # If any new dependencies
   python manage.py migrate  # If any migrations
   sudo systemctl restart gunicorn
   sudo systemctl restart nginx
   ```

3. **Test API:**
   ```bash
   # Test units endpoint
   curl https://admin.pewaca.id/api/units/residence/3/
   
   # Test registration
   curl -X POST https://admin.pewaca.id/api/auth/public-sign-up/ \
     -H "Content-Type: application/json" \
     -d '{"full_name":"Test","phone_no":"081234567890","residence_id":3,"unit_id":1,"email":"test@test.com","password":"pass123","account_type":"warga","is_warga":true,"is_staff":false}'
   ```

---

## ⚠️ CRITICAL FIXES

### **FIX #1: Change `is_pengurus` to `is_staff`**

The `m_user` table has:
- ✅ `is_staff` tinyint(1)
- ✅ `is_warga` tinyint(1)
- ❌ NO `is_pengurus` field!

**Search your Django code for `is_pengurus` and replace with `is_staff`:**

```bash
cd /path/to/django
grep -r "is_pengurus" --include="*.py"
# Replace all occurrences with is_staff
```

---

## 📝 Summary

**Laravel Changes (DONE ✅):**
- ✅ Form menggunakan dropdown `unit_id` dengan AJAX loading
- ✅ Controller validate `unit_id` dan kirim ke Django API
- ✅ Error handling untuk API failures

**Django Changes (TODO - ADD THESE):**
- 🔴 Create `MUnitPublicSerializer`
- 🔴 Add `residence_units` endpoint to `MUnitViewSet`
- 🔴 Update `public_sign_up` to handle `unit_id`
- 🔴 **CRITICAL:** Replace `is_pengurus` with `is_staff`

---

## 🎯 Next Steps

1. Add Django code snippets di atas
2. Deploy Django ke server
3. Test API endpoints dengan curl
4. Test registration flow dari Laravel form

Setelah Django updated, registrasi dengan dropdown Blok Rumah akan langsung jalan! 🚀
