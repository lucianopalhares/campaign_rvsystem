@extends('layouts.admin.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-podcast"></i> Series</h1>
          <p>Formulário</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('admin/series')}}">Series</a></li>
          <li class="breadcrumb-item">Formulário</li>
        </ul>
      </div>

      @include('admin.flash_msg')

      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">{{isset($item->id)?'Editar':'Cadastrar'}} Serie</h3>
            <div class="tile-body">
              {!! Form::open(['url' => 'admin/series','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                
                <div class="form-group">
                  <label class="control-label">Nome *</label>
                  <input type="text" name="nome" value="{{ old('nome',isset($item->nome)?$item->nome:' ') }}" class="form-control {{ $errors->has('nome')? 'is-invalid':'' }}" id="nome" placeholder="">
                  {!! $errors->has('nome')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('nome').'</small>':'' !!}
                </div>          
                <div class="form-group">
                  <label class="control-label">Ordem <small>(somente numero)</small></label>
                  <input type="text" name="ordem" value="{{ old('ordem',isset($item->ordem)?$item->ordem:' ') }}" class="form-control {{ $errors->has('ordem')? 'is-invalid':'' }}" id="ordem" placeholder="">
                  {!! $errors->has('ordem')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('ordem').'</small>':'' !!}
                </div>  
                <div class="form-group">
                  <label class="control-label">Imagem </label>
                  <input type="file" {{isset($show)?"disabled='disabled'":''}} name="imagem" id="imagem" class="form-control">
                  {!! $errors->has('imagem	')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('imagem	').'</small>':'' !!}
                </div>        

                @if(isset($item->id))
                    <div class="form-group">
                    <label class="control-label"></label>
                    <img src="/images/series/{{$item->imagem}}" width="100" alt="">
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
    