from rest_framework import serializers
from management_user.models import  Warga,MUser

# Serializers
class UpdateProfileSerializer(serializers.Serializer):
    # MUser fields
    email = serializers.EmailField(required=False)
    username = serializers.CharField(max_length=100, required=False)
    image = serializers.ImageField(required=False)

    # Warga fields
    full_name = serializers.CharField(max_length=150, required=False)
    gender_id = serializers.ChoiceField(choices=Warga.GENDER_CHOICES, required=False)
    date_of_birth = serializers.DateField(required=False)
    place_of_birth = serializers.CharField(max_length=150, required=False)
    phone_no = serializers.CharField(max_length=15, required=False)
    marital_status_id = serializers.IntegerField(required=False)
    religion_id = serializers.IntegerField(required=False)
    occupation_id = serializers.IntegerField(required=False)
    education_id = serializers.IntegerField(required=False)
    profile_photo = serializers.ImageField(required=False)
    
    class Meta:
        model = MUser
        fields = "__all__"
