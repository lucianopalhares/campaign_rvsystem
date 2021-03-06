@extends('app.quiz.layout.main')

@section('main')

    <main class="app-content">
      @include('app._utils.flash_msg')
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Dashboard
      
          </h1>
          <p>Gráficos com Questões de Multipla Escolha e que possuem Respostas
            <a href="{{url('app/campanha/'.$quizCampaign->slug.'/relatorio')}}" target="_blank" data-toggle="tooltip" data-placement="left" title="" data-original-title="Gerar Relatório">
              <span class="badge badge-secondary"><i class="fa fa-download"></i>&nbsp; Gerar Relatório</span>
          
            </a>  
            <a href="{{url('app/campanha/'.$quizCampaign->slug.'/espelho')}}" target="_blank" data-toggle="tooltip" data-placement="left" title="" data-original-title="Gerar Espelho da Pesquisa">
              <span class="badge badge-secondary"><i class="fa fa-download"></i>&nbsp; Gerar Espelho da Pesquisa</span>
          
            </a>            
        </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Campanha {{$quizCampaign->id}}</li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
      </div>
      
      @foreach($quizCampaign->questions as $question)
        @if($question->options_required=='1'&&$question->answers->count()>0)
        <div class="row">
          
          <div class="col-md-2"></div>
          <div class="col-md-8">
            <div class="tile">
              <h3 class="tile-title">{{$question->getDescription()}}</h3>
              <div class="embed-responsive embed-responsive-16by9">
                <canvas class="embed-responsive-item" id="barChart{{$question->id}}"></canvas>
              </div>
            </div>
          </div>
          <div class="col-md-2"></div>
          <!--
          <div class="col-md-6 col-lg-3" data-toggle="tooltip" data-placement="top" title="Ir para Lista de Questões">
            <a href="{{url('app/campanha/'.$quizCampaign->slug.'/questoes')}}" target="_blank">
            <div class="widget-small danger coloured-icon"><i class="icon fa fa-quora fa-3x"></i>
              <div class="info">
                <h5>Questões</h5>
                <p><b>{{$quizCampaign->questions->count()}}</b></p>
              </div>
            </div>
            </a>
          </div>
          <div class="col-md-6 col-lg-3" data-toggle="tooltip" data-placement="top" title="Ver Todas Opções">
            <a href="{{url('app/campanha/'.$quizCampaign->slug.'/opcoes')}}" target="_blank">
            <div class="widget-small warning coloured-icon"><i class="icon fa fa-list fa-3x"></i>
              <div class="info">
                <h4>Opções</h4>
                <p><b>{{$quizCampaign->options->count()}}</b></p>
              </div>
            </div>
            </a>
          </div>        
          <div class="col-md-6 col-lg-3" data-toggle="tooltip" data-placement="top" title="Ver Lista de Todas Respostas">
            <a href="{{url('app/campanha/'.$quizCampaign->slug.'/respostas')}}" target="_blank">
            <div class="widget-small primary coloured-icon"><i class="icon fa fa-quote-right fa-3x"></i>
              <div class="info">
                <h4>Respostas</h4>
                <p><b>{{$quizCampaign->answers->count()}}</b></p>
              </div>
            </div>
            </a>
          </div>
        -->

        </div>
        @endif
      @endforeach
    </main>

@endsection 

@section('page-js') 

<script type="text/javascript">
  $(document).ready(function() {
    var baseElement = document.querySelector("body");
    //alert(baseElement);
});
  
</script>
    <!-- Page specific javascripts-->
    <script type="text/javascript" src="{{ asset('js/plugins/chart.js') }}"></script>
    <script type="text/javascript">
    
      @foreach($quizCampaign->questions as $question)
    
        @if($question->options_required=='1'&&$question->answers->count()>0)
        
          var labels = [];
          var datas = [];
          
          @foreach($question->options as $option)
                  
            labels.push("{{$option->getDescription()}}");
            datas.push("{{round($option->answers->count()*100/$question->answers->count())}}");
          
          @endforeach
        
          var data = {
          	labels: labels,
          	datasets: [
          		{
          			label: "{{$question->getDescription()}}",
          			fillColor: "rgba(151,187,205,0.2)",
          			strokeColor: "rgba(151,187,205,1)",
          			pointColor: "rgba(151,187,205,1)",
          			pointStrokeColor: "#fff",
          			pointHighlightFill: "#fff",
          			pointHighlightStroke: "rgba(151,187,205,1)",
          			data: datas
          		}
          	]
          };
          
          var ctxb = $("#barChart{{$question->id}}").get(0).getContext("2d");
          var barChart = new Chart(ctxb).Bar(data);
      
        @endif
      @endforeach
      
    </script>
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