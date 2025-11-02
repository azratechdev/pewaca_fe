from rest_framework import viewsets, status
from rest_framework.permissions import IsAuthenticated
from rest_framework.parsers import MultiPartParser, FormParser
from rest_framework.decorators import action
from rest_framework.views import APIView
from rest_framework.exceptions import ValidationError,NotFound
from django_filters.rest_framework import DjangoFilterBackend
from django.utils import timezone
from drf_yasg import openapi
from drf_yasg.utils import swagger_auto_schema
from django.db import IntegrityError
from dateutil.relativedelta import relativedelta
from django.db import transaction, IntegrityError
from django.shortcuts import get_object_or_404

from tagihan.models import Tagihan, TagihanWargaRejectNote, TagihanWarga,NoteTagihan,ImageNoteWarga,TagihanUnpublishNote
from management_user.models import Warga, MUser
from main.models import MResidenceCommite,MUnit,MResidenceBank,BankList
from api.serializers import (
    TagihanSerializer,
    TagihanCreateSerializer,
    TagihanWargaRejectNoteSerializer,
    TagihanWargaSerializer,
    TagihanWargaCreateSerializer,
    TagihanWargaReadOnlySerializer,
    TagihanAllSerializer,
    ImageNoteWargaSerializer,
    NoteSerializer,
    CreateNoteSerializer,
    NoteUnpublishTagihanSerializer
)
from api.utils import  custom_response, custom_error_response,CustomPagination
import logging
from rest_framework.response import Response

from django.http import HttpResponse
from reportlab.lib.pagesizes import A4
from reportlab.platypus import SimpleDocTemplate, Table, TableStyle, Paragraph, Spacer
from reportlab.lib.styles import getSampleStyleSheet
from reportlab.lib import colors
from io import BytesIO
from rest_framework.decorators import api_view
from api.utils import compress_image  # pastikan path-nya benar
from api.utils import TokenJWTAuthentication
from django.core.files.base import ContentFile

logger = logging.getLogger(__name__)


