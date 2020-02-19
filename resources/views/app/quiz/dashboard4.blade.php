<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta name="description" content="">
    <!-- Twitter meta-->
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:site" content="">
    <meta property="twitter:creator" content="">
    <!-- Open Graph Meta-->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="Quiz">
    <meta property="og:title" content="Quiz">
    <meta property="og:url" content="">
    <meta property="og:image" content="">
    <meta property="og:description" content="Quiz">
    <title>Quiz</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    <!-- Main CSS-->
    <link rel="stylesheet" type="text/css" href="{{ asset('css/main.css') }}">
  
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  
  </head>
  <body class="app sidebar-mini" id="reportPage">

    <!-- Navbar-->
    <header class="app-header"><a class="app-header__logo" href="{{url('app/campanha/'.$quizCampaign->slug.'/dashboard')}}">Quiz Eleitoral</a>
      <!-- Sidebar toggle button--><a class="app-sidebar__toggle" href="#" data-toggle="sidebar" aria-label="Hide Sidebar"></a>
      <!-- Navbar Right Menu-->
      
      <ul class="app-nav">
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="javascript:void" data-toggle="dropdown">
          <span class="badge badge-pill badge-light" data-toggle="tooltip" data-placement="top" title="" data-original-title="{{$quizCampaign->description}}">CAMPANHA: {{substr($quizCampaign->description, 0, 125) . '...'}}</span>     
        </a>          
        </li>
        <li class="dropdown"><a class="app-nav__item badge badge-secondary" href="{{url('app/')}}" onclick="return confirm('Quer mesmo ir para a página inicial?');">
          Sair desta Campanha&nbsp;&nbsp;&nbsp;&nbsp;<i class="fa fa-mail-reply fa-lg"></i>
          </a>          
        </li>
        <!-- User Menu-->
        <li class="dropdown"><a class="app-nav__item" href="#" data-toggle="dropdown" aria-label="Open Profile Menu">{{Auth::user()->name}}&nbsp;&nbsp;<i class="fa fa-user fa-lg"></i></a>
          <ul class="dropdown-menu settings-menu dropdown-menu-right">
            <li>
                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <i class="fa fa-sign-out fa-lg"></i>Sair
                </a>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>        
            </li>
          </ul>
        </li>
      </ul>
    </header>
    <!-- Sidebar menu-->
    <div class="app-sidebar__overlay" data-toggle="sidebar"></div>
    <aside class="app-sidebar">
      <div class="app-sidebar__user"><img class="app-sidebar__user-avatar" src="{{ asset('images/campaign.png') }}" width="80px;" alt="">
        <div>
          <p class="app-sidebar__user-name"> 
            Campanha
          </p>
          <p class="app-sidebar__user-designation alert alert-dark text-center text-primary">
             
             {{$quizCampaign->id}}
          </p>
        </div>
      </div>
      <ul class="app-menu">
        <li><a class="app-menu__item {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/dashboard')) ? 'active' : '' }}" href="{{url('app/campanha/'.$quizCampaign->slug.'/dashboard')}}"><i class="app-menu__icon fa fa-dashboard"></i><span class="app-menu__label">Dashboard</span></a></li>

        <li class="treeview {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/questoes/*')) ? 'is-expanded' : '' }} {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/questoes')) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-quora"></i><span class="app-menu__label">Questões</span><span class="badge badge-danger">{{$quizCampaign->questions->count()}}</span>&nbsp;&nbsp;&nbsp;<i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/questoes')) ? 'active' : '' }}" href="{{url('app/campanha/'.$quizCampaign->slug.'/questoes')}}"><i class="icon fa fa-circle-o"></i> Todas Questões</a></li>
            <li><a class="treeview-item {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/questoes/create')) ? 'active' : '' }}" href="{{url('app/campanha/'.$quizCampaign->slug.'/questoes/create')}}"><i class="icon fa fa-circle-o"></i> Nova Questão</a></li>
          </ul>
        </li>

        <li class="treeview {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/opcoes/*')) ? 'is-expanded' : '' }} {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/opcoes')) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-list"></i><span class="app-menu__label">Opções</span><span class="badge badge-warning">{{$quizCampaign->options->count()}}</span>&nbsp;&nbsp;&nbsp;<i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/opcoes')) ? 'active' : '' }}" href="{{url('app/campanha/'.$quizCampaign->slug.'/opcoes')}}"><i class="icon fa fa-circle-o"></i> Todas Opções</a></li>
            <li><a class="treeview-item {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/opcoes/create')) ? 'active' : '' }}" href="{{url('app/campanha/'.$quizCampaign->slug.'/opcoes/create')}}"><i class="icon fa fa-circle-o"></i> Nova Opção</a></li>
          </ul>
        </li>

        <li class="treeview {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/respostas/*')) ? 'is-expanded' : '' }} {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/respostas')) ? 'is-expanded' : '' }}"><a class="app-menu__item" href="#" data-toggle="treeview"><i class="app-menu__icon fa fa-quote-right"></i><span class="app-menu__label">Respostas</span><span class="badge badge-primary">{{$quizCampaign->answers->count()}}</span>&nbsp;&nbsp;&nbsp;<i class="treeview-indicator fa fa-angle-right"></i></a>
          <ul class="treeview-menu">
            <li><a class="treeview-item {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/respostas')) ? 'active' : '' }}" href="{{url('app/campanha/'.$quizCampaign->slug.'/respostas')}}"><i class="icon fa fa-circle-o"></i> Todas Respostas</a></li>
            <li><a class="treeview-item {{ (request()->is('app/campanha/'.$quizCampaign->slug.'/respostas/create')) ? 'active' : '' }}" href="{{url('app/campanha/'.$quizCampaign->slug.'/respostas/create')}}"><i class="icon fa fa-circle-o"></i> Responder Pergunta</a></li>
          </ul>
        </li> 

      </ul>
    </aside>
    
    <main class="app-content">
    
      <div class="app-title">
        <div>
          <h1><i class="fa fa-dashboard"></i> Dashboard
      
          </h1>
          <p>Gráficos com Questões de Multipla Escolha e que possuem Respostas
            <a href="{{url('app/campanha/'.$quizCampaign->slug.'/relatorio')}}" target="_blank" data-toggle="tooltip" data-placement="left" title="" data-original-title="Gerar Relatório">
              <!--
              <span class="badge badge-secondary" id="downloadPdf"><i class="fa fa-download"></i>&nbsp; Baixar PDF</span>
    -->
            </a>            
        </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Campanha {{$quizCampaign->id}}</li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
      </div>
      
      <div class="pdf"><!-- inicio do pdf -->   
      
      <div id="graficos">   
      
        @foreach($quizCampaign->questions as $question)
          @if($question->options_required=='1'&&$question->answers->count()>0&&$question->options->count()>0)
          <div class="row">
            
            <div class="col-md-2"></div>
            <div class="col-md-8">
              <div class="tile">
                <!--<h3 class="tile-title">{{$question->getDescription()}}</h3>-->
                <div class="embed-responsive embed-responsive-16by9">
                  <canvas class="embed-responsive-item" id="barChart{{$question->id}}"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-2"></div>

          </div>
          @endif
        @endforeach
      
      </div>
      
    </div><!-- fim do pdf -->
      
    </main>



    <!-- Essential javascripts for application to work-->
      <script src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>
    
    <!-- Essential javascripts for application to work
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    -->
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/main.js') }}"></script>
    <!-- The javascript plugin to display page loading on top-->
    <script src="{{ asset('js/plugins/pace.min.js') }}"></script>
    
    <script src="https://cdn.jsdelivr.net/npm/chart.js@2.7.3/dist/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@0.7.0"></script>
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>
   

