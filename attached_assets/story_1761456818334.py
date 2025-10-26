from rest_framework import serializers, viewsets
from main.models import Story, StoryReplay
from management_user.models import Warga
from django.conf import settings
import uuid
from api.utils import compress_image  # pastikan path-nya benar

from django.core.files.base import ContentFile
# Serializers

class MiniWargaSerializer(serializers.ModelSerializer):
    profile_photo = serializers.SerializerMethodField()

    class Meta:
        model = Warga
        fields = [
            'id',
            'full_name',
            'profile_photo',
        ]

    def get_profile_photo(self, obj):
        request = self.context.get('request')
        if obj.profile_photo:  # Jika ada foto profil
            # Gunakan request.build_absolute_uri untuk membuat URL absolut
            if request:
                return request.build_absolute_uri(obj.profile_photo.url)
            # Gunakan settings.BASE_URL jika request tidak ada
            return f"{settings.BASE_URL}{obj.profile_photo.url}"
        return None  # Jika tidak ada foto profil
    
class StoryDetailSerializer(serializers.ModelSerializer):
    warga =  MiniWargaSerializer()
    class Meta:
        model = Story
        fields = '__all__'
        
# Serializers
class StoryListSerializer(serializers.ModelSerializer):
    warga =  MiniWargaSerializer()
    class Meta:
        model = Story
        fields = '__all__'
        
class StorySerializer(serializers.ModelSerializer):
    class Meta:
        model = Story
        fields = ["story","image"]
        

    def create(self, validated_data):
        image = validated_data.get("image", None)

        if image and not image.name.lower().endswith(".webp"):
            compressed_image = compress_image(image)
            image_name = image.name
            validated_data["image"] = ContentFile(compressed_image.read(), name=image_name)

        return super().create(validated_data)
    
    # Optional: Validate or process the image field if needed
    # def validate_image(self, value):
    #     if value.size > 1024 * 1024 * 20:  # Example: restrict file size to 5MB
    #         raise serializers.ValidationError("Image file too large ( > 5MB ).")
    #     return value
    
class StoryUpdateSerializer(serializers.ModelSerializer):
    class Meta:
        model = Story
        fields = ["id","story","image"]
    
    # Optional: Validate or process the image field if needed
    # def validate_image(self, value):
    #     if value.size > 1024 * 1024 * 5:  # Example: restrict file size to 5MB
    #         raise serializers.ValidationError("Image file too large ( > 5MB ).")
    #     return value

class StoryReplaySerializer(serializers.ModelSerializer):
    warga =  MiniWargaSerializer()
    class Meta:
        model = StoryReplay
        fields = ["story", "replay","warga"]

class StoryReplayPostSerializer(serializers.ModelSerializer):
    class Meta:
        model = StoryReplay
        fields = ["story", "replay"]

    def create(self, validated_data):
        # Get additional data passed from the view
        warga = self.context.get('warga')
        created_by = self.context.get('created_by')

        if not warga or not created_by:
            raise serializers.ValidationError("Missing required context data for `warga` or `created_by`.")

        # Include these fields in the creation process
        validated_data['id'] = uuid.uuid4()
        validated_data['warga'] = warga
        validated_data['created_by'] = created_by

        return StoryReplay.objects.create(**validated_data)