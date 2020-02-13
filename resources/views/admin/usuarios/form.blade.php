@extends('layouts.admin.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-user-circle"></i> Usuários</h1>
          <p>Formulário</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('admin/usuarios')}}">Usuários</a></li>
          <li class="breadcrumb-item">Formulário</li>
        </ul>
      </div>

      @include('admin.flash_msg')

      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">{{isset($item->id)?'Editar':'Cadastrar'}} Usuário</h3>
            <div class="tile-body">
              {!! Form::open(['url' => 'admin/usuarios']) !!}
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                
                @if(!App\User::count())
                  <input type="hidden" name="is_admin" value="1" />
                @endif                
                
                <div class="form-group">
                  <label class="control-label">Nome *</label>
                  <input type="text" required name="name" value="{{ old('name',isset($item->name)?$item->name:' ') }}" class="form-control {{ $errors->has('name')? 'is-invalid':'' }}" id="name" placeholder="">
                  {!! $errors->has('name')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('name').'</small>':'' !!}
                </div>          

                <div class="form-group">
                  <label class="control-label">Email *</label>
                  <input type="email" required name="email" value="{{ old('email',isset($item->email)?$item->email:' ') }}" class="form-control {{ $errors->has('email')? 'is-invalid':'' }}" id="email" placeholder="">
                  {!! $errors->has('email')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('email').'</small>':'' !!}
                </div>  
                
                <div class="form-group">
                  <label class="control-label">Cargo</label>
                  <select class="form-control {{ $errors->has('id_cargo')? 'is-invalid':'' }}" id="type_id" name="type_id">
                    <option value="">            
                      Selecione o Cargo
                    </option>
                    @foreach($cargos as $cargo)
                      <option value="{{$cargo->id}}" {{ old('id_cargo') == $cargo->id ? "selected='selected'" : isset($item->id_cargo) && $item->id_cargo == $cargo->id ? "selected='selected'" : '' }}>
                        {{$cargo->nome}}
                      </option>
                    @endforeach
                  </select>
                  {!! $errors->has('id_cargo')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('id_cargo').'</small>':'' !!}
                  </div>  
    
                <div class="form-group">
                  <label class="control-label">Senha *</label>
                  <input type="password" required name="password" value="{{ old('password',isset($item->password)?$item->password:'') }}" class="form-control {{ $errors->has('password')? 'is-invalid':'' }}" id="password" placeholder="">
                  {!! $errors->has('password')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('password').'</small>':'' !!}
                </div>  

                <div class="form-group">
                  <label class="control-label">Confirme a Senha *</label>
                  <input type="password" required name="password_confirmation" class="form-control {{ $errors->has('password_confirmation')? 'is-invalid':'' }}" id="password-confirm" placeholder="">
                  {!! $errors->has('password')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('password_confirmation').'</small>':'' !!}
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
@endsection

@section('page-js')
  
  <script type="text/javascript" src="{{ asset('js/plugins/select2.min.js') }}"></script>
  <script type="text/javascript">
    $('select').select2();
  </script>
@endsection