<script type="text/javascript">
  $(document).ready(function() {
    var baseElement = document.querySelector("body");
    //alert(baseElement);
});
  
</script>
    <script type="text/javascript">
    
    
      @foreach($quizCampaign->questions as $question)
    
        @if($question->options_required=='1'&&$question->answers->count()>0&&$question->options->count()>0)
        
          var labels = [];
          var datas = [];
          
          @foreach($question->options as $option)
                  
            labels.push("{{$option->getDescription()}}");
            datas.push("{{round($option->answers->count()*100/$question->answers->count())}}");
          
          @endforeach
           
           var data0 = 
               {
                 "labels": ["January","February","March","April","May","June","July"],
                 "datasets":
                 [
                   {
                    "label":"My First Dataset",
                    "data":[65,59,80,81,56,55,40],
                    "fill":false,
                    "backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],
                    "borderColor":["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"],
                    "borderWidth":1
                  }
                 ]
               };
                       
          var data = {
          	labels: labels,
          	datasets: [
          		{
          			label: "{{$question->getDescription()}}",
          			fillColor: 'rgb(54, 162, 235)',
          			strokeColor: "rgba(151,187,205,1)",
          			pointColor: "rgba(151,187,205,1)",
          			pointStrokeColor: "#fff",
          			pointHighlightFill: "#fff",
          			pointHighlightStroke: "rgba(151,187,205,1)",
          			data: datas
          		}
          	]
          };

          var data2 = 
               {
                 "labels": labels,
                 "datasets":
                 [
                   {
                    "label":"{{$question->getDescription()}}",
                    "data":datas,
                    "fill":true,
                    "backgroundColor":["rgba(255, 99, 132, 0.2)","rgba(255, 159, 64, 0.2)","rgba(255, 205, 86, 0.2)","rgba(75, 192, 192, 0.2)","rgba(54, 162, 235, 0.2)","rgba(153, 102, 255, 0.2)","rgba(201, 203, 207, 0.2)"],
                    "borderColor":["rgb(255, 99, 132)","rgb(255, 159, 64)","rgb(255, 205, 86)","rgb(75, 192, 192)","rgb(54, 162, 235)","rgb(153, 102, 255)","rgb(201, 203, 207)"],
                    "borderWidth":1
                  }
                 ]
               };
                    
          var ctx = $("#barChart{{$question->id}}").get(0).getContext("2d");
        

