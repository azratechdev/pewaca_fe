@if(Session::has('flash-message'))
    {{-- <div class="alert alert-dismissible {{ Session::get('flash-message.alert-class') }}">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        {{ Session::get('flash-message.message') }}
    </div> --}}

    <div class="alert alert-dismissible  {{ Session::get('flash-message.alert-class') }} fade show" role="alert">
        <strong>{{ Session::get('flash-message.message') }}</strong>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif