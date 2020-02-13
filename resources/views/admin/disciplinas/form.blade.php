@extends('layouts.admin.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-wpexplorer"></i> Disciplinas</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('admin/disciplinas')}}">Disciplinas</a></li>
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
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Disciplina</h3>
            <div class="tile-body">
              {!! Form::open(['url' => 'admin/disciplinas','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                         
                  <div class="form-group">
                    <label class="control-label">Nome *</label>
                    <input type="text" required {{isset($show)?"disabled='disabled'":''}} name="nome" value="{{ old('nome',isset($item->nome)?$item->nome:' ') }}" class="form-control {{ $errors->has('nome')? 'is-invalid':'' }}" id="nome" placeholder="">
                    {!! $errors->has('nome')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('nome').'</small>':'' !!}
                  </div>         
                
                        
                <div class="form-group">
                  <label class="control-label">Imagem <small>(tamanho ideal 600x400)</small></label>
                  <input type="file" {{isset($show)?"disabled='disabled'":''}} name="imagem" id="imagem" class="form-control">
                  {!! $errors->has('imagem	')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('imagem	').'</small>':'' !!}
                </div>        

                @if(isset($item->id))
                    <div class="form-group">
                    <label class="control-label"></label>
                    <img src="/images/disciplinas/{{$item->imagem}}" width="100" alt="">
                    </div>    
                @endif      
                                                              
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('admin/disciplinas/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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