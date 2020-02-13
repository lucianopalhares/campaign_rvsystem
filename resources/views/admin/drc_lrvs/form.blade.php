@extends('layouts.admin.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-ravelry"></i> DRC/LRV</h1>
          <p>Formulário</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('admin/drc_lrvs')}}">DRC/LRV</a></li>
          <li class="breadcrumb-item">Formulário</li>
        </ul>
      </div>

      @include('admin.flash_msg')

      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">{{isset($item->id)?'Editar':'Cadastrar'}} DRC/LRV</h3>
            <div class="tile-body">
              {!! Form::open(['url' => 'admin/drc_lrvs']) !!}
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                       
                
                <div class="form-group">
                  <label class="control-label">Campo Atuação *</label>
                  <input type="text" required="required" name="campo_atuacao" value="{{ old('campo_atuacao',isset($item->campo_atuacao)?$item->campo_atuacao:' ') }}" class="form-control {{ $errors->has('campo_atuacao')? 'is-invalid':'' }}" id="campo_atuacao" placeholder="">
                  {!! $errors->has('campo_atuacao')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('campo_atuacao').'</small>':'' !!}
                </div>          

                <div class="form-group">
                  <label class="control-label">Unidade Temática *</label>
                  <input type="text" required="required" name="unidade_tematica" value="{{ old('unidade_tematica',isset($item->unidade_tematica)?$item->unidade_tematica:' ') }}" class="form-control {{ $errors->has('unidade_tematica')? 'is-invalid':'' }}" id="unidade_tematica" placeholder="">
                  {!! $errors->has('unidade_tematica')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('unidade_tematica').'</small>':'' !!}
                </div>  

                <div class="form-group">
                  <label class="control-label">Habilidade Código *</label>
                  <input type="text" required="required" name="habilidade_codigo" value="{{ old('habilidade_codigo',isset($item->habilidade_codigo)?$item->habilidade_codigo:' ') }}" class="form-control {{ $errors->has('habilidade_codigo')? 'is-invalid':'' }}" id="habilidade_codigo" placeholder="">
                  {!! $errors->has('habilidade_codigo')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('habilidade_codigo').'</small>':'' !!}
                </div>  

                <div class="form-group">
                  <label class="control-label">Habilidade Descrição *</label>
                  <textarea rows="2" required="required" name="habilidade_descricao" class="form-control {{ $errors->has('habilidade_descricao')? 'is-invalid':'' }}" id="habilidade_descricao">
                    {{ old('habilidade_descricao',isset($item->habilidade_descricao)?$item->habilidade_descricao:' ') }}
                  </textarea>
                  {!! $errors->has('habilidade_descricao')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('habilidade_descricao').'</small>':'' !!}
                </div>        
                       
                <div class="form-group">
                  <label class="control-label">Objeto Conhecimento Código *</label>
                  <input type="text" name="objeto_conhecimento_codigo" required="required" value="{{ old('objeto_conhecimento_codigo',isset($item->objeto_conhecimento_codigo)?$item->objeto_conhecimento_codigo:' ') }}" class="form-control {{ $errors->has('objeto_conhecimento_codigo')? 'is-invalid':'' }}" id="objeto_conhecimento_codigo" placeholder="">
                  {!! $errors->has('objeto_conhecimento_codigo')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('objeto_conhecimento_codigo').'</small>':'' !!}
                </div>  

                <div class="form-group">
                  <label class="control-label">Objeto Conhecimento Descrição *</label>
                  <textarea rows="2" required="required" name="objeto_conhecimento_descricao" class="form-control {{ $errors->has('objeto_conhecimento_descricao')? 'is-invalid':'' }}" id="objeto_conhecimento_descricao">
                    {{ old('objeto_conhecimento_descricao',isset($item->objeto_conhecimento_descricao)?$item->objeto_conhecimento_descricao:' ') }}
                  </textarea>
                  {!! $errors->has('objeto_conhecimento_descricao')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('objeto_conhecimento_descricao').'</small>':'' !!}
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
    