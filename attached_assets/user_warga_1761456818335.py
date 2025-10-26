from rest_framework import serializers
from main.models import   MResidenceCommite
from management_user.models import MUser,MRoleWarga

class MRoleWargaSerializer(serializers.ModelSerializer):
    class Meta:
        model = MRoleWarga
        fields = ['id','name', 'desc']

class ResidenceCommiteSerializer(serializers.ModelSerializer):
    role = MRoleWargaSerializer()
    class Meta:
        model = MResidenceCommite
        fields = ['residence', 'role', 'user', 'warga']

class UserSerializer(serializers.ModelSerializer):
    residence_commites = ResidenceCommiteSerializer(many=True, source='user_commites')
    class Meta:
        model = MUser
        fields = "__all__"

class UserSimpleSerializer(serializers.ModelSerializer):
    class Meta:
        model = MUser
        fields = [
            'user_id', 'email', 'username', 
            'is_active'
        ]

class UserProfileSerializer(serializers.ModelSerializer):
    residence_commites = ResidenceCommiteSerializer(many=True, source='user_commites')
    is_pengurus = serializers.SerializerMethodField()

    class Meta:
        model = MUser
        fields = [
            'user_id', 'email', 'username', 
            'is_active', 'residence_commites', 'is_pengurus'
        ]

    def get_is_pengurus(self, obj):
        return obj.user_commites.all().exists()
    
    def update(self, instance, validated_data):
        warga_data = validated_data.pop('warga', None)
        residence_commites_data = validated_data.pop('residence_commites', None)

        # Update user fields
        for attr, value in validated_data.items():
            setattr(instance, attr, value)
        instance.save()

        if warga_data:
            warga_instance = instance.warga.first()  
            for attr, value in warga_data.items():
                setattr(warga_instance, attr, value)
            warga_instance.save()
        
        if residence_commites_data:
            for commite_data in residence_commites_data:
                MResidenceCommite.objects.update_or_create(
                    user=instance,
                    defaults=commite_data
                )
        
        return instance