class TagihanViewSet(viewsets.ModelViewSet):
    queryset = Tagihan.objects.filter(is_active=True)
    serializer_class = TagihanSerializer
    permission_classes = [IsAuthenticated]
    authentication_classes = [TokenJWTAuthentication]
    filter_backends = [DjangoFilterBackend]
    http_method_names = ['get','post','put']

    def retrieve(self, request, *args, **kwargs):
        tagihan_id = kwargs.get('pk')
        tagihan = Tagihan.objects.get(id=tagihan_id)
        serializer = self.get_serializer(tagihan)
        return custom_response(serializer.data,  status=status.HTTP_200_OK)


    def get_queryset(self):        
        user = self.request.user
        user_id = user.user_id
        if user_id==None:
            return Tagihan.objects.none()

        user = MUser.objects.filter(user_id=user_id).first()
        comite = MResidenceCommite.objects.filter(user=user).first()
        if comite is None:
            return Tagihan.objects.none()
        return Tagihan.objects.filter(residence = comite.residence,is_active=True).order_by('-id')

    def get(self, request, *args, **kwargs):
        
        user = request.user
        user_id = user.user_id
        user = MUser.objects.filter(user_id=user_id).first()
        if user is None:
            return custom_error_response('User tidak ditemukan.', status_code=401)
        return super().get(request, *args, **kwargs)

    @swagger_auto_schema(
        operation_description="Create a new tagihan (billing)",
        request_body=TagihanCreateSerializer,
        responses={
            201: openapi.Response('Tagihan created successfully', TagihanCreateSerializer),
            400: 'Validation error',
            401: 'Unauthorized, token is invalid or not found',
            403: 'Forbidden, user lacks necessary access rights',
            404: 'User not found',
            500: 'Unexpected server error'
        }
    )
    def create(self, request, *args, **kwargs):
        try:            
            user = request.user
            user_id = user.user_id
            if user_id is None:
                return custom_error_response('Token tidak valid atau tidak ditemukan.', status_code=401)

            user = MUser.objects.filter(user_id=user_id).first()
            if not user:
                return custom_error_response('User tidak ditemukan.', status_code=404)

            comite = MResidenceCommite.objects.filter(user=user).first()
            if not comite:
                return custom_error_response('Anda tidak memiliki akses untuk membuat tagihan.', status_code=403)


            try:
                data = request.data.copy()
                data['residence'] = comite.residence.id
                data['created_by'] = user_id
                data['is_publish'] = False
                # Best practice: gunakan field 'created_by' sesuai model
                print(f"Modified data: {data}")
            except Exception as e:
                print(f"ERROR modifying data: {str(e)}")
                import traceback
                traceback.print_exc()
                raise


            serializer = TagihanCreateSerializer(data=data)
            serializer.is_valid(raise_exception=True)
            self.perform_create(serializer)
            
            return custom_response(serializer.data,  status=status.HTTP_201_CREATED)
        
        except ValidationError as e:
            return custom_error_response(f"Validation error: {e.detail}", status_code=status.HTTP_400_BAD_REQUEST)
        except Exception as e:
            return custom_error_response(f"Unexpected error: {str(e)}", status_code=status.HTTP_500_INTERNAL_SERVER_ERROR)

    @swagger_auto_schema(
        operation_description="Update an existing tagihan (billing)",
        request_body=TagihanCreateSerializer,
        responses={
            200: openapi.Response('Tagihan updated successfully', TagihanCreateSerializer),
            400: 'Validation error',
            401: 'Unauthorized, token is invalid or not found',
            403: 'Forbidden, user lacks necessary access rights',
            404: 'Tagihan or user not found',
            500: 'Unexpected server error'
        }
    )
    def update(self, request, *args, **kwargs):
        try:
            # Authenticate user by extracting user_id from token
            
            user = request.user
            user_id = user.user_id
            if user_id is None:
                return custom_error_response('Token tidak valid atau tidak ditemukan.', status_code=401)

            # Verify user existence in the database
            user = MUser.objects.filter(user_id=user_id).first()
            if not user:
                return custom_error_response('User tidak ditemukan.', status_code=404)

            # Check if the user is part of a residence committee
            comite = MResidenceCommite.objects.filter(user=user).first()
            if not comite:
                return custom_error_response('Anda tidak memiliki akses untuk memperbarui tagihan.', status_code=403)

            # Get the tagihan instance
            tagihan_id = kwargs.get('pk')
            if tagihan_id is None:
                return custom_error_response('Tagihan ID tidak ditemukan dalam permintaan.', status_code=400)

            try:
                tagihan = Tagihan.objects.get(pk=tagihan_id)
                print(tagihan)
            except Tagihan.DoesNotExist:
                return custom_error_response('Tagihan tidak ditemukan.', status_code=404)

            if tagihan.residence.id != comite.residence.id:
                return custom_error_response('Anda tidak memiliki akses untuk memperbarui tagihan ini.', status_code=403)

            # Update the tagihan instance
            serializer = TagihanAllSerializer(tagihan, data=request.data, partial=True)
            if serializer.is_valid(raise_exception=True):
                self.perform_update(serializer)
                return custom_response(serializer.data, status=status.HTTP_200_OK)

        except ValidationError as e:
            return custom_error_response(f"Validation error: {e.detail}", status_code=status.HTTP_400_BAD_REQUEST)
        except NotFound as e:
            return custom_error_response('Tagihan tidak ditemukan.', status_code=status.HTTP_404_NOT_FOUND)
        except Exception as e:
            return custom_error_response(f"Unexpected error: {str(e)}", status_code=status.HTTP_500_INTERNAL_SERVER_ERROR)
        
class TagihanWargaRejectNoteViewSet(viewsets.ModelViewSet):
    queryset = TagihanWargaRejectNote.objects.all()
    serializer_class = TagihanWargaRejectNoteSerializer
    permission_classes = [IsAuthenticated]
    authentication_classes = [TokenJWTAuthentication]
    http_method_names = ['get','post']

    def create(self, request, *args, **kwargs):
        
        user = request.user
        user_id = user.user_id
        user = MUser.objects.filter(user_id=user_id).first()
        comite = MResidenceCommite.objects.filter(user=user).first()
        if not comite:
            return custom_error_response('Anda tidak memiliki akses untuk membuat tagihan.', status_code=403
            )
        return custom_response('Reject Tagihan berhasil dibuat.', status=200)

class TagihanWargaViewSet(viewsets.ModelViewSet):
    queryset = TagihanWarga.objects.all()
    serializer_class = TagihanWargaSerializer
    permission_classes = [IsAuthenticated]
    authentication_classes = [TokenJWTAuthentication]
    http_method_names = ['get','post'] 
    parser_classes = [MultiPartParser, FormParser]    
    pagination_class = CustomPagination

    @swagger_auto_schema(
            responses={200: TagihanWargaSerializer}
        )
    def retrieve(self, request, *args, **kwargs):
        # Ambil objek instance
        instance = self.get_object()

        # Periksa apakah residence_bank belum di-set
        if not instance.residence_bank:
            residence_bank = MResidenceBank.objects.filter(
                residence=instance.tagihan.residence,
                isactive=True
            ).first()
            if residence_bank:
                instance.residence_bank = residence_bank
            else:
                return custom_error_response(
                     "Residence bank not found.",
                    status_code=status.HTTP_404_NOT_FOUND,
                )

        # Serialisasi data
        serializer = TagihanWargaReadOnlySerializer(instance)
        return custom_response(serializer.data, status=status.HTTP_200_OK)
    
    @swagger_auto_schema(
        operation_description="Retrieve a list of tagihan warga",
        manual_parameters=[
            openapi.Parameter(
                "status",
                openapi.IN_QUERY,
                description="Status of tagihan (ignore, unpaid, paid, process, rejected, cancel)",
                type=openapi.TYPE_STRING,
                required=False,
            ),
            openapi.Parameter(
                "end_due_date",
                openapi.IN_QUERY,
                description="End of due date",
                type=openapi.TYPE_STRING,
                required=False,
            ),
            # search by unit_name and tagihan name
            openapi.Parameter(
                "search",
                openapi.IN_QUERY,
                description="Search by unit_name and tagihan name",
                type=openapi.TYPE_STRING,
                required=False,
            ),
            # search by warga_id
            openapi.Parameter(
                "warga_id",
                openapi.IN_QUERY,
                description="Search by warga_id",
                type=openapi.TYPE_INTEGER,
                required=False,
            ),
        ],
        responses={
            200: openapi.Response("Success", TagihanWargaSerializer),
            404: "Not Found",
            400: "Bad Request",
        },
    )
    def list(self, request, *args, **kwargs):
        user = request.user
        user_id = user.user_id if hasattr(user, 'user_id') else user.id

        tagihan_warga = TagihanWarga.objects.order_by("-id")

        filters = {}
        if status := request.query_params.get("status"):
            filters["status__in"] = status.split(",")
        if end_due_date := request.query_params.get("end_due_date"):
            filters["date_due__lte"] = end_due_date
        if search := request.query_params.get("search"):
            tagihan_warga = tagihan_warga.filter(
                unit_id__unit_name__icontains=search
            ) | tagihan_warga.filter(tagihan__name__icontains=search)
        if warga_id := request.query_params.get("warga_id"):
            filters["warga_id"] = warga_id

        tagihan_warga = tagihan_warga.filter(**filters)
        tagihan_warga = tagihan_warga.filter(tagihan__is_active=True)
        comite = MResidenceCommite.objects.filter(user=user_id).first()
        warga = None if comite else Warga.objects.filter(user_id=user_id).first()


        if comite:
            tagihan_warga = tagihan_warga.filter(unit_id__unit_residence=comite.residence)
        elif warga:
            tagihan_warga = tagihan_warga.filter(unit_id=warga.unit_id)
        else:
            return custom_error_response({"error": "User is not associated with any residence or unit"}, status_code=400)


        paginated_queryset = self.paginate_queryset(tagihan_warga)
        if paginated_queryset is not None:
            return self.get_paginated_response(self.get_serializer(paginated_queryset, many=True).data)

        if not tagihan_warga.exists():
            return custom_error_response({"message": "No data found"}, status_code=404)

        return custom_response(data=self.get_serializer(tagihan_warga, many=True).data)

    
    @swagger_auto_schema(
        operation_description="Retrieve a list of tagihan warga",
        manual_parameters=[
            openapi.Parameter('status', openapi.IN_QUERY, description="status of tagihan (ignore,unpaid,paid,process,rejected,cancel)", type=openapi.TYPE_STRING, required=False),
            openapi.Parameter('end_due_date', openapi.IN_QUERY, description="End Range Of due date", type=openapi.TYPE_STRING, required=False),
            openapi.Parameter(
                "search",
                openapi.IN_QUERY,
                description="Search by unit_name and tagihan name",
                type=openapi.TYPE_STRING,
                required=False,
            ),
            
            # search by warga_id
            openapi.Parameter(
                "warga_id",
                openapi.IN_QUERY,
                description="Search by warga_id",
                type=openapi.TYPE_INTEGER,
                required=False,
            ),
        ],
        responses={
            200: openapi.Response("Success", TagihanWargaSerializer),
            404: "Not Found",
            400: "Bad Request"
        }
    )
    @action(detail=False, methods=['get'],url_path='self-list')
    def self_list(self, request, *args, **kwargs):
        user = request.user
        user_id = user.user_id if hasattr(user, 'user_id') else user.id

        # Base QuerySet
        warga = Warga.objects.filter(user_id=user_id).first()
        if not warga:
            return custom_error_response({"error": "User is not associated with any unit"}, status_code=400)
        tagihan_warga = TagihanWarga.objects.filter(unit_id=warga.unit_id).order_by('-id')
        tagihan_warga = tagihan_warga.filter(tagihan__is_active=True)

        # Apply Filters
        filters = {}
        if status := request.query_params.get('status'):
            filters['status__in'] = status.split(',')
        if end_due_date := request.query_params.get('end_due_date'):
            filters['date_due__lte'] = end_due_date
        if search := request.query_params.get("search"):
            tagihan_warga = tagihan_warga.filter(
                unit_id__unit_name__icontains=search
            ) | tagihan_warga.filter(tagihan__name__icontains=search)
        if warga_id := request.query_params.get("warga_id"):
            filters["warga_id"] = warga_id

        tagihan_warga = tagihan_warga.filter(**filters)

        # Apply Pagination
        paginated_queryset = self.paginate_queryset(tagihan_warga)
        if paginated_queryset is not None:
            return self.get_paginated_response(self.get_serializer(paginated_queryset, many=True).data)

        # If no data found, return meaningful response
        if not tagihan_warga.exists():
            return custom_error_response({"message": "No data found"}, status_code=404)

        # Serialize and return response
        return custom_response(data=self.get_serializer(tagihan_warga, many=True).data)

    @swagger_auto_schema(
        operation_description="Approve a specific bill for a resident",
        manual_parameters=[],
        responses={
            200: openapi.Response("Success", TagihanWargaSerializer),
            404: "Not Found",
            400: "Bad Request"
        }
    )
    @action(detail=True, methods=['post'],serializer_class=TagihanWargaReadOnlySerializer)
    def approve(self, request, pk=None):
        tagihan = self.get_object()
        if tagihan.status == "paid":    
            return custom_error_response( "Tagihan sudah disetujui.")
        tagihan.status = "paid"
        tagihan.paydate = timezone.now()
        tagihan.save()
        return custom_response("Tagihan berhasil disetujui.", status=200)

    @swagger_auto_schema(
        operation_description="Reject a specific bill for a resident",
        manual_parameters=[],
        responses={
            200: openapi.Response("Success", TagihanWargaSerializer),
            404: "Not Found",
            400: "Bad Request"
        }
    )
    @action(detail=True, methods=['post'],serializer_class=TagihanWargaReadOnlySerializer)
    def reject(self, request, pk=None):
        tagihan = self.get_object()
        if tagihan.status == "rejected":
            return custom_error_response(
                "Tagihan sudah ditolak."
            )
        tagihan.status = "rejected"
        tagihan.save()
        return custom_response("Tagihan berhasil ditolak.", status=200)
    
    @swagger_auto_schema(
        request_body=TagihanWargaCreateSerializer,
        responses={201: TagihanWargaCreateSerializer}
    )
    def create(self, request, *args, **kwargs):
        serializer = TagihanWargaCreateSerializer(data=request.data)
        if serializer.is_valid():
            try:
                serializer.save()
                return custom_response(data=serializer.data, status=status.HTTP_201_CREATED)
            except IntegrityError as e:
                return custom_response(data={"detail": "Duplicate entry error."}, status=status.HTTP_400_BAD_REQUEST)
        return custom_response(data=serializer.errors, status=status.HTTP_400_BAD_REQUEST)
    
