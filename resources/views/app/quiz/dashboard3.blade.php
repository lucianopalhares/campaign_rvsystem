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
   <form method="post" id="make_pdf" action="{{url('app/campanha/'.$quizCampaign->slug.'/relatorio2')}}">
    @method('post')
    @csrf
    <input type="text" name="hidden_html" id="hidden_html" />
    <button type="button" name="create_pdf" id="create_pdf" class="btn btn-danger btn-xs">Make PDF</button>
   </form>
       
            </a>            
        </p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Campanha {{$quizCampaign->id}}</li>
          <li class="breadcrumb-item"><a href="#">Dashboard</a></li>
        </ul>
      </div>
      
      <div class="pdf" style="width:100%;height:100%;"><!-- inicio do pdf -->   
        
       <div id="chart_div"></div>
      
      <div id="graficos">   
      

      </div>
      


  

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
    
        
    
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.3.3/jspdf.debug.js"></script>
    
    <script src= 
"https://files.codepedia.info/files/uploads/iScripts/html2canvas.js"> 
    </script> 
    
  <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>      

<script type="text/javascript">
  $(document).ready(function() {
    var baseElement = document.querySelector("body");


});
  
</script>
    <script type="text/javascript">



    
google.charts.load('current', {packages: ['corechart', 'bar']});
google.charts.setOnLoadCallback(drawMultSeries);

function drawMultSeries() {
      var data = google.visualization.arrayToDataTable([
        ['City', '2010 Population', '2000 Population'],
        ['New York City, NY', 8175000, 8008000],
        ['Los Angeles, CA', 3792000, 3694000],
        ['Chicago, IL', 2695000, 2896000],
        ['Houston, TX', 2099000, 1953000],
        ['Philadelphia, PA', 1526000, 1517000]
      ]);

      var options = {
        title: 'Population of Largest U.S. Cities',
        chartArea: {width: '50%'},
        hAxis: {
          title: 'Total Population',
          minValue: 0
        },
        vAxis: {
          title: 'City'
        }
      };
      var chart_area = document.getElementById('chart_div');
      var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
    google.visualization.events.addListener(chart, 'ready', function(){
     chart_area.innerHTML = '<img id="youtubeimg" src="' + chart.getImageURI() + '" class="img-responsive">';
    var youtubeimgsrc = document.getElementById("youtubeimg").src;
    console.log(youtubeimgsrc);
    window.open(youtubeimgsrc);

    });
      chart.draw(data, options);
      


  
    }

        
  $(document).ready(function() {

var pdfHtml = $('.pdf').html();
 
  $('#hidden_html').val(pdfHtml);
$('#create_pdf').click(function(){
  $('#make_pdf').submit();
 });

});
    </script>

    </div><!-- fim do pdf -->
      
    </main>
  </body>
</html>
