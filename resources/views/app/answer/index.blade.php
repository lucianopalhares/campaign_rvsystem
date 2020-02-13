@extends('app.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-quote-right"></i> {{isset($title)?$title:'Respostas'}} &nbsp;&nbsp;<a href="{{url('app/quiz/respostas/create')}}" class="text-primary" data-toggle="tooltip" data-placement="right" title="Cadastrar Resposta"><span class="fa fa-plus"></span></a></h1>
          <p>Tabela com {{isset($title)?$title:'todas as Respostas'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Respostas</li>
          <li class="breadcrumb-item active">Tabela</li>
        </ul>
      </div>
      <div class="flash_msg">
        @include('app.layout.flash_msg')
      </div>
      <div class="row">
        <div class="col-md-12">
          <div class="tile">
            <div class="tile-body">
              <div class="table-responsive">
                <table class="table table-hover table-bordered" id="sampleTable">
                  <thead>
                    <tr>
                      <th>#</th>
                      <th>Municipe</th>
                      <th>Descrição</th>                      
                      <th>Opção</th>
                      <th>Questão</th>
                      <th>Campanha</th>
                      <th><i class="fa fa-cog"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($items as $item)
                    <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->name}}</td>
                      <td>{{$item->description}}</td>
                      <td><span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{'id:'.$item->quiz_option_id.' / '.$item->option->description}}">{{substr($item->option->description, -15).'..'}}</span></td>
                      <td><span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{'id:'.$item->quiz_question_id.' / '.$item->question->description}}">{{substr($item->question->description, -15).'..'}}</span></td>             
                      <td><span data-toggle="tooltip" data-placement="top" title="" data-original-title="{{'id:'.$item->quiz_campaign_id.' / '.$item->campaign->description}}">{{substr($item->campaign->description, -15).'..'}}</span></td>             
                                            
                      <td>              
                      <a href="{{url('app/quiz/respostas/'.$item->id.'/edit')}}" class="text-primary"><span class="fa fa-edit" data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar"></span></a>
                      <a href="{{url('app/quiz/respostas/'.$item->id)}}" class="text-secondary"><span class="fa fa-eye" data-toggle="tooltip" data-placement="left" title="" data-original-title="Visualizar"></span></a>
                        <form name="delete" action="{{ route('respostas.destroy', $item->id) }}" method="POST" style="display: none;">
                            @method('DELETE')
                            @csrf
                        </form>                    
                        <a href="javascript:void" class="text-danger" onclick="if(confirm('Você quer mesmo deletar?'))document.delete.submit();"><span class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="" data-original-title="Excluir"></span></a>
                      
                      &nbsp;                                           
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
    

@endsection