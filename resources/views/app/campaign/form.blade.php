@extends('app.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-braille"></i> Campanhas</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('app/campanhas')}}">Campanhas</a></li>
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
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Campanha</h3>
            <div class="tile-body">
              
              @if(isset($item))
                {!! Form::open(['url' => 'app/campanhas/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @else 
                {!! Form::open(['url' => 'app/campanhas','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @endif
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                <div class="form-group">
                  <label class="control-label">URL / Sem espaços e tudo minusculo (ex:campanha-teste)*</label>
                  <input type="text" required="required" {{isset($show)?"disabled='disabled'":''}} name="slug" value="{{ old('slug',isset($item->slug)?$item->slug:' ') }}" class="form-control {{ $errors->has('slug')? 'is-invalid':'' }}" id="slug" placeholder="campanha-teste">
                  {!! $errors->has('slug')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('slug').'</small>':'' !!}
                </div> 
                
                <div class="form-group">
                  <label class="control-label">Descrição *</label>
                  <textarea rows="3" required="required" name="description" class="form-control {{ $errors->has('description')? 'is-invalid':'' }}" id="description">{{ old('description',isset($item->description)?$item->description:'') }}</textarea>
                  {!! $errors->has('description')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('description').'</small>':'' !!}
                </div>       

     
                            
                <div class="form-group">
                  <label class="control-label">Status</label>
                  <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('active')? 'is-invalid':'' }}" id="active" name="active">

                      <option value="0" {{ old('active') == "0" ? "selected='selected'" : isset($item->active) && $item->active == "0" ? "selected='selected'" : "" }}>
                        Não Ativa
                      </option>
                      <option value="1" {{ old('active') == "1" ? "selected='selected'" : isset($item->active) && $item->active == "1" ? "selected='selected'" : "selected='selected'" }}>
                        Ativada
                      </option>                 
                  </select>
                  {!! $errors->has('active')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('active').'</small>':'' !!}
                  </div>                                      

                                                                               
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('app/campanhas/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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