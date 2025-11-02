from rest_framework import serializers
from main.models import City, District, MProvince, MVillage
from main.models import MResidence
from django.conf import settings


class CitySerializer(serializers.ModelSerializer):
    class Meta:
        model = City
        fields = ['id', 'province_id', 'name']

class DistrictSerializer(serializers.ModelSerializer):
    class Meta:
        model = District
        fields = ['id', 'city_id', 'name']

class MProvinceSerializer(serializers.ModelSerializer):
    class Meta:
        model = MProvince
        fields = ['id', 'code', 'name']

class MVillageSerializer(serializers.ModelSerializer):
    class Meta:
        model = MVillage
        fields = ['id', 'district_id', 'name', 'postal_code']



class MResidenceSerializer(serializers.ModelSerializer):
    prov_id = MProvinceSerializer()
    city_id = CitySerializer()
    district_id = DistrictSerializer()
    village_id = MVillageSerializer()
    image = serializers.SerializerMethodField()

    class Meta:
        model = MResidence
        fields = [
            'id', 'name', 'code', 'loc_address', 'image', 
            'prov_id',
            'city_id', 
            'district_id', 
            'village_id',
            'postal_code', 'lat', 'long', 'area_large', 
            'establishment_year', 'isactive', 'isdelete'
        ]
    
    # Optional: Validate or process the image field if needed
    def validate_image(self, value):
        if value.size > 1024 * 1024 * 5:  # Example: restrict file size to 5MB
            raise serializers.ValidationError("Image file too large ( > 5MB ).")
        return value
    
    def get_image(self, obj):
        request = self.context.get('request')
        if obj.image:  # Jika ada foto profil
            # Gunakan request.build_absolute_uri untuk membuat URL absolut
            if request:
                return request.build_absolute_uri(obj.image.url)
            # Gunakan settings.BASE_URL jika request tidak ada
            return f"{settings.BASE_URL}{obj.image.url}"
        return None  # Jika tidak ada foto profil


class MResidenceAdminSerializer(serializers.ModelSerializer):

    image = serializers.SerializerMethodField()
    class Meta:
        model = MResidence
        fields = [
            'id', 'name', 'code', 'loc_address', 'image', 
            'prov_id',
            'city_id', 
            'district_id', 
            'village_id',
            'postal_code', 'lat', 'long', 'area_large', 
            'establishment_year', 'isactive', 'isdelete'
        ]
        
    def get_image(self, obj):
        request = self.context.get('request')
        if obj.image:  # Jika ada foto profil
            # Gunakan request.build_absolute_uri untuk membuat URL absolut
            if request:
                return request.build_absolute_uri(obj.image.url)
            # Gunakan settings.BASE_URL jika request tidak ada
            return f"{settings.BASE_URL}{obj.image.url}"
        return None  # Jika tidak ada foto profil
    
    # Optional: Validate or process the image field if needed
    def validate_image(self, value):
        if value.size > 1024 * 1024 * 5:  # Example: restrict file size to 5MB
            raise serializers.ValidationError("Image file too large ( > 5MB ).")
        return value
