@extends('layouts.admin.main')

@section('page-css')
  <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/css/bootstrap-datetimepicker.min.css" rel="stylesheet" />
@endsection

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-bomb"></i> Notas de Alunos</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('admin/aluno_notas')}}">Notas de Alunos</a></li>
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
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Notas de Alunos</h3>
            
                {!! Form::open(['url' => 'admin/aluno_notas']) !!}
                <div class="tile-body">   
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                         
                <div class="form-group">
                  <label class="control-label">Aluno</label>
                  <select class="form-control {{ $errors->has('id_aluno')? 'is-invalid':'' }}" id="id_aluno" name="id_aluno">
                    <option value="">            
                      Selecione o Aluno
                    </option>
                    @foreach($alunos as $aluno)
                      <option value="{{$aluno->id}}" {{ old('id_aluno') == $aluno->id ? "selected='selected'" : isset($item->id_aluno) && $item->id_aluno == $aluno->id ? "selected='selected'" : '' }}>
                        {{$aluno->nome}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('id_aluno')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('id_aluno').'</small>':'' !!}
                  </div>  
                                                          
                <div class="form-group">
                  <label class="control-label">Data *</label>
                  <input type="text" required {{isset($show)?"disabled='disabled'":''}} name="data" value="{{ old('data',isset($item->data)?date('d/m/Y', strtotime($item->data)):' ') }}" class="form-control {{ $errors->has('data')? 'is-invalid':'' }}" id="data" placeholder="">
                  {!! $errors->has('data')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('data').'</small>':'' !!}
                </div>            
                         
                <div class="form-group">
                  <label class="control-label">Nota *</label>
                  <input type="text" required {{isset($show)?"disabled='disabled'":''}} name="nota" value="{{ old('nota',isset($item->nota)?date('d/m/Y', strtotime($item->nota)):' ') }}" class="form-control {{ $errors->has('nota')? 'is-invalid':'' }}" id="nota" placeholder="">
                  {!! $errors->has('nota')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('nota').'</small>':'' !!}
                </div>  
                       
                                                              
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('admin/aluno_notas/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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
  
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>
  <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/locale/pt-br.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>
  <script type="text/javascript" src="{{ asset('js/plugins/select2.min.js') }}"></script>
  <script type="text/javascript">
    $('select').select2();

    $(document).ready(function () {
      $('#data').datetimepicker({
        format: '{{ config('app.date_format_javascript') }}',
        locale: 'pt-br'
      });
    });
      
  </script>
@endsection