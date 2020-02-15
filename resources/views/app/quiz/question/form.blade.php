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
  </script>
@endsection  