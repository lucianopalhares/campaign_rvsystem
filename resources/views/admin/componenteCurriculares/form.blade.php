@extends('layouts.admin.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-wpexplorer"></i> Componentes Curriculares</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('admin/componenteCurriculares')}}">Componentes Curriculares</a></li>
          <li class="breadcrumb-item">{{isset($show)?'Ver':'Formulário'}}</li>
        </ul>
      </div>

      @include('admin.flash_msg')

      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Componente Curricular</h3>
            <div class="tile-body">
              {!! Form::open(['url' => 'admin/componenteCurriculares','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                <!--         
                  <div class="form-group">
                    <label class="control-label">Nome *</label>
                    <input type="text" required {{isset($show)?"disabled='disabled'":''}} name="nome" value="{{ old('nome',isset($item->nome)?$item->nome:' ') }}" class="form-control {{ $errors->has('nome')? 'is-invalid':'' }}" id="nome" placeholder="">
                    {!! $errors->has('nome')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('nome').'</small>':'' !!}
                  </div>         
                -->
                <div class="form-group">
                  <label class="control-label">Disciplina *</label>
                  <select required="required" class="form-control {{ $errors->has('id_disciplina')? 'is-invalid':'' }}" required id="id_disciplina" name="id_disciplina">
                    <option value="">            
                      Selecione a Disciplina
                    </option>
                    @foreach($disciplinas as $disciplina)
                      <option value="{{$disciplina->id}}" {{ old('id_disciplina') == $disciplina->id ? "selected='selected'" : isset($item->id_disciplina) && $item->id_disciplina == $disciplina->id ? "selected='selected'" : '' }}>
                        {{$disciplina->nome}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('id_disciplina')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('id_serie').'</small>':'' !!}
                  </div> 
                  
                <div class="form-group">
                  <label class="control-label">Série</label>
                  <select class="form-control {{ $errors->has('id_serie')? 'is-invalid':'' }}" required id="id_serie" name="id_serie">
                    <option value="">            
                      Selecione a Série
                    </option>
                    @foreach($series as $serie)
                      <option value="{{$serie->id}}" {{ old('id_serie') == $serie->id ? "selected='selected'" : isset($item->id_serie) && $item->id_serie == $serie->id ? "selected='selected'" : '' }}>
                        {{$serie->nome}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('id_serie')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('id_serie').'</small>':'' !!}
                  </div>  
                  <!--
                <div class="form-group">
                  <label class="control-label">Turma</label>
                  <select class="form-control {{ $errors->has('id_turma')? 'is-invalid':'' }}" id="id_turma" name="id_turma">
                    <option value="">            
                      Selecione a Turma
                    </option>
                    @foreach($turmas as $turma)
                      <option value="{{$turma->id}}" {{ old('id_turma') == $turma->id ? "selected='selected'" : isset($item->id_turma) && $item->id_turma == $turma->id ? "selected='selected'" : '' }}>
                        {{$turma->nome}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('id_turma')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('id_turma').'</small>':'' !!}
                  </div>    
-->
            
                <div class="form-group">
                  <label class="control-label">Area</label>
                  <input type="text" {{isset($show)?"disabled='disabled'":''}} name="area" value="{{ old('area',isset($item->area)?$item->area:' ') }}" class="form-control {{ $errors->has('area')? 'is-invalid':'' }}" id="area" placeholder="">
                  {!! $errors->has('area')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('area').'</small>':'' !!}
                </div> 

             <div class="row">
               <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Carga Hora Anual</label>
                  <input type="text" {{isset($show)?"disabled='disabled'":''}} name="carga_horaria_anual" value="{{ old('carga_horaria_anual',isset($item->carga_horaria_anual)?$item->carga_horaria_anual:' ') }}" class="form-control {{ $errors->has('carga_horaria_anual')? 'is-invalid':'' }}" id="carga_horaria_anual" placeholder="">
                  {!! $errors->has('carga_horaria_anual')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('carga_horaria_anual').'</small>':'' !!}
                </div> 
              </div>
               <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Carga Hora Semanal</label>
                  <input type="text" {{isset($show)?"disabled='disabled'":''}} name="carga_horaria_semanal" value="{{ old('carga_horaria_semanal',isset($item->carga_horaria_semanal)?$item->carga_horaria_semanal:' ') }}" class="form-control {{ $errors->has('carga_horaria_semanal')? 'is-invalid':'' }}" id="carga_horaria_semanal" placeholder="">
                  {!! $errors->has('carga_horaria_semanal')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('carga_horaria_semanal').'</small>':'' !!}
                </div> 
              </div>
            </div>   

             <div class="row">
               <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Duração da Aula</label>
                  <input type="text" {{isset($show)?"disabled='disabled'":''}} name="duracao_aula" value="{{ old('duracao_aula',isset($item->duracao_aula)?$item->duracao_aula:' ') }}" class="form-control {{ $errors->has('duracao_aula')? 'is-invalid':'' }}" id="duracao_aula" placeholder="">
                  {!! $errors->has('duracao_aula')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('duracao_aula').'</small>':'' !!}
                </div> 
              </div>
               <div class="col-md-6">
                <div class="form-group">
                  <label class="control-label">Dias Letivos Anual</label>
                  <input type="text" {{isset($show)?"disabled='disabled'":''}} name="dias_letivo_anual" value="{{ old('dias_letivo_anual',isset($item->dias_letivo_anual)?$item->dias_letivo_anual:' ') }}" class="form-control {{ $errors->has('dias_letivo_anual')? 'is-invalid':'' }}" id="dias_letivo_anual" placeholder="">
                  {!! $errors->has('dias_letivo_anual')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('dias_letivo_anual').'</small>':'' !!}
                </div> 
              </div>
            </div>  
            <!--           
                <div class="form-group">
                  <label class="control-label">Imagem <small>(tamanho ideal 600x400)</small></label>
                  <input type="file" {{isset($show)?"disabled='disabled'":''}} name="imagem" id="imagem" class="form-control">
                  {!! $errors->has('imagem	')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('imagem	').'</small>':'' !!}
                </div>        

                @if(isset($item->id))
                    <div class="form-group">
                    <label class="control-label"></label>
                    <img src="/images/componentes_curriculares/{{$item->imagem}}" width="100" alt="">
                    </div>    
                @endif      
              -->                                                
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('admin/componenteCurriculares/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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