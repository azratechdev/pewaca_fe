
from rest_framework import serializers
from main.models import MResidenceCommite
from api.serializers import WargaSerializer

class MResidenceCommiteSerializer(serializers.ModelSerializer):
    warga = WargaSerializer(read_only=True)
    class Meta:
        model = MResidenceCommite
        fields = '__all__'  # Include all fields in the serializer


class MResidenceCommiteRequestSerializer(serializers.ModelSerializer):
    class Meta:
        model = MResidenceCommite
        fields = ['warga','role']  # Include all fields in the serializer