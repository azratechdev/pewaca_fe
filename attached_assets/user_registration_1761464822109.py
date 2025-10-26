from rest_framework import serializers
from django.contrib.auth import get_user_model
from management_user.models import Warga,MaritalStatus,Role,MfamilyAs
from main.models import MResidence,MReligion,MUnit,MOccupation,MEducation
from django.shortcuts import get_object_or_404
from django.db import transaction, IntegrityError
from django.contrib.auth.hashers import make_password

User = get_user_model()

class UserRegistrationSerializer(serializers.ModelSerializer):
    unit_id = serializers.ListField(child=serializers.IntegerField(), required=True)
    nik = serializers.ListField(child=serializers.CharField(), required=True)
    full_name = serializers.ListField(child=serializers.CharField(), required=True)
    phone_no = serializers.ListField(child=serializers.CharField(), required=True)
    gender_id = serializers.ListField(child=serializers.IntegerField(), required=True)
    date_of_birth = serializers.ListField(child=serializers.DateField(), required=True)
    religion = serializers.ListField(child=serializers.CharField(), required=True)
    place_of_birth = serializers.ListField(child=serializers.CharField(), required=True)
    marital_status = serializers.ListField(child=serializers.CharField(), required=True)
    occupation = serializers.ListField(child=serializers.CharField(), required=True)
    education = serializers.ListField(child=serializers.CharField(), required=True)
    profile_photo = serializers.ListField(child=serializers.ImageField(required=False), required=False)
    email = serializers.EmailField(required=True)
    password = serializers.CharField(write_only=True)
    family_as = serializers.ListField(child=serializers.IntegerField(), required=True)

    class Meta:
        model = User
        fields = [
            'email', 'password',
            'unit_id', 'nik', 'full_name', 'phone_no', 'gender_id',
            'date_of_birth', 'religion', 'place_of_birth', 'marital_status',
            'occupation', 'education', 'profile_photo','family_as'
        ]

    def validate_email(self, value):
        """Check if the email already exists."""
        if User.objects.filter(email=value).exists():
            raise serializers.ValidationError("An account with this email already exists.")
        return value
    
    def create(self, validated_data):
        try:
            code = self.context.get('code')
            print(f"[DEBUG] Code: {code}")
            print(f"[DEBUG] Validated data keys: {validated_data.keys()}")

            warga_fields = [
                'unit_id', 'nik', 'full_name', 'phone_no', 'gender_id',
                'date_of_birth', 'religion', 'place_of_birth', 'marital_status',
                'occupation', 'education',  'family_as'
            ]
            warga_data = {field: validated_data.pop(field) for field in warga_fields}

            try:
                with transaction.atomic():
                    user = User.objects.create_user(
                        email=validated_data['email'],
                        username=validated_data['email'],
                        password=validated_data['password'],
                        is_warga=1,
                        is_active=0,
                        role=Role.objects.filter(role_id=5).first()
                    )

                    residence = get_object_or_404(MResidence, code=code)

                    unit_ids = warga_data.get('unit_id', [])
                    religion_ids = warga_data.get('religion', [])
                    
                    marital_status_ids = warga_data.get('marital_status', [])
                    occupation_ids = warga_data.get('occupation', [])
                    education_ids = warga_data.get('education', [])
                    family_as_id = warga_data.get('family_as', [])
                    

                    units = MUnit.objects.filter(unit_id__in=unit_ids)
                    unit_dict = {unit.unit_id: unit for unit in units}

                    religions = MReligion.objects.filter(id__in=religion_ids)
                    religion_dict = {religion.id: religion for religion in religions}

                    marital_statuses = MaritalStatus.objects.filter(id__in=marital_status_ids)
                    marital_status_dict = {marital_status.id: marital_status for marital_status in marital_statuses}

                    occupations = MOccupation.objects.filter(id__in=occupation_ids)
                    occupation_dict = {occupation.id: occupation for occupation in occupations}

                    educations = MEducation.objects.filter(id__in=education_ids)
                    education_dict = {education.id: education for education in educations}

                    familyAss = MfamilyAs.objects.filter(id__in=family_as_id)
                    familyAs_dict = {familyAs.id: familyAs for familyAs in familyAss}
                    # Ensure that warga_data['nik'] is indeed a list
                    nik_list = warga_data.get('nik', [])
                    full_name_list = warga_data.get('full_name', [])
                    phone_no_list = warga_data.get('phone_no', [])
                    gender_id_list = warga_data.get('gender_id', [])
                    date_of_birth_list = warga_data.get('date_of_birth', [])
                    place_of_birth_list = warga_data.get('place_of_birth', [])
                    profile_photo_list = warga_data.get('profile_photo', [None] * len(nik_list))  # Default to None if not provided
                    if profile_photo_list is None:
                        profile_photo_list = [None] * len(nik_list)

                    if isinstance(nik_list, list):
                        for i in range(len(nik_list)):
                            Warga.objects.create(
                                user=user,
                                residence=residence,
                                unit_id=unit_dict.get(int(warga_data['unit_id'][i])),
                                nik=nik_list[i],
                                full_name=full_name_list[i],
                                phone_no=phone_no_list[i],
                                gender_id=gender_id_list[i],
                                date_of_birth=date_of_birth_list[i],
                                religion=religion_dict.get(int(religion_ids[i])),
                                place_of_birth=place_of_birth_list[i],
                                marital_status=marital_status_dict.get(int(marital_status_ids[i])),
                                occupation=occupation_dict.get(int(occupation_ids[i])),
                                education=education_dict.get(int(education_ids[i])),
                                profile_photo=profile_photo_list[i],
                                family_as=familyAs_dict.get(int(family_as_id[i])),
                                created_by=user.id
                            )
                    else:
                        # Handling the case where nik is not a list
                        Warga.objects.create(
                            user=user,
                            residence=residence,
                            unit_id=unit_dict.get(int(warga_data['unit_id'])),
                            nik=warga_data['nik'],
                            full_name=warga_data['full_name'],
                            phone_no=warga_data['phone_no'],
                            gender_id=warga_data['gender_id'],
                            date_of_birth=warga_data['date_of_birth'],
                            religion=religion_dict.get(int(warga_data['religion'])),
                            place_of_birth=warga_data['place_of_birth'],
                            marital_status=marital_status_dict.get(int(warga_data['marital_status'])),
                            occupation=occupation_dict.get(int(warga_data['occupation'])),
                            education=education_dict.get(int(warga_data['education'])),
                            profile_photo=warga_data['profile_photo'] if warga_data.get('profile_photo') else None,
                            created_by=user.id
                        )

                    return user

            except IntegrityError as e:
                raise serializers.ValidationError(f"Database error occurred: {str(e)}")
            except Exception as e:
                raise serializers.ValidationError(f"An error occurred during registration: {str(e)}")
        except Exception as e:
            print(f"[ERROR] CAUGHT EXCEPTION: {type(e).__name__}")
            print(f"[ERROR] Message: {str(e)}")
            import traceback
            traceback.print_exc()
            raise serializers.ValidationError(f"Registration failed: {str(e)}")



    

