@extends('layouts.admin.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-th-list"></i> Aulas Homologadas &nbsp;&nbsp;<a href="{{url('admin/aulaHomologadas/create')}}" class="text-primary" alt="Cadastrar"><span class="fa fa-plus"></span></a></h1>
          <p>Tabela com todos as Aulas Homologadas</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Aulas Homologadas</li>
          <li class="breadcrumb-item active">Tabela</li>
        </ul>
      </div>
      <div class="flash_msg">
        
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                      <th>Aula</th>
                      <th>Quem Homologou</th>
                      <th>Dificuldade</th>
                      <th>Descrição</th>
                      <th>Hora</th>
                      <th><i class="fa fa-cog"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($items as $item)
                    <tr>
                      <td>
                        <span data-toggle="tooltip" data-placement="top" title="" data-original-title="Ver Detalhes Aula">
                          <a href="javascript:void" class="text-secondary" data-toggle="modal" data-target="#modalVerAula" id="modal" data-aula="{{$item->aula}}">
                            {{$item->aula->nome}}
                          </a>   
                        </span>
                      </td>
                      <td>{{$item->user->name}}</td>
                      <td>{{$item->grau_dificuldade->nome}}</td>
                      <td>{{$item->descricao}}</td>
                      <td>{{date('H:m - d/m/Y', strtotime($item->created_at))}}</td>
                      <td>
                      <a href="{{url('admin/aulaHomologadas/'.$item->id.'/edit')}}" class="text-primary"><span class="fa fa-edit"></span></a>
                      
                      <a href="#" class="text-danger" id="delete_item" data-id="{{ $item->id }}"><span class="fa fa-trash"></span></a>
                                            
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
    
    <div class="modal fade" id="modalVerAula" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">  
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Ver Aula</h5>
            <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span></button>
          </div>
          <div class="modal-body">
            <div class="container-fluid">
              <div class="row">
                <div class="col-sm-4">Nome da Aula:
                </div>
                <div class="col-sm-8" id="aula_nome">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">Disciplina:
                </div>
                <div class="col-sm-8" id="aula_componente_curricular">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">Professor:
                </div>
                <div class="col-sm-8" id="aula_professor">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">DCR/LRV:
                </div>
                <div class="col-sm-8" id="aula_drc_lrv">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">Atividades:
                </div>
                <div class="col-sm-8" id="aula_qtd_atividades">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">Ordem:
                </div>
                <div class="col-sm-8" id="aula_ordem">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">Plano (Doc):
                </div>
                <div class="col-sm-8" id="aula_plano">
                </div>
              </div>
              <div class="row">
                <div class="col-sm-4">Apresentação (Doc):
                </div>
                <div class="col-sm-8" id="aula_apresentacao">
                </div>
              </div>
            </div>
          </div>
          
          <div class="modal-footer">
          <!--  <button class="btn btn-primary" type="button">Salvar</button>-->
            <button class="btn btn-secondary" type="button" data-dismiss="modal">Fechar</button>
          </div>
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

  $( document ).ready(function() {
    
    $("a#modal").click(function(e){

        var aula = $(this).data("aula");
        e.preventDefault();
        
        $("#aula_nome").html(aula.nome+" ("+aula.bimestre+" Bimestre)");
        $("#aula_componente_curricular").html(aula.componente_curricular.disciplina.nome);
        $("#aula_professor").html(aula.professor.nome);
        $("#aula_drc_lrv").html(aula.drc_lrv.campo_atuacao);
        $("#aula_qtd_atividades").html(aula.qtd_atividades);
        $("#aula_ordem").html(aula.ordem);
        if(aula.plano){
          $("#aula_plano").html("<a href='{{asset('arquivos/aulas_planos/')}}"+"/"+aula.plano+"' target='_blank'><i class='fa fa-download'></i></a></td>");
        }
        if(aula.apresentacao){
          $("#aula_plano").html("<a href='{{asset('arquivos/aulas_apresentacoes/')}}"+"/"+aula.apresentacao+"' target='_blank'><i class='fa fa-download'></i></a></td>");
        }
    });

    $("a#delete_item").click(function(e){
              
        var id = $(this).data("id");
        e.preventDefault();
        var token = $("meta[name='csrf-token']").attr("content");
        var url = e.target;
                
        if (confirm("Você tem certeza que quer apagar?")) {
          
          $.ajax({
            url: "aulaHomologadas/"+id, //or you can use url: "company/"+id,
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