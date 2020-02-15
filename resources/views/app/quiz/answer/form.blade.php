@extends('app.quiz.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-quote-right"></i> Respostas</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('app/quiz/respostas')}}">Respostas</a></li>
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
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Resposta</h3>
            <div class="tile-body">
              
              @if(isset($item))
                {!! Form::open(['url' => 'app/quiz/respostas/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @else 
                {!! Form::open(['url' => 'app/quiz/respostas','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @endif
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif

                <div class="form-group">
                  <label class="control-label">Campanha *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} onchange="changeCampaign(this.value)" required class="form-control {{ $errors->has('quiz_campaign_id')? 'is-invalid':'' }}" required="required" id="quiz_campaign_id" name="quiz_campaign_id">
                    <option value="">            
                      Selecione a Campanha
                    </option>
                    @foreach($campaigns as $campaign)
                      <option value="{{$campaign->id}}" {{ old('quiz_campaign_id') == $campaign->id ? "selected='selected'" : isset($item->quiz_campaign_id) && $item->quiz_campaign_id == $campaign->id ? "selected='selected'" : '' }}>
                        {{$campaign->description}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('quiz_campaign_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('quiz_campaign_id').'</small>':'' !!}
                  </div>  

                <div class="form-group">
                  <label class="control-label">Questão *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} onchange="changeQuestion(this.value)" required="required" class="form-control {{ $errors->has('quiz_question_id')? 'is-invalid':'' }}" required="required" id="quiz_question_id" name="quiz_question_id">
                    <option value=" ">
                      Selecione Primeiro a Campanha
                    </option>
                  </select>
                  {!! $errors->has('quiz_question_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('quiz_question_id').'</small>':'' !!}
                  </div>                    

                <div class="form-group">
                  <label class="control-label">Opção *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control {{ $errors->has('quiz_option_id')? 'is-invalid':'' }}" required="required" id="quiz_option_id" name="quiz_option_id">
                    <option value=" ">
                      Selecione Primeiro a Questão
                    </option>
                  </select>
                  {!! $errors->has('quiz_option_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('quiz_option_id').'</small>':'' !!}
                  </div>  

                <div class="form-group">
                  <label class="control-label">Municipe *</label>
                  <input type="text" required="required" {{isset($show)?"disabled='disabled'":''}} name="name" value="{{ old('name',isset($item->name)?$item->name:' ') }}" class="form-control {{ $errors->has('name')? 'is-invalid':'' }}" id="name" placeholder="">
                  {!! $errors->has('name')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('name').'</small>':'' !!}
                </div>     

                <div class="form-group">
                  <label class="control-label">Endereço *</label>
                  <input type="text" required="required" {{isset($show)?"disabled='disabled'":''}} name="address" value="{{ old('address',isset($item->address)?$item->address:' ') }}" class="form-control {{ $errors->has('address')? 'is-invalid':'' }}" id="address" placeholder="">
                  {!! $errors->has('address')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('address').'</small>':'' !!}
                </div>  

                <div class="form-group">
                  <label class="control-label">Bairro *</label>
                  <input type="text" required="required" {{isset($show)?"disabled='disabled'":''}} name="district" value="{{ old('district',isset($item->district)?$item->district:' ') }}" class="form-control {{ $errors->has('district')? 'is-invalid':'' }}" id="district" placeholder="">
                  {!! $errors->has('district')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('district').'</small>':'' !!}
                </div>  

                <div class="form-group">
                  <label class="control-label">CEP *</label>
                  <input type="text" required="required" {{isset($show)?"disabled='disabled'":''}} name="zip_code" value="{{ old('zip_code',isset($item->zip_code)?$item->zip_code:' ') }}" class="form-control {{ $errors->has('zip_code')? 'is-invalid':'' }}" id="zip_code" placeholder="">
                  {!! $errors->has('zip_code')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('zip_code').'</small>':'' !!}
                </div>

                <div class="form-group">
                  <label class="control-label">Estado/UF *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} onchange="changeState(this.value)" required class="form-control {{ $errors->has('state_id')? 'is-invalid':'' }}" required="required" id="state_id" name="state_id">
                    <option value="">            
                      Selecione o Estado
                    </option>
                    @foreach($states as $state)
                      <option value="{{$state->id}}" {{ old('state_id') == $state->id ? "selected='selected'" : isset($item->state_id) && $item->state_id == $state->id ? "selected='selected'" : '' }}>
                        {{$state->title}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('state_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('state_id').'</small>':'' !!}
                  </div>  

                <div class="form-group">
                  <label class="control-label">Cidade *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required class="form-control {{ $errors->has('city_id')? 'is-invalid':'' }}" required="required" id="city_id" name="city_id">
                    <option value="">            
                      Primeiro Selecione o Estado
                    </option>
                  </select>
                  {!! $errors->has('city_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('city_id').'</small>':'' !!}
                  </div>
                                                                                                                                    
                <div class="form-group">
                  <label class="control-label">Descrição *</label>
                  <textarea rows="3" required="required" name="description" class="form-control {{ $errors->has('description')? 'is-invalid':'' }}" id="description">{{ old('description',isset($item->description)?$item->description:'') }}</textarea>
                  {!! $errors->has('description')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('description').'</small>':'' !!}
                </div>          
            
                                                                               
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('app/quiz/respostas/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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
    
    <?php if(isset($item)){ ?>
      changeCampaign({{$item->quiz_campaign_id}},{{$item->quiz_question_id}});
      changeQuestion({{$item->quiz_question_id}},{{$item->quiz_option_id}});
      changeState({{$item->state_id}},{{$item->city_id}});
    <?php } ?>
    
  });
          
    function changeCampaign(quiz_campaign_id,question_selected = null){        

        var select_question = document.getElementById("quiz_question_id");
        var select_option = document.getElementById("quiz_option_id");        
        select_question.options.length = 0;
        select_option.options.length = 0;
                
        var token = $("meta[name='csrf-token']").attr("content");
                                
        if(!parseInt(quiz_campaign_id)) return false;
                          
          $.ajax({
            url: "{{url('api/questions/')}}"+"/"+quiz_campaign_id, 
            type: 'get',
            dataType: "json",
            data: {
              _token: token,
                  id: quiz_campaign_id,
                  _method: 'get'
                },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function (data){
                
                select_question.options[select_question.options.length] = new Option('Selecione',' ');
                for(index in data) {                  
                    if(parseInt(data[index]['id'])==parseInt(question_selected)){
                      select_question.options[select_question.options.length] = new Option(data[index]['description'], data[index]['id'],true,true);
                    }else{
                      select_question.options[select_question.options.length] = new Option(data[index]['description'], data[index]['id']);
                    } 
                }                
              }
          });      
    }
    
    function changeQuestion(quiz_question_id,option_selected = null){
                      
        var token = $("meta[name='csrf-token']").attr("content");
        var select_option = document.getElementById("quiz_option_id");  
        select_option.options.length = 0;
                        
        if(!parseInt(quiz_question_id)) return false;
                          
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
                
                select_option.options[select_option.options.length] = new Option('Selecione',' ');
                for(index in data) {
                    if(data[index]['id']==parseInt(option_selected)){
                      select_option.options[select_option.options.length] = new Option(data[index]['description'], data[index]['id'],true,true);
                    }else{
                      select_option.options[select_option.options.length] = new Option(data[index]['description'], data[index]['id']);
                    } 
                }
              }
          });      
    }
    function changeState(state_id,city_selected = null){
                      
        var token = $("meta[name='csrf-token']").attr("content");
        var select_city = document.getElementById("city_id");
        select_city.options.length = 0;
                        
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