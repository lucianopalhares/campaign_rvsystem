@extends('app.quiz.layout.main')

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


                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/responder-pergunta','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}


                <input type="hidden" name="quiz_campaign_id" value="{{ old('quiz_campaign_id',isset($item->quiz_campaign_id)?$item->quiz_campaign_id:$quizCampaign->id) }}" />
                <input type="hidden" name="latitude" value="{{ old('latitude',isset($item->latitude)?$item->latitude:' ') }}" class="form-control {{ $errors->has('latitude')? 'is-invalid':'' }}" id="latitude">
                <input type="hidden" name="longitude" value="{{ old('longitude',isset($item->longitude)?$item->longitude:' ') }}" class="form-control {{ $errors->has('longitude')? 'is-invalid':'' }}" id="longitude">
                <input type="hidden" name="quiz_question_id" value="{{$question->id}}" />





                @if(isset($answer))
                  <input type="hidden" name="name" value="{{$answer->name}}" />
                  <div class="row">
                    <div class="col-12">
                      <div class="form-group">
                        <label class="control-label">Municipe *</label>
                        <input type="text" disabled="disabled" value="{{$answer->name}}" class="form-control">
                      </div>
                    </div>
                  </div>

                  <input type="hidden" name="district_id" value="{{$answer->district_id}}" />
                  <input type="hidden" name="zip_code" value="{{$answer->zip_code}}" />

                  <div class="row">
                    @if($answer->district_id>0)
                    <div class="col-7">
                      <div class="form-group">
                      <label class="control-label">Bairro </label>
                      <input type="text" disabled="disabled" value="{{$answer->district->name}}" class="form-control">
                      </div>
                    </div>
                    @endif
                    <div class="col-5">
                      <div class="form-group">
                      <label class="control-label">CEP </label>
                      <input type="text" disabled="disabled" value="{{$answer->zip_code}}" class="form-control">
                      </div>
                    </div>
                  </div>

                  <div class="form-group">
                  <label class="control-label">Endereço </label>
                  <input type="text" disabled="disabled" value="{{$answer->address}}" class="form-control">
                  </div>

                  <div class="row">
                    <div class="col-6">
                      <div class="form-group">
                        <label class="control-label">Latitude </label>
                        <input type="text" disabled='disabled' value="{{$answer->latitude}}" class="form-control">

                      </div>
                    </div>
                    <div class="col-6">
                      <div class="form-group">
                        <label class="control-label">Longitude </label>
                        <input type="text" disabled='disabled' value="{{$answer->longitude}}" class="form-control">

                      </div>
                    </div>
                  </div>

                @else
                <div class="row">
                  <div class="col-12">
                    <div class="form-group">
                      <label class="control-label">Municipe *</label>
                      <input type="text" required="required" {{isset($show)?"disabled='disabled'":''}} name="name" value="{{ old('name',isset($item->name)?$item->name:' ') }}" class="form-control {{ $errors->has('name')? 'is-invalid':'' }}" id="name" placeholder="">
                      {!! $errors->has('name')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('name').'</small>':'' !!}
                    </div>
                  </div>
                </div>

                @if($quizCampaign->state_id>0&&$quizCampaign->city_id>0)
                <div class="row">
                  <div class="col-5">
                    <div class="form-group">
                    <label class="control-label">Estado/UF</label>
                    <select disabled='disabled' class="form-control">
                      <option value="">
                        {{$quizCampaign->state->letter}}
                      </option>
                    </select>
                    </div>
                  </div>
                  <div class="col-7">
                    <div class="form-group">
                    <label class="control-label">Cidade</label>
                    <select disabled='disabled' class="form-control">
                      <option value="">
                        {{$quizCampaign->city->title}}
                      </option>
                    </select>
                    </div>
                  </div>
                </div>
                @endif


                                <div class="row">
                                  <div class="col-7">
                                    <div class="form-group">
                                    <label class="control-label">Bairro <small class="text-danger"><i class="text-danger" id="no_districts"></i></small></label>
                                    <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('district_id')? 'is-invalid':'' }}" id="district_id" name="district_id">
                                      <option value="">
                                        Não Respondeu
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
                @endif


                <div class="form-group">
                  <label class="control-label">Pergunta</label>
                  <textarea disabled='disabled'rows="3" class="form-control">{{$question->description}}</textarea>

                </div>

                @if($question->type==0 or $question->type==1)
                  <input type="hidden" name="description" value="" />


                  @foreach($question->options as $option)
                  <div class="row">
                    <div class="col-12 text-center">
                      <div class="form-group">
                      <label class="control-label">{{$option->description}}</label>
                      <input type="checkbox" class="form-control" name="options[]" value="{{$option->id}}" />
                      </div>
                    </div>
                  </div>
                  @endforeach


                @elseif($question->type==2)
                <div class="form-group">
                  <label class="control-label">Descrição</label>
                  <textarea {{isset($show)?"disabled='disabled'":''}} rows="3" name="description" class="form-control {{ $errors->has('description')? 'is-invalid':'' }}" id="description">{{ old('description',isset($item->description)?$item->description:'') }}</textarea>
                  {!! $errors->has('description')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('description').'</small>':'' !!}
                </div>
                @endif







            </div>
            <div class="tile-footer">

              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;

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
    //var state_id_selected = "{{ old('state_id', isset($item) ? $item->state_id : $quizCampaign->state_id) }}";
    //var city_id_selected = "{{ old('city_id', isset($item) ? $item->city_id : $quizCampaign->city_id) }}";
    //changeState(state_id_selected,city_id_selected);
    var district_id_selected = "{{ old('district_id', isset($item) ? $item->district_id : '') }}";
    loadDistricts(district_id_selected);


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
    function loadDistricts(district_selected = null){

        var token = $("meta[name='csrf-token']").attr("content");
        var select_district = document.getElementById("district_id");

          select_district.options.length = 0;

          $.ajax({
            url: "{{url('app/campanha/'.$quizCampaign->slug.'/bairros')}}",
            type: 'get',
            dataType: "json",
            data: {
              _token: token,
                  _method: 'get'
                },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function (data){
                if(data.length){
                  select_district.options[select_district.options.length] = new Option('Não Respondeu',' ');
                  for(index in data) {
                      if(data[index]['id']==parseInt(district_selected)){
                        select_district.options[select_district.options.length] = new Option(data[index]['name'], data[index]['id'],true,true);
                      }else{
                        select_district.options[select_district.options.length] = new Option(data[index]['name'], data[index]['id']);
                      }
                  }
                }
              }
          });
    }

</script>
@endsection
