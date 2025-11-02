# api/serializers.py

from rest_framework import serializers
from main.models import MResidenceBank
from api.serializers import BankListSerializer

class MResidenceBankSerializer(serializers.ModelSerializer):
    class Meta:
        model = MResidenceBank
        fields = '__all__'

class GetMResidenceBankSerializer(serializers.ModelSerializer):
    bank = BankListSerializer(read_only=True)
    class Meta:
        model = MResidenceBank
        fields = '__all__'