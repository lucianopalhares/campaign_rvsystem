@if(session('success'))
    <div class="alert alert-success text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>      
        {!! session('success') !!}
    </div>
@endif
    
@if(session('error'))
    <div class="alert alert-danger text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>
        {!! session('error') !!}
    </div>
@endif

@if (count($errors) > 0)
    <div class="alert alert-danger text-center" role="alert">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span></button>

              <ul style="list-style-type: none">
                  @foreach ($errors->all() as $error)
                     @if(is_array($error)&&count($error)>0)
                        @foreach ($error as $erro)
                          <li>{{ $erro }}</li>
                        @endforeach
                     @else
                      <li>{{ $error }}</li>
                     @endif
                  @endforeach
              </ul>
    </div>
@endif



  