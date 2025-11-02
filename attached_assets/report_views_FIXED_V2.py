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
    operation_description="Data Ringkasan Laporan - Filter by residence_id",
    manual_parameters=[
        openapi.Parameter('periode', openapi.IN_QUERY, description="Periode laporan (format: YYYY-MM)", type=openapi.TYPE_STRING),
        openapi.Parameter('unit_no', openapi.IN_QUERY, description="Unit number (optional filter)", type=openapi.TYPE_STRING),
        openapi.Parameter('residence_id', openapi.IN_QUERY, description="Residence ID untuk filter (required)", type=openapi.TYPE_INTEGER, required=True)
    ],
    responses={200: ReportIndexSerializer}
)
@api_view(['GET'])
def report_index_data(request):
    periode = request.query_params.get('periode')
    unit_no = request.query_params.get('unit_no')
    residence_id = request.query_params.get('residence_id')
    
    if not residence_id:
        return Response({"error": "residence_id parameter is required"}, status=400)
    
    try:
        residence_id = int(residence_id)
    except ValueError:
        return Response({"error": "residence_id must be an integer"}, status=400)
    
    # TODO: Query database dengan filter residence_id
    # Contoh dengan Django ORM:
    # 
    # from django.db.models import Sum, Count, Q
    # 
    # # Get all units dalam residence ini
    # units = Unit.objects.filter(residence_id=residence_id, isactive=True, isdelete=False)
    # 
    # # Filter by unit_no jika ada
    # if unit_no:
    #     units = units.filter(unit_no__icontains=unit_no)
    # 
    # unit_ids = units.values_list('id', flat=True)
    # 
    # # Query payments untuk periode dan residence ini
    # payments = Payment.objects.filter(
    #     periode=periode,
    #     unit_id__in=unit_ids
    # )
    # 
    # total_uang_masuk = payments.aggregate(total=Sum('nominal'))['total'] or 0
    # jumlah_warga = units.count()
    # 
    # # Hitung sudah bayar vs belum bayar
    # sudah_bayar = payments.values('unit_id').distinct().count()
    # belum_bayar = jumlah_warga - sudah_bayar
    # 
    # # Hitung by type (wajib vs sukarela)
    # wajib_total = payments.filter(tipe='wajib').aggregate(total=Sum('nominal'))['total'] or 0
    # sukarela_total = payments.filter(tipe='sukarela').aggregate(total=Sum('nominal'))['total'] or 0
    # 
    # # Hitung tunggakan
    # tunggakan_units = Tunggakan.objects.filter(
    #     unit_id__in=unit_ids,
    #     periode__lte=periode
    # ).values('unit_id').distinct()
    # total_tunggakan = Tunggakan.objects.filter(
    #     unit_id__in=unit_ids,
    #     periode__lte=periode
    # ).aggregate(total=Sum('nominal'))['total'] or 0
    
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
    operation_description="Detail Pembayaran Warga - Filter by residence_id",
    manual_parameters=[
        openapi.Parameter('periode', openapi.IN_QUERY, description="Periode laporan (format: YYYY-MM)", type=openapi.TYPE_STRING),
        openapi.Parameter('unit_name', openapi.IN_QUERY, description="Unit Name (optional filter)", type=openapi.TYPE_STRING),
        openapi.Parameter('residence_id', openapi.IN_QUERY, description="Residence ID untuk filter (required)", type=openapi.TYPE_INTEGER, required=True),
        openapi.Parameter('page', openapi.IN_QUERY, description="Page number for pagination", type=openapi.TYPE_INTEGER)
    ],
    responses={200: ReportCashoutSerializer}
)
@api_view(['GET'])
def report_cashout_data(request):
    periode = request.query_params.get('periode')
    unit_name = request.query_params.get('unit_name')
    residence_id = request.query_params.get('residence_id')
    page = request.query_params.get('page', 1)
    
    if not residence_id:
        return Response({"error": "residence_id parameter is required"}, status=400)
    
    try:
        residence_id = int(residence_id)
        page = int(page)
    except ValueError:
        return Response({"error": "residence_id and page must be integers"}, status=400)
    
    # TODO: Query database dengan filter residence_id
    # Contoh:
    # 
    # from django.core.paginator import Paginator
    # 
    # # Get units in this residence
    # units = Unit.objects.filter(residence_id=residence_id, isactive=True, isdelete=False)
    # if unit_name:
    #     units = units.filter(unit_name__icontains=unit_name)
    # 
    # unit_ids = list(units.values_list('id', flat=True))
    # 
    # # Sudah bayar
    # sudah_bayar_data = Payment.objects.filter(
    #     periode=periode,
    #     unit_id__in=unit_ids,
    #     status='paid'
    # ).select_related('unit').values('unit__unit_no', 'tanggal_bayar', 'nominal')
    # 
    # # Belum bayar (units yang tidak ada di payment)
    # paid_unit_ids = Payment.objects.filter(
    #     periode=periode, 
    #     unit_id__in=unit_ids
    # ).values_list('unit_id', flat=True)
    # 
    # belum_bayar_units = units.exclude(id__in=paid_unit_ids)
    # 
    # # Paginate data
    # paginator_sudah = Paginator(list(sudah_bayar_data), 10)
    # paginator_belum = Paginator(list(belum_bayar_units), 10)
    
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
    operation_description="Laporan per Tipe Pembayaran - Filter by residence_id",
    manual_parameters=[
        openapi.Parameter('periode', openapi.IN_QUERY, description="Periode laporan (format: YYYY-MM)", type=openapi.TYPE_STRING),
        openapi.Parameter('unit_no', openapi.IN_QUERY, description="Unit number (optional filter)", type=openapi.TYPE_STRING),
        openapi.Parameter('residence_id', openapi.IN_QUERY, description="Residence ID untuk filter (required)", type=openapi.TYPE_INTEGER, required=True)
    ],
    responses={200: ReportByTypeSerializer}
)
@api_view(['GET'])
def report_by_type_data(request):
    periode = request.query_params.get('periode')
    unit_no = request.query_params.get('unit_no')
    residence_id = request.query_params.get('residence_id')
    
    if not residence_id:
        return Response({"error": "residence_id parameter is required"}, status=400)
    
    try:
        residence_id = int(residence_id)
    except ValueError:
        return Response({"error": "residence_id must be an integer"}, status=400)
    
    # TODO: Query database dengan filter residence_id
    # Contoh:
    # 
    # # Get units in this residence
    # units = Unit.objects.filter(residence_id=residence_id, isactive=True, isdelete=False)
    # if unit_no:
    #     units = units.filter(unit_no__icontains=unit_no)
    # 
    # unit_ids = units.values_list('id', flat=True)
    # 
    # # Query payments
    # payments = Payment.objects.filter(periode=periode, unit_id__in=unit_ids)
    # 
    # # Split by type
    # wajib_payments = payments.filter(tipe='wajib').select_related('unit')
    # sukarela_payments = payments.filter(tipe='sukarela').select_related('unit')
    # 
    # wajib_total = wajib_payments.aggregate(Sum('nominal'))['nominal__sum'] or 0
    # sukarela_total = sukarela_payments.aggregate(Sum('nominal'))['nominal__sum'] or 0
    # 
    # wajib_data = wajib_payments.values('unit__unit_no', 'tanggal_bayar', 'nominal')
    # sukarela_data = sukarela_payments.values('unit__unit_no', 'tanggal_bayar', 'nominal')
    # 
    # bytype_chart = [
    #     {"name": "Wajib", "nominal": wajib_total},
    #     {"name": "Sukarela", "nominal": sukarela_total}
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
    operation_description="Data Tunggakan Warga - Filter by residence_id",
    manual_parameters=[
        openapi.Parameter('periode', openapi.IN_QUERY, description="Periode laporan (format: YYYY-MM)", type=openapi.TYPE_STRING),
        openapi.Parameter('unit_no', openapi.IN_QUERY, description="Unit number (optional filter)", type=openapi.TYPE_STRING),
        openapi.Parameter('residence_id', openapi.IN_QUERY, description="Residence ID untuk filter (required)", type=openapi.TYPE_INTEGER, required=True)
    ],
    responses={200: ReportTunggakanSerializer}
)
@api_view(['GET'])
def report_tunggakan_data(request):
    periode = request.query_params.get('periode')
    unit_no = request.query_params.get('unit_no')
    residence_id = request.query_params.get('residence_id')
    
    if not residence_id:
        return Response({"error": "residence_id parameter is required"}, status=400)
    
    try:
        residence_id = int(residence_id)
    except ValueError:
        return Response({"error": "residence_id must be an integer"}, status=400)
    
    # TODO: Query database dengan filter residence_id
    # Contoh:
    # 
    # # Get units in this residence
    # units = Unit.objects.filter(residence_id=residence_id, isactive=True, isdelete=False)
    # if unit_no:
    #     units = units.filter(unit_no__icontains=unit_no)
    # 
    # unit_ids = units.values_list('id', flat=True)
    # 
    # # Query tunggakan
    # tunggakan = Tunggakan.objects.filter(
    #     unit_id__in=unit_ids,
    #     periode__lte=periode
    # ).select_related('unit')
    # 
    # # Group by unit
    # from collections import defaultdict
    # units_data = []
    # unit_tunggakan_map = defaultdict(list)
    # 
    # for t in tunggakan:
    #     unit_tunggakan_map[t.unit_id].append(t)
    # 
    # for unit_id, tunggakan_list in unit_tunggakan_map.items():
    #     unit_obj = tunggakan_list[0].unit
    #     total_nominal = sum([t.nominal for t in tunggakan_list])
    #     periode_list = [t.periode_bulan for t in tunggakan_list]
    #     
    #     units_data.append({
    #         "nama_unit": unit_obj.unit_no,
    #         "periode": periode_list,
    #         "tahun": tunggakan_list[0].tahun,
    #         "total_nominal": total_nominal
    #     })
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
