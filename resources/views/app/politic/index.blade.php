@extends('app.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-male"></i> {{isset($title)?$title:'Politicos'}} &nbsp;&nbsp;<a href="{{url('app/politicos/create')}}" class="text-primary" data-toggle="tooltip" data-placement="right" title="Cadastrar Politico"><span class="fa fa-plus"></span></a></h1>
          <p>Tabela com {{isset($title)?$title:'todos os Politicos'}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Politicos</li>
          <li class="breadcrumb-item active">Tabela</li>
        </ul>
      </div>
      <div class="flash_msg">
        @include('app._utils.flash_msg')
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
                      <th>Nome</th>                                          
                      <th>Cargo</th>
                      <th>Partido</th>  
                      <th><i class="fa fa-cog"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($items as $item)
                    <tr>
                      <td>{{$item->id}}</td>
                      <td>{{$item->person->getFullNameAttribute()}}</td>                      
                      <td>{{$item->office->name}}</td>   
                      <td>{{$item->party->name}}</td>                    
                      <td>              
                      <a href="{{url('app/politicos/'.$item->id.'/edit')}}" class="text-primary"><span class="fa fa-edit" data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar"></span></a>
                      <a href="{{url('app/pessoas/'.$item->id)}}" target="_blank" class="text-secondary"><span class="fa fa-eye" data-toggle="tooltip" data-placement="left" title="" data-original-title="Visualizar os dados pessoais"></span></a>
                      @if(!$item->questions()->exists()&&!$item->options()->exists())
                        <form name="delete{{$item->id}}" action="{{url('app/politicos/'.$item->id)}}" method="POST" style="display: none;">
                            @method('DELETE')
                            @csrf
                        </form>                    
                        <a href="javascript:void" class="text-danger" onclick="if(confirm('Você quer mesmo deletar?'))return document.delete{{$item->id}}.submit();"><span class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="" data-original-title="Excluir"></span></a>
                      
                      @endif
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