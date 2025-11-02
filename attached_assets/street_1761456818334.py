from rest_framework import serializers
from main.models import MStreet

class MStreetSerializer(serializers.ModelSerializer):
    class Meta:
        model = MStreet
        fields = ['id',  'name']