class UserUpdateSerializer(serializers.ModelSerializer):
    unit_id = serializers.IntegerField(required=True)
    nik = serializers.CharField(required=True)
    full_name = serializers.CharField(required=True)
    phone_no = serializers.CharField(required=True)
    gender_id = serializers.IntegerField(required=True)
    date_of_birth = serializers.DateField(format='%Y-%m-%d', input_formats=['%Y-%m-%d', 'iso-8601'], required=True)
    religion = serializers.IntegerField(required=True)
    place_of_birth = serializers.CharField(required=True)
    marital_status = serializers.IntegerField(required=True)
    occupation = serializers.IntegerField(required=True)
    education = serializers.IntegerField(required=True)
    profile_photo = serializers.ImageField(required=False, allow_null=True)
    marriagePhoto = serializers.ImageField(required=False, allow_null=True)
    email = serializers.EmailField(required=True)
    password = serializers.CharField(write_only=True)
    family_as = serializers.IntegerField(required=True)

    class Meta:
        model = User
        fields = [
            'email', 'password', 'unit_id', 'nik', 'full_name', 'phone_no', 'gender_id',
            'date_of_birth', 'religion', 'place_of_birth', 'marital_status',
            'occupation', 'education', 'profile_photo', 'family_as','marriagePhoto'
        ]

    # def validate_email(self, value):
    #     """Check if the email already exists."""
    #     print("self")
    #     print(self)
    #     if User.objects.filter(email=value).exists():
    #         raise serializers.ValidationError("An account with this email already exists.")
    #     return value

    def create(self, validated_data):
        """Create a User and a single Warga entry."""
        code = self.context.get('code')  # Mengambil kode perumahan dari konteks

        try:
            with transaction.atomic():
                user, created = User.objects.update_or_create(
                    email=validated_data['email'],
                    defaults={
                        'username': validated_data['email'],
                        'password': make_password(validated_data['password']),  # Hash password
                        'role': Role.objects.filter(role_id=5).first(),
                    }
                )

                residence = get_object_or_404(MResidence, code=code)

                # Mengambil objek referensi dari model lain
                unit = get_object_or_404(MUnit, unit_id=validated_data['unit_id'])
                religion = get_object_or_404(MReligion, id=validated_data['religion'])
                marital_status = get_object_or_404(MaritalStatus, id=validated_data['marital_status'])
                occupation = get_object_or_404(MOccupation, id=validated_data['occupation'])
                education = get_object_or_404(MEducation, id=validated_data['education'])
                family_as = get_object_or_404(MfamilyAs, id=validated_data['family_as'])

                # Simpan data warga
                Warga.objects.create(
                    user=user,
                    residence=residence,
                    unit=unit,
                    nik=validated_data['nik'],
                    full_name=validated_data['full_name'],
                    phone_no=validated_data['phone_no'],
                    gender_id=validated_data['gender_id'],
                    date_of_birth=validated_data['date_of_birth'],
                    religion=religion,
                    place_of_birth=validated_data['place_of_birth'],
                    marital_status=marital_status,
                    occupation=occupation,
                    education=education,
                    profile_photo=validated_data.get('profile_photo', None),
                    family_as=family_as,
                    created_by=user.id
                )

                return user

        except IntegrityError as e:
            raise serializers.ValidationError(f"Database error occurred: {str(e)}")
        except Exception as e:
            raise serializers.ValidationError(f"An error occurred during registration: {str(e)}")
        
