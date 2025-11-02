from drf_yasg.utils import swagger_auto_schema
from drf_yasg import openapi
from rest_framework.decorators import api_view
from rest_framework.response import Response

from api.serializers import (
    ReportIndexSerializer,
    ReportCashoutSerializer,
    ReportByTypeSerializer,
    ReportTunggakanSerializer
)

@swagger_auto_schema(
    method='get',
    operation_description="Data Ringkasan Laporan",
    manual_parameters=[
        openapi.Parameter('periode', openapi.IN_QUERY, description="Periode laporan (format: YYYY-MM)", type=openapi.TYPE_STRING),
        openapi.Parameter('unit_no', openapi.IN_QUERY, description="Unit number", type=openapi.TYPE_STRING),
        openapi.Parameter('unit_ids', openapi.IN_QUERY, description="Comma-separated unit IDs untuk filter (required)", type=openapi.TYPE_STRING, required=True)
    ],
    responses={200: ReportIndexSerializer}
)
@api_view(['GET'])
def report_index_data(request):
    periode = request.query_params.get('periode')
    unit_no = request.query_params.get('unit_no')
    unit_ids_param = request.query_params.get('unit_ids')
    
    if not unit_ids_param:
        return Response({"error": "unit_ids parameter is required"}, status=400)
    
    try:
        unit_ids = [int(x.strip()) for x in unit_ids_param.split(',')]
    except ValueError:
        return Response({"error": "unit_ids must be comma-separated integers"}, status=400)
    
    if len(unit_ids) == 0:
        return Response({"error": "unit_ids cannot be empty"}, status=400)
    
    # TODO: Query database dengan filter unit_ids
    # Contoh dengan Django ORM:
    # payments = Payment.objects.filter(periode=periode, unit_id__in=unit_ids)
    # if unit_no:
    #     payments = payments.filter(unit__unit_no=unit_no)
    # 
    # Kemudian aggregate data untuk:
    # - total_uang_masuk = payments.aggregate(Sum('nominal'))['nominal__sum']
    # - jumlah_warga = payments.values('unit_id').distinct().count()
    # - bypembayaran = hitung sudah bayar vs belum bayar untuk unit_ids
    # - bytype = hitung wajib vs sukarela
    # - tunggakan = query tunggakan untuk unit_ids
    
    data = {
        "periode": periode,
        "total_uang_masuk": 20000000,
        "jumlah_warga": 100,
        "bypembayaran": [
            {"name": "Sudah Bayar", "jumlah": 80},
            {"name": "Belum Bayar", "jumlah": 20}
        ],
        "bytype": [
            {"name": "Wajib", "nominal": 12000000},
            {"name": "Sukarela", "nominal": 8000000}
        ],
        "tunggakan": {
            "total_unit": 10,
            "total_nominal": 15000000
        }
    }
    return Response(data)


@swagger_auto_schema(
    method='get',
    operation_description="Detail Pembayaran Warga",
    manual_parameters=[
        openapi.Parameter('periode', openapi.IN_QUERY, description="Periode laporan (format: YYYY-MM)", type=openapi.TYPE_STRING),
        openapi.Parameter('unit_name', openapi.IN_QUERY, description="Unit Name", type=openapi.TYPE_STRING),
        openapi.Parameter('unit_ids', openapi.IN_QUERY, description="Comma-separated unit IDs untuk filter (required)", type=openapi.TYPE_STRING, required=True),
        openapi.Parameter('page', openapi.IN_QUERY, description="Page number for pagination", type=openapi.TYPE_INTEGER)
    ],
    responses={200: ReportCashoutSerializer}
)
@api_view(['GET'])
def report_cashout_data(request):
    periode = request.query_params.get('periode')
    unit_name = request.query_params.get('unit_name')
    unit_ids_param = request.query_params.get('unit_ids')
    page = request.query_params.get('page', 1)
    
    if not unit_ids_param:
        return Response({"error": "unit_ids parameter is required"}, status=400)
    
    try:
        unit_ids = [int(x.strip()) for x in unit_ids_param.split(',')]
    except ValueError:
        return Response({"error": "unit_ids must be comma-separated integers"}, status=400)
    
    if len(unit_ids) == 0:
        return Response({"error": "unit_ids cannot be empty"}, status=400)
    
    # TODO: Query database dengan filter unit_ids
    # Contoh:
    # units = Unit.objects.filter(id__in=unit_ids)
    # if unit_name:
    #     units = units.filter(unit_name__icontains=unit_name)
    # 
    # sudah_bayar = Payment.objects.filter(
    #     periode=periode, 
    #     unit_id__in=unit_ids,
    #     status='paid'
    # ).values('unit__unit_no', 'tanggal_bayar', 'nominal')
    # 
    # belum_bayar = units yang belum ada di Payment untuk periode tsb
    
    data = {
        "periode": periode,
        "jumlah_warga": 100,
        "bypembayaran": [
            {"name": "Sudah Bayar", "jumlah": 80},
            {"name": "Belum Bayar", "jumlah": 20}
        ],
        "sudah_bayar": {
            "total": 12,
            "data": [
                {"unit": "C44", "tanggal": "12 April 2025", "nominal": 150000},
                {"unit": "C45", "tanggal": "13 April 2025", "nominal": 200000},
            ]
        },
        "belum_bayar": {
            "total": 8,
            "data": [
                {"unit": "C12", "tanggal": "12 April 2025", "nominal": 200000}
            ]
        }
    }
    return Response(data)