class TagihanWargaBayarViewSet(APIView):
    queryset = TagihanWarga.objects.all()
    serializer_class = TagihanWargaSerializer
    permission_classes = [IsAuthenticated]
    authentication_classes = [TokenJWTAuthentication]
    http_method_names = ['patch',] 
    parser_classes = [MultiPartParser, FormParser]

    @swagger_auto_schema(
        operation_description="Upload bukti pembayaran",
        manual_parameters=[
            openapi.Parameter('bukti_pembayaran', openapi.IN_FORM, description="Upload bukti pembayaran", type=openapi.TYPE_FILE, required=True),
            openapi.Parameter('amount', openapi.IN_FORM, description="Amount", type=openapi.TYPE_INTEGER, required=False),
            openapi.Parameter('note', openapi.IN_FORM, description="Note", type=openapi.TYPE_STRING, required=False),
            openapi.Parameter('residence_bank', openapi.IN_FORM, description="Residence bank", type=openapi.TYPE_INTEGER, required=True),
        ],
        responses={
            200: openapi.Response(description="Upload bukti pembayaran updated successfully"),
            400: openapi.Response(description="Validation errors"),
        }
    )
    def patch(self, request, pk=None):
        user = request.user
        user_id = user.user_id if hasattr(user, 'user_id') else user.id
        warga = Warga.objects.filter(user_id=user_id).first()

        if not warga:
            return custom_error_response("User tidak ditemukan", status_code=status.HTTP_400_BAD_REQUEST)

        tagihan = get_object_or_404(TagihanWarga, pk=pk)
        file = request.FILES.get('bukti_pembayaran')
        amount = request.data.get('amount')
        residence_bank = request.data.get('residence_bank')
        note = request.data.get('note') or "Bukti pembayaran"  # Jika kosong, gunakan default

        if amount:
            tagihan.amount = amount
            
        residence_bank = MResidenceBank.objects.filter(
            id=request.data.get('residence_bank'),
            isactive=True
        ).first()
        tagihan.residence_bank = residence_bank

        note_obj =  NoteTagihan.objects.create(note=note, tagihan_warga=tagihan, warga=warga)

        if file:
            
            # Kompres gambar jika bukan webp
            if not file.name.lower().endswith(".webp"):
                compressed = compress_image(file)
                file = ContentFile(compressed.read(), name=file.name)
            tagihan.status = 'process'
            tagihan.warga = warga
            tagihan.update_date = timezone.now()
            ImageNoteWarga.objects.create(image=file, note=note_obj)
            tagihan.save()
            return custom_response("Bukti pembayaran berhasil diunggah", status=status.HTTP_200_OK)

        return custom_error_response("File tidak ditemukan", status_code=status.HTTP_400_BAD_REQUEST)
    
