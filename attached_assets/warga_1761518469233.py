
from rest_framework import generics, permissions
from rest_framework.views import APIView
from management_user.models import Warga,WargaRejectionLog,MUser
from api.serializers import WargaSerializer 
from api.utils import custom_response, custom_response_pagination, custom_error_response
from drf_yasg.utils import swagger_auto_schema
from drf_yasg import openapi
from rest_framework.exceptions import ValidationError, NotFound
from django.utils import timezone
from api.utils import TokenJWTAuthentication

class GenderChoiceAPIView(APIView):
    permission_classes = [permissions.AllowAny]

    def get(self, request):
        data = [
            {
                "id": Warga.GENDER_CHOICES[0][0],
                "name": Warga.GENDER_CHOICES[0][1],
            },
            {
                "id": Warga.GENDER_CHOICES[1][0],
                "name": Warga.GENDER_CHOICES[1][1],
            },
        ]
        return custom_response(data=data)

class WargaListView(generics.ListAPIView):
    serializer_class = WargaSerializer
    authentication_classes = [TokenJWTAuthentication]
    permission_classes = [permissions.IsAuthenticated]

    def get_queryset(self):
        
        user = self.request.user
        user_id = user.user_id
        warga_user = Warga.objects.filter(user=user_id).first()

        if not warga_user:
            return Warga.objects.none()

        warga = Warga.objects.filter(residence=warga_user.residence, isdelete=False).order_by('-created_on')

        is_checker_param = self.request.query_params.get('is_checker')
        if is_checker_param is not None:
            is_checker = is_checker_param.lower() == 'true'
            warga = warga.filter(is_checker=is_checker)
            
        isreject_param = self.request.query_params.get('isreject')
        if isreject_param is not None:
            isreject = isreject_param.lower() == 'true'
            warga = warga.filter(isreject=isreject)
        
        search = self.request.query_params.get('search')
        if search:
            warga = warga.filter(full_name__icontains=search) | warga.filter(nik__icontains=search) | warga.filter(user__email__icontains=search)
             
        return warga

    @swagger_auto_schema(
        manual_parameters=[
            openapi.Parameter(
                'is_checker', 
                openapi.IN_QUERY, 
                description="Filter warga by is_checker (true/false)", 
                type=openapi.TYPE_STRING,
                enum=["true", "false"],  
            ),
            openapi.Parameter(
                'isreject', 
                openapi.IN_QUERY, 
                description="Filter warga by isreject (true/false)", 
                type=openapi.TYPE_STRING,
                enum=["true", "false"],  
            ),
            openapi.Parameter(
                'page', 
                openapi.IN_QUERY, 
                description="Page number for pagination", 
                type=openapi.TYPE_INTEGER,
            ),
            # search
            openapi.Parameter(
                'search', 
                openapi.IN_QUERY, 
                description="Search by name, nik, or email", 
                type=openapi.TYPE_STRING,
            ),
        ],
        responses={
            200: WargaSerializer(many=True),
            400: openapi.Response('Bad Request'),
        },
    )
    def get(self, request, *args, **kwargs):
        return super().get(request, *args, **kwargs)

class WargaVerifyView(APIView):
    authentication_classes = [TokenJWTAuthentication]
    permission_classes = [permissions.IsAuthenticated]
    
    @swagger_auto_schema(
        operation_description="Verify a Warga",
        request_body=openapi.Schema(
            type=openapi.TYPE_OBJECT,
            required=['warga_id'],
            properties={
                'warga_id': openapi.Schema(type=openapi.TYPE_INTEGER, description='ID of the Warga to verify')
            }
        ),
        responses={
            200: openapi.Response(description='Warga successfully verified', schema=openapi.Schema(type=openapi.TYPE_OBJECT, properties={
                'message': openapi.Schema(type=openapi.TYPE_STRING, description='Success message')
            })),
            400: openapi.Response(description='Bad Request')
        }
    )
    def post(self, request, *args, **kwargs):
        try:
            user_pengurus = request.user.user_id  # Ganti dari get_user_id_from_token
            warga_id = request.data.get('warga_id')
            if not warga_id:
                return custom_error_response(message={'error': 'warga_id is required'}, status_code=400)
            
            warga = Warga.objects.filter(id=warga_id).first()
            if not warga:
                raise NotFound(detail='Warga not found')
            warga.is_checker = True 
            warga.isreject = False
            warga.modified_by = user_pengurus
            warga.checked_on = timezone.now()
            warga.save()
            return custom_response(data={'message': 'Warga successfully verified'})
        except ValidationError as e:
            return custom_error_response(message={'error': 'Invalid request data'}, status_code=400)
        except NotFound as e:
            return custom_error_response(message={'error': e.detail}, status_code=404)
        except Exception as e:
            return custom_error_response(message={'error': 'Internal Server Error'}, status_code=500)
        except NotFound as e:
            return custom_error_response(message={'error': e.detail}, status_code=404)
        except Exception as e:
            return custom_error_response(message={'error': 'Internal Server Error'}, status_code=500)

class WargaRejectView(APIView):
    authentication_classes = [TokenJWTAuthentication]
    permission_classes = [permissions.IsAuthenticated]
    
    @swagger_auto_schema(
        operation_description="Reject a Warga",
        request_body=openapi.Schema(
            type=openapi.TYPE_OBJECT,
            required=['warga_id', 'reason'],
            properties={
                'warga_id': openapi.Schema(type=openapi.TYPE_INTEGER, description='ID of the Warga to reject'),
                'reason': openapi.Schema(type=openapi.TYPE_STRING, description='Reason for rejection')
            }
        ),
        responses={
            200: openapi.Response(description='Warga successfully rejected', schema=openapi.Schema(type=openapi.TYPE_OBJECT, properties={
                'message': openapi.Schema(type=openapi.TYPE_STRING, description='Success message')
            })),
            400: openapi.Response(description='Bad Request'),
            404: openapi.Response(description='Warga not found'),
            500: openapi.Response(description='Internal Server Error')
        }
    )
    def post(self, request, *args, **kwargs):
        try:
            user_pengurus = request.user.user_id  # Ganti dari get_user_id_from_token
            warga_id = request.data.get('warga_id')
            reason = request.data.get('reason')
            
            if not warga_id:
                return custom_error_response(message={'error': 'warga_id is required'}, status_code=400)
            if not reason:
                return custom_error_response(message={'error': 'reason is required'}, status_code=400)
            
            warga = Warga.objects.filter(id=warga_id).first()
            
            if not warga:
                raise NotFound(detail='Warga not found')
            
            WargaRejectionLog.objects.create(
                warga=warga,
                reason=reason,
                rejected_by=user_pengurus
            )
            
            warga.isreject = True
            warga.modified_by = user_pengurus
            warga.save()
            
            warga.user.username = f'{warga.user.username}_rejected_{warga.user.user_id}'
            warga.user.email = f'{warga.user.email}_rejected_{warga.user.user_id}'
            warga.user.is_active = False
            warga.user.save()
            
            return custom_response(data={'message': 'Warga successfully rejected'})
        
        except ValidationError as e:
            return custom_error_response(message={'error': 'Invalid request data'}, status_code=400)
        except NotFound as e:
            return custom_error_response(message={'error': e.detail}, status_code=404)
        except Exception as e:
            print(e)
            return custom_error_response(message={'error': 'Internal Server Error'}, status_code=500)

class WargaDetailView(generics.RetrieveAPIView):
    serializer_class = WargaSerializer
    authentication_classes = [TokenJWTAuthentication]
    permission_classes = [permissions.IsAuthenticated]
    queryset = Warga.objects.all()
    lookup_field = 'id'

    def retrieve(self, request, *args, **kwargs):
        # Ambil nilai 'id' dari kwargs
        warga_id = kwargs.get(self.lookup_field)
        if not warga_id:
            return custom_response(error="ID is required", status=400)

        try:
            # Pastikan id valid dan instance ditemukan
            instance = self.get_object()
        except Warga.DoesNotExist:
            return custom_response(error=f"Warga with id {warga_id} not found", status=404)

        serializer = self.get_serializer(instance)
        return custom_response(data=serializer.data)
