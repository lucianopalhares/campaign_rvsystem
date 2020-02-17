@extends('app.quiz.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-quora"></i> Questões da Campanha {{$quizCampaign->id}}</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Campanha {{$quizCampaign->id}}</li>
          <li class="breadcrumb-item"><a href="{{url('app/campanha/'.$quizCampaign->slug.'/questoes')}}">Questões</a></li>
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
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Questão da Campanha {{$quizCampaign->id}}</h3>
            <div class="tile-body">
              
              @if(isset($item))
                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/questoes/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @else 
                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/questoes','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @endif
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                  
                  
                <div class="form-group">
                  <label class="control-label">Pergunta *</label>
                  <textarea rows="3" required="required" name="description" class="form-control {{ $errors->has('description')? 'is-invalid':'' }}" id="description" placeholder="Exemplo: Você concorda com os gastos do atual prefeito <adicional da pergunta> ?">{{ old('description',isset($item->description)?$item->description:'') }}</textarea>
                  {!! $errors->has('description')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('description').'</small>':'' !!}
                </div>
                

                <div class="form-group">
                  <label class="control-label">Adicionar no final da pergunta:</label>
                  <select {{isset($show)?"disabled='disabled'":''}} onchange="changeAdd(this.value)" required class="form-control {{ $errors->has('state_id')? 'is-invalid':'' }}" required="required" id="state_id" name="state_id">
                    <option value="">            
                      Não adicionar
                    </option>
                    <option value="political_party_id">Um Partido Politico</option>
                    <option value="political_id">Um Politico</option>
                    <option value="state_id">Um Estado</option>
                    <option value="city_id">Uma Cidade</option>
                    <option value="district_id">Um Bairro</option>
                  </select>
                  <small id="passwordHelpBlock" class="form-text text-secondary" id="change_add">* apenas um é permitido</small>
                  </div>  

                <!-- quiz_optionable_name == political_party_id / start--> 
                <div id="political_party_id">  
                  <div class="form-group">
                    <label class="control-label">Partido Politico</label>
                    <select {{isset($show)?"disabled='disabled'":''}} class="form-control" id="political_party_id_select" name="political_party_id_select">
                      <option value="">            
                        Selecione o Partido
                      </option>
                      @foreach($political_parties as $political_party)
                        <option value="{{$political_party->id}}" {{ isset($item->quiz_questionable_name) && $item->quiz_questionable_name == 'political_party_id' && $item->quiz_questionable_id == $political_party->id ? "selected='selected'" : '' }}>
                          {{$political_party->name}}
                        </option>
                      @endforeach
                    </select>
                  </div>  
                </div>
                <!-- quiz_optionable_name == political_party_id / end--> 
                
                <!-- quiz_optionable_name == politic_id / start--> 
                <div id="politic_id">  
                  <div class="form-group">
                    <label class="control-label">Politico</label>
                    <select {{isset($show)?"disabled='disabled'":''}} class="form-control" id="politic_id_select" name="politic_id_select">
                      <option value="">            
                        Selecione o Politico
                      </option>
                      @foreach($politics as $politic)
                        <option value="{{$politic->id}}" {{ isset($item->quiz_questionable_name) && $item->quiz_questionable_name == 'political_id' && $item->quiz_questionable_id == $politic->id ? "selected='selected'" : '' }}>
                          {{$politic->name}}
                        </option>
                      @endforeach
                    </select>
                  </div>  
                </div>
                <!-- quiz_optionable_name == politic_id / end--> 
                
                <!-- quiz_optionable_name == state_id / start-->                          
                <div id="state_id">  
                  
                  <div class="form-group">
                    <label class="control-label">Estado/UF </label>
                    <select {{isset($show)?"disabled='disabled'":''}} class="form-control" required="required" id="state_id_select" name="state_id_select">
                      <option value="">            
                        Selecione o Estado
                      </option>
                      @foreach($states as $state)
                        <option value="{{$state->id}}" {{ isset($item->quiz_questionable_name) && $item->quiz_questionable_name == 'state_id' && $item->quiz_questionable_id == $state->id ? "selected='selected'" : '' }}>
                          {{$state->title}}
                        </option>
                      @endforeach
                    </select>
                  </div>  
                  
                </div>
                <!-- quiz_optionable_name == state_id / end-->
                
                <!-- quiz_optionable_name == city_id / start-->
                <div id="city_id">  
          
                  <div class="form-group">
                    <label class="control-label">Estado/UF</label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="city_id_changeState(this.value)" class="form-control">
                      <option value="">            
                        Selecione o Estado
                      </option>
                      @foreach($states as $state)
                        <option value="{{$state->id}}" {{ isset($item->quiz_questionable_name) && $item->quiz_questionable_name == 'city_id' ? $item->quiz_questionable->state_id == $state->id ? "selected='selected'" : '' : '' }}>
                          {{$state->title}}
                        </option>
                      @endforeach
                    </select>                  
                  </div>  

                  <div class="form-group">
                    <label class="control-label">Cidade</label>
                    <select {{isset($show)?"disabled='disabled'":''}} class="form-control" id="city_id_select" name="city_id_select">
                      <option value="">            
                        Primeiro Selecione o Estado
                      </option>
                    </select>
                  </div>
                
              </div>    
              <!-- quiz_optionable_name == city_id / end-->    
                  
                <!-- quiz_optionable_name == district_id / start-->
                <div id="district_id">  
          
                  <div class="form-group">
                    <label class="control-label">Estado/UF</label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="district_id_changeState(this.value)" class="form-control">
                      <option value="">            
                        Selecione o Estado
                      </option>
                      @foreach($states as $state)
                        <option value="{{$state->id}}" {{ isset($item->quiz_questionable_name) && $item->quiz_questionable_name == 'district_id' ? $item->quiz_questionable->city->state_id == $state->id ? "selected='selected'" : '' : '' }}>
                          {{$state->title}}
                        </option>
                      @endforeach
                    </select>                  
                  </div>  

                  <div class="form-group">
                    <label class="control-label">Cidade</label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="district_id_changeCity(this.value)" class="form-control" id="district_id_city_id" name="district_id_city_id">
                      <option value="">            
                        Primeiro Selecione o Estado
                      </option>
                    </select>
                  </div>

                  <div class="form-group">
                    <label class="control-label">Bairro</label>
                    <select {{isset($show)?"disabled='disabled'":''}} class="form-control" id="district_id_select" name="district_id_select">
                      <option value="">            
                        Primeiro Selecione a Cidade
                      </option>
                    </select>
                  </div>                
              </div>    
              <!-- quiz_optionable_name == district_id / end--> 
                                
            
                  <div class="form-group">
                    <label class="control-label">Cidades Teste</label>
                    <select {{isset($show)?"disabled='disabled'":''}} class="form-control">
                      <option value="">            
                        Selecione a Cidade
                      </option>
                      @foreach($cities as $city)
                        <option value="{{$city->id}}">
                          {{$city->title}}
                        </option>
                      @endforeach
                    </select>                  
                  </div> 
                  
                                                              
                <div class="form-group">
                  <label class="control-label">Multipla Escolha <smal><i>('sim' obriga adicionar opções nesta questão)</i></small></label>
                  <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('options_required')? 'is-invalid':'' }}" id="options_required" name="options_required">

                      <option value="0" {{ old('options_required') == "0" ? "selected='selected'" : isset($item->options_required) && $item->options_required == "0" ? "selected='selected'" : "selected='selected'" }}>
                        Não
                      </option>
                      <option value="1" {{ old('options_required') == "1" ? "selected='selected'" : isset($item->options_required) && $item->options_required == "1" ? "selected='selected'" : '' }}>
                        Sim
                      </option>                 
                  </select>
                  {!! $errors->has('options_required')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('options_required').'</small>':'' !!}
                  </div>                                      

                                                                               
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('app/campanha/'.$quizCampaign->slug.'/questoes/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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
    
    function city_id_changeState(state_id,city_id_select_selected = null){
                      
        var token = $("meta[name='csrf-token']").attr("content");
        var city_id_select = document.getElementById("city_id_select");
        city_id_select.options.length = 0;
                        
        if(!parseInt(state_id)) return false;
                          
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
                
                city_id_select.options[city_id_select.options.length] = new Option('Selecione',' ');
                for(index in data) {
                    if(data[index]['id']==parseInt(city_id_select_selected)){
                      city_id_select.options[city_id_select.options.length] = new Option(data[index]['title'], data[index]['id'],true,true);
                    }else{
                      city_id_select.options[city_id_select.options.length] = new Option(data[index]['title'], data[index]['id']);
                    } 
                }
              }
          });      
    }    
    function district_id_changeState(state_id,district_id_city_id_selected = null){
                      
        var token = $("meta[name='csrf-token']").attr("content");
        var district_id_city_id = document.getElementById("district_id_city_id");
        district_id_city_id.options.length = 0;
                        
        if(!parseInt(state_id)) return false;
                          
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
                
                district_id_city_id.options[district_id_city_id.options.length] = new Option('Selecione',' ');
                for(index in data) {
                    if(data[index]['id']==parseInt(district_id_city_id_selected)){
                      district_id_city_id.options[district_id_city_id.options.length] = new Option(data[index]['title'], data[index]['id'],true,true);
                    }else{
                      district_id_city_id.options[district_id_city_id.options.length] = new Option(data[index]['title'], data[index]['id']);
                    } 
                }
              }
          });      
    }        
    function district_id_changeCity(city_id,district_id_selected = null){
                      
        var token = $("meta[name='csrf-token']").attr("content");
        var district_id_select = document.getElementById("district_id_select");
        district_id_select.options.length = 0;
                        
        if(!parseInt(city_id)) return false;
                          
          $.ajax({
            url: "{{url('api/districts/')}}"+"/"+city_id, 
            type: 'get',
            dataType: "json",
            data: {
              _token: token,
                  id: city_id,
                  _method: 'get'
                },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function (data){
                
                district_id_select.options[district_id_select.options.length] = new Option('Selecione',' ');
                for(index in data) {
                    if(data[index]['id']==parseInt(district_id_selected)){
                      district_id_select.options[district_id_select.options.length] = new Option(data[index]['title'], data[index]['id'],true,true);
                    }else{
                      district_id_select.options[district_id_select.options.length] = new Option(data[index]['title'], data[index]['id']);
                    } 
                }
              }
          });      
    }     
  </script>
@endsection  