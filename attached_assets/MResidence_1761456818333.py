# api/serializers.py

from rest_framework import serializers
from main.models import MResidence

class MResidenceCreateSerializer(serializers.ModelSerializer):
    class Meta:
        model = MResidence
        fields = ['name','loc_address','image','lat',
                  'long','area_large','establishment_year']