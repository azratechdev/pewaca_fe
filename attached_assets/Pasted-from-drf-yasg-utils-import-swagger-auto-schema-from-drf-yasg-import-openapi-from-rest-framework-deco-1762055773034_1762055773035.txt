from drf_yasg.utils import swagger_auto_schema
from drf_yasg import openapi
from rest_framework.decorators import api_view
from rest_framework.response import Response
from django.db.models import Sum, Count, Q
from django.core.paginator import Paginator
from datetime import datetime

from api.serializers import (
    ReportIndexSerializer,
    ReportCashoutSerializer,
    ReportByTypeSerializer,
    ReportTunggakanSerializer
)

# Import Django models
from tagihan.models import Tagihan, TagihanWarga
from main.models import MUnit


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
    
    # FIXED: Only filter by isdelete (not isactive because all units have isactive=0)
    units = MUnit.objects.filter(
        unit_residence_id=residence_id,
        unit_isdelete=False
    )
    
    if unit_no:
        units = units.filter(unit_name__icontains=unit_no)
    
    unit_ids = list(units.values_list('unit_id', flat=True))
    jumlah_warga = len(unit_ids)
    
    if periode:
        try:
            year, month = periode.split('-')
            year = int(year)
            month = int(month)
        except (ValueError, AttributeError):
            return Response({"error": "periode format must be YYYY-MM"}, status=400)
    
    tagihan_queryset = Tagihan.objects.filter(
        residence_id=residence_id,
        is_active=True,
        is_publish=True
    )
    
    if periode:
        tagihan_queryset = tagihan_queryset.filter(
            Q(date_due__year=year, date_due__month=month) |
            Q(date_start__year=year, date_start__month=month)
        )
    
    tagihan_ids = list(tagihan_queryset.values_list('id', flat=True))
    
    tagihan_warga = TagihanWarga.objects.filter(
        unit_id__unit_id__in=unit_ids,
        tagihan_id__in=tagihan_ids
    )
    
    total_uang_masuk = tagihan_warga.filter(
        status='paid'
    ).aggregate(total=Sum('amount'))['total'] or 0
    
    units_sudah_bayar = tagihan_warga.filter(
        status='paid'
    ).values('unit_id').distinct().count()
    
    units_belum_bayar = jumlah_warga - units_sudah_bayar
    
    bypembayaran = [
        {"name": "Sudah Bayar", "jumlah": units_sudah_bayar},
        {"name": "Belum Bayar", "jumlah": units_belum_bayar}
    ]
    
    wajib_total = 0
    sukarela_total = 0
    
    for tagihan_id in tagihan_ids:
        try:
            tagihan_obj = Tagihan.objects.get(id=tagihan_id)
            tipe = tagihan_obj.tipe
            
            total = tagihan_warga.filter(
                tagihan_id=tagihan_id,
                status='paid'
            ).aggregate(total=Sum('amount'))['total'] or 0
            
            if tipe == 'wajib':
                wajib_total += total
            elif tipe == 'tidak wajib':
                sukarela_total += total
        except Tagihan.DoesNotExist:
            continue
    
    bytype = [
        {"name": "Wajib", "nominal": float(wajib_total)},
        {"name": "Sukarela", "nominal": float(sukarela_total)}
    ]
    
    tunggakan_units = tagihan_warga.filter(
        status='unpaid'
    ).values('unit_id').distinct().count()
    
    tunggakan_total = tagihan_warga.filter(
        status='unpaid'
    ).aggregate(total=Sum('amount'))['total'] or 0
    
    data = {
        "periode": periode,
        "total_uang_masuk": float(total_uang_masuk),
        "jumlah_warga": jumlah_warga,
        "bypembayaran": bypembayaran,
        "bytype": bytype,
        "tunggakan": {
            "total_unit": tunggakan_units,
            "total_nominal": float(tunggakan_total)
        }
    }
    
    return Response(data)