@swagger_auto_schema(
    method='get',
    operation_description="Laporan per Tipe Pembayaran",
    manual_parameters=[
        openapi.Parameter('periode', openapi.IN_QUERY, description="Periode laporan (format: YYYY-MM)", type=openapi.TYPE_STRING),
        openapi.Parameter('unit_no', openapi.IN_QUERY, description="Unit number", type=openapi.TYPE_STRING),
        openapi.Parameter('unit_ids', openapi.IN_QUERY, description="Comma-separated unit IDs untuk filter (required)", type=openapi.TYPE_STRING, required=True)
    ],
    responses={200: ReportByTypeSerializer}
)
@api_view(['GET'])
def report_by_type_data(request):
    periode = request.query_params.get('periode')
    unit_no = request.query_params.get('unit_no')
    unit_ids_param = request.query_params.get('unit_ids')
    
    if not unit_ids_param:
        return Response({"error": "unit_ids parameter is required"}, status=400)
    
    try:
        unit_ids = [int(x.strip()) for x in unit_ids_param.split(',')]
    except ValueError:
        return Response({"error": "unit_ids must be comma-separated integers"}, status=400)
    
    if len(unit_ids) == 0:
        return Response({"error": "unit_ids cannot be empty"}, status=400)
    
    # TODO: Query database dengan filter unit_ids
    # Contoh:
    # payments = Payment.objects.filter(periode=periode, unit_id__in=unit_ids)
    # if unit_no:
    #     payments = payments.filter(unit__unit_no=unit_no)
    # 
    # wajib = payments.filter(tipe='wajib').values('unit__unit_no', 'tanggal_bayar', 'nominal')
    # sukarela = payments.filter(tipe='sukarela').values('unit__unit_no', 'tanggal_bayar', 'nominal')
    # 
    # bytype_chart = [
    #     {"name": "Wajib", "nominal": wajib.aggregate(Sum('nominal'))['nominal__sum']},
    #     {"name": "Sukarela", "nominal": sukarela.aggregate(Sum('nominal'))['nominal__sum']}
    # ]
    
    data = {
        "periode": periode,
        "total_uang_masuk": 20000000,
        "jumlah_warga": 100,
        "bytype_chart": [
            {"name": "Wajib", "nominal": 12000000},
            {"name": "Sukarela", "nominal": 8000000}
        ],
        "wajib": {
            "total": 12000000,
            "data": [
                {"unit": "C44", "tanggal": "12 April 2025", "nominal": 150000},
                {"unit": "C45", "tanggal": "13 April 2025", "nominal": 200000},
            ]
        },
        "sukarela": {
            "total": 8000000,
            "data": [
                {"unit": "C12", "tanggal": "12 April 2025", "nominal": 200000}
            ]
        }
    }
    return Response(data)


@swagger_auto_schema(
    method='get',
    operation_description="Data Tunggakan Warga",
    manual_parameters=[
        openapi.Parameter('periode', openapi.IN_QUERY, description="Periode laporan (format: YYYY-MM)", type=openapi.TYPE_STRING),
        openapi.Parameter('unit_no', openapi.IN_QUERY, description="Unit number", type=openapi.TYPE_STRING),
        openapi.Parameter('unit_ids', openapi.IN_QUERY, description="Comma-separated unit IDs untuk filter (required)", type=openapi.TYPE_STRING, required=True)
    ],
    responses={200: ReportTunggakanSerializer}
)
@api_view(['GET'])
def report_tunggakan_data(request):
    periode = request.query_params.get('periode')
    unit_no = request.query_params.get('unit_no')
    unit_ids_param = request.query_params.get('unit_ids')
    
    if not unit_ids_param:
        return Response({"error": "unit_ids parameter is required"}, status=400)
    
    try:
        unit_ids = [int(x.strip()) for x in unit_ids_param.split(',')]
    except ValueError:
        return Response({"error": "unit_ids must be comma-separated integers"}, status=400)
    
    if len(unit_ids) == 0:
        return Response({"error": "unit_ids cannot be empty"}, status=400)
    
    # TODO: Query database dengan filter unit_ids
    # Contoh:
    # tunggakan = Tunggakan.objects.filter(unit_id__in=unit_ids, periode__lte=periode)
    # if unit_no:
    #     tunggakan = tunggakan.filter(unit__unit_no=unit_no)
    # 
    # units_data = []
    # for unit_id in unit_ids:
    #     unit_tunggakan = tunggakan.filter(unit_id=unit_id)
    #     if unit_tunggakan.exists():
    #         units_data.append({
    #             "nama_unit": unit_tunggakan.first().unit.unit_no,
    #             "periode": list(unit_tunggakan.values_list('periode_bulan', flat=True)),
    #             "tahun": unit_tunggakan.first().tahun,
    #             "total_nominal": unit_tunggakan.aggregate(Sum('nominal'))['nominal__sum']
    #         })
    # 
    # total_unit = len(units_data)
    # total_nominal = sum([u['total_nominal'] for u in units_data])
    
    data = {
        "periode": periode,
        "total_unit": 10,
        "total_nominal": 15000000,
        "units": [
            {
                "nama_unit": "C44",
                "periode": ["April", "Mei"],
                "tahun": 2025,
                "total_nominal": 300000
            },
            {
                "nama_unit": "C45",
                "periode": ["Mei"],
                "tahun": 2025,
                "total_nominal": 150000
            },
            {
                "nama_unit": "C46",
                "periode": ["April", "Mei"],
                "tahun": 2025,
                "total_nominal": 300000
            }
        ]
    }
    return Response(data)
