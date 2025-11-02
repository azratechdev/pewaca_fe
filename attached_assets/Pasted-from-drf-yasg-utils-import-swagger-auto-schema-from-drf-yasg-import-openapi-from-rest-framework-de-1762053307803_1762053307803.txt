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
    periode = request.query_params.get('periode')  # Format: YYYY-MM
    unit_no = request.query_params.get('unit_no')
    residence_id = request.query_params.get('residence_id')
    
    if not residence_id:
        return Response({"error": "residence_id parameter is required"}, status=400)
    
    try:
        residence_id = int(residence_id)
    except ValueError:
        return Response({"error": "residence_id must be an integer"}, status=400)
    
    # Get all active units in this residence
    units = MUnit.objects.filter(
        unit_residence_id=residence_id,
        unit_isactive=True,
        unit_isdelete=False
    )
    
    # Filter by unit_no if provided
    if unit_no:
        units = units.filter(unit_name__icontains=unit_no)
    
    unit_ids = list(units.values_list('unit_id', flat=True))
    jumlah_warga = len(unit_ids)
    
    # Parse periode (YYYY-MM)
    if periode:
        try:
            year, month = periode.split('-')
            year = int(year)
            month = int(month)
        except (ValueError, AttributeError):
            return Response({"error": "periode format must be YYYY-MM"}, status=400)
    
    # Get tagihan for this residence and periode
    tagihan_queryset = Tagihan.objects.filter(
        residence_id=residence_id,
        is_active=True,
        is_publish=True
    )
    
    # Filter by periode (month and year from date_due or date_start)
    if periode:
        tagihan_queryset = tagihan_queryset.filter(
            Q(date_due__year=year, date_due__month=month) |
            Q(date_start__year=year, date_start__month=month)
        )
    
    tagihan_ids = list(tagihan_queryset.values_list('id', flat=True))
    
    # Get tagihan_warga for units in this residence
    tagihan_warga = TagihanWarga.objects.filter(
        unit_id__unit_id__in=unit_ids,
        tagihan_id__in=tagihan_ids
    )
    
    # Total uang masuk (semua yang sudah dibayar)
    total_uang_masuk = tagihan_warga.filter(
        status='paid'
    ).aggregate(total=Sum('amount'))['total'] or 0
    
    # By Pembayaran: Sudah Bayar vs Belum Bayar
    # Hitung unique unit yang sudah bayar
    units_sudah_bayar = tagihan_warga.filter(
        status='paid'
    ).values('unit_id').distinct().count()
    
    units_belum_bayar = jumlah_warga - units_sudah_bayar
    
    bypembayaran = [
        {"name": "Sudah Bayar", "jumlah": units_sudah_bayar},
        {"name": "Belum Bayar", "jumlah": units_belum_bayar}
    ]
    
    # By Type: Wajib vs Sukarela (dari tipe di tagihan)
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
    
    # Tunggakan: units yang belum bayar
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
    
    # Get units in this residence
    units = MUnit.objects.filter(
        unit_residence_id=residence_id,
        unit_isactive=True,
        unit_isdelete=False
    )
    
    if unit_name:
        units = units.filter(unit_name__icontains=unit_name)
    
    unit_ids = list(units.values_list('unit_id', flat=True))
    jumlah_warga = len(unit_ids)
    
    # Parse periode
    if periode:
        try:
            year, month = periode.split('-')
            year = int(year)
            month = int(month)
        except (ValueError, AttributeError):
            return Response({"error": "periode format must be YYYY-MM"}, status=400)
    
    # Get tagihan for this periode
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
    
    # Sudah Bayar
    sudah_bayar_queryset = TagihanWarga.objects.filter(
        unit_id__unit_id__in=unit_ids,
        tagihan_id__in=tagihan_ids,
        status='paid'
    ).select_related('unit_id')
    
    sudah_bayar_data = []
    for tw in sudah_bayar_queryset:
        sudah_bayar_data.append({
            "unit": tw.unit_id.unit_name,
            "tanggal": tw.paydate.strftime('%d %B %Y') if tw.paydate else '-',
            "nominal": float(tw.amount) if tw.amount else 0
        })
    
    # Belum Bayar: units yang tidak ada di tagihan_warga atau status unpaid
    paid_unit_ids = sudah_bayar_queryset.values_list('unit_id', flat=True).distinct()
    belum_bayar_units = units.exclude(unit_id__in=paid_unit_ids)
    
    belum_bayar_data = []
    
    # Units yang belum ada tagihan_warga sama sekali
    for unit in belum_bayar_units:
        expected_amount = tagihan_queryset.aggregate(total=Sum('amount'))['total'] or 0
        belum_bayar_data.append({
            "unit": unit.unit_name,
            "tanggal": "-",
            "nominal": float(expected_amount)
        })
    
    # Units yang ada tagihan_warga tapi status unpaid
    unpaid_queryset = TagihanWarga.objects.filter(
        unit_id__unit_id__in=unit_ids,
        tagihan_id__in=tagihan_ids,
        status='unpaid'
    ).select_related('unit_id')
    
    for tw in unpaid_queryset:
        belum_bayar_data.append({
            "unit": tw.unit_id.unit_name,
            "tanggal": tw.date_due.strftime('%d %B %Y') if tw.date_due else '-',
            "nominal": float(tw.amount) if tw.amount else 0
        })
    
    # Pagination
    paginator_sudah = Paginator(sudah_bayar_data, 10)
    paginator_belum = Paginator(belum_bayar_data, 10)
    
    try:
        sudah_page = paginator_sudah.page(page)
        belum_page = paginator_belum.page(page)
    except:
        sudah_page = paginator_sudah.page(1)
        belum_page = paginator_belum.page(1)
    
    # By Pembayaran counts
    units_sudah_bayar = len(set(paid_unit_ids))
    units_belum_bayar = jumlah_warga - units_sudah_bayar
    
    data = {
        "periode": periode,
        "jumlah_warga": jumlah_warga,
        "bypembayaran": [
            {"name": "Sudah Bayar", "jumlah": units_sudah_bayar},
            {"name": "Belum Bayar", "jumlah": units_belum_bayar}
        ],
        "sudah_bayar": {
            "total": len(sudah_bayar_data),
            "data": list(sudah_page)
        },
        "belum_bayar": {
            "total": len(belum_bayar_data),
            "data": list(belum_page)
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
    
    # Get units
    units = MUnit.objects.filter(
        unit_residence_id=residence_id,
        unit_isactive=True,
        unit_isdelete=False
    )
    
    if unit_no:
        units = units.filter(unit_name__icontains=unit_no)
    
    unit_ids = list(units.values_list('unit_id', flat=True))
    jumlah_warga = len(unit_ids)
    
    # Parse periode
    if periode:
        try:
            year, month = periode.split('-')
            year = int(year)
            month = int(month)
        except (ValueError, AttributeError):
            return Response({"error": "periode format must be YYYY-MM"}, status=400)
    
    # Get tagihan wajib
    tagihan_wajib = Tagihan.objects.filter(
        residence_id=residence_id,
        tipe='wajib',
        is_active=True,
        is_publish=True
    )
    
    if periode:
        tagihan_wajib = tagihan_wajib.filter(
            Q(date_due__year=year, date_due__month=month) |
            Q(date_start__year=year, date_start__month=month)
        )
    
    tagihan_wajib_ids = list(tagihan_wajib.values_list('id', flat=True))
    
    # Get tagihan sukarela (tidak wajib)
    tagihan_sukarela = Tagihan.objects.filter(
        residence_id=residence_id,
        tipe='tidak wajib',
        is_active=True,
        is_publish=True
    )
    
    if periode:
        tagihan_sukarela = tagihan_sukarela.filter(
            Q(date_due__year=year, date_due__month=month) |
            Q(date_start__year=year, date_start__month=month)
        )
    
    tagihan_sukarela_ids = list(tagihan_sukarela.values_list('id', flat=True))
    
    # Get payments for wajib
    wajib_payments = TagihanWarga.objects.filter(
        unit_id__unit_id__in=unit_ids,
        tagihan_id__in=tagihan_wajib_ids,
        status='paid'
    ).select_related('unit_id')
    
    wajib_data = []
    for tw in wajib_payments:
        wajib_data.append({
            "unit": tw.unit_id.unit_name,
            "tanggal": tw.paydate.strftime('%d %B %Y') if tw.paydate else '-',
            "nominal": float(tw.amount) if tw.amount else 0
        })
    
    wajib_total = wajib_payments.aggregate(total=Sum('amount'))['total'] or 0
    
    # Get payments for sukarela
    sukarela_payments = TagihanWarga.objects.filter(
        unit_id__unit_id__in=unit_ids,
        tagihan_id__in=tagihan_sukarela_ids,
        status='paid'
    ).select_related('unit_id')
    
    sukarela_data = []
    for tw in sukarela_payments:
        sukarela_data.append({
            "unit": tw.unit_id.unit_name,
            "tanggal": tw.paydate.strftime('%d %B %Y') if tw.paydate else '-',
            "nominal": float(tw.amount) if tw.amount else 0
        })
    
    sukarela_total = sukarela_payments.aggregate(total=Sum('amount'))['total'] or 0
    
    total_uang_masuk = float(wajib_total) + float(sukarela_total)
    
    data = {
        "periode": periode,
        "total_uang_masuk": total_uang_masuk,
        "jumlah_warga": jumlah_warga,
        "bytype_chart": [
            {"name": "Wajib", "nominal": float(wajib_total)},
            {"name": "Sukarela", "nominal": float(sukarela_total)}
        ],
        "wajib": {
            "total": float(wajib_total),
            "data": wajib_data
        },
        "sukarela": {
            "total": float(sukarela_total),
            "data": sukarela_data
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
    
    # Get units
    units = MUnit.objects.filter(
        unit_residence_id=residence_id,
        unit_isactive=True,
        unit_isdelete=False
    )
    
    if unit_no:
        units = units.filter(unit_name__icontains=unit_no)
    
    unit_ids = list(units.values_list('unit_id', flat=True))
    
    # Parse periode untuk filter sampai periode ini (inclusive)
    if periode:
        try:
            year, month = periode.split('-')
            year = int(year)
            month = int(month)
        except (ValueError, AttributeError):
            return Response({"error": "periode format must be YYYY-MM"}, status=400)
    
    # Get all tagihan up to this periode
    tagihan_queryset = Tagihan.objects.filter(
        residence_id=residence_id,
        is_active=True,
        is_publish=True
    )
    
    if periode:
        from datetime import date
        periode_date = date(year, month, 1)
        tagihan_queryset = tagihan_queryset.filter(date_due__lte=periode_date)
    
    tagihan_ids = list(tagihan_queryset.values_list('id', flat=True))
    
    # Get tunggakan (unpaid)
    tunggakan_queryset = TagihanWarga.objects.filter(
        unit_id__unit_id__in=unit_ids,
        tagihan_id__in=tagihan_ids,
        status='unpaid'
    ).select_related('unit_id')
    
    # Group by unit
    from collections import defaultdict
    unit_tunggakan_map = defaultdict(list)
    
    for tw in tunggakan_queryset:
        unit_tunggakan_map[tw.unit_id.unit_id].append(tw)
    
    units_data = []
    total_nominal_all = 0
    
    for unit_id, tunggakan_list in unit_tunggakan_map.items():
        unit_obj = MUnit.objects.get(unit_id=unit_id)
        
        # Get periode list (bulan)
        periode_list = []
        tahun = None
        total_nominal_unit = 0
        
        for tw in tunggakan_list:
            if tw.date_due:
                month_name = tw.date_due.strftime('%B')
                if month_name not in periode_list:
                    periode_list.append(month_name)
                if not tahun:
                    tahun = tw.date_due.year
            
            total_nominal_unit += float(tw.amount) if tw.amount else 0
        
        units_data.append({
            "nama_unit": unit_obj.unit_name,
            "periode": periode_list,
            "tahun": tahun or year,
            "total_nominal": total_nominal_unit
        })
        
        total_nominal_all += total_nominal_unit
    
    data = {
        "periode": periode,
        "total_unit": len(units_data),
        "total_nominal": total_nominal_all,
        "units": units_data
    }
    
    return Response(data)
