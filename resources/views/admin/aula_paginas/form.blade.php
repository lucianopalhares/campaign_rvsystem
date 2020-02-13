@extends('layouts.admin.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-wpexplorer"></i> Páginas das Aulas</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('admin/paginas_aula')}}">Páginas das Aulas</a></li>
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
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Página de Aula</h3>
            <div class="tile-body">
              {!! Form::open(['url' => 'admin/paginas_aula','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif


                <div class="form-group">
                  <label class="control-label">Selecione a Aula *</label>
                  <select {{isset($show)?"disabled='disabled'":''}} required class="form-control {{ $errors->has('aula_id')? 'is-invalid':'' }}" required id="aula_id" name="aula_id">
                    <option value="">            
                      Selecione a Aula
                    </option>
                    @foreach($aulas as $aula)
                      <option value="{{$aula->id}}" {{ old('aula_id') == $aula->id ? "selected='selected'" : isset($item->aula_id) && $item->aula_id == $aula->id ? "selected='selected'" : '' }}>
                        {{$aula->nome}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('aula_id')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('aula_id').'</small>':'' !!}
                  </div>  
              
                                                                               
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('admin/paginas_aula/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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