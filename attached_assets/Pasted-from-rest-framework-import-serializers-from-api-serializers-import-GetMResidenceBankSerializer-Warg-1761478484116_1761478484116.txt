from rest_framework import serializers
from api.serializers import GetMResidenceBankSerializer,WargaSmallSerializer,MUnitSmallSerializer
from tagihan.models import  Tagihan, TagihanWarga, TagihanWargaRejectNote,TagihanUnpublishNote

class TagihanSimpleSerializer(serializers.ModelSerializer):
    residence = serializers.CharField( read_only=True)
    class Meta:
        model = Tagihan
        fields = ['id', 'name', 'jenis_tagihan','tipe', 'amount','tagihan_ke','date_due','residence','description']

class TagihanSerializer(serializers.ModelSerializer):
    created_by = serializers.CharField(read_only=True)
    create_at = serializers.DateTimeField( read_only=True)
    residence = serializers.CharField( read_only=True)
    publish_date = serializers.DateTimeField( read_only=True)
    is_publish = serializers.BooleanField( read_only=True)
    class Meta:
        model = Tagihan
        fields = '__all__'

class TagihanCreateSerializer(serializers.ModelSerializer):
    created_by = serializers.CharField(read_only=True)
    create_at = serializers.DateTimeField( read_only=True)
    publish_date = serializers.DateTimeField( read_only=True)
    is_publish = serializers.BooleanField( read_only=True)
    class Meta:
        model = Tagihan
        fields = '__all__'

class TagihanAllSerializer(serializers.ModelSerializer):
    class Meta:
        model = Tagihan
        fields = '__all__'

class TagihanWargaRejectNoteSerializer(serializers.ModelSerializer):
    class Meta:
        model = TagihanWargaRejectNote
        fields = '__all__'

class TagihanUnpublishNoteSerializer(serializers.ModelSerializer):
    class Meta:
        model = TagihanUnpublishNote
        fields = '__all__'

class TagihanWargaSerializer(serializers.ModelSerializer):
    reject_note = TagihanWargaRejectNoteSerializer(read_only=True)
    tagihan = TagihanSimpleSerializer(read_only=True)
    warga = WargaSmallSerializer(read_only=True)
    unit_id = MUnitSmallSerializer(read_only=True)

    class Meta:
        model = TagihanWarga
        fields = '__all__'

class TagihanWargaCreateSerializer(serializers.ModelSerializer):

    class Meta:
        model = TagihanWarga
        fields = '__all__'

class TagihanWargaReadOnlySerializer(serializers.ModelSerializer):
    reject_note = TagihanWargaRejectNoteSerializer(read_only=True)
    tagihan = TagihanSerializer(read_only=True)
    residence_bank = GetMResidenceBankSerializer(read_only=True)
    unit_id = MUnitSmallSerializer(read_only=True)
    warga = WargaSmallSerializer(read_only=True)
    class Meta:
        model = TagihanWarga
        fields = '__all__'
        read_only_fields = [
            'id',
            'status',
            'tagihan',
            'bukti_pembayaran',
            'warga',
            'unit_id',
            'paydate',
            'update_date'
        ]