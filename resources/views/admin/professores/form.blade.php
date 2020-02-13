@extends('layouts.admin.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-user-o"></i> Professores</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('admin/professores')}}">Professores</a></li>
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
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Professor</h3>
            <div class="tile-body">
              {!! Form::open(['url' => 'admin/professores']) !!}
              
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
                  <label class="control-label">Matricula </label>
                  <input type="text" name="matricula" {{isset($show)?"disabled='disabled'":''}} value="{{ old('matricula',isset($item->matricula)?$item->matricula:' ') }}" class="form-control {{ $errors->has('matricula')? 'is-invalid':'' }}" id="matricula" placeholder="">
                  {!! $errors->has('matricula')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('matricula').'</small>':'' !!}
                </div>   

                <div class="form-group">
                  <label class="control-label">CPF </label>
                  <input type="text" name="cpf" {{isset($show)?"disabled='disabled'":''}} value="{{ old('cpf',isset($item->cpf)?$item->cpf:' ') }}" class="form-control {{ $errors->has('cpf')? 'is-invalid':'' }}" id="cpf" placeholder="">
                  {!! $errors->has('cpf')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('cpf').'</small>':'' !!}
                </div>  

                <div class="form-group">
                  <label class="control-label">Data Nascimento </label>
                  <input type="text" name="data_nascimento" {{isset($show)?"disabled='disabled'":''}} value="{{ old('data_nascimento',isset($item->data_nascimento)?$item->data_nascimento:' ') }}" class="form-control {{ $errors->has('data_nascimento')? 'is-invalid':'' }}" id="data_nascimento" placeholder="">
                  {!! $errors->has('data_nascimento')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('data_nascimento').'</small>':'' !!}
                </div>  

                <div class="form-group">
                  <label class="control-label">Endereço </label>
                  <input type="text" name="endereco" {{isset($show)?"disabled='disabled'":''}} value="{{ old('endereco',isset($item->endereco)?$item->endereco:' ') }}" class="form-control {{ $errors->has('endereco')? 'is-invalid':'' }}" id="endereco" placeholder="">
                  {!! $errors->has('endereco')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('endereco').'</small>':'' !!}
                </div>                  

                <div class="form-group">
                  <label class="control-label">Telefone </label>
                  <input type="text" name="telefone" {{isset($show)?"disabled='disabled'":''}} value="{{ old('telefone',isset($item->telefone)?$item->telefone:' ') }}" class="form-control {{ $errors->has('telefone')? 'is-invalid':'' }}" id="endereco" placeholder="">
                  {!! $errors->has('telefone')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('telefone').'</small>':'' !!}
                </div>                    
                                                
                <div class="form-group">
                  <label class="control-label">Email *</label>
                  <input type="email" name="email" {{isset($show)?"disabled='disabled'":''}} value="{{ old('email',isset($item->email)?$item->email:' ') }}" class="form-control {{ $errors->has('email')? 'is-invalid':'' }}" id="email" placeholder="">
                  {!! $errors->has('email')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('email').'</small>':'' !!}
                </div>  

                <div class="form-group">
                  <label class="control-label">Nome Pai </label>
                  <input type="text" name="nome_pai	" {{isset($show)?"disabled='disabled'":''}} value="{{ old('nome_pai	',isset($item->nome_pai	)?$item->nome_pai	:' ') }}" class="form-control {{ $errors->has('nome_pai	')? 'is-invalid':'' }}" id="nome_pai	" placeholder="">
                  {!! $errors->has('nome_pai	')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('nome_pai	').'</small>':'' !!}
                </div>        

                <div class="form-group">
                  <label class="control-label">Nome Mãe </label>
                  <input type="text" name="nome_mae	" {{isset($show)?"disabled='disabled'":''}} value="{{ old('nome_mae	',isset($item->nome_mae	)?$item->nome_mae	:' ') }}" class="form-control {{ $errors->has('nome_mae	')? 'is-invalid':'' }}" id="nome_mae	" placeholder="">
                  {!! $errors->has('nome_mae	')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('nome_mae	').'</small>':'' !!}
                </div>               
                                                              
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('admin/professores/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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
    