@extends('layouts.admin.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-wpexplorer"></i> Aulas</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('admin/aulas')}}">Aulas</a></li>
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
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Aula</h3>
            <div class="tile-body">
              {!! Form::open(['url' => 'admin/aulas','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif


                <div class="form-group">
                  <label class="control-label">DRC/LRV *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required class="form-control {{ $errors->has('id_drc_lrv')? 'is-invalid':'' }}" required id="id_drc_lrv" name="id_drc_lrv">
                    <option value="">            
                      Selecione o DRC/LRV
                    </option>
                    @foreach($drc_lrvs as $drc_lrv)
                      <option value="{{$drc_lrv->id}}" {{ old('id_drc_lrv') == $drc_lrv->id ? "selected='selected'" : isset($item->id_drc_lrv) && $item->id_drc_lrv == $drc_lrv->id ? "selected='selected'" : '' }}>
                        {{$drc_lrv->campo_atuacao}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('id_drc_lrv')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('id_drc_lrv').'</small>':'' !!}
                  </div>  
                                           
                  <div class="form-group">
                    <label class="control-label">Nome da Aula *</label>
                    <input type="text" required {{isset($show)?"disabled='disabled'":''}} name="nome" value="{{ old('nome',isset($item->nome)?$item->nome:' ') }}" class="form-control {{ $errors->has('nome')? 'is-invalid':'' }}" id="nome" placeholder="">
                    {!! $errors->has('nome')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('nome').'</small>':'' !!}
                  </div>         
                  
                <div class="form-group">
                  <label class="control-label">Componente Curricular *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required class="form-control {{ $errors->has('id_componente_curricular')? 'is-invalid':'' }}" required id="id_componente_curricular" name="id_componente_curricular">
                    <option value="">            
                      Selecione o Componente Curricular
                    </option>
                    @foreach($componente_curriculares as $componente_curricular)
                      <option value="{{$componente_curricular->id}}" {{ old('id_componente_curricular') == $componente_curricular->id ? "selected='selected'" : isset($item->id_componente_curricular) && $item->id_componente_curricular == $componente_curricular->id ? "selected='selected'" : '' }}>
                        {{$componente_curricular->disciplina->nome}} ({{$componente_curricular->serie->nome}})
                        @if(strlen($componente_curricular->area)>0)
                          {{$componente_curricular->area}}
                        @endif                        
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('id_componente_curricular')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('id_componente_curricular').'</small>':'' !!}
                  </div>  

                <div class="form-group">
                  <label class="control-label">Professor(a) *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required class="form-control {{ $errors->has('id_professor')? 'is-invalid':'' }}" required id="id_professor" name="id_professor">
                    <option value="">            
                      Selecione o Professor(a)
                    </option>
                    @foreach($professores as $professor)
                      <option value="{{$professor->id}}" {{ old('id_professor') == $professor->id ? "selected='selected'" : isset($item->id_professor) && $item->id_professor == $professor->id ? "selected='selected'" : '' }}>
                        {{$professor->nome}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('id_professor')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('id_professor').'</small>':'' !!}
                  </div> 
<!--
                <div class="form-group">
                  <label class="control-label">Grau de Dificuldade *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required class="form-control {{ $errors->has('id_grau_dificuldade')? 'is-invalid':'' }}" required id="id_grau_dificuldade" name="id_grau_dificuldade">
                    <option value="">            
                      Selecione o Grau de Dificuldade
                    </option>
                    @foreach($grau_dificuldades as $grau_dificuldade)
                      <option value="{{$grau_dificuldade->id}}" {{ old('id_grau_dificuldade') == $grau_dificuldade->id ? "selected='selected'" : isset($item->id_grau_dificuldade) && $item->id_grau_dificuldade == $grau_dificuldade->id ? "selected='selected'" : '' }}>
                        {{$grau_dificuldade->nome}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('id_grau_dificuldade')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('id_grau_dificuldade').'</small>':'' !!}
                  </div> 
-->
                <div class="form-group">
                  <label class="control-label">Grau de Dificuldade *</label>
                  <input disabled="disabled" type="text" value="Baixa" class="form-control">
                
                </div> 
                                  
                <div class="form-group">
                  <label class="control-label">Ordem <small>(somente numero)</small></label>
                  <input {{isset($show)?"disabled='disabled'":''}} type="text" name="ordem" value="{{ old('ordem',isset($item->ordem)?$item->ordem:' ') }}" class="form-control {{ $errors->has('ordem')? 'is-invalid':'' }}" id="ordem" placeholder="">
                  {!! $errors->has('ordem')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('ordem').'</small>':'' !!}
                </div>                    

                <div class="form-group">
                  <label class="control-label">Qte Atividade <small>(somente numero)</small></label>
                  <input {{isset($show)?"disabled='disabled'":''}} type="text" name="qtd_atividades" value="{{ old('qtd_atividades',isset($item->qtd_atividades)?$item->qtd_atividades:' ') }}" class="form-control {{ $errors->has('qtd_atividades')? 'is-invalid':'' }}" id="qtd_atividades" placeholder="">
                  {!! $errors->has('qtd_atividades')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('qtd_atividades').'</small>':'' !!}
                </div>                 
                  
                <div class="form-group">
                  <label class="control-label">Bimestre</label>
                  <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('bimestre')? 'is-invalid':'' }}" required id="bimestre" name="bimestre">
                    <option value="">            
                      Selecione o Bimestre
                    </option>
                      <option value="1º" {{ old('bimestre') == "1º" ? "selected='selected'" : isset($item->bimestre) && $item->bimestre == "1º" ? "selected='selected'" : '' }}>
                        1º
                      </option>
                      <option value="2º" {{ old('bimestre') == "2º" ? "selected='selected'" : isset($item->bimestre) && $item->bimestre == "2º" ? "selected='selected'" : '' }}>
                        2º
                      </option>
                      <option value="3º" {{ old('bimestre') == "3º" ? "selected='selected'" : isset($item->bimestre) && $item->bimestre == "3º" ? "selected='selected'" : '' }}>
                        3º
                      </option>    
                      <option value="4º" {{ old('bimestre') == "4º" ? "selected='selected'" : isset($item->bimestre) && $item->bimestre == "4º" ? "selected='selected'" : '' }}>
                        4º
                      </option>
                      <option value="5º" {{ old('bimestre') == "5º" ? "selected='selected'" : isset($item->bimestre) && $item->bimestre == "5º" ? "selected='selected'" : '' }}>
                        5º
                      </option>
                      <option value="6º" {{ old('bimestre') == "6º" ? "selected='selected'" : isset($item->bimestre) && $item->bimestre == "6º" ? "selected='selected'" : '' }}>
                        6º
                      </option>                   
                  </select>
                  {!! $errors->has('bimestre')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('bimestre').'</small>':'' !!}
                  </div>                                      
            
                <div class="form-group">
                  <label class="control-label">Arquivo de Plano <small></small></label>
                  <input type="file" {{isset($show)?"disabled='disabled'":''}} name="plano" id="plano" class="form-control">
                  {!! $errors->has('plano	')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('plano	').'</small>':'' !!}
                </div>      
                <div class="form-group">
                  <label class="control-label">Arquivo de Apresentação <small></small></label>
                  <input type="file" {{isset($show)?"disabled='disabled'":''}} name="apresentacao" id="apresentacao" class="form-control">
                  {!! $errors->has('apresentacao	')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('apresentacao	').'</small>':'' !!}
                </div>  
                                                                               
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('admin/aulas/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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