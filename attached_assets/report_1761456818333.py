from rest_framework import serializers

# Untuk 'bypembayaran' dan 'bytype'
class PembayaranSerializer(serializers.Serializer):
    name = serializers.CharField()
    jumlah = serializers.IntegerField()

class TipePembayaranSerializer(serializers.Serializer):
    name = serializers.CharField()
    nominal = serializers.IntegerField()

# Untuk 'tunggakan'
class TunggakanSerializer(serializers.Serializer):
    total_unit = serializers.IntegerField()
    total_nominal = serializers.IntegerField()

# Untuk report_index_data
class ReportIndexSerializer(serializers.Serializer):
    periode = serializers.CharField()
    total_uang_masuk = serializers.IntegerField()
    jumlah_warga = serializers.IntegerField()
    bypembayaran = PembayaranSerializer(many=True)
    bytype = TipePembayaranSerializer(many=True)
    tunggakan = TunggakanSerializer()


# Untuk report_cashout_data
class UnitTransaksiSerializer(serializers.Serializer):
    unit = serializers.CharField()
    tanggal = serializers.CharField()
    nominal = serializers.IntegerField()

class SudahBelumBayarSerializer(serializers.Serializer):
    total = serializers.IntegerField()
    data = UnitTransaksiSerializer(many=True)

class ReportCashoutSerializer(serializers.Serializer):
    periode = serializers.CharField()
    jumlah_warga = serializers.IntegerField()
    bypembayaran = PembayaranSerializer(many=True)
    sudah_bayar = SudahBelumBayarSerializer()
    belum_bayar = SudahBelumBayarSerializer()


# Untuk report_by_type_data
class ReportByTypeSerializer(serializers.Serializer):
    periode = serializers.CharField()
    total_uang_masuk = serializers.IntegerField()
    jumlah_warga = serializers.IntegerField()
    bytype_chart = TipePembayaranSerializer(many=True)
    wajib = SudahBelumBayarSerializer()
    sukarela = SudahBelumBayarSerializer()


# Untuk report_tunggakan_data
class UnitTunggakanSerializer(serializers.Serializer):
    nama_unit = serializers.CharField()
    periode = serializers.ListField(child=serializers.CharField())
    tahun = serializers.IntegerField()
    total_nominal = serializers.IntegerField()

class ReportTunggakanSerializer(serializers.Serializer):
    periode = serializers.CharField()
    total_unit = serializers.IntegerField()
    total_nominal = serializers.IntegerField()
    units = UnitTunggakanSerializer(many=True)
