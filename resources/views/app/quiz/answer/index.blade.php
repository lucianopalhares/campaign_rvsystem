@extends('app.quiz.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-quote-right"></i> {{isset($title)?$title:'Respostas'}} da Campanha {{$quizCampaign->id}} &nbsp;&nbsp;<a href="{{url('app/campanha/'.$quizCampaign->slug.'/respostas/create')}}" class="text-primary" data-toggle="tooltip" data-placement="right" title="Responder uma Questão"><span class="fa fa-plus"></span></a></h1>
          <p>Tabela com {{isset($title)?$title:'todas as Respostas'}} da Campanha {{$quizCampaign->id}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Campanha {{$quizCampaign->id}}</li>
          <li class="breadcrumb-item"><a href="{{url('app/campanha/'.$quizCampaign->slug.'/respostas')}}">Respostas</a></li>
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
                      <th><input type="checkbox" id="master"> <button class="btn btn-danger btn-xs delete_all" data-url="{{url('app/campanha/'.$quizCampaign->slug.'/deletar-respostas-selecionadas')}}"><span class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="" data-original-title="Excluir"></span></button></th>
                      <th>ID</th>
                      <th>Municipe</th>
                      <th>Questão</th>  
                      <th>Resposta</th>
                      <th><i class="fa fa-cog"></i></th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach($items as $item)
                    <tr id="tr_{{$item->id}}">
                      <td><input type="checkbox" class="sub_chk" data-id="{{$item->id}}"></td>
                      <td>{{$item->id}}</td>
                      <td>{{$item->name}}</td>
                      <td>
                        
                        {{$item->question->getDescription()}}    
                        @if($item->question->options_required)
                          <a href="{{url('app/campanha/'.$quizCampaign->slug.'/opcoes?quiz_question_id='.$item->quiz_question_id)}}" target="_blank" data-toggle="tooltip" data-placement="left" title="" data-original-title="Abrir uma nova Guia de Página com Opções Somente desta Questão">
                            <small><i class="fa fa-list" data-toggle="tooltip" data-placement="left" title="" data-original-title="Multipla Escolha"></i></small>
                          </a> 
                        @endif   
                                                        
                      </td>
                      <td>
                       
                        {{$item->description?$item->description:''}}
                      </td>              
                      <td>              
                      <a href="{{url('app/campanha/'.$quizCampaign->slug.'/respostas/'.$item->id.'/edit')}}" class="text-primary"><span class="fa fa-edit" data-toggle="tooltip" data-placement="left" title="" data-original-title="Editar"></span></a>
                      <a href="{{url('app/campanha/'.$quizCampaign->slug.'/respostas/'.$item->id)}}" class="text-secondary"><span class="fa fa-eye" data-toggle="tooltip" data-placement="left" title="" data-original-title="Visualizar"></span></a>
                      
                        <form name="delete{{$item->id}}" action="{{url('app/campanha/'.$quizCampaign->slug.'/respostas/'.$item->id)}}" method="POST" style="display: none;">
                            @method('DELETE')
                            @csrf
                        </form>                    
                        <a href="javascript:void" class="text-danger" onclick="if(confirm('Você quer mesmo deletar?'))return document.delete{{$item->id}}.submit();"><span class="fa fa-trash" data-toggle="tooltip" data-placement="left" title="" data-original-title="Excluir"></span></a>
                                                                  
                     
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
    
    <script type="text/javascript">
    $(document).ready(function () {


        $('#master').on('click', function(e) {
         if($(this).is(':checked',true))  
         {
            $(".sub_chk").prop('checked', true);  
         } else {  
            $(".sub_chk").prop('checked',false);  
         }  
        });


        $('.delete_all').on('click', function(e) {


            var allVals = [];  
            $(".sub_chk:checked").each(function() {  
                allVals.push($(this).attr('data-id'));
            });  


            if(allVals.length <=0)  
            {  
                alert("Selecione a linha.");  
            }  else {  


                var check = confirm("Quer mesmo excluir esta linha?");  
                if(check == true){  


                    var join_selected_values = allVals.join(","); 


                    $.ajax({
                        url: $(this).data('url'),
                        type: 'POST',
                        dataType: "json",
                        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
                        data: 'ids='+join_selected_values,
                        success: function (data) {
                        
                            if (data.status) {
                                $(".sub_chk:checked").each(function() {  
                                    $(this).parents("tr").remove();
                                });
                                
                                $( ".flash_msg" ).html('<div class="alert alert-success text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');

                            } else if (!data.status) {
                              $( ".flash_msg" ).html('<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.msg+'</div>');
                            } else {
                              $( ".flash_msg" ).html('<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>Ops, parece que algo deu errado!</div>');
                            }
                        },
                        error: function (data) {
                            $( ".flash_msg" ).html('<div class="alert alert-danger text-center" role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>'+data.responseText+'</div>');
                        }
                    });


                  $.each(allVals, function( index, value ) {
                      $('table tr').filter("[data-row-id='" + value + "']").remove();
                  });
                }  
            }  
        });

    });
</script>
@endsection