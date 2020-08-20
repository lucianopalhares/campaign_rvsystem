@extends('app.quiz.layout.main')

@section('page-css')
<style>
.note-group-select-from-files {
  display: none;
}
.select2-container {
width: 100% !important;
padding: 0;
}
</style>
@endsection

@section('main')

    <main class="app-content">
      <div class="app-title">
        <div>
          <h1><i class="fa fa-quote-right"></i> Gráfico da Campanha: </h1>
          <p>{{$quizCampaign->description}}</p>
        </div>
        <ul class="app-breadcrumb breadcrumb">
          <li class="breadcrumb-item"><i class="fa fa-home fa-lg"></i></li>
          <li class="breadcrumb-item">Campanha {{$quizCampaign->id}}</li>
          <li class="breadcrumb-item">Gráfico</li>
        </ul>
      </div>

      @include('app._utils.flash_msg')

      <div class="row">
        <div class="col-md-2"></div>
        <div class="col-md-8">

              <form>

                        <div class="form-group label-floating">

                            <select required="required" class="form-control" name="questions[]" multiple="multiple" onchange="changeFormAction()">
                              <option value=" ">Filtrar as Perguntas</option>
                                @foreach($allquestions as $q)

                                    <option value="{{$q->id}}">
                                      {{$q->description}}
                                    </option>

                                @endforeach
                            </select>
                        </div>

            </form>

        </div>
        <div class="col-md-2"></div>
      </div>

      <div id="verGraficoButton">
        <div class="row">
          <div class="col-md-12 text-center float-center">

            <button type="button" class="badge badge-success" onclick="verGrafico()"><i class="fa fa-share"></i> Ver Gráfico das Perguntas Selecionadas</button>
          </div>
        </div>
      </div>

      @if(\request()->has('perguntas'))
        <div id="verGraficoButton">
          <div class="row">
            <div class="col-md-12 text-center float-center">

                <a href="{{url('/app/campanha/'.$quizCampaign->slug.'/grafico')}}" class="badge badge-secondary"><i class="fa fa-share"></i>Ver Todas Perguntas</a>

            </div>
          </div>
        </div>
      @endif

            @foreach($questions as $question)


              <div class="row text-center">

                <!-- Area Chart -->
                <div class="col-xl-12">
                  <div class="card shadow mb-4">

                    <!-- Card Body -->
                    <div class="card-body">

                      <div class="chart-pie">
                        <canvas id="myPieChart{{$question->id}}"></canvas>
                      </div>

                    </div>
                  </div>
                </div>
              </div>

            @endforeach




              <div class="row text-center">

                <!-- Area Chart -->
                <div class="col-xl-12">
                  <div class="card shadow mb-4">

                    <!-- Card Body -->
                    <div class="card-body">

                      <div class="chart-pie">
                        <canvas id="myPieChartDistrict"></canvas>
                      </div>

                    </div>
                  </div>
                </div>
              </div>


    </main>
@endsection

