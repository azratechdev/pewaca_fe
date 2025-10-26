from rest_framework import serializers
from main.models import MCorridor

class MCorridorSerializer(serializers.ModelSerializer):
    class Meta:
        model = MCorridor
        fields = ['id', 'corridor_residence', 'corridor_name', 'corridor_desc', 'corridor_icon', 
                  'corridor_created_by', 'corridor_created_on', 'corridor_modified_by', 
                  'corridor_modified_on', 'corridor_isactive', 'corridor_isdelete']
        read_only_fields = ['corridor_created_on', 'corridor_modified_on']
