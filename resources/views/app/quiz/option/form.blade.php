@extends('app.quiz.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-list"></i> Opções da Campanha {{$quizCampaign->id}}</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Campanha {{$quizCampaign->id}}</li>
          <li class="breadcrumb-item"><a href="{{url('app/campanha/'.$quizCampaign->slug.'/opcoes')}}">Opções</a></li>
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
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Opção da Campanha {{$quizCampaign->id}}</h3>
            <div class="tile-body">
              
              @if(isset($item))
                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/opcoes/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @else 
                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/opcoes','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @endif
              
                @if(isset($item->id))

                <div class="row">
                  <div class="col-12 alert alert-primary text-center" role="alert">
                                                
                      {{$item->getDescription()}}  
                      
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                
                <input type="hidden" name="quiz_campaign_id" value="{{ old('quiz_campaign_id',isset($item->quiz_campaign_id)?$item->quiz_campaign_id:$quizCampaign->id) }}" />

                <div class="form-group">
                  <label class="control-label">Questão (pergunta) *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control {{ $errors->has('quiz_question_id')? 'is-invalid':'' }}" required="required" id="quiz_question_id" name="quiz_question_id">
                    @if($questions->count())
                      <option value="">            
                        Selecione a Questão
                      </option>
                    @endif
                    @forelse($questions as $question)
                      <option value="{{$question->id}}" {{ old('quiz_question_id') == $question->id ? "selected='selected'" : isset($item->quiz_campaign_id) && $item->quiz_question_id == $question->id ? "selected='selected'" : '' }}>
                        {{$question->description}}
                        @if($question->quiz_questionable_id) 
                          <span class="badge badge-light">{{$question->quiz_questionable->nable()}}</span>
                        @endif
                        ?
                      </option>
                    @empty
                      <option value="">            
                        Nenhuma Questão (Multipla Escolha) Cadastrada
                      </option>                    
                    @endforelse
                  </select>
                  {!! $errors->has('quiz_question_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('quiz_question_id').'</small>':'' !!}
                  </div>                    
                  
                <div class="form-group">
                  <label class="control-label">Descrição 1</label>
                  <textarea rows="3" name="description" class="form-control {{ $errors->has('description')? 'is-invalid':'' }}" id="description" placeholder="Exemplo: Vereador + <descricao 2>">{{ old('description',isset($item->description)?$item->description:'') }}</textarea>
                  <small id="passwordHelpBlock" class="form-text text-danger">Preencha a Descrição 1 ou a Descrição 2</small>
                </div>
                

                <div class="form-group">
                  <label class="control-label">Descrição 2:  <small><i>(se ambas forem preenchidas a Descrição 2 acrescenta no final da Descrição 1)</i></small></label>
                  <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizOptionableName(this.value)" id="change_quiz_optionable_name_select" class="form-control">
                    <option value="">            
                      Selecione uma Opção
                    </option>
                    <option value="">            
                      Somente a Descrição 1
                    </option>
                    <option value="political_party_id" {{isset($item)&&$item->quiz_optionable_name=='political_party_id'?"selected='selected'":''}}">Um Partido Politico</option>
                    <option value="politic_id" {{isset($item)&&$item->quiz_optionable_name=='politic_id'?"selected='selected'":''}}">Um Politico</option>
                    <option value="state_id" {{isset($item)&&$item->quiz_optionable_name=='state_id'?"selected='selected'":''}}">Um Estado</option>
                    <option value="city_id" {{isset($item)&&$item->quiz_optionable_name=='city_id'?"selected='selected'":''}}">Uma Cidade</option>
                    <option value="district_id" {{isset($item)&&$item->quiz_optionable_name=='district_id'?"selected='selected'":''}}">Um Bairro</option>
                  </select>                  
                </div>                  
                
                <input type="hidden" name="quiz_optionable_id" id="quiz_optionable_id" value="{{ old('quiz_optionable_id',isset($item->quiz_optionable_id)?$item->quiz_optionable_id:' ') }}" />
                <input type="hidden" name="quiz_optionable_type" id="quiz_optionable_type" value="{{ old('quiz_optionable_type',isset($item->quiz_optionable_type)?$item->quiz_optionable_type:' ') }}" />
                <input type="hidden" name="quiz_optionable_name" id="quiz_optionable_name" value="{{ old('quiz_optionable_name',isset($item->quiz_optionable_name)?$item->quiz_optionable_name:' ') }}" />

                <hr />
                <!-- quiz_optionable_name == political_party_id / start--> 
                <div id="political_party_id">  
                  <div class="form-group">
                    <label class="control-label">Partido Politico</label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizOptionableId(this.value)" class="form-control" id="political_party_id_select" name="political_party_id_select">
                      @if($political_parties->count())
                      <option value="">Selecione o Partido Politico</option>
                      @endif
                      @forelse($political_parties as $political_party)
                        <option value="{{$political_party->id}}" {{ isset($item->quiz_optionable_name) && $item->quiz_optionable_name == 'political_party_id' && $item->quiz_optionable_id == $political_party->id ? "selected='selected'" : '' }}>
                          {{$political_party->name}}
                        </option>
                      @empty
                        <option value="">            
                          Nenhum Partido Politico foi cadastrado ainda
                        </option>
                      @endforelse
                    </select>
                  </div>  
                </div>
                <!-- quiz_optionable_name == political_party_id / end--> 
                
                <!-- quiz_optionable_name == politic_id / start--> 
                <div id="politic_id">  
                  <div class="form-group">
                    <label class="control-label">Politico</label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizOptionableId(this.value)" class="form-control" id="politic_id_select" name="politic_id_select">
                      @if($politics->count())
                      <option value="">Selecione o Politico</option>
                      @endif
                      @forelse($politics as $politic)
                        <option value="{{$politic->id}}" {{ isset($item->quiz_optionable_name) && $item->quiz_optionable_name == 'political_id' && $item->quiz_optionable_id == $politic->id ? "selected='selected'" : '' }}>
                          {{$politic->political_office->name}}: {{$politic->name}}
                        </option>
                      @empty
                        <option value="">            
                          Nenhum Politico foi cadastrado ainda
                        </option>
                      @endforelse
                    </select>
                  </div>  
                </div>
                <!-- quiz_optionable_name == politic_id / end--> 
                
                <!-- quiz_optionable_name == state_id / start-->                          
                <div id="state_id">  
                  
                  <div class="form-group">
                    <label class="control-label">Estado/UF </label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizOptionableId(this.value)" class="form-control" id="state_id_select" name="state_id_select">
                      <option value="">            
                        Selecione o Estado
                      </option>
                      @foreach($states as $state)
                        <option value="{{$state->id}}" {{ isset($item->quiz_optionable_name) && $item->quiz_optionable_name == 'state_id' && $item->quiz_optionable_id == $state->id ? "selected='selected'" : '' }}>
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
                    <label class="control-label">Cidade </label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizOptionableId(this.value)" class="form-control" id="city_id_select" name="city_id_select">
                      <option value="">            
                        Selecione a Cidade
                      </option>
                      @foreach($cities as $city)
                        <option value="{{$city->id}}" {{ isset($item->quiz_optionable_name) && $item->quiz_optionable_name == 'city_id' && $item->quiz_optionable_id == $city->id ? "selected='selected'" : '' }}>
                          
                          {{$city->title}} / {{$city->state->letter}}
                        </option>
                      @endforeach
                    </select>
                  </div>  
                
                </div>    
              <!-- quiz_optionable_name == city_id / end-->    
                  
                <!-- quiz_optionable_name == district_id / start-->
                <div id="district_id">  
          
                  <div class="form-group">
                    <label class="control-label">Bairro </label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizOptionableId(this.value)" class="form-control" id="district_id_select" name="district_id_select">
                      @if($districts->count())
                      <option value="">Selecione o Bairro</option>
                      @endif
                      @forelse($districts as $district)                        
                        <option value="{{$district->id}}" {{ isset($item->quiz_optionable_name) && $item->quiz_optionable_name == 'district_id' && $item->quiz_optionable_id == $district->id ? "selected='selected'" : '' }}>
                          {{$district->name}}, {{$district->city->title}}/{{$district->city->state->letter}}
                        </option>
                      @empty
                        <option value="">            
                          Nenhum Bairro foi cadastrado ainda
                        </option>
                      @endforelse
                    </select>
                  </div> 
                                 
                </div>    
              <!-- quiz_optionable_name == district_id / end--> 
                                
              <hr />
                                             

                                                                               
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit" id="save"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('app/campanha/'.$quizCampaign->slug.'/opcoes/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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

      var quiz_optionable_types = {
        political_party_id : 'App\\Domain\\Political\\Model\\PoliticalParty',
        politic_id : 'App\\Domain\\Political\\Model\\Politic',
        state_id : 'App\\Domain\\City\\Model\\State',
        city_id : 'App\\Domain\\City\\Model\\City',
        district_id : 'App\\Domain\\City\\Model\\District'
      };
        
  jQuery(document).ready(function(){
      
    changeQuizOptionableName("{{isset($item)&&isset($item->quiz_optionable_name)?$item->quiz_optionable_name:''}}");
    changeQuizOptionableId("{{isset($item)&&isset($item->quiz_optionable_id)?$item->quiz_optionable_id:''}}");
    

    
    
    
  });
      
    function changeQuizOptionableName(quiz_optionable_name = null){    

      $('#save').prop('disabled', false);
      
      jQuery('#political_party_id').hide();
      jQuery('#politic_id').hide();
      jQuery('#state_id').hide();
      jQuery('#city_id').hide();
      jQuery('#district_id').hide();
      
      quiz_optionable_id = '';
      quiz_optionable_type = '';
              
      if(quiz_optionable_name){
              
        $('#save').prop('disabled', true);
        
        quiz_optionable_type =  quiz_optionable_types[quiz_optionable_name];
        jQuery('#'+quiz_optionable_name).show(); 
        

      }
            
      jQuery('#quiz_optionable_id').val(quiz_optionable_id);
      jQuery('#quiz_optionable_type').val(quiz_optionable_type);
      jQuery('#quiz_optionable_name').val(quiz_optionable_name);
      
    }
    function changeQuizOptionableId(quiz_optionable_id = null){

      jQuery('#quiz_optionable_id').val(quiz_optionable_id);
      
      $('#save').prop('disabled', true);
      if(parseInt(quiz_optionable_id)){
        $('#save').prop('disabled', false);
      }
    }
  </script>
@endsection  