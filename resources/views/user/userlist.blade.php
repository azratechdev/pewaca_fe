@extends('layouts.basetemplate')
@section('content')
 
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12 col-sm-12">
            <div class="white-box">
                <div class="row">
                    <div class="col-md-6"><h3><b>Users</b></h3></div>
                    <div class="col-md-6 text-right">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#userModal">
                            <i class="icon-user-follow"></i> Add User
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
                                <td>{{ $v['role']['name'] }}</td>
                                <td>{{ $v['is_active'] }}</td>
                                <td><button class="btn btn-xs btn-success" id="edit_user" onClick="edit_user({{ $v['id'] }});" data-id="{{ $v['id'] }}" title="Edit User"><i class="icon-pencil"></i></button> 
                                    <a class="btn btn-xs btn-danger" title="Delete User"><i class="icon-trash"></i></a>
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

<script>
    
    $(function() {
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
@endsection
