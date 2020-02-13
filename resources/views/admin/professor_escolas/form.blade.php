@extends('layouts.admin.main')

@section('page-css')
  
@endsection

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-user-o"></i> Professores de Escolas</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('admin/professor_escolas')}}">Professores de Escolas</a></li>
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
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Professor de Escola</h3>
            <div class="tile-body">
              {!! Form::open(['url' => 'admin/professor_escolas']) !!}
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                         
                <div class="form-group">
                  <label class="control-label">Escola</label>
                  <select required class="form-control {{ $errors->has('id_escola')? 'is-invalid':'' }}" id="id_escola" name="id_escola">
                    <option value="">            
                      Selecione a Escola
                    </option>
                    @foreach($escolas as $escola)
                      <option value="{{$escola->id}}" {{ old('id_escola') == $escola->id ? "selected='selected'" : isset($item->id_escola) && $item->id_escola == $escola->id ? "selected='selected'" : '' }}>
                        {{$escola->nome}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('id_escola')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('id_escola').'</small>':'' !!}
                  </div>  

                <div class="form-group">
                  <label class="control-label">Professor *</label>
                  <select required class="form-control {{ $errors->has('id_professor')? 'is-invalid':'' }}" id="id_professor" name="id_professor">
                    <option value="">            
                      Selecione o Professor
                    </option>
                    @foreach($professores as $professor)
                      <option value="{{$professor->id}}" {{ old('id_professor') == $professor->id ? "selected='selected'" : isset($item->id_professor) && $item->id_professor == $professor->id ? "selected='selected'" : '' }}>
                        {{$professor->nome}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('id_professor')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('id_professor').'</small>':'' !!}
                  </div>  
                  
                           
                                                              
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('admin/professor_escolas/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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