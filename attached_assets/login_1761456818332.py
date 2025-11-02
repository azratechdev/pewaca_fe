from rest_framework import serializers

class LoginSerializer(serializers.Serializer):
    email = serializers.EmailField(
        required=True,
        error_messages={'required': 'Email tidak boleh kosong.'}
    )
    password = serializers.CharField(
        write_only=True,
        required=True,
        error_messages={'required': 'Password tidak boleh kosong.'}
    )
