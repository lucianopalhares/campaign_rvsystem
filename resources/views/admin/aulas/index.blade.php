@extends('layouts.admin.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-wpexplorer"></i> {{isset($title)?$title:'Aulas'}} &nbsp;&nbsp;<a href="{{url('admin/aulas/create')}}" class="text-primary" data-toggle="tooltip" data-placement="right" title="Cadastrar Aula"><span class="fa fa-plus"></span></a></h1>
          <p>Tabela com {{isset($title)?$title:'todas as Aulas'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Aulas</li>
          <li class="breadcrumb-item active">Tabela</li>
        </ul>
      </div>
      <div class="flash_msg">
        @include('admin.flash_msg')
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                      <th>DRC/LRV (cp.atuação)</th>
                      <th>Nome</th>
                      <th>Professor</th>
                      <th>Homologada</th>
                      <th>Plano</th>
                      <th>Apresentação</th>
                      <th><i class="fa fa-cog"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($items as $item)
                    <tr>
                      <td>{{$item->drc_lrv->campo_atuacao}}</td>
                      <td>{{$item->nome}} ({{$item->componente_curricular->disciplina->nome}} {{$item->componente_curricular->serie->nome}} - {{$item->bimestre}} Bimestre)</td>

                      <td>{{$item->professor->nome}}</td>
                      <td>
                        @if($item->aula_homologada()->exists())
                          <span class="badge badge-primary">Homologada</span>
                        @else 
                          <span class="badge badge-warning">Não Homologada</span>
                        @endif
                      </td>
                      <td>
                        @if(strlen($item->plano)>0)
                        <a href="{{asset('arquivos/aulas_planos/'.$item->plano)}}" target="_blank"><i class="fa fa-download"></i></a></td>
                        @endif
                      <td>
                        @if(strlen($item->apresentacao)>0)
                        <a href="{{asset('arquivos/aulas_apresentacoes/'.$item->apresentacao)}}" target="_blank"><i class="fa fa-download"></i></a>
                        @endif
                      </td>
              
                      <td>              
                      <a href="{{url('admin/aulas/'.$item->id.'/edit')}}" class="text-primary"><span class="fa fa-edit"></span></a>
                      <a href="{{url('admin/aulas/'.$item->id)}}" class="text-secondary"><span class="fa fa-eye"></span></a>
                      <!--if(!item->users()->exists())-->
                        <a href="#" class="text-danger" id="delete_item" data-id="{{ $item->id }}"><span class="fa fa-trash"></span></a>
                      <!--endif   --> 
                      &nbsp;-&nbsp;
                      @if($item->aula_homologada()->exists())
                        <span data-toggle="tooltip" data-placement="left" title="" data-original-title="Excluir Homologação">
                            <a href="#" class="text-danger" id="delete_homologacao" data-id="{{ $item->aula_homologada->id }}">
                              <i class="fa fa-power-off fa-lg"></i>
                            </a>   
                        </span>
                      @else  
                        <span data-toggle="tooltip" data-placement="left" title="" data-original-title="Homologar">
                          <a href="javascript:void" class="text-success" data-toggle="modal" data-target="#modalHomologar" data-aula="{{$item}}" id="modal">
                            <i class="fa fa-power-off fa-lg"></i>
                          </a>   
                        </span>
                      @endif     
                                            
                      </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>

    <div class="modal fade" id="modalHomologar" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">  
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Homologar Aula</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          {!! Form::open(['url' => 'admin/aulaHomologadas']) !!}
          <div class="modal-body"> 
              <input type="hidden" name="id_aula" id="id_aula" value="" />

              <div class="form-group">
                <label for="aula_nome" class="col-form-label">ID Aula:</label>
                <input disabled="disabled" type="text" class="form-control" id="id_aula_print">
              </div>
              
              <div class="form-group">
                <label for="aula_nome" class="col-form-label">Nome Aula:</label>
                <input disabled="disabled" type="text" class="form-control" id="nome_aula">
              </div>
              <div class="form-group">
                <label for="aula_nome" class="col-form-label">Grau de Dificuldade:</label>
                <select class="form-control" onchange="modalPreenchido();" name="id_grau_dificuldade" id="id_grau_dificuldade" required="required">
                  <option value="">
                    Selecione o Grau de Dificuldade
                  </option>
                    @foreach($grau_dificuldades as $grau_dificuldade)
                      <option value="{{$grau_dificuldade->id}}">
                        {{$grau_dificuldade->nome}}
                      </option>
                    @endforeach
                </select>
              </div>
              <div class="form-group">
                <label for="descricao" class="col-form-label">Descrição:</label>
                <textarea required="required" onkeyup="modalPreenchido();" class="form-control" name="descricao" id="descricao"></textarea>
              </div>
            
          </div>
          <div class="modal-footer">
            <button class="btn btn-primary" type="submit" id="buttonHomologar">Confirmar Homologação</button>
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
          </div>
          {{ Form::close() }}
        </div>
      </div>
    </div>
@endsection 

@section('page-js')    

    <script type="text/javascript" src="{{ asset('js/plugins/jquery.dataTables.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('js/plugins/dataTables.bootstrap.min.js') }}"></script>
    <script type="text/javascript">$('#sampleTable').DataTable({
            "language": {
            "lengthMenu": "Mostrar _MENU_ items por pagina",
            "zeroRecords": "Nada encontrado",
            "info": "Mostrando pagina _PAGE_ of _PAGES_",
            "infoEmpty": "Sem datos disponiveis",
            "infoFiltered": "(filtrado de _MAX_ total items)",
            "search" : "Buscar",
            "paginate": {
              "previous": "Anterior",
              "next": "Próximo"
            }
        }
    });</script>
    <!-- Google analytics script-->
    <script type="text/javascript">
      if(document.location.hostname == 'pratikborsadiya.in') {
      	(function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      	(i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      	m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      	})(window,document,'script','//www.google-analytics.com/analytics.js','ga');
      	ga('create', 'UA-72504830-1', 'auto');
      	ga('send', 'pageview');
      }
    </script>
    
<script>

function modalPreenchido() {
    var descricao = $('textarea#descricao').val();
    var id_grau_dificuldade = document.getElementById('id_grau_dificuldade').value;
    if(descricao !='' && id_grau_dificuldade!='') {
      document.querySelector('#buttonHomologar').disabled = false;
    }else{
      document.querySelector('#buttonHomologar').disabled = true;
    }
 }
 
  jQuery(document).ready(function(){

    $("a#modal").click(function(e){
      
        var descricao = $('textarea#descricao').val();
        var id_grau_dificuldade = document.getElementById('id_grau_dificuldade').value;
        if(descricao !='' && id_grau_dificuldade!='') {
          document.querySelector('#buttonHomologar').disabled = false;
        }else{
          document.querySelector('#buttonHomologar').disabled = true;
        }      
        var aula = $(this).data("aula");
        e.preventDefault();
        
        $("#id_aula").val(aula.id);
        $("#id_aula_print").val(aula.id);
        $("#nome_aula").val(aula.nome);
    });
          
    $("a#delete_item").click(function(e){
              
        var id = $(this).data("id");
        e.preventDefault();
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
                
        if (confirm("Você tem certeza que quer apagar?")) {
          
          $.ajax({
            url: "aulas/"+id, //or you can use url: "company/"+id,
            type: 'post',
            dataType: "json",
            data: {
              _token: token,
                  id: id,
                  _method: 'delete'
                },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function (data){
                
                if(data.status){
                  $( ".flash_msg" ).html('<div class="alert alert-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');
              
                  setInterval('location.reload()',1000);
                }else{
                  $( ".flash_msg" ).html('<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');
                }
              }
          });
      }
    });
    $("a#delete_homologacao").click(function(e){
              
        var id = $(this).data("id");
        e.preventDefault();
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
                
        if (confirm("Você tem certeza que quer apagar a Homologação desta Aula?")) {
          
          $.ajax({
            url: "aulaHomologadas/"+id,
            type: 'post',
            dataType: "json",
            data: {
              _token: token,
                  id: id,
                  _method: 'delete'
                },
            headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
              success: function (data){
                
                if(data.status){
                  $( ".flash_msg" ).html('<div class="alert alert-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');
              
                  setInterval('location.reload()',1000);
                }else{
                  $( ".flash_msg" ).html('<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');
                }
              }
          });
      }
    });
  });
</script>
@endsection