from rest_framework import serializers
from main.models import MUnit

# class MUnitSerializer(serializers.ModelSerializer):
#     class Meta:
#         model = MUnit
#         fields = ['unit_id','unit_name','unit_corridor','unit_name','unit_desc','unit_image','unit_size','unit_isused']

class MUnitAdminSerializer(serializers.ModelSerializer):
    class Meta:
        model = MUnit
        fields = ['unit_id','unit_name','unit_corridor','unit_name','unit_desc','unit_image','unit_size','unit_isused']
