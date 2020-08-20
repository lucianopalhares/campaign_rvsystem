@extends('app.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-male"></i> Politicos</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('app/politicos')}}">Politicos</a></li>
          <li class="breadcrumb-item">{{isset($show)?'Ver':'Formulário'}}</li>
        </ul>
      </div>

      @include('app._utils.flash_msg')

      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Politico</h3>
            <div class="tile-body">
              
              @if(isset($item))
                {!! Form::open(['url' => 'app/politicos/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @else 
                {!! Form::open(['url' => 'app/politicos','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @endif
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                 





                <div class="form-group">
                  <label class="control-label">Pessoa para ser Politico *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control {{ $errors->has('person_id')? 'is-invalid':'' }}" id="person_id" name="person_id">
                    <option value="">            
                      Selecione a Pessoa
                    </option>
                    @foreach($people as $person)
                      <option value="{{$person->id}}" {{ old('person_id') == $person->id ? "selected='selected'" : isset($item->person_id) && $item->person_id == $person->id ? "selected='selected'" : '' }}>
                        {{$person->getFullNameAttribute()}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('person_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('person_id').'</small>':'' !!}
                  </div>  

                <div class="form-group">
                  <label class="control-label">Cargo Politico *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control {{ $errors->has('political_office_id')? 'is-invalid':'' }}" id="political_office_id" name="political_office_id">
                    <option value="">            
                      Selecione o Cargo Politico
                    </option>
                    @foreach($political_offices as $political_office)
                      <option value="{{$political_office->id}}" {{ old('political_office_id') == $political_office->id ? "selected='selected'" : isset($item->political_office_id) && $item->political_office_id == $political_office->id ? "selected='selected'" : '' }}>
                        {{$political_office->name}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('political_office_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('political_office_id').'</small>':'' !!}
                  </div>  

                <div class="form-group">
                  <label class="control-label">Partido Politico *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control {{ $errors->has('political_party_id')? 'is-invalid':'' }}" id="political_party_id" name="political_party_id">
                    <option value="">            
                      Selecione o Partido Politico
                    </option>
                    @foreach($political_parties as $political_party)
                      <option value="{{$political_party->id}}" {{ old('political_party_id') == $political_party->id ? "selected='selected'" : isset($item->political_party_id) && $item->political_party_id == $political_party->id ? "selected='selected'" : '' }}>
                        {{$political_party->name}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('political_party_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('political_party_id').'</small>':'' !!}
                  </div>  
            
                                                                               
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('app/politicos/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
              @endif
            </div>
            {{ Form::close() }}
          </div>
        </div>
        <div class="col-md-3">
        </div>
        <div class="clearix"></div>
      </div>
    </main>
@endsection

@section('page-js')
  
  <script type="text/javascript" src="{{ asset('js/plugins/select2.min.js') }}"></script>
  <script type="text/javascript">
    $('select').select2();



</script>
@endsection  