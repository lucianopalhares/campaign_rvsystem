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

                <div class="row">
                  <div class="col-5">
                    <div class="form-group">
                    <label class="control-label">Estado da Campanha *</label>
                    <select {{isset($show)?"disabled='disabled'":''}} required="required" onchange="changeState(this.value)" class="form-control {{ $errors->has('state_id')? 'is-invalid':'' }}" id="state_id" name="state_id">
                      <option value="">            
                        Selecione
                      </option>   
                      @foreach($states as $state)
                        <option value="{{$state->id}}" {{ old('state_id') == $state->id ? "selected='selected'" : isset($item->state_id) && $item->state_id == $state->id ? "selected='selected'" : '' }}>
                          {{$state->title}}
                        </option>
                      @endforeach
                    </select>
                    {!! $errors->has('state_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('state_id').'</small>':'' !!}
                    </div>                      
                  </div>
                  <div class="col-7">
                    <div class="form-group">
                    <label class="control-label">Cidade da Campanha *</label>
                    <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control {{ $errors->has('city_id')? 'is-invalid':'' }}" id="city_id" name="city_id">
                                 
                      <option value="">            
                        Primeiro Selecione o Estado
                      </option>
                    </select>
                    {!! $errors->has('city_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('city_id').'</small>':'' !!}
                    </div>                    
                  </div>
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

  jQuery(document).ready(function(){
    
    var state_id_selected = "{{ old('state_id', isset($item) ? $item->state_id : '') }}";
    var city_id_selected = "{{ old('city_id', isset($item) ? $item->city_id : '') }}";    
    changeState(state_id_selected,city_id_selected);


  });
      
    function changeState(state_id,city_selected = null){
                      
        var token = $("meta[name='csrf-token']").attr("content");
        var select_city = document.getElementById("city_id");        
                        
        if(!parseInt(state_id)) return false;
        
          select_city.options.length = 0;
                          
          $.ajax({
            url: "{{url('api/cities/')}}"+"/"+state_id, 
            type: 'get',
            dataType: "json",
            data: {
              _token: token,
                  id: state_id,
                  _method: 'get'
                },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function (data){
                
                select_city.options[select_city.options.length] = new Option('Selecione',' ');
                for(index in data) {
                    if(data[index]['id']==parseInt(city_selected)){
                      select_city.options[select_city.options.length] = new Option(data[index]['title'], data[index]['id'],true,true);
                    }else{
                      select_city.options[select_city.options.length] = new Option(data[index]['title'], data[index]['id']);
                    } 
                }
              }
          });      
    }
  </script>
@endsection  