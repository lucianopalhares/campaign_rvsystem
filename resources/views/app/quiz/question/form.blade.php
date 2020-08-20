@extends('app.quiz.layout.main')

<<<<<<< HEAD
@section('page-css')
<style>
.note-group-select-from-files {
  display: none;
}
.select2-container {
width: 100% !important;
padding: 0;
}
</style>
@endsection

=======
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
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
<<<<<<< HEAD

              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Questão da Campanha {{$quizCampaign->id}}</h3>
            <div class="tile-body">

              @if(isset($item))
                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/questoes/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}

              @else
                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/questoes','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}

              @endif

              @if(isset($item->id))

                <div class="row">
                  <div class="col-12 alert alert-primary text-center" role="alert">
                    {{$item->description}}
                      @if($item->quiz_questionable_id)
=======
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Questão da Campanha {{$quizCampaign->id}}</h3>
            <div class="tile-body">
              
              @if(isset($item))
                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/questoes/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @else 
                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/questoes','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @endif
              
              @if(isset($item->id))
              
                <div class="row">
                  <div class="col-12 alert alert-primary text-center" role="alert">
                    {{$item->description}}
                      @if($item->quiz_questionable_id) 
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                        {{$item->quiz_questionable->nable()}}
                      @endif
                      ?
                  </div>
                </div>
<<<<<<< HEAD

=======
                
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
<<<<<<< HEAD
                </div>
                @endif

                <input type="hidden" name="quiz_campaign_id" value="{{ old('quiz_campaign_id',isset($item->quiz_campaign_id)?$item->quiz_campaign_id:$quizCampaign->id) }}" />


                <div class="form-group">
                  <label class="control-label">Descrição * <small><i>não insira ponto de interrogação (?)</i></small></label>
                  <textarea rows="3" required="required" name="description" class="form-control {{ $errors->has('description')? 'is-invalid':'' }}" id="description" placeholder="Exemplo: Você concorda com os gastos do atual prefeito + <descrição 2 com nome do prefeito>">{{ old('description',isset($item->description)?$item->description:'') }}</textarea>
                  {!! $errors->has('description')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('description').'</small>':'' !!}
                </div>


<!--
                <div class="form-group">
                  <label class="control-label">Descrição 2: * <small><i>(vai ser adicionado no final da Descrição 1)</i></small></label>
                  <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizQuestionableName(this.value)" id="change_quiz_questionable_name_select" class="form-control">
                    <option value="">
                      Selecione
                    </option>
                    <option value="">
=======
                </div>   
                @endif
                
                <input type="hidden" name="quiz_campaign_id" value="{{ old('quiz_campaign_id',isset($item->quiz_campaign_id)?$item->quiz_campaign_id:$quizCampaign->id) }}" />
                  
                  
                <div class="form-group">
                  <label class="control-label">Descrição 1 * <small><i>não insira ponto de interrogação (?)</i></small></label>
                  <textarea rows="3" required="required" name="description" class="form-control {{ $errors->has('description')? 'is-invalid':'' }}" id="description" placeholder="Exemplo: Você concorda com os gastos do atual prefeito + <descrição 2 com nome do prefeito>">{{ old('description',isset($item->description)?$item->description:'') }}</textarea>
                  {!! $errors->has('description')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('description').'</small>':'' !!}
                </div>
                

                <div class="form-group">
                  <label class="control-label">Descrição 2: * <small><i>(vai ser adicionado no final da Descrição 1)</i></small></label>
                  <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizQuestionableName(this.value)" id="change_quiz_questionable_name_select" class="form-control">
                    <option value="">            
                      Selecione
                    </option>
                    <option value="">            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                      Não Adicionar
                    </option>
                    <option value="person_id" {{isset($item)&&$item->quiz_questionable_name=='person_id'?"selected='selected'":''}}">Adicionar uma Pessoa</option>
                    <option value="political_party_id" {{isset($item)&&$item->quiz_questionable_name=='political_party_id'?"selected='selected'":''}}">Adicionar Um Partido Politico</option>
                    <option value="politic_id" {{isset($item)&&$item->quiz_questionable_name=='politic_id'?"selected='selected'":''}}">Adicionar Um Politico</option>
<<<<<<< HEAD

                    <option value="state_id" {{isset($item)&&$item->quiz_questionable_name=='state_id'?"selected='selected'":''}}">Adicionar Um Estado</option>
                    <option value="city_id" {{isset($item)&&$item->quiz_questionable_name=='city_id'?"selected='selected'":''}}">Adicionar Uma Cidade</option>
                    <option value="district_id" {{isset($item)&&$item->quiz_questionable_name=='district_id'?"selected='selected'":''}}">Adicionar Um Bairro</option>

                  </select>
                </div>
-->
=======
                  <!--
                    <option value="state_id" {{isset($item)&&$item->quiz_questionable_name=='state_id'?"selected='selected'":''}}">Adicionar Um Estado</option>
                    <option value="city_id" {{isset($item)&&$item->quiz_questionable_name=='city_id'?"selected='selected'":''}}">Adicionar Uma Cidade</option>
                    <option value="district_id" {{isset($item)&&$item->quiz_questionable_name=='district_id'?"selected='selected'":''}}">Adicionar Um Bairro</option>
                  -->
                  </select>                  
                </div>                  
                
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                <input type="hidden" name="quiz_questionable_id" id="quiz_questionable_id" value="{{ old('quiz_questionable_id',isset($item->quiz_questionable_id)?$item->quiz_questionable_id:' ') }}" />
                <input type="hidden" name="quiz_questionable_type" id="quiz_questionable_type" value="{{ old('quiz_questionable_type',isset($item->quiz_questionable_type)?$item->quiz_questionable_type:' ') }}" />
                <input type="hidden" name="quiz_questionable_name" id="quiz_questionable_name" value="{{ old('quiz_questionable_name',isset($item->quiz_questionable_name)?$item->quiz_questionable_name:' ') }}" />

<<<<<<< HEAD


                <!-- quiz_questionable_name == person_id / start-->
                <div id="person_id">
=======
                <hr />

                <!-- quiz_questionable_name == person_id / start--> 
                <div id="person_id">  
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                  <div class="form-group">
                    <label class="control-label">Pessoa</label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizQuestionableId(this.value)" class="form-control" id="person_id" name="person_id">
                      @if($people->count())
                      <option value="">Selecione a Pessoa</option>
                      @endif
                      @forelse($people as $person)
                        <option value="{{$person->id}}" {{ isset($item->quiz_questionable_name) && $item->quiz_questionable_name == 'person_id' && $item->quiz_questionable_id == $person->id ? "selected='selected'" : '' }}>
                          {{$person->getFullNameAttribute()}}
                        </option>
                      @empty
<<<<<<< HEAD
                        <option value="">
=======
                        <option value="">            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                          Nenhuma Pessoa foi cadastrada ainda
                        </option>
                      @endforelse
                    </select>
<<<<<<< HEAD
                  </div>
                </div>
                <!-- quiz_questionable_name == person_id / end-->

                <!-- quiz_questionable_name == political_party_id / start-->
                <div id="political_party_id">
=======
                  </div>  
                </div>
                <!-- quiz_questionable_name == person_id / end--> 
                
                <!-- quiz_questionable_name == political_party_id / start--> 
                <div id="political_party_id">  
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                  <div class="form-group">
                    <label class="control-label">Partido Politico</label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizQuestionableId(this.value)" class="form-control" id="political_party_id_select" name="political_party_id_select">
                      @if($political_parties->count())
                      <option value="">Selecione o Partido Politico</option>
                      @endif
                      @forelse($political_parties as $political_party)
                        <option value="{{$political_party->id}}" {{ isset($item->quiz_questionable_name) && $item->quiz_questionable_name == 'political_party_id' && $item->quiz_questionable_id == $political_party->id ? "selected='selected'" : '' }}>
                          {{$political_party->name}}
                        </option>
                      @empty
