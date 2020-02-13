@extends('layouts.admin.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-vcard-o"></i> Aulas Homologadas</h1>
          <p>Formulário</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('admin/aulaHomologadas')}}">Aulas Homologadas</a></li>
          <li class="breadcrumb-item">Formulário</li>
        </ul>
      </div>

      @include('admin.flash_msg')

      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">{{isset($item->id)?isset($show)?'Mostrar':'Editar':'Cadastrar'}} Aula Homologada</h3>
            <div class="tile-body">
              {!! Form::open(['url' => 'admin/aulaHomologadas']) !!}
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                <div class="form-group">
                  <label class="control-label">Aula *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required="required" class="form-control {{ $errors->has('id_aula')? 'is-invalid':'' }}" id="id_aula" name="id_aula">
                    <option value="">            
                      Selecione o Aula
                    </option>
                    @if(isset($item->id))
                      <option value="{{$item->id_aula}}" {{ old('id_aula') == $item->id_aula ? "selected='selected'" : "selected='selected'" }}>
                         {{$item->aula->nome}}
                      </option>                    
                    @endif
                    @foreach($aulas as $aula)
                      
                      <option value="{{$aula->id}}" {{ old('id_aula') == $aula->id ? "selected='selected'" : isset($item->id_aula) && $item->id_aula == $aula->id ? "selected='selected'" : '' }}>
                         {{$aula->nome}}
                      </option>
                      
                    @endforeach
                  </select>
                  {!! $errors->has('id_aula')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('id_aula').'</small>':'' !!}
                </div>       

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
                  
                <div class="form-group">
                  <label class="control-label">Descrição</label>
                  <textarea {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('descricao')? 'is-invalid':'' }}" rows="2" id="descricao" name="descricao">
                  {{ old('descricao',isset($item->descricao)?$item->descricao:' ') }}
                  </textarea>
                
                  {!! $errors->has('descricao')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('descricao').'</small>':'' !!}
                </div>                     
              
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
    