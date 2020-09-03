

@extends('app.quiz.layout.main')

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-quora"></i> Questões com Respostas da Campanha {{$quizCampaign->id}} </h1>
          <p>Tabela das Questões com Respostas da Campanha {{$quizCampaign->id}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb side">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Campanha {{$quizCampaign->id}}</li>
          <li class="breadcrumb-item"><a href="{{url('app/campanha/'.$quizCampaign->slug.'/questoes')}}">Questões</a></li>
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
                
    

    <?php 

$min = 1500;
$max = 3500;

$total_questions = $quizCampaign->questions->count();

$answers = \App\Domain\Quiz\Model\QuizAnswer::whereQuizCampaignId($quizCampaign->id)->select('description','quiz_question_id')->get()->groupBy('quiz_question_id');
$total_answers = 0; 

$answers_printed = 0;

$min_answers = 0;
$max_answers = 0;

$districts = \App\Domain\City\Model\District::whereHas('answers',function($query) use ($quizCampaign){
  $query->where('quiz_campaign_id',$quizCampaign->id);
})->get();
$answersDistricts = \App\Domain\Quiz\Model\QuizAnswer::whereQuizCampaignId($quizCampaign->id)->select('district_id')->get()->groupBy('district_id');

//dd($districts);
?>


<tbody>

@foreach($quizCampaign->questions as $k => $question)
    @if ($loop->first)
        <tr>
    @endif
    
    <td>            
        {{ $answers[$question->id][0]->question->description }}

       
        <?php 

          if($max_answers<$answers[$question->id]->count()){
            $max_answers = $answers[$question->id]->count();
          }
          if($min_answers==0){
            $min_answers = $answers[$question->id]->count();
          }else{
            if($answers[$question->id]->count()<$min_answers){
              $min_answers = $answers[$question->id]->count();
            }
          }

          $total_answers += $answers[$question->id]->count();  
        
        ?>
    </td>
    
@endforeach

    
    <td>Bairro</td> 
    </tr>

@for($c = 0; $c < $max_answers; $c++)
  
  <tr>

  @foreach($quizCampaign->questions as $k => $question)

    @if(isset($answers[$question->id][$c]) && strlen($answers[$question->id][$c]->description)>0)

      <td>{{$answers[$question->id][$c]->description}}</td> 

      <?php
          $answers_printed++;
      ?>

    @else 
      <td></td>
    @endif

  @endforeach

     <td>
          @if(isset($districts[$c]))
            {{$districts[$c]->name}}
          @endif
     </td>
                   
    </tr>
  

@endfor

</tbody>


            </table>

<h1>{{$answers_printed}} Respostas na Tabela </h1> 
<h1>{{ $total_answers }} Respostas no Total </h1> 
<h1>{{$total_questions}} Perguntas </h1> 

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