@section('page-js')

  <script src="{{ asset('js/chart.js/Chart.min.js') }}"></script>

      <!-- Page level custom scripts -->
      <script type="text/javascript">
      // Set new default font family and font color to mimic Bootstrap's default styling
      Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
      Chart.defaults.global.defaultFontColor = 'black';



      function number_format(number, decimals, dec_point, thousands_sep) {
        // *     example: number_format(1234.56, 2, ',', ' ');
        // *     return: '1 234,56'
        number = (number + '').replace(',', '').replace(' ', '');
        var n = !isFinite(+number) ? 0 : +number,
          prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
          sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
          dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
          s = '',
          toFixedFix = function(n, prec) {
            var k = Math.pow(10, prec);
            return '' + Math.round(n * k) / k;
          };
        // Fix for IE parseFloat(0.55).toFixed(0) = 0;
        s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
        if (s[0].length > 3) {
          s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
        }
        if ((s[1] || '').length < prec) {
          s[1] = s[1] || '';
          s[1] += new Array(prec - s[1].length + 1).join('0');
        }
        return s.join(dec);
      }

      function randomColorGenerator() {
          return '#' + (Math.random().toString(16) + '0000000').slice(2, 8);
      }

      $(function() {
          window.onbeforeprint = beforePrintHandler;
      });
      @foreach($questions as $question)

          var answers{{$question->id}} = [];
          var campaign_answers{{$question->id}} = [];
          var campaign_answers_color{{$question->id}} = [];

          var total_answers{{$question->id}} = 0;

            @foreach($question->answers_chart as $answer => $answer_total)

              <?php $random = rand(); ?>

              let description{{$random}} = "{{preg_replace('/\s+/', ' ', $answer)}}";
              let answer_count{{$random}} = "{{$answer_total}}";

              total_answers{{$question->id}} = total_answers{{$question->id}} + "{{$answer_total}}";

                (function($) {
                    "use strict"; // Start of use strict
                    answers{{$question->id}}.push(description{{$random}});
                    campaign_answers{{$question->id}}.push(answer_count{{$random}});
                    campaign_answers_color{{$question->id}}.push(randomColorGenerator());
                })(jQuery); // End of use strict

            @endforeach


        // Pie Chart Example
        var ctx{{$question->id}} = document.getElementById("myPieChart{{$question->id}}");

        var myPieChart{{$question->id}} = new Chart(ctx{{$question->id}}, {
          type: 'bar',
          data: {
            labels: answers{{$question->id}},
            datasets: [{
              data: campaign_answers{{$question->id}},
              backgroundColor: campaign_answers_color{{$question->id}} ,
              hoverBackgroundColor: campaign_answers_color{{$question->id}} ,
              borderColor: "#4e73df",
            }],
          },
          options: {
            title: {
                display: true,
                fontColor: 'blue',
                text: "{{preg_replace('/\s+/', ' ', $question->description)}}"
            },
            responsive: true,
            maintainAspectRatio: false,
            legend: {
              display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            tooltips: {
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + number_format(tooltipItem.yLabel);
                }
              }
            },
          }
        });


      @endforeach



          var answersDistrict = [];
          var campaign_answersDistrict = [];
          var campaign_answersDistrict_color = [];

            @foreach($districts as $district)

              <?php $random = rand(); ?>

              let description{{$random}} = "{{preg_replace('/\s+/', ' ', $district->name)}}";
              let answer_count{{$random}} = "{{$district->answers->count()}}";

                (function($) {
                    "use strict"; // Start of use strict
                    answersDistrict.push(description{{$random}});
                    campaign_answersDistrict.push(answer_count{{$random}});
                    campaign_answersDistrict_color.push(randomColorGenerator());
                })(jQuery); // End of use strict

            @endforeach


        // Pie Chart Example
        var ctxDistrict = document.getElementById("myPieChartDistrict");

        var myPieChartDistrict = new Chart(ctxDistrict, {
          type: 'bar',
          data: {
            labels: answersDistrict,
            datasets: [{
              data: campaign_answersDistrict,
              backgroundColor: campaign_answersDistrict_color ,
              hoverBackgroundColor: campaign_answersDistrict_color ,
              borderColor: "#4e73df",
            }],
          },
          options: {
            title: {
                display: true,
                fontColor: 'blue',
                text: "Bairros"
            },
            responsive: true,
            maintainAspectRatio: false,
            legend: {
              display: false
            },
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero:true
                    }
                }]
            },
            tooltips: {
              titleMarginBottom: 10,
              titleFontColor: '#6e707e',
              titleFontSize: 14,
              backgroundColor: "rgb(255,255,255)",
              bodyFontColor: "#858796",
              borderColor: '#dddfeb',
              borderWidth: 1,
              xPadding: 15,
              yPadding: 15,
              displayColors: false,
              caretPadding: 10,
              callbacks: {
                label: function(tooltipItem, chart) {
                  var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                  return datasetLabel + number_format(tooltipItem.yLabel);
                }
              }
            },
          }
        });


      </script>

      <script type="text/javascript" src="{{ asset('js/plugins/select2.min.js') }}"></script>

      <script type="text/javascript">

        var url = null;

        $(document).ready(function(){
          $('select').select2({
            placeholder: "Filtrar por Perguntas",
          });
          $('#verGraficoButton').hide();
        });

        function changeFormAction() {
          $('#verGraficoButton').hide();
          url = null;
          var campaign_slug = "{{$quizCampaign->slug}}";

          var questions = $('select').select2('data');

          if(questions.length>0){
            let questionsString = '';
            for (let i = 0; i < questions.length; ++i) {
              if(i>0){
                questionsString = questionsString + ','
              }
              questionsString = questionsString + questions[i].id;

            }
            url = "/app/campanha" +"/"+ campaign_slug + "/grafico?perguntas="+questionsString;
            $('#verGraficoButton').show();
          }
        }

        function verGrafico() {
          if(url){
            this.document.location.href = url;
          }
        }
        function beforePrintHandler () {
          for (var id in Chart.instances) {
            Chart.instances[id].resize()
          }
        }
      </script>
@endsection
