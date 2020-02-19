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
    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
  
    <!-- Font-icon css-->
    <link rel="stylesheet" type="text/css" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
  
  </head>
  <body class="" id="reportPage">
    <br />
    <div class="row">
      <div class="col-2">
        
      </div>
      <div class="col-8 text-center">
        <h1>Relatório da Campanha {{$quizCampaign->id}}</h1>
      </div>
      <div class="col-2 text-right">
        <button type="button" class="btn btn-primary" id="downloadPDF99"><i class="fa fa-download"></i> Baixar</button>
        
      </div>
    </div>
    
<hr />
    
    <main class="app-content" id="pdf0">

      
      <div id="pdf" style="width:90%;height:auto;"><!-- inicio do pdf -->   
      
      <div id="graficos">   
      
        @foreach($quizCampaign->questions as $question)
          @if($question->options_required=='1'&&$question->answers->count()>0&&$question->options->count()>0)
          <div class="row" id="0barChart5">
            <div class="col-md-1"></div>
            <div class="col-md-10">
              <div class="tile">
                <!--<h3 class="tile-title">{{$question->getDescription()}}</h3>-->
                <div class="embed-responsive embed-responsive-16by9">
                  <canvas class="embed-responsive-item" id="barChart{{$question->id}}"></canvas>
                </div>
              </div>
            </div>
            <div class="col-md-1"></div>

          </div>
          @endif
        @endforeach
      
      </div>
      
    </div><!-- fim do pdf -->
    
    <div id="resultsDiv">
      
    </div>
      
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
    
    <script src="https://html2canvas.hertzen.com/dist/html2canvas.js"></script>
    
    
   

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


$('#downloadPDF99').click(function(event) {

	// Convert the div to image (canvas)
      html2canvas(document.getElementById("reportPage")).then(function (canvas) {
        
        var ur = canvas.toDataURL("image/jpeg",1);
        // Get the image data as JPEG and 0.9 quality (0.0 - 1.0)
        var pdf = new jsPDF();
        pdf.addImage(ur, 'JPEG', 0, 0);
                    
        // download the pdf
        pdf.save('{{$quizCampaign->slug}}.pdf');
      });
      
  // create new pdf and add our new canvas as an image
  /*var pdf = new jsPDF();
  pdf.addImage(pdfCanvas, 'PNG', 0, 120);//ultimo digito desce

   pdf.fromHTML($('.pdf').html(), 15, 15, {
        'width': 250
    });
    
  // download the pdf
  pdf.save('{{$quizCampaign->slug}}.pdf');
  */

});

  $(document).ready(function() {

  });
    </script>

  
  </body>
</html>
