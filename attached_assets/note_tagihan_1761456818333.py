from rest_framework import serializers
from tagihan.models import TagihanWarga, NoteTagihan, ImageNoteWarga,TagihanUnpublishNote
from main.models import MResidenceCommite
from django.conf import settings

class ImageNoteWargaSerializer(serializers.ModelSerializer):
    image = serializers.SerializerMethodField()
    class Meta:
        model = ImageNoteWarga
        fields = '__all__'

    def get_image(self, obj):
        request = self.context.get('request')
        if obj.image:  
            if request:
                return request.build_absolute_uri(obj.image.url)
            return f"{settings.BASE_URL}{obj.image.url}"
        return None  
    
class NoteSerializer(serializers.ModelSerializer):
    images = ImageNoteWargaSerializer(many=True, read_only=True)
    is_pengurus = serializers.SerializerMethodField()
    warga = serializers.SerializerMethodField()

    class Meta:
        model = NoteTagihan
        fields = '__all__'

    def get_is_pengurus(self, obj):
        return MResidenceCommite.objects.filter(warga=obj.warga).exists()
    
    def get_warga(self, obj):
        if obj.warga:
            return {
                "id": obj.warga.id,
                "nama": obj.warga.full_name  # ganti `nama_lengkap` sesuai field nama di model `Warga`
            }
        return None
    
class CreateNoteSerializer(serializers.ModelSerializer):
    images = ImageNoteWargaSerializer(many=True, read_only=True)

    class Meta:
        model = NoteTagihan
        fields = '__all__'
    
    def create(self, validated_data):
        images_data = validated_data.pop('images', [])  
        note = NoteTagihan.objects.create(**validated_data)  

        for image_data in images_data:
            ImageNoteWarga.objects.create(note=note, **image_data)

        return note



class NoteUnpublishTagihanSerializer(serializers.ModelSerializer):
    is_pengurus = serializers.SerializerMethodField()

    class Meta:
        model = TagihanUnpublishNote
        fields = '__all__'

    def get_is_pengurus(self, obj):
        return MResidenceCommite.objects.filter(user=obj.created_by).exists()
    