class PublishTagihanView(APIView):

    def generate_tagihan_onetime(self, tagihan):
        unit = MUnit.objects.filter(unit_residence=tagihan.residence).all()
        tagihan_ke = tagihan.tagihan_ke
        if tagihan_ke == None:
            tagihan_ke = 0
        for u in unit:
            no_tagihan = "T-" + str(u.unit_id) + "-" + str(tagihan.id)
            date = tagihan.date_due
            if tagihan.jenis_tagihan == "monthly":
                date = tagihan.date_due + relativedelta(months=tagihan_ke)
            elif tagihan.jenis_tagihan == "yearly":
                date = tagihan.date_due + relativedelta(years=tagihan_ke)
            elif tagihan.jenis_tagihan == "weekly":
                date = tagihan.date_due + relativedelta(weeks=tagihan_ke)
            TagihanWarga.objects.create(
                    tagihan_id=tagihan.id,
                    date_due=date,
                    unit_id=u,
                    no_tagihan=no_tagihan,
                    status="unpaid"
                )
        tagihan_ke = tagihan_ke+1

            
        return  tagihan_ke

    def post(self, request, pk=None):
        try:
            tagihan = Tagihan.objects.get(id=pk)
            tagihan.is_publish = True
            tagihan.publish_date = timezone.now()  # Set publish date to now
            tagihan.tagihan_ke =  self.generate_tagihan_onetime(tagihan)
            tagihan.save()
            serializer = TagihanSerializer(tagihan)
            return custom_response(serializer.data, status=200)
        except Tagihan.DoesNotExist:
            return custom_error_response('Tagihan tidak ditemukan', status_code=404)
        
