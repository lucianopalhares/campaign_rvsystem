@extends('app.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-users"></i> Pessoas</h1>
          <p>{{isset($show)?'Ver':'Formulário'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item"><a href="{{url('app/pessoas')}}">Pessoas</a></li>
          <li class="breadcrumb-item">{{isset($show)?'Ver':'Formulário'}}</li>
        </ul>
      </div>

      @include('app.layout.flash_msg')

      <div class="row">
        <div class="col-md-3">
        </div>
        <div class="col-md-6">
          <div class="tile">
            <h3 class="tile-title">
              
              {{isset($item->id)?isset($show)?'Ver':'Editar':'Cadastrar'}} Pessoa</h3>
            <div class="tile-body">
              
              @if(isset($item))
                {!! Form::open(['url' => 'app/pessoas/'.$item->id,'method'=>'PUT','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @else 
                {!! Form::open(['url' => 'app/pessoas','method'=>'POST','enctype' => 'multipart/form-data','files'=>true]) !!}
              
              @endif
              
                @if(isset($item->id))
                <div class="form-group">
                  <label class="control-label">ID: </label>
                  {{$item->id}}
                  <input type="hidden" name="id" value="{{$item->id}}" />
                </div>   
                @endif
                
                <div class="row">
                  <div class="col-5">
                    <div class="form-group">                  
                      <label class="control-label">Nome *</label>
                      <input type="text" required="required" {{isset($show)?"disabled='disabled'":''}} name="first_name" value="{{ old('first_name',isset($item->first_name)?$item->first_name:' ') }}" class="form-control {{ $errors->has('first_name')? 'is-invalid':'' }}" id="first_name" placeholder="">
                      {!! $errors->has('first_name')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('first_name').'</small>':'' !!}
                    </div>                        
                  </div>
                  <div class="col-7">
                    <div class="form-group">                  
                      <label class="control-label">Sobrenome *</label>
                      <input type="text" required="required" {{isset($show)?"disabled='disabled'":''}} name="last_name" value="{{ old('last_name',isset($item->last_name)?$item->last_name:' ') }}" class="form-control {{ $errors->has('last_name')? 'is-invalid':'' }}" id="last_name" placeholder="">
                      {!! $errors->has('last_name')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('last_name').'</small>':'' !!}
                    </div>                        
                  </div>
                </div>
                
                <div class="row">
                  <div class="col-5">
                    <div class="form-group">                  
                      <label class="control-label">CPF *</label>
                      <input type="text" required="required" {{isset($show)?"disabled='disabled'":''}} name="cpf" value="{{ old('cpf',isset($item->cpf)?$item->cpf:' ') }}" class="form-control {{ $errors->has('cpf')? 'is-invalid':'' }}" id="cpf" placeholder="">
                      {!! $errors->has('cpf')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('cpf').'</small>':'' !!}
                    </div>                        
                  </div>
                  <div class="col-7">
                    <div class="form-group">
                      <label class="control-label">Sexo * </label>
                      <select required="required" {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('sex')? 'is-invalid':'' }}" id="sex" name="sex">

                          <option value="">
                            Selecione
                          </option>
                          <option value="M" {{ old('sex') == "M" ? "selected='selected'" : isset($item->sex) && $item->sex == "M" ? "selected='selected'" : " " }}>
                            Masculino
                          </option>
                          <option value="F" {{ old('sex') == "F" ? "selected='selected'" : isset($item->sex) && $item->sex == "F" ? "selected='selected'" : " " }}>
                            Feminino
                          </option>                                                                                                                                  
                      </select>
                      {!! $errors->has('sex')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('sex').'</small>':'' !!}
                    </div>                          
                  </div>
                </div>
                
                <hr />

                <div class="row">
                  <div class="col-3">
                    <div class="form-group">                  
                      <label class="control-label">Idade</label>
                      <input type="text" {{isset($show)?"disabled='disabled'":''}} name="years_old" value="{{ old('years_old',isset($item->years_old)?$item->years_old:' ') }}" class="form-control {{ $errors->has('years_old')? 'is-invalid':'' }}" id="years_old" placeholder="00">
                      {!! $errors->has('years_old')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('years_old').'</small>':'' !!}
                    </div>                        
                  </div>
                  <div class="col-5">
                    <div class="form-group">                  
                      <label class="control-label">Data de Nascimento</label>
                      <input type="text" {{isset($show)?"disabled='disabled'":''}} name="birth" value="{{ old('birth',isset($item->birth)?date('d/m/Y', strtotime($item->birth)):' ') }}" class="form-control {{ $errors->has('birth')? 'is-invalid':'' }}" id="birth" placeholder="99/99/9999">
                      {!! $errors->has('birth')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('birth').'</small>':'' !!}
                    </div>                        
                  </div>
                  <div class="col-4">
                    <div class="form-group">                  
                      <label class="control-label">Apelido </label>
                      <input type="text" {{isset($show)?"disabled='disabled'":''}} name="nickname" value="{{ old('nickname',isset($item->nickname)?$item->nickname:' ') }}" class="form-control {{ $errors->has('nickname')? 'is-invalid':'' }}" id="nickname" placeholder="">
                      {!! $errors->has('nickname')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('nickname').'</small>':'' !!}
                    </div>                          
                  </div>
                </div>                     
                
                <div class="row">
                  <div class="col-8">                
                    <div class="form-group">
                      <label class="control-label">Escolaridade </label>
                      <select {{isset($show)?"disabled='disabled'":''}} class="form-control {{ $errors->has('education_level')? 'is-invalid':'' }}" id="education_level" name="education_level">

                          <option value="">
                            Selecione
                          </option>
                          <option value="Ensino Fundamental / Incompleto" {{ old('education_level') == "Ensino Fundamental / Incompleto" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Ensino Fundamental / Incompleto" ? "selected='selected'" : " " }}>
                            Ensino Fundamental / Incompleto
                          </option>
                          <option value="Ensino Fundamental / Completo" {{ old('education_level') == "Ensino Fundamental / Completo" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Ensino Fundamental / Completo" ? "selected='selected'" : " " }}>
                            Ensino Fundamental / Completo
                          </option> 
                          <option value="Ensino Médio / Incompleto" {{ old('education_level') == "Ensino Médio / Incompleto" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Ensino Médio / Incompleto" ? "selected='selected'" : " " }}>
                            Ensino Médio / Incompleto
                          </option> 
                          <option value="Ensino Médio / Completo" {{ old('education_level') == "Ensino Médio / Completo" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Ensino Médio / Completo" ? "selected='selected'" : " " }}>
                            Ensino Médio / Completo
                          </option> 
                          <option value="Nunca Estudou" {{ old('education_level') == "Nunca Estudou" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Nunca Estudou" ? "selected='selected'" : " " }}>
                            Nunca Estudou
                          </option> 
                          <option value="Superior / Incompleto" {{ old('education_level') == "Superior / Incompleto" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Superior / Incompleto" ? "selected='selected'" : " " }}>
                            Superior / Incompleto
                          </option>
                          <option value="Superior / Completo" {{ old('education_level') == "Superior / Completo" ? "selected='selected'" : isset($item->education_level) && $item->education_level == "Superior / Completo" ? "selected='selected'" : " " }}>
                            Superior / Completo
                          </option>
                                                                                                                                                                       
                      </select>
                      {!! $errors->has('education_level')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('education_level').'</small>':'' !!}
                      </div>    
                        
                  </div>
                  <div class="col-4">
                    <div class="form-group">                  
                      <label class="control-label">Salário </label>
                      <input type="text" {{isset($show)?"disabled='disabled'":''}} name="salary" value="{{ old('salary',isset($item->salary)?$item->salary:' ') }}" class="form-control {{ $errors->has('salary')? 'is-invalid':'' }}" id="salary" placeholder="">
                      {!! $errors->has('salary')? '<small id="passwordHelpBlock" class="form-text text-danger">'.$errors->first('salary').'</small>':'' !!}
                    </div>                          
                  </div>
                </div>
                    
                @if(isset($item) && $item->user_id>0)  
                  <hr />
                  <div class="row text-center">
                    <div class="col-12">
                      <div class="form-group">                  
                        <label class="control-label">Usuário </label>
                        <input type="text" disabled='disabled' value="{{$item->user->email}}" class="form-control">
                        <small id="passwordHelpBlock" class="form-text text-danger"><i>* no cadastro/edição de Usuário é que se escolhe a pessoa</i></small>
                      </div>                        
                    </div>
                  </div>  
                @endif
                <input type="hidden" name="user_id" value="" />
                
                                                                               
            </div>
            <div class="tile-footer">
              @if(!isset($show))
              <button class="btn btn-primary" type="submit"><i class="fa fa-fw fa-lg fa-check-circle"></i>Salvar</button>&nbsp;&nbsp;&nbsp;
              @else
              <a href="{{url('app/pessoas/'.$item->id.'/edit')}}" class="btn btn-secondary"><i class="fa fa-fw fa-lg fa-check-circle"></i>Editar</a>
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