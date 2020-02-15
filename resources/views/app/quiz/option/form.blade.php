@extends('app.quiz.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-list"></i> Opções</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('app/quiz/opcoes')}}">Opções</a></li>
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
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Opção</h3>
            <div class="tile-body">
              
              @if(isset($item))
                {!! Form::open(['url' => 'app/quiz/opcoes/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @else 
                {!! Form::open(['url' => 'app/quiz/opcoes','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
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
                  <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control {{ $errors->has('quiz_question_id')? 'is-invalid':'' }}" required="required" id="quiz_question_id" name="quiz_question_id">
                    <option value=" ">
                      Selecione a Campanha Primeiro
                    </option>
                  </select>
                  {!! $errors->has('quiz_question_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('quiz_question_id').'</small>':'' !!}
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
              <a href="{{url('app/quiz/opcoes/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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
    <?php } ?>
    
  });
          
    function changeCampaign(quiz_campaign_id,question_selected = null){        

        var select_question = document.getElementById("quiz_question_id"); 
        select_question.options.length = 0;
                
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
</script>
@endsection  