var barChart = new Chart(ctx,
  {
  "type":"bar",
  "data":data2,
  "options":
    {
      "scales":
        {"xAxes":
          [
            {"ticks":
              {
                "beginAtZero":true,
                autoSkip: false
              }
            }      
          ]}

    }
  }
);
      
        @endif
      @endforeach

$('#downloadPdf').click(function(event) {
  // get size of report page
  var reportPageHeight = $('#graficos').innerHeight();
  var reportPageWidth = $('#graficos').innerWidth();

  // create a new canvas object that we will populate with all other canvas objects
  var pdfCanvas = $('<canvas />').attr({
    id: "canvaspdf",
    width: reportPageWidth,
    height: reportPageHeight
  });

  // keep track canvas position
  var pdfctx = $(pdfCanvas)[0].getContext('2d');
  var pdfctxX = 50;
  var pdfctxY = 0;
  var buffer = 100;

  // for each chart.js chart
  $("canvas").each(function(index) {
    // get the chart height/width
    var canvasHeight = $(this).innerHeight();
    var canvasWidth = $(this).innerWidth();

    // draw the chart into the new canvas
    pdfctx.drawImage($(this)[0], pdfctxX, pdfctxY, canvasWidth, canvasHeight);
    pdfctxX += canvasWidth + buffer;

    // our report page is in a grid pattern so replicate that in the new canvas
    if (index % 2 === 1) {
      pdfctxX = 0;
      pdfctxY += canvasHeight + buffer;
    }
  });

  // create new pdf and add our new canvas as an image
  var pdf = new jsPDF();
  pdf.addImage($(pdfCanvas)[0], 'PNG', 0, 120);//ultimo digito desce

   pdf.fromHTML($('.pdf').html(), 15, 15, {
        'width': 250
    });
    
  // download the pdf
  pdf.save('{{$quizCampaign->slug}}.pdf');
  

});
    </script>

  
  </body>
</html>