class UserRegistrationSingleSerializer(serializers.ModelSerializer):
    unit_id = serializers.IntegerField(required=True)
    nik = serializers.CharField(required=False)
    full_name = serializers.CharField(required=True)
    phone_no = serializers.CharField(required=True)
    gender_id = serializers.IntegerField(required=True)
    date_of_birth = serializers.DateField(required=True)
    religion = serializers.IntegerField(required=True)
    place_of_birth = serializers.CharField(required=True)
    marital_status = serializers.IntegerField(required=True)
    occupation = serializers.IntegerField(required=True)
    education = serializers.IntegerField(required=True)
    profile_photo = serializers.ImageField(required=False, allow_null=True)
    marriage_photo = serializers.ImageField( required=False,allow_null=True)
    email = serializers.EmailField(required=True)
    password = serializers.CharField(write_only=True)
    family_as = serializers.IntegerField(required=True)

    class Meta:
        model = User
        fields = [
            'email', 'password', 'unit_id', 'nik', 'full_name', 'phone_no',
            'gender_id', 'date_of_birth', 'religion', 'place_of_birth',
            'marital_status', 'occupation', 'education', 'profile_photo', 'family_as','marriage_photo'
        ]

    def validate_email(self, value):
        """Check if the email already exists."""
        if User.objects.filter(email=value).exists():
            raise serializers.ValidationError("Email sudah terdaftar.")
        return value

    def create(self, validated_data):
        """Create a User and a corresponding Warga record."""
        code = self.context.get('code')
        
        try:
            with transaction.atomic():
                user = User.objects.create_user(
                    email=validated_data['email'],
                    username=validated_data['email'],
                    password=validated_data['password'],
                    is_warga=1,
                    is_active=0,
                    role=Role.objects.filter(role_id=5).first()
                )
                if not user.user_id:
                    user.user_id = user.id
                    user.save(update_fields=['user_id'])

                residence = get_object_or_404(MResidence, code=code)

                # Ambil objek referensi berdasarkan ID
                unit = get_object_or_404(MUnit, unit_id=validated_data['unit_id'])
                religion = get_object_or_404(MReligion, id=validated_data['religion'])
                marital_status = get_object_or_404(MaritalStatus, id=validated_data['marital_status'])
                occupation = get_object_or_404(MOccupation, id=validated_data['occupation'])
                education = get_object_or_404(MEducation, id=validated_data['education'])
                family_as = get_object_or_404(MfamilyAs, id=validated_data['family_as'])

                # Buat Warga terkait dengan user
                Warga.objects.create(
                    user=user,
                    residence=residence,
                    unit_id=unit,
                    nik=validated_data.get('nik'),
                    full_name=validated_data['full_name'],
                    phone_no=validated_data['phone_no'],
                    gender_id=validated_data['gender_id'],
                    date_of_birth=validated_data['date_of_birth'],
                    religion=religion,
                    place_of_birth=validated_data['place_of_birth'],
                    marital_status=marital_status,
                    occupation=occupation,
                    education=education,
                    profile_photo=validated_data.get('profile_photo'),
                    family_as=family_as,
                    created_by=user.id,
                    marriagePhoto=validated_data.get('marriage_photo')
                )

                return user

        except IntegrityError as e:
            raise serializers.ValidationError(f"Terjadi kesalahan database: {str(e)}")
        except Exception as e:
            raise serializers.ValidationError(f"Terjadi kesalahan saat registrasi: {str(e)}")