class NoteViewSet(viewsets.ModelViewSet):
    queryset = NoteTagihan.objects.all()
    serializer_class = NoteSerializer
    permission_classes = [IsAuthenticated]
    authentication_classes = [TokenJWTAuthentication]
    http_method_names = ['get',"post"] 
    parser_classes = [MultiPartParser, FormParser]


    @swagger_auto_schema(
        manual_parameters=[
            openapi.Parameter(
                'tagihan_warga_id',
                openapi.IN_PATH,
                description="ID Tagihan untuk filter catatan",
                type=openapi.TYPE_INTEGER
            )
        ],
        responses={200: NoteSerializer(many=True)}
    )
    @action(detail=False, methods=['get'], url_path='list/(?P<tagihan_warga_id>[^/.]+)')
    def tagihan_note_list(self, request, tagihan_warga_id=None):
        if tagihan_warga_id is None:
            return custom_error_response({"error": "tagihan_warga_id diperlukan"}, status_code=400)

        notes = NoteTagihan.objects.filter(tagihan_warga=tagihan_warga_id).order_by('timestamp')
        serializer = NoteSerializer(notes, many=True)
        return custom_response(data=serializer.data)
    
    @swagger_auto_schema(
        operation_description="API untuk membuat Note baru dengan beberapa gambar",
        manual_parameters=[
            openapi.Parameter(
                'tagihan_warga', openapi.IN_FORM, description="ID Tagihan warga",
                type=openapi.TYPE_INTEGER, required=True
            ),
            openapi.Parameter(
                'warga', openapi.IN_FORM, description="ID Warga ",
                type=openapi.TYPE_INTEGER, required=True
            ),
            openapi.Parameter(
                'note', openapi.IN_FORM, description="Catatan",
                type=openapi.TYPE_STRING, required=True
            ),
            openapi.Parameter(
                'images', openapi.IN_FORM, description="Unggah gambar (gunakan beberapa field images[] untuk multi-upload)",
                type=openapi.TYPE_FILE, required=False
            ),
        ],
        responses={201: "Note berhasil dibuat", 400: "Gagal membuat Note"}
    )
    @action(detail=False, methods=['post'], url_path='create-note')
    def create_note(self, request):
        images = request.FILES.getlist('images')  # Ambil daftar gambar dari request
        serializer = CreateNoteSerializer(data=request.data)

        if serializer.is_valid():
            with transaction.atomic(): 
                note = serializer.save()  
                
                image_instances = []

                for img in images:
                    if not img.name.lower().endswith(".webp"):
                        compressed = compress_image(img)
                        img = ContentFile(compressed.read(), name=img.name)
                    
                    image_instances.append(ImageNoteWarga(note=note, image=img))

                ImageNoteWarga.objects.bulk_create(image_instances)

            return custom_response(serializer.data, status=status.HTTP_201_CREATED)

        return custom_error_response(serializer.errors, status_code=status.HTTP_400_BAD_REQUEST)


class ImageTagihanWargaViewSet(viewsets.ModelViewSet):
    queryset = ImageNoteWarga.objects.all()
    serializer_class = ImageNoteWargaSerializer


class PublishTagihanView(APIView):

    def generate_tagihan_onetime(self, tagihan):
        unit = MUnit.objects.filter(unit_residence=tagihan.residence).all()
        tagihan_ke = tagihan.tagihan_ke
        if tagihan_ke == None:
            tagihan_ke = 0
        for u in unit:
            no_tagihan = "T-" + str(u.unit_id) + "-" + str(tagihan.id)
            date = tagihan.date_due
            if tagihan.jenis_tagihan == "monthly":
                date = tagihan.date_due + relativedelta(months=tagihan_ke)
            elif tagihan.jenis_tagihan == "yearly":
                date = tagihan.date_due + relativedelta(years=tagihan_ke)
            elif tagihan.jenis_tagihan == "weekly":
                date = tagihan.date_due + relativedelta(weeks=tagihan_ke)
            TagihanWarga.objects.create(
                    tagihan_id=tagihan.id,
                    date_due=date,
                    unit_id=u,
                    no_tagihan=no_tagihan,
                    status="unpaid"
                )
        tagihan_ke = tagihan_ke+1

            
        return  tagihan_ke

    def post(self, request, pk=None):
        try:
            tagihan = Tagihan.objects.get(id=pk)
            tagihan.is_publish = True
            tagihan.publish_date = timezone.now()  # Set publish date to now
            tagihan.tagihan_ke =  self.generate_tagihan_onetime(tagihan)
            tagihan.save()
            serializer = TagihanSerializer(tagihan)
            return custom_response(serializer.data, status=200)
        except Tagihan.DoesNotExist:
            return custom_error_response('Tagihan tidak ditemukan', status_code=404)
     

class UnpublishTagihanView(APIView):
    permission_classes = [IsAuthenticated]
    authentication_classes = [TokenJWTAuthentication]

    @swagger_auto_schema(
        manual_parameters=[
            openapi.Parameter(
                'tagihan_id',
                openapi.IN_PATH,
                description="ID Tagihan untuk filter catatan",
                type=openapi.TYPE_INTEGER
            )
        ],
        responses={200: NoteUnpublishTagihanSerializer(many=True)}
    )
    def get(self, request, tagihan_id):
        tagihan_notes = TagihanUnpublishNote.objects.filter(tagihan=tagihan_id)
        serializer = NoteUnpublishTagihanSerializer(tagihan_notes, many=True)
        return custom_response(serializer.data, status=status.HTTP_200_OK)

    @swagger_auto_schema(
        manual_parameters=[
            openapi.Parameter(
                'tagihan_id',
                openapi.IN_PATH,
                description="ID Tagihan untuk filter catatan",
                type=openapi.TYPE_INTEGER
            )
        ],
        request_body=openapi.Schema(
            type=openapi.TYPE_OBJECT,
            properties={
                'note': openapi.Schema(type=openapi.TYPE_STRING, description="Note")
            },
            required=['note']
        )
    )
    def post(self, request, tagihan_id):
        try:            
            user = request.user
            user_id = user.user_id
            if user_id == None:
                return None
            user = MUser.objects.filter(user_id=user_id).first()
            
            tagihan = Tagihan.objects.get(id=tagihan_id)
            tagihan.is_publish = False
            tagihan.is_active = False
            tagihan.save()

            TagihanUnpublishNote.objects.create(
                tagihan=tagihan,
                note=request.data.get('note'),
                created_by=user
            )

            serializer = TagihanSerializer(tagihan)
            return custom_response(serializer.data, status=status.HTTP_200_OK)

        except Tagihan.DoesNotExist:
            return custom_error_response('Tagihan tidak ditemukan', status_code=404)
        
@swagger_auto_schema(
    method='get',
    operation_description="Generate PDF rincian pembayaran IPL bulan Agustus 2021",
    responses={200: openapi.Response(description="PDF file")},
)
@api_view(['GET'])
def generate_ipl_pdf(request):
    buffer = BytesIO()
    doc = SimpleDocTemplate(buffer, pagesize=A4)
    elements = []

    styles = getSampleStyleSheet()
    title = Paragraph("RINCIAN PEMBAYARAN IPL BULAN AGUSTUS 2021", styles['Title'])
    elements.append(title)
    elements.append(Spacer(1, 12))

    # Data untuk tabel
    data = [
        ['No', 'Nomor Rumah', 'Tgl Bayar', 'Nominal', 'Keterangan'],
        ['1', 'G101', '3-Aug', '100.000', ''],
        ['2', 'G105', '5-Aug', '200.000', ''],
        ['3', 'G107', '18-Aug', '200.000', ''],
        ['4', 'G108', '2-Aug', '100.000', ''],
        ['5', 'G112', '30-Aug', '200.000', ''],
        ['6', 'G117', '2-Aug', '200.000', ''],
        ['7', 'G201', '2-Aug', '300.000', ''],
    ]

    # Membuat tabel
    table = Table(data, colWidths=[40, 90, 90, 80, 100])
    table.setStyle(TableStyle([
        ('BACKGROUND', (0,0), (-1,0), colors.lightgrey),
        ('GRID', (0,0), (-1,-1), 1, colors.black),
        ('ALIGN', (0,0), (-1,-1), 'CENTER'),
        ('FONTNAME', (0,0), (-1,0), 'Helvetica-Bold'),
        ('BOTTOMPADDING', (0,0), (-1,0), 12),
    ]))

    elements.append(table)

    doc.build(elements)

    buffer.seek(0)
    return HttpResponse(
        buffer,
        content_type='application/pdf',
        headers={
            'Content-Disposition': 'attachment; filename="rincian_pembayaran_ipl_agustus_2021.pdf"'
        }
    )