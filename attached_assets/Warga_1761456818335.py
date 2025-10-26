# api/serializers.py

from rest_framework import serializers
from management_user.models import Warga,MfamilyAs
from main.models import MaritalStatus,MReligion,MUnit,BankList,MEducation,MOccupation,MCorridor
from api.serializers.user_warga import UserSimpleSerializer,ResidenceCommiteSerializer
from django.conf import settings


class MfamilyAsSerializer(serializers.ModelSerializer):
    class Meta:
        model = MfamilyAs
        fields = '__all__'
class MOccupationSerializer(serializers.ModelSerializer):
    class Meta:
        model = MOccupation
        fields = '__all__'
class MOccupationSimpleSerializer(serializers.ModelSerializer):
    class Meta:
        model = MOccupation
        fields = ['id','code', 'name']
class MEducationListSerializer(serializers.ModelSerializer):
    class Meta:
        model = MEducation
        fields = '__all__'
class MEducationSimpleSerializer(serializers.ModelSerializer):
    class Meta:
        model = MEducation
        fields = ['id','code', 'name']
class BankListSerializer(serializers.ModelSerializer):
    class Meta:
        model = BankList
        fields = '__all__'
class MaritalStatusSerializer(serializers.ModelSerializer):
    class Meta:
        model = MaritalStatus
        fields = ['id', 'name']
class MReligionSerializer(serializers.ModelSerializer):
    class Meta:
        model = MReligion
        fields = ['id', 'name']
class MfamilyAsSerializer(serializers.ModelSerializer):
    class Meta:
        model = MfamilyAs
        fields = ['id', 'name']

class MUnitCreateSerializer(serializers.ModelSerializer):
    class Meta:
        model = MUnit
        fields = '__all__'

class MUnitSmallSerializer(serializers.ModelSerializer):
    class Meta:
        model = MUnit
        fields = ['unit_id', 'unit_name', 'unit_size']

class MUnitSerializer(serializers.ModelSerializer):
    unit_residence_name = serializers.StringRelatedField(
        read_only=True,
        source='unit_residence'
    )
    unit_corridor_name = serializers.StringRelatedField(
        read_only=True,
        source='unit_corridor'
    )
    unit_image = serializers.ImageField(
        max_length=None, 
        use_url=True, 
        required=False
    )
    unit_image = serializers.SerializerMethodField()
    
    class Meta:
        model = MUnit
        fields = ['unit_id', 'unit_name', 'unit_image', 'unit_size', 'unit_corridor', 'unit_corridor_name', 'unit_residence_name']

    def get_unit_image(self, obj):
        request = self.context.get('request')
        if obj.unit_image:  # Jika ada foto profil
            # Gunakan request.build_absolute_uri untuk membuat URL absolut
            if request:
                return request.build_absolute_uri(obj.unit_image.url)
            # Gunakan settings.BASE_URL jika request tidak ada
            return f"{settings.BASE_URL}{obj.unit_image.url}"
        return None  # Jika tidak ada foto profil
    
class WargaSerializer(serializers.ModelSerializer):
    marital_status = MaritalStatusSerializer()
    religion = MReligionSerializer()
    unit_id = MUnitSerializer()
    gender_id = serializers.ChoiceField(choices=Warga.GENDER_CHOICES)
    gender = serializers.SerializerMethodField()
    family_as = MfamilyAsSerializer()
    occupation = MOccupationSimpleSerializer()
    education = MEducationSimpleSerializer()
    marriagePhoto = serializers.SerializerMethodField()
    profile_photo = serializers.SerializerMethodField()
    user = UserSimpleSerializer()
    # residence_commites = ResidenceCommiteSerializer(many=True, source='user_commites')
    residence_commites = serializers.SerializerMethodField()
    class Meta:
        model = Warga
        fields = ['id',  "user",'nik', 'full_name', 'gender_id','gender', 'marital_status', 'religion', 
                  'phone_no', 'unit_id',  'family_as','is_lead', 'is_checker', 'isreject',
                  'education','occupation','marriagePhoto','profile_photo','date_of_birth','residence_commites',
                  'place_of_birth','checked_on','created_on']
        read_only_fields = ['id',]  # Adjust as needed
    
    def get_residence_commites(self, obj):
        # Get all commites for this user and serialize them
        commites = obj.user.user_commites.all()
        return ResidenceCommiteSerializer(commites, many=True, context=self.context).data


    def get_gender(self, obj):
        gender_display = dict(Warga.GENDER_CHOICES).get(obj.gender_id, "-")
        return gender_display
    
    
    def get_marriagePhoto(self, obj):
        request = self.context.get('request')
        if obj.marriagePhoto:  
            if request:
                return request.build_absolute_uri(obj.marriagePhoto.url)
            return f"{settings.BASE_URL}{obj.marriagePhoto.url}"
        return None  
    
    def get_profile_photo(self, obj):
        if obj.profile_photo:  
            # Check if using Tencent COS (URL already includes full domain)
            if hasattr(obj.profile_photo, 'url'):
                url = obj.profile_photo.url
                # If URL already starts with http/https, return as is (for COS)
                if url.startswith(('http://', 'https://')):
                    return url
                # Otherwise, build absolute URI for local storage
                request = self.context.get('request')
                if request:
                    return request.build_absolute_uri(url)
                return f"{settings.BASE_URL}{url}"
        return None  

    
