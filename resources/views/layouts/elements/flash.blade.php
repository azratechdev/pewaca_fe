@if(Session::has('flash-message'))
    <div class="alert alert-dismissible  {{ Session::get('flash-message.alert-class') }} fade show" role="alert">
        @if (Session::get('flash-message.alert-class') == "alert-success")
            <p style="color: green; margin: 0; font-weight: bold;">
                {{ Session::get('flash-message.message') }}
            </p>
        @else    
            <p style="color: orange; margin: 0; font-weight: bold;">
                {{ Session::get('flash-message.message') }}
            </p>
        @endif
        {{-- <strong>{{ Session::get('flash-message.message') }}</strong> --}}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif