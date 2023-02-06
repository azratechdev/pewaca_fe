<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h3 class="modal-title"><b>Add New User</b></h3>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
            <form id="userform" method="post" action="{{ route('store') }}" enctype="multipart/form-data">
                {{ csrf_field() }}
                <div class="form-group row">
                    <label class="col-sm-2">Username</label>
                    <div class="col-sm-6">
                        <input type="text" name="name" id="name" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Email</label>
                    <div class="col-sm-6">
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Password</label>
                    <div class="col-sm-6">
                        <input type="password" name="password" id="password" minlength="6" class="form-control" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Role</label>
                    <div class="col-sm-6">
                        <select type="text" name="role" id="role" class="form-control" required>
                            <option>Select User Role</option>
                            @foreach($role as $key => $v)
                            <option value="{{ $v['name'] }}">{{ $v['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="form-group row">
                    <label class="col-sm-2">Is Active</label>
                    <div class="col-sm-3">
                        <select type="text" name="isactive" id="isactive" class="form-control" required>
                            <option value="0">No</option>
                            <option value="1" selected>Yes</option>
                        </select>
                    </div>
                </div>
               
        </div>
        <div class="modal-footer">
            <button type="submit" class="btn btn-primary btn-sm fas fa-floopy">Save</button>
            <a href="{{ route('users') }}" class="btn btn-sm btn-danger" data-dismiss="modal">Cancel</a>
        </div>
      </div>
    </form>
    </div>
</div>