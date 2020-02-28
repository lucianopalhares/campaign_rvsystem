@extends('app.quiz.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-quote-right"></i> Respostas da Campanha {{$quizCampaign->id}}</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Campanha {{$quizCampaign->id}}</li>
          <li class="breadcrumb-item"><a href="{{url('app/campanha/'.$quizCampaign->slug.'/respostas')}}">Respostas</a></li>
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
              {{isset($item->id)?isset($show)?'Visualizar Resposta':'Responder Pergunta':'Responder Pergunta'}}
               da Campanha {{$quizCampaign->id}} <small><i>{{isset($item->id)?isset($show)?'':'(Edição)':''}}</i></small></h3>
            <div class="tile-body">
              
              @if(isset($item))
                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/respostas/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @else 
                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/respostas','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @endif
              
                @if(isset($item->id))
                
                <div class="row">
                  <div class="col-12 alert alert-primary text-center" role="alert">
                    
                    {{$item->question->getDescription()}}
                                              <br />  
                    
                    @if($item->quiz_option_id)                          
                        {{$item->option->getDescription()}}  
                    @endif
                    {{$item->description?$item->description:''}}
                      
                  </div>
                </div>
                
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif

                <input type="hidden" name="quiz_campaign_id" value="{{ old('quiz_campaign_id',isset($item->quiz_campaign_id)?$item->quiz_campaign_id:$quizCampaign->id) }}" />
                <input type="hidden" name="answered_times" value="{{ old('answered_times',isset($item->answered_times)?$item->answered_times:'0') }}" />
                <input type="hidden" name="latitude" value="{{ old('latitude',isset($item->latitude)?$item->latitude:' ') }}" class="form-control {{ $errors->has('latitude')? 'is-invalid':'' }}" id="latitude">
                <input type="hidden" name="longitude" value="{{ old('longitude',isset($item->longitude)?$item->longitude:' ') }}" class="form-control {{ $errors->has('longitude')? 'is-invalid':'' }}" id="longitude">
                
                <div class="form-group">
                  <label class="control-label">Questão (pergunta) *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuestion(this.value)" required="required" class="form-control {{ $errors->has('quiz_question_id')? 'is-invalid':'' }}" required="required" id="quiz_question_id" name="quiz_question_id">
                    <option value="">            
                      Selecione a Questão
                    </option>
                    @foreach($questions as $question)
                      <option value="{{$question->id}}" {{ old('quiz_question_id') == $question->id ? "selected='selected'" : isset($item->quiz_campaign_id) && $item->quiz_question_id == $question->id ? "selected='selected'" : '' }}>
                        {{$question->description}}
                        @if($question->quiz_questionable_id) 
                          <span class="badge badge-light">{{$question->quiz_questionable->nable()}}</span>
                        @endif
                        ?
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('quiz_question_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('quiz_question_id').'</small>':'' !!}
                  </div> 
                     
                 
                  <div class="form-group">
                  <label class="control-label">Opção da Pergunta </label>
                  <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('quiz_option_id')? 'is-invalid':'' }}" required="required" id="quiz_option_id" name="quiz_option_id">
                    <option value=" ">
                      Selecione Primeiro a Questão
                    </option>
                  </select>
                  {!! $errors->has('quiz_option_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('quiz_option_id').'</small>':'' !!}
                  </div>
              
                  
                <div class="row">
                  <div class="col-8">
                    <div class="form-group">
                      <label class="control-label">Municipe *</label>
                      <input type="text" required="required" {{isset($show)?"disabled='disabled'":''}} name="name" value="{{ old('name',isset($item->name)?$item->name:' ') }}" class="form-control {{ $errors->has('name')? 'is-invalid':'' }}" id="name" placeholder="">
                      {!! $errors->has('name')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('name').'</small>':'' !!}
                    </div>                      
                  </div>
                  <div class="col-4">
                    <div class="form-group">
                      <label class="control-label">Sexo </label>
                      <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('sex')? 'is-invalid':'' }}" id="sex" name="sex">

                          <option value="Não Respondeu" {{ old('sex') == "Não Respondeu" ? "selected='selected'" : isset($item->sex) && $item->sex == "Não Respondeu" ? "selected='selected'" : " " }}>
                            Não Respondeu
                          </option> 
                          <option value="M" {{ old('sex') == "M" ? "selected='selected'" : isset($item->sex) && $item->sex == "M" ? "selected='selected'" : " " }}>
                            Masculino
                          </option>
                          <option value="F" {{ old('sex') == "F" ? "selected='selected'" : isset($item->sex) && $item->sex == "F" ? "selected='selected'" : " " }}>
                            Feminino
                          </option>  
 
                                                                                                                                                          
                      </select>
                      {!! $errors->has('sex')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('sex').'</small>':'' !!}
                    </div>                          
                  </div>
                </div>  

                <div class="row">
                  <div class="col-5">
                    <div class="form-group">
                      <label class="control-label">Idade </label>
                      <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('years_old')? 'is-invalid':'' }}" id="years_old" name="years_old">

                          <option value="Não Respondeu" {{ old('years_old') == "Não Respondeu" ? "selected='selected'" : isset($item->years_old) && $item->years_old == "Não Respondeu" ? "selected='selected'" : " " }}>
                            Não Respondeu
                          </option> 
                          <option value="16-24 Anos" {{ old('years_old') == "16-24 Anos" ? "selected='selected'" : isset($item->years_old) && $item->years_old == "16-24 Anos" ? "selected='selected'" : " " }}>
                            16-24 Anos
                          </option>
                          <option value="25-34 Anos" {{ old('years_old') == "25-34 Anos" ? "selected='selected'" : isset($item->years_old) && $item->years_old == "25-34 Anos" ? "selected='selected'" : " " }}>
                            25-34 Anos
                          </option>
                          <option value="45-59 Anos" {{ old('years_old') == "45-59 Anos" ? "selected='selected'" : isset($item->years_old) && $item->years_old == "45-59 Anos" ? "selected='selected'" : " " }}>
                            45-59 Anos
                          </option> 
                          <option value="Acima de 60 Anos" {{ old('years_old') == "Acima de 60 Anos" ? "selected='selected'" : isset($item->years_old) && $item->years_old == "Acima de 60 Anos" ? "selected='selected'" : " " }}>
                            Acima de 60 Anos
                          </option>   
                                                                                                                     
                      </select>
                      {!! $errors->has('years_old')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('years_old').'</small>':'' !!}
                    </div>                          
                  </div>
                  <div class="col-7">
                    <div class="form-group">
                      <label class="control-label">Salario </label>
                      <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('salary')? 'is-invalid':'' }}" id="salary" name="salary">

                          <option value="Não Respondeu" {{ old('salary') == "Não Respondeu" ? "selected='selected'" : isset($item->salary) && $item->salary == "Não Respondeu" ? "selected='selected'" : " " }}>
                            Não Respondeu
                          </option> 
                          <option value="Até 1 Salário Minimo" {{ old('salary') == "Até 1 Salário Minimo" ? "selected='selected'" : isset($item->salary) && $item->salary == "Até 1 Salário Minimo" ? "selected='selected'" : " " }}>
                            Até 1 Salário Minimo
                          </option>
                          <option value="Entre 1 e 2 Salários Minimos" {{ old('salary') == "Entre 1 e 2 Salários Minimos" ? "selected='selected'" : isset($item->salary) && $item->salary == "Entre 1 e 2 Salários Minimos" ? "selected='selected'" : " " }}>
                            Entre 1 e 2 Salários Minimos
                          </option>
                          <option value="Entre 2 e 5 Salários Minimos" {{ old('salary') == "Entre 2 e 5 Salários Minimos" ? "selected='selected'" : isset($item->salary) && $item->salary == "Entre 2 e 5 Salários Minimos" ? "selected='selected'" : " " }}>
                            Entre 2 e 5 Salários Minimos
                          </option> 
                          <option value="Entre 5 e 10 Salários Minimos" {{ old('salary') == "Entre 5 e 10 Salários Minimos" ? "selected='selected'" : isset($item->salary) && $item->salary == "Entre 5 e 10 Salários Minimos" ? "selected='selected'" : " " }}>
                            Entre 5 e 10 Salários Minimos
                          </option>   
                          <option value="Mais de 10 Salários Minimos" {{ old('salary') == "Mais de 10 Salários Minimos" ? "selected='selected'" : isset($item->salary) && $item->salary == "Mais de 10 Salários Minimos" ? "selected='selected'" : " " }}>
                            Mais de 10 Salários Minimos
                          </option>   
                                                                                                                                               
                      </select>
                      {!! $errors->has('salary')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('salary').'</small>':'' !!}
                    </div>                          
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label class="control-label">Escolaridade </label>
                      <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('education_level')? 'is-invalid':'' }}" id="education_level" name="education_level">

                          <option value="Não Respondeu" {{ old('education_level') == "Não Respondeu" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Não Respondeu" ? "selected='selected'" : " " }}>
                            Não Respondeu
                          </option> 
                          <option value="Ensino Fundamental / Incompleto" {{ old('education_level') == "Ensino Fundamental / Incompleto" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Ensino Fundamental / Incompleto" ? "selected='selected'" : " " }}>
                            Ensino Fundamental / Incompleto
                          </option>
                          <option value="Ensino Fundamental / Completo" {{ old('education_level') == "Ensino Fundamental / Completo" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Ensino Fundamental / Completo" ? "selected='selected'" : " " }}>
                            Ensino Fundamental / Completo
                          </option>
                          <option value="Ensino Médio / Incompleto" {{ old('education_level') == "Ensino Médio / Incompleto" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Ensino Médio / Incompleto" ? "selected='selected'" : " " }}>
                            Ensino Médio / Incompleto
                          </option> 
                          <option value="Ensino Médio / Completo" {{ old('education_level') == "Ensino Médio / Completo" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Ensino Médio / Completo" ? "selected='selected'" : " " }}>
                            Ensino Médio / Completo
                          </option>   
                          <option value="Nunca Estudou" {{ old('education_level') == "Nunca Estudou" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Nunca Estudou" ? "selected='selected'" : " " }}>
                            Nunca Estudou
                          </option>   
                          <option value="Superior / Incompleto" {{ old('education_level') == "Superior / Incompleto" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Superior / Incompleto" ? "selected='selected'" : " " }}>
                            Superior / Incompleto
                          </option>   
                          <option value="Superior / Completo" {{ old('education_level') == "Superior / Completo" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Superior / Completo" ? "selected='selected'" : " " }}>
                            Superior / Completo
                          </option>   
                                                                                                                                                                                                   
                      </select>
                      {!! $errors->has('education_level')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('education_level').'</small>':'' !!}
                    </div>                          
                  </div>
              
                </div>  

     

                
                <div class="row">
                  <div class="col-5">
                    <div class="form-group">
                    <label class="control-label">Estado/UF</label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeState(this.value)" class="form-control {{ $errors->has('state_id')? 'is-invalid':'' }}" id="state_id" name="state_id">
                      <!--<option value="">            
                        Não Respondeu
                      </option>  --> 
                      @foreach($states as $state)
                        @if($state->id==$quizCampaign->state_id)
                          <option value="{{$state->id}}" {{ old('state_id') == $state->id ? "selected='selected'" : isset($item->state_id) && $item->state_id == $state->id ? "selected='selected'" : '' }}>
                            {{$state->title}}
                          </option>
                        @endif
                      @endforeach
                    </select>
                    {!! $errors->has('state_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('state_id').'</small>':'' !!}
                    </div>                      
                  </div>
                  <div class="col-7">
                    <div class="form-group">
                    <label class="control-label">Cidade</label>
                    <select {{isset($show)?"disabled='disabled'":''}} onchange="changeCity(this.value)" class="form-control {{ $errors->has('city_id')? 'is-invalid':'' }}" id="city_id" name="city_id">
                      <option value="">            
                        Não Respondeu
                      </option>                       
                      <option value="">            
                        Primeiro Selecione o Estado
                      </option>
                    </select>
                    {!! $errors->has('city_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('city_id').'</small>':'' !!}
                    </div>                    
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-7">
                    <div class="form-group">
                    <label class="control-label">Bairro <small class="text-danger"><i class="text-danger" id="no_districts"></i></small></label>
                    <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('district_id')? 'is-invalid':'' }}" id="district_id" name="district_id">
                      <option value="">            
                        Não Respondeu
                      </option>                    
                      <option value="1" {{ old('district_id') == '1' ? "selected='selected'" : isset($item->district_id) && $item->district_id == '1' ? "selected='selected'" : '' }}>
                          Area Urbana - Centro e Bairros
                      </option>
                      <option value="2" {{ old('district_id') == '2' ? "selected='selected'" : isset($item->district_id) && $item->district_id == '2' ? "selected='selected'" : '' }}>
                          Zona Rural - Povoados,Chacaras,Fazendas e Outros
                      </option>
                    </select>
                    {!! $errors->has('district_id')? '<small id="passwordHelpBlockDistrict" class="form-text text-danger">'.$errors->first('district_id').'</small>':'' !!}
                    </div>                    
                  </div>
                  <div class="col-5">
                    <div class="form-group">
                      <label class="control-label">CEP </label>
                      <input type="text" {{isset($show)?"disabled='disabled'":''}} name="zip_code" value="{{ old('zip_code',isset($item->zip_code)?$item->zip_code:' ') }}" class="form-control {{ $errors->has('zip_code')? 'is-invalid':'' }}" id="zip_code" placeholder="Não Respondeu">
                      {!! $errors->has('zip_code')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('zip_code').'</small>':'' !!}
                    </div>                       
                  </div>
                </div>



                <div class="form-group">
                  <label class="control-label">Endereço</label>
                  <input type="text" {{isset($show)?"disabled='disabled'":''}} name="address" value="{{ old('address',isset($item->address)?$item->address:' ') }}" class="form-control {{ $errors->has('address')? 'is-invalid':'' }}" id="address" placeholder="Não Respondeu">
                  {!! $errors->has('address')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('address').'</small>':'' !!}
                </div>  

                <div class="row">
                  <div class="col-6">
                    <div class="form-group">
                      <label class="control-label">Latitude </label>
                      <input type="text" disabled='disabled' value="{{ old('latitude',isset($item->latitude)?$item->latitude:' ') }}" class="form-control">
        
                    </div>                       
                  </div>
                  <div class="col-6">
                    <div class="form-group">
                      <label class="control-label">Longitude </label>
                      <input type="text" disabled='disabled' value="{{ old('longitude',isset($item->longitude)?$item->longitude:' ') }}" class="form-control">
        
                    </div>                       
                  </div>
                </div>
                                                                                                                                                                                      
                <div class="form-group">
                  <label class="control-label">Descrição</label>
                  <textarea {{isset($show)?"disabled='disabled'":''}} rows="3" name="description" class="form-control {{ $errors->has('description')? 'is-invalid':'' }}" id="description">{{ old('description',isset($item->description)?$item->description:'') }}</textarea>
                  {!! $errors->has('description')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('description').'</small>':'' !!}
                </div>          
            
                                                                               
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('app/campanha/'.$quizCampaign->slug.'/respostas/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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
  
  
	var info_pesquisa = [
		quiz_campaign_id= 3
	];
  /*
	var pesquisa_respostas = [{
		quiz_question_id: 12,
		resposta_id: 37,
		resposta: Area Urbana - Centro e Bairros
	}, {
		quiz_question_id: 13,
		resposta_id: 39,
		resposta: Masculino
	}, {
		quiz_question_id: 14,
		resposta_id: 41,
		resposta: 16 - 24 anos
	}, {
		quiz_question_id: 15,
		resposta_id: 46,
		resposta: Nunca Estudou
	}, {
		quiz_question_id: 16,
		resposta_id: 51,
		resposta: Ate 1 Salario Minimo
	}, {
		quiz_question_id: 17,
		resposta_id: 57,
		resposta: Desemprego
	}, {
		quiz_question_id: 18,
		resposta_id: 66,
		resposta: Não sabe / Não Respondeu
	}, {
		quiz_question_id: 19,
		resposta_id: 75,
		resposta: Não sabe / não respondeu
	}, {
		quiz_question_id: 20,
		resposta_id: 82,
		resposta: Otimo / Bom
	}, {
		quiz_question_id: 21,
		resposta_id: 86,
		resposta: Ótimo / Bom
	}];
  */
  jQuery(document).ready(function(){
    
    var quiz_question_id_selected = "{{ old('quiz_question_id', isset($item) ? $item->quiz_question_id : '') }}";
    var quiz_option_id_selected = "{{ old('quiz_option_id', isset($item) ? $item->quiz_option_id : '') }}";
    changeQuestion(quiz_question_id_selected,quiz_option_id_selected);
    var state_id_selected = "{{ old('state_id', isset($item) ? $item->state_id : $quizCampaign->state_id) }}";
    var city_id_selected = "{{ old('city_id', isset($item) ? $item->city_id : $quizCampaign->city_id) }}";      
    changeState(state_id_selected,city_id_selected);    
    var district_id_selected = "{{ old('district_id', isset($item) ? $item->district_id : '') }}"; 
    changeCity(city_id_selected,district_id_selected);
    

    console.log(info_pesquisa);
  });
  
    
    function changeQuestion(quiz_question_id,option_selected = null){
                      
        var token = $("meta[name='csrf-token']").attr("content");
        var select_option = document.getElementById("quiz_option_id");          
                        
        if(!parseInt(quiz_question_id)) return false;
        
          select_option.options.length = 0;
                          
          $.ajax({
            url: "{{url('api/options/')}}"+"/"+quiz_question_id, 
            type: 'get',
            dataType: "json",
            data: {
              _token: token,
                  id: quiz_question_id,
                  _method: 'get'
                },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function (data){
                
                if(!parseInt(data['quiz_question']['options_required'])){
                  select_option.options[select_option.options.length] = new Option('RESPONDA NA DESCRIÇÃO (a questão não é Multipla Escolha)',' ');
                }else{
                
                  select_option.options[select_option.options.length] = new Option('Selecione',' ');
                  for(index in data['data']) {
                      if(data['data'][index]['id']==parseInt(option_selected)){
                        select_option.options[select_option.options.length] = new Option(data['data'][index]['description'], data['data'][index]['id'],true,true);
                      }else{
                        select_option.options[select_option.options.length] = new Option(data['data'][index]['description'], data['data'][index]['id']);
                      } 
                  }
                }
              }
          });      
    }
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
                
                //select_city.options[select_city.options.length] = new Option('Não Respondeu',' ');
                for(index in data) {
                    if(data[index]['id']==parseInt(city_selected)){
                      select_city.options[select_city.options.length] = new Option(data[index]['title'], data[index]['id'],true,true);
                    }else{
                      //select_city.options[select_city.options.length] = new Option(data[index]['title'], data[index]['id']);
                    } 
                }
              }
          });      
    }
    function changeCity(city_id,district_selected = null){
                      
        var token = $("meta[name='csrf-token']").attr("content");
        var select_district = document.getElementById("district_id");        
                        
        if(!parseInt(city_id)) return false;
        
          select_district.options.length = 0;
                          
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
                if(data.length){
                  select_district.options[select_district.options.length] = new Option('Não Respondeu',' ');
                  select_district.options[select_district.options.length] = new Option('1','Area Urbana - Centro e Bairros');
                  select_district.options[select_district.options.length] = new Option('2','Zona Rural - Povoados,Chacaras,Fazendas e Outros');
                  for(index in data) {
                      if(data[index]['id']==parseInt(district_selected)){
                        select_district.options[select_district.options.length] = new Option(data[index]['name'], data[index]['id'],true,true);
                      }else{
                        select_district.options[select_district.options.length] = new Option(data[index]['name'], data[index]['id']);
                      } 
                  }
                }else{
                  $('#no_districts').html('(sem bairros cadastrados nesta cidade)');
                  select_district.options[select_district.options.length] = new Option('Não Respondeu',' ');
                  select_district.options[select_district.options.length] = new Option('Area Urbana - Centro e Bairros','1');
                  select_district.options[select_district.options.length] = new Option('Zona Rural - Povoados,Chacaras,Fazendas e Outros','2');
                }
              }
          });      
    }

</script>
@endsection  