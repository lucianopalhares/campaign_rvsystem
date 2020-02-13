@extends('layouts.admin.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-etsy"></i> Escolas</h1>
          <p>Formulário</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('admin/escolas')}}">Escolas</a></li>
          <li class="breadcrumb-item">Formulário</li>
        </ul>
      </div>

      @include('admin.flash_msg')

      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">{{isset($item->id)?'Editar':'Cadastrar'}} Escola</h3>
            <div class="tile-body">
              {!! Form::open(['url' => 'admin/escolas']) !!}
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                       
                
                <div class="form-group">
                  <label class="control-label">Nome *</label>
                  <input type="text" required name="nome" value="{{ old('nome',isset($item->nome)?$item->nome:' ') }}" class="form-control {{ $errors->has('nome')? 'is-invalid':'' }}" id="nome" placeholder="">
                  {!! $errors->has('nome')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('nome').'</small>':'' !!}
                </div>          

                <div class="form-group">
                  <label class="control-label">Código Inep *</label>
                  <input type="text" required name="codigo_inep" value="{{ old('codigo_inep',isset($item->codigo_inep)?$item->codigo_inep:' ') }}" class="form-control {{ $errors->has('codigo_inep')? 'is-invalid':'' }}" id="codigo_inep" placeholder="">
                  {!! $errors->has('codigo_inep')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('codigo_inep').'</small>':'' !!}
                </div>  

                <div class="form-group">
                  <label class="control-label">Endereço *</label>
                  <input type="text" required name="endereco" value="{{ old('endereco',isset($item->endereco)?$item->endereco:' ') }}" class="form-control {{ $errors->has('endereco')? 'is-invalid':'' }}" id="endereco" placeholder="">
                  {!! $errors->has('endereco')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('endereco').'</small>':'' !!}
                </div>  

                <div class="form-group">
                  <label class="control-label">Bairro *</label>
                  <input type="text" required name="bairro" value="{{ old('bairro',isset($item->bairro)?$item->bairro:' ') }}" class="form-control {{ $errors->has('bairro')? 'is-invalid':'' }}" id="bairro" placeholder="">
                  {!! $errors->has('bairro')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('bairro').'</small>':'' !!}
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
    