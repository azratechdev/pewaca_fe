# api/serializers.py

from rest_framework import serializers
from management_user.models import Role,MRoleWarga

class MRoleSerializer(serializers.ModelSerializer):
    class Meta:
        model = Role
        fields = ['role_id', 'role_name', 'role_desc', 'role_created_by', 'role_created_on', 'role_modified_by', 'role_modified_on', 'role_isactive', 'role_isdelete']
        read_only_fields = ['role_id', 'role_created_on', 'role_modified_by', 'role_modified_on']  # Adjust as needed

class MRoleCreateSerializer(serializers.ModelSerializer):
    class Meta:
        model = Role
        fields = ['role_name', 'role_desc', 'role_isactive', 'role_isdelete']  # Exclude 'role_created_by' here

class MRoleWargaSerializer(serializers.ModelSerializer):
    class Meta:
        model = MRoleWarga
        fields = "__all__"
