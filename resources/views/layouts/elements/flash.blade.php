@if(Session::has('flash-message'))
    <div class="alert alert-dismissible {{ Session::get('flash-message.alert-class') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ Session::get('flash-message.message') }}
    </div>
@endif