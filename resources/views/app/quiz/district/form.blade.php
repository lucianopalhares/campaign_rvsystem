@extends('app.quiz.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-map"></i> Bairros da Campanha {{$quizCampaign->id}}</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Campanha {{$quizCampaign->id}}</li>
          <li class="breadcrumb-item"><a href="{{url('app/campanha/'.$quizCampaign->slug.'/bairros')}}">Bairros</a></li>
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
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Bairro</h3>
            <div class="tile-body">
              
              @if(isset($item))
                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/bairros/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @else 
                {!! Form::open(['url' => 'app/campanha/'.$quizCampaign->slug.'/bairros','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @endif
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                 
                <input type="hidden" name="quiz_campaign_id" value="{{ $quizCampaign->id }}">
              
                @if($quizCampaign->city_id>0)
                
                  <input type="hidden" name="city_id" value="{{ $quizCampaign->city_id }}">

                  <div class="form-group">
                    <label class="control-label">Estado/UF *</label>
                      <select disabled='disabled' class="form-control">
                        <option value="{{$quizCampaign->state_id}}">            
                          {{$quizCampaign->state->letter}}
                        </option>
                    </select>
                  </div> 
                  <div class="form-group">
                    <label class="control-label">Cidade *</label>
                      <select disabled='disabled' class="form-control">
                        <option value="{{$quizCampaign->city_id}}">            
                          {{$quizCampaign->city->title}}
                        </option>
                    </select>
                  </div>     
                                                
                @else 

                <div class="form-group">
                  <label class="control-label">Estado/UF *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} onchange="changeState(this.value)" required class="form-control {{ $errors->has('state_id')? 'is-invalid':'' }}" required="required" id="state_id" name="state_id">
                    <option value="">            
                      Selecione o Estado
                    </option>
                    @foreach($states as $state)
                      <option value="{{$state->id}}" {{ old('state_id') == $state->id ? "selected='selected'" : isset($item->city->state_id) && $item->city->state_id == $state->id ? "selected='selected'" : '' }}>
                        {{$state->title}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('state_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('state_id').'</small>':'' !!}
                  </div>  

                <div class="form-group">
                  <label class="control-label">Cidade *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control {{ $errors->has('city_id')? 'is-invalid':'' }}" required="required" id="city_id" name="city_id">
                    <option value="">            
                      Primeiro Selecione o Estado
                    </option>
                  </select>
                  {!! $errors->has('city_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('city_id').'</small>':'' !!}
                  </div>
                
                @endif

            
                                                                                                                                                      
                <div class="form-group">
                  <label class="control-label">Nome do Bairro *</label>
                  <input type="text" required="required" {{isset($show)?"disabled='disabled'":''}} name="name" value="{{ old('name',isset($item->name)?$item->name:' ') }}" class="form-control {{ $errors->has('name')? 'is-invalid':'' }}" id="name" placeholder="">
                  {!! $errors->has('name')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('name').'</small>':'' !!}
                </div>      

            
                                                                               
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('app/bairros/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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
  
  @if(!$quizCampaign->city_id)

  <script type="text/javascript">
  
  jQuery(document).ready(function(){
    
    <?php if(isset($item)){ ?>
      changeState({{$item->city->state_id}},{{$item->city_id}});
    <?php } ?>
    
  });
          
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
  @endif
  
@endsection  