<<<<<<< HEAD
                        <option value="">
=======
                        <option value="">            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                          Nenhum Partido Politico foi cadastrado ainda
                        </option>
                      @endforelse
                    </select>
<<<<<<< HEAD
                  </div>
                </div>
                <!-- quiz_questionable_name == political_party_id / end-->

                <!-- quiz_questionable_name == politic_id / start-->
                <div id="politic_id">
=======
                  </div>  
                </div>
                <!-- quiz_questionable_name == political_party_id / end--> 
                
                <!-- quiz_questionable_name == politic_id / start--> 
                <div id="politic_id">  
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                  <div class="form-group">
                    <label class="control-label">Politico</label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizQuestionableId(this.value)" class="form-control" id="politic_id_select" name="politic_id_select">
                      @if($politics->count())
                      <option value="">Selecione o Politico</option>
                      @endif
                      @forelse($politics as $politic)
                        <option value="{{$politic->id}}" {{ isset($item->quiz_questionable_name) && $item->quiz_questionable_name == 'political_id' && $item->quiz_questionable_id == $politic->id ? "selected='selected'" : '' }}>
                          {{$politic->office->name}}: {{$politic->person->getFullNameAttribute()}}
                        </option>
                      @empty
<<<<<<< HEAD
                        <option value="">
=======
                        <option value="">            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                          Nenhum Politico foi cadastrado ainda
                        </option>
                      @endforelse
                    </select>
<<<<<<< HEAD
                  </div>
                </div>
                <!-- quiz_questionable_name == politic_id / end-->

                <!-- quiz_questionable_name == state_id / start-->
                <div id="state_id">

                  <div class="form-group">
                    <label class="control-label">Estado/UF </label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizQuestionableId(this.value)" class="form-control" id="state_id_select" name="state_id_select">
                      <option value="">
=======
                  </div>  
                </div>
                <!-- quiz_questionable_name == politic_id / end--> 
                
                <!-- quiz_questionable_name == state_id / start-->                          
                <div id="state_id">  
                  
                  <div class="form-group">
                    <label class="control-label">Estado/UF </label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizQuestionableId(this.value)" class="form-control" id="state_id_select" name="state_id_select">
                      <option value="">            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                        Selecione o Estado
                      </option>
                      @foreach($states as $state)
                        <option value="{{$state->id}}" {{ isset($item->quiz_questionable_name) && $item->quiz_questionable_name == 'state_id' && $item->quiz_questionable_id == $state->id ? "selected='selected'" : '' }}>
                          {{$state->title}}
                        </option>
                      @endforeach
                    </select>
<<<<<<< HEAD
                  </div>

                </div>
                <!-- quiz_questionable_name == state_id / end-->

                <!-- quiz_questionable_name == city_id / start-->
                <div id="city_id">

                  <div class="form-group">
                    <label class="control-label">Cidade </label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizQuestionableId(this.value)" class="form-control" id="city_id_select" name="city_id_select">
                      <option value="">
=======
                  </div>  
                  
                </div>
                <!-- quiz_questionable_name == state_id / end-->
                
                <!-- quiz_questionable_name == city_id / start-->
                <div id="city_id">  
          
                  <div class="form-group">
                    <label class="control-label">Cidade </label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizQuestionableId(this.value)" class="form-control" id="city_id_select" name="city_id_select">
                      <option value="">            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                        Selecione a Cidade
                      </option>
                      @foreach($cities as $city)
                        <option value="{{$city->id}}" {{ isset($item->quiz_questionable_name) && $item->quiz_questionable_name == 'city_id' && $item->quiz_questionable_id == $city->id ? "selected='selected'" : '' }}>
<<<<<<< HEAD

=======
                          
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                          {{$city->title}} / {{$city->state->letter}}
                        </option>
                      @endforeach
                    </select>
<<<<<<< HEAD
                  </div>

                </div>
              <!-- quiz_questionable_name == city_id / end-->

                <!-- quiz_questionable_name == district_id / start-->
                <div id="district_id">

=======
                  </div>  
                
                </div>    
              <!-- quiz_questionable_name == city_id / end-->    
                  
                <!-- quiz_questionable_name == district_id / start-->
                <div id="district_id">  
          
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                  <div class="form-group">
                    <label class="control-label">Bairro </label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuizQuestionableId(this.value)" class="form-control" id="district_id_select" name="district_id_select">
                      @if($districts->count())
                      <option value="">Selecione o Bairro</option>
                      @endif
<<<<<<< HEAD
                      @forelse($districts as $district)
                        <option value="{{$district->id}}" {{ isset($item->quiz_questionable_name) && $item->quiz_questionable_name == 'district_id' && $item->quiz_questionable_id == $district->id ? "selected='selected'" : '' }}>
                          @if($district->name)
                            {{$district->name}}
                          @else
=======
                      @forelse($districts as $district)                        
                        <option value="{{$district->id}}" {{ isset($item->quiz_questionable_name) && $item->quiz_questionable_name == 'district_id' && $item->quiz_questionable_id == $district->id ? "selected='selected'" : '' }}>
                          @if($district->name)                          
                            {{$district->name}}
                          @else 
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                            {{$district->type}}
                          @endif
                          @if($district->city_id)
                            ,{{$district->city->title}}/{{$district->city->state->letter}}
                          @endif
                        </option>
                      @empty
<<<<<<< HEAD
                        <option value="">
=======
                        <option value="">            
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
                          Nenhum Bairro foi cadastrado ainda
                        </option>
                      @endforelse
                    </select>
<<<<<<< HEAD
                  </div>

                </div>
              <!-- quiz_questionable_name == district_id / end-->

              <hr />

              <div class="form-group">
                <label class="control-label">Tipo de Resposta *<smal><i></i></small></label>
                <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('type')? 'is-invalid':'' }}" id="type" name="type">

                    <option value="0" {{ old('type') == "0" ? "selected='selected'" : isset($item->type) && $item->type == "0" ? "selected='selected'" : "" }}>
                      Escolher Uma
                    </option>
                    <option value="1" {{ old('type') == "1" ? "selected='selected'" : isset($item->type) && $item->type == "1" ? "selected='selected'" : "" }}>
                      Escolher Mais de Uma
                    </option>
                    <option value="2" {{ old('type') == "2" ? "selected='selected'" : isset($item->type) && $item->type == "2" ? "selected='selected'" : "" }}>
                      Digitar
                    </option>
                </select>
                {!! $errors->has('type')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('type').'</small>':'' !!}
                </div>

                <input type="hidden" name="options_required" value="0" />
                <!--
                <div class="form-group">
                  <label class="control-label">Multipla Escolha <smal><i>('sim' obriga adicionar opções nesta questão)</i></small></label>
                  <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('options_required')? 'is-invalid':'' }}" id="options_required" name="options_required" onchange="multiplaEscolha(this.value)">
=======
                  </div> 
                                 
                </div>    
              <!-- quiz_questionable_name == district_id / end--> 
                                
              <hr />
                  
                                                              
                <div class="form-group">
                  <label class="control-label">Multipla Escolha <smal><i>('sim' obriga adicionar opções nesta questão)</i></small></label>
                  <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('options_required')? 'is-invalid':'' }}" id="options_required" name="options_required">
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af

                      <option value="0" {{ old('options_required') == "0" ? "selected='selected'" : isset($item->options_required) && $item->options_required == "0" ? "selected='selected'" : "" }}>
                        Não
                      </option>
                      <option value="1" {{ old('options_required') == "1" ? "selected='selected'" : isset($item->options_required) && $item->options_required == "1" ? "selected='selected'" : "selected='selected'" }}>
                        Sim
<<<<<<< HEAD
                      </option>
                  </select>
                  {!! $errors->has('options_required')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('options_required').'</small>':'' !!}
                  </div>
-->

                  <div class="flash_msg">

                  </div>


                  <div class="form-group field-quiz-options">
                      <label class="control-label">Adicionar Opções nesta Pergunta </label>
                      @if(isset($item))
                          @foreach($item->options as $option)
                              <div class="input-group" id="option_saved_{{$option->id}}">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fa fa-check"></i></span></div>
                                <input disabled="disabled" type="text" class="form-control" value="{!!strip_tags($option->description)!!}"/>

                                <div class="input-group-append">
                                  <span class="input-group-text">
                                    <a href="javascript:void(0);" onclick="deleteQuizOption('{{$option->id}}')" class="text-danger"><i class="fa fa-trash"></i> </a>
                                  </span>
                                </div>
                              </div>
                          @endforeach
                      @endif
                          <div class="input-group add-option">
                            <div class="input-group-prepend"><span class="input-group-text"></span></div>
                            <input type="text" name="options[]" class="form-control"/>

                            <div class="input-group-append">
                              <span class="input-group-text">
                                <a href="javascript:void(0);" onclick="addFieldQuizOption()" class="text-success add_button"><i class="fa fa-plus"></i> </a>
                              </span>
                            </div>
                          </div>
                  </div>



=======
                      </option>                 
                  </select>
                  {!! $errors->has('options_required')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('options_required').'</small>':'' !!}
                  </div>                                      

                                                                               
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit" id="save"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
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
<<<<<<< HEAD

=======
  
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
  <script type="text/javascript" src="{{ asset('js/plugins/select2.min.js') }}"></script>
  <script type="text/javascript">
    $('select').select2();

<<<<<<< HEAD
    var campaign = "{{$quizCampaign->slug}}";

=======
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
      var quiz_questionable_types = {
        person_id : 'App\\Domain\\Person\\Model\\Person',
        political_party_id : 'App\\Domain\\Political\\Model\\PoliticalParty',
        politic_id : 'App\\Domain\\Political\\Model\\Politic',
        state_id : 'App\\Domain\\City\\Model\\State',
        city_id : 'App\\Domain\\City\\Model\\City',
        district_id : 'App\\Domain\\City\\Model\\District'
      };
<<<<<<< HEAD

  jQuery(document).ready(function(){

    changeQuizQuestionableName("{{isset($item)&&isset($item->quiz_questionable_name)?$item->quiz_questionable_name:''}}");
    changeQuizQuestionableId("{{isset($item)&&isset($item->quiz_questionable_id)?$item->quiz_questionable_id:''}}");
    multiplaEscolha("{{isset($item)&&isset($item->options_required)?$item->options_required:''}}")
  });

    function changeQuizQuestionableName(quiz_questionable_name = null){

      //$('#save').prop('disabled', false);

=======
        
  jQuery(document).ready(function(){
      
    changeQuizQuestionableName("{{isset($item)&&isset($item->quiz_questionable_name)?$item->quiz_questionable_name:''}}");
    changeQuizQuestionableId("{{isset($item)&&isset($item->quiz_questionable_id)?$item->quiz_questionable_id:''}}");
    

    
    
    
  });
      
    function changeQuizQuestionableName(quiz_questionable_name = null){    

      $('#save').prop('disabled', false);
      
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
      jQuery('#person_id').hide();
      jQuery('#political_party_id').hide();
      jQuery('#politic_id').hide();
      jQuery('#state_id').hide();
      jQuery('#city_id').hide();
      jQuery('#district_id').hide();
<<<<<<< HEAD

      quiz_questionable_id = '';
      quiz_questionable_type = '';

      if(quiz_questionable_name){

        //$('#save').prop('disabled', true);

        quiz_questionable_type =  quiz_questionable_types[quiz_questionable_name];
        jQuery('#'+quiz_questionable_name).show();


      }

      jQuery('#quiz_questionable_id').val(quiz_questionable_id);
      jQuery('#quiz_questionable_type').val(quiz_questionable_type);
      jQuery('#quiz_questionable_name').val(quiz_questionable_name);

=======
      
      quiz_questionable_id = '';
      quiz_questionable_type = '';
              
      if(quiz_questionable_name){
              
        $('#save').prop('disabled', true);
        
        quiz_questionable_type =  quiz_questionable_types[quiz_questionable_name];
        jQuery('#'+quiz_questionable_name).show(); 
        

      }
            
      jQuery('#quiz_questionable_id').val(quiz_questionable_id);
      jQuery('#quiz_questionable_type').val(quiz_questionable_type);
      jQuery('#quiz_questionable_name').val(quiz_questionable_name);
      
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
    }
    function changeQuizQuestionableId(quiz_questionable_id = null){

      jQuery('#quiz_questionable_id').val(quiz_questionable_id);
<<<<<<< HEAD

      //$('#save').prop('disabled', true);
      if(parseInt(quiz_questionable_id)){
        //$('#save').prop('disabled', false);
      }
    }




    //add and remove field quiz options
    var count_field_quiz_options = 1;

    var right_quiz_option = null;

    function addFieldQuizOption(){
        var fieldHTML = '<div class="input-group" id=';
        var field_quiz_option = "field_quiz_option_"+count_field_quiz_options;
        fieldHTML = fieldHTML + field_quiz_option;
        fieldHTML = fieldHTML + '>';
        fieldHTML = fieldHTML + '<div class="input-group-prepend"><span class="input-group-text"></span></div>';
        fieldHTML = fieldHTML + '<input type="text" name="options[]" class="form-control"/>';

        fieldHTML = fieldHTML + '<div class="input-group-append">';
        fieldHTML = fieldHTML + '<span class="input-group-text">';
        fieldHTML = fieldHTML + '<a href="javascript:void(0);" class="text-secondary" onclick="removeFieldQuizOption('+field_quiz_option+')"><i class="fa fa-trash"></i></a>';
        fieldHTML = fieldHTML + '</span></div>';

        fieldHTML = fieldHTML + '</div>';
        count_field_quiz_options++;
        $('.field-quiz-options').append(fieldHTML); //Add field html
    }
    function removeFieldQuizOption(field_quiz_option){
        $(field_quiz_option).remove(); //Remove field html
    }

    function deleteQuizOption(quiz_option_id){

        if(!parseInt(quiz_option_id)) return false;
        var token = $("meta[name='csrf-token']").attr("content");

        if (confirm("Tem certeza que quer apagar esta opção do sistema?")) {

          $.ajax({
            url: "{{url('app/campanha')}}"+"/"+campaign+"/opcoes"+"/"+quiz_option_id,
            type: 'post',
            dataType: "json",
            data: {
              _token: token,
                  id: quiz_option_id,
                  _method: 'delete'
                },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function (data){

                if(data.status){
                  $( ".flash_msg" ).html('<div class="alert alert-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');

                  //setInterval('location.reload()',1000);
                  $('#option_saved_'+quiz_option_id).remove();

                }else{
                  $( ".flash_msg" ).html('<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');
                }
              }
          });
      }
    }
    function multiplaEscolha(simNao){
      if(simNao=='1'){
        //$('.add-option').show();
      }else{
        //$('.add-option').hide();
      }
    }
  </script>
@endsection
=======
      
      $('#save').prop('disabled', true);
      if(parseInt(quiz_questionable_id)){
        $('#save').prop('disabled', false);
      }
    }
  </script>
@endsection  
>>>>>>> 60b1267b93fd8d6fc0bb78ce9aaeffb3820fe4af
