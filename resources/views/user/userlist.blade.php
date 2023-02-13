@extends('layouts.basetemplate')
@section('content')
 
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            @include('layouts.elements.flash')
            <div class="white-box">
                <div class="row">
                    <div class="col-md-6"><h3><b>Users</b></h3></div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addModal">
                            <i class="fa fa-user-plus" aria-hidden="true"></i> Add User
                        </button>
                    </div>
                </div>
                <br>
                <div class="table-responsive">
                    <table id="myTable" class="display nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Is Active</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No.</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Is Active</th>
                                <th>Action</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach ($data as $key => $v )
                            <tr>
                                <td>{{ $key+1 }}</td>
                                <td>{{ $v['name'] }}</td>
                                <td>{{ $v['email'] }}</td>
                                <td>{{ $v['roles'][0]['name'] }}</td>
                                <td>@if($v['is_active'] == 1) Yes @else No @endif</td>
                                <td>
                                    <button class="btn btn-xs btn-success" id="edit_user" data-id="{{ $v['id'] }}" title="Edit User">
                                        <i class="fa fa-pencil" aria-hidden="true"></i>
                                    </button> 
                                    <button class="btn btn-xs btn-danger" id="delete_user" data-id="{{ $v['id'] }}" title="Delete User">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

@include('user.add')
@include('user.edit')   
@include('user.confirm') 

<script>
    $(document).ready(function() {

        $('#myTable').dataTable();

        var table = $('#myTable').dataTable({
            "retrieve": true,
            "columnDefs": [{
                "visible": false,
                "targets": 2
            }],
            "order": [
                [2, 'asc']
            ],
            "displayLength": 25,
            "drawCallback": function(settings) {
                var api = this.api();
                var rows = api.rows({
                    page: 'current'
                }).nodes();
                var last = null;
                api.column(2, {
                    page: 'current'
                }).data().each(function(group, i) {
                    if (last !== group) {
                        $(rows).eq(i).before('<tr class="group"><td colspan="5">' + group + '</td></tr>');
                        last = group;
                    }
                });
            }
        });
        // Order by the grouping
        $('#myTable tbody').on('click', 'tr.group', function() {
            var currentOrder = table.order()[0];
            if (currentOrder[0] === 2 && currentOrder[1] === 'asc') {
                table.order([2, 'desc']).draw();
            } else {
                table.order([2, 'asc']).draw();
            }
        });
    });

</script>
<script>
$.ajaxSetup({
    headers:{
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
$(document).ready(function(){
   
    $('button#edit_user').click(function(){
        var id = $(this).attr('data-id');
        var token = "<?php echo csrf_token(); ?>";
        //alert(token);
        $.ajax({
            url: "{{ route('getUser') }}",
            method: "POST",
            cache: false,
            data: {
                '_token': token, 
                'id':id
            },
            success: function(response) { 
                var url = "{{ route('update', ':id') }}";
                url = url.replace(':id', response['data']['id']);
                $('form#user_editform').attr("action", url);

               $('#modalEdit').modal('show');
               $('input#edit_id').val(response['data']['id']);
               $('input#edit_name').val(response['data']['name']);
               $('input#edit_email').val(response['data']['email']);
               $('select#edit_role').val(response['data']['roles'][0]['name']);
               $('select#edit_role').attr('selected');
               $('select#edit_isactive').val(response['data']['is_active']);
               $('select#edit_isactive').attr('selected');
               //alert(response['data']['name']);

               
            }
           
        });
    });

    $('button#delete_user').click(function(){
        var id = $(this).attr('data-id');
        var url = "{{ route('destroy', ':id') }}";
        $('#confirmModal').modal('show');
        $('button#submit_delete').click(function(){
            url = url.replace(':id', id);
            location.href = url;
        });
    });
});
</script>
@endsection