class WargaSimpleSerializer(serializers.ModelSerializer):
    profile_photo = serializers.SerializerMethodField()
    class Meta:
        model = Warga
        fields = '__all__'
        read_only_fields = ['id',]  # Adjust as needed

    def get_profile_photo(self, obj):
        if obj.profile_photo:  # Jika ada foto profil
            # Check if using Tencent COS (URL already includes full domain)
            if hasattr(obj.profile_photo, 'url'):
                url = obj.profile_photo.url
                # If URL already starts with http/https, return as is (for COS)
                if url.startswith(('http://', 'https://')):
                    return url
                # Otherwise, build absolute URI for local storage
                request = self.context.get('request')
                if request:
                    return request.build_absolute_uri(url)
                return f"{settings.BASE_URL}{url}"
        return None  # Jika tidak ada foto profil
    
class WargaSmallSerializer(serializers.ModelSerializer):
    class Meta:
        model = Warga
        fields = ['id', 'full_name', 'nik','profile_photo']
        read_only_fields = ['id',]  # Adjust as needed

class WargaCreateSerializer(serializers.ModelSerializer):
    class Meta:
        model = Warga
        fields = ['full_name', ]  # Exclude 'created_by' here

class MCorridoSerializer(serializers.ModelSerializer):
    class Meta:
        model = MCorridor
        # fields = '__all__'
        fields = ['id', 'corridor_name', 'corridor_icon', 'corridor_desc']

class MCorridorCreateSerializer(serializers.ModelSerializer):
    class Meta:
        model = MCorridor
        fields = '__all__'


class WargaProfileSerializer(serializers.ModelSerializer):
    is_checker = serializers.BooleanField(
        read_only=True,
    )
    profile_photo = serializers.SerializerMethodField()
    religion = MReligionSerializer( read_only=True)
    unit_id = MUnitSerializer( read_only=True)
    family_as = MfamilyAsSerializer(read_only=True)
    education = MEducationListSerializer(read_only=True)
    marital_status = MaritalStatusSerializer(read_only=True)
    occupation = MOccupationSerializer(read_only=True)
    gender_id = serializers.ChoiceField(choices=Warga.GENDER_CHOICES)
    marriagePhoto = serializers.SerializerMethodField()

    class Meta:
        model = Warga
        fields = ['id',
            'nik', 'full_name', 'gender_id', 'date_of_birth', 'place_of_birth', 
            'marital_status', 'religion', 'phone_no', 'residence', 'unit_id', 
            'occupation', 'education', 'profile_photo', 'is_checker', 
            'family_as', 'is_lead', 'marriagePhoto'
        ]
    def get_profile_photo(self, obj):
        if obj.profile_photo:  # Jika ada foto profil
            # Check if using Tencent COS (URL already includes full domain)
            if hasattr(obj.profile_photo, 'url'):
                url = obj.profile_photo.url
                # If URL already starts with http/https, return as is (for COS)
                if url.startswith(('http://', 'https://')):
                    return url
                # Otherwise, build absolute URI for local storage
                request = self.context.get('request')
                if request:
                    return request.build_absolute_uri(url)
                return f"{settings.BASE_URL}{url}"
        return None  # Jika tidak ada foto profil

    def get_marriagePhoto(self, obj):
        request = self.context.get('request')
        if obj.marriagePhoto:  # Jika ada foto profil
            # Gunakan request.build_absolute_uri untuk membuat URL absolut
            if request:
                return request.build_absolute_uri(obj.marriagePhoto.url)
            # Gunakan settings.BASE_URL jika request tidak ada
            return f"{settings.BASE_URL}{obj.marriagePhoto.url}"
        return None  # Jika tidak ada foto profil

# This serializer is used for the family list in the profile, and unit data, so unit first then multiple warga
class WargaProfileFamilySerializer(serializers.ModelSerializer):
    unit_id = MUnitSerializer(read_only=True)
    family_members = serializers.SerializerMethodField()
    
    class Meta:
        model = Warga
        fields = ['unit_id', 'family_members']
    
    def get_family_members(self, obj):
        family_members = Warga.objects.filter(unit_id=obj.unit_id)
        return WargaSimpleSerializer(family_members, many=True).data
