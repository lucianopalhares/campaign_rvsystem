<?php

namespace App\Controller\App\Quiz;

use Illuminate\Http\Request;
use App\Controller\Controller;
use Illuminate\Support\Arr;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Job\PDF_Diag;

class DashboardController extends Controller
{
    public $campaign;
    public $question;
    public $option;
    public $answer;
    public $card;

    public function __construct()
    {
        $this->campaign = \App::make('App\Domain\Quiz\Model\QuizCampaign');
        $this->question = \App::make('App\Domain\Quiz\Model\QuizQuestion');
        $this->option = \App::make('App\Domain\Quiz\Model\QuizOption');
        $this->answer = \App::make('App\Domain\Quiz\Model\QuizAnswer');
        $this->card = \App::make('App\Domain\Quiz\Model\Card');
    }


    public function index()
    {
      /*
        $campaigns = $this->campaign::all();

        foreach($campaigns as $campanha){

          $answers = $this->answer::whereQuizCampaignId($campanha->id)->get()->groupBy('name');

          foreach($answers as $name => $respostas){

            $card = new $this->card;
            $card->quiz_campaign_id = $campanha->id;
            $card->name = $name;
            $card->district_id = $respostas[0]->district_id;
            $card->address = $respostas[0]->address;
            $card->zip_code = $respostas[0]->zip_code;
            $card->latitude = $respostas[0]->latitude;
            $card->longitude = $respostas[0]->longitude;
            $card->save();

            foreach($respostas as $resposta){

              $resposta = $this->answer::findOrFail($resposta->id)->update(['card_id'=>$card->id]);
            }

          }
        }*/
        
        $quizCampaign = request()->session()->get('quizCampaign');

        return view('app.quiz.dashboard',compact('quizCampaign'));
    }
    public function relatorio() {

      $quizCampaign = request()->session()->get('quizCampaign');
      $answers = $quizCampaign->answers;

      $textColour = array( 0, 0, 0 );
      $headerColour = array( 100, 100, 100 );
      $tableHeaderTopTextColour = array( 255, 255, 255 );
      $tableHeaderTopFillColour = array( 125, 152, 179 );
      $tableHeaderTopFirstLineTextColour = array( 0, 0, 0 );
      $tableHeaderTopFirstLineFillColour = array( 143, 173, 204 );
      $tableHeaderLeftTextColour = array( 99, 42, 57 );
      $tableHeaderLeftFillColour = array( 184, 207, 229 );
      $tableBorderColour = array( 50, 50, 50 );
      $tableRowFillColour = array( 213, 170, 170 );
      $reportName = utf8_decode("Pesquisa de Opnião Pública - Campanha ".$quizCampaign->id);
      $reportNameYPos = 160;
      $logoFile = "*";
      $logoXPos = 50;
      $logoYPos = 108;
      $logoWidth = 110;

      $pdf = new PDF_Diag( 'P', 'mm', 'A4' );
      $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );

      $pdf->AddPage();

      $pdf->SetAutoPageBreak(false);
      $height_of_cell = 60; // mm
      $page_height = 286.93; // mm (portrait letter)
      $bottom_margin = 0; // mm

      $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
      $pdf->SetFont( 'Arial', '', 22 );
      $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
      $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );

      $pdf->Ln( 8 );
      $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
      $pdf->SetFont( 'Arial', '', 12 );
      $pdf->Cell( 0, 15, "Amostra utilizada de ".$answers->count()." eleitores da cidade de ".$quizCampaign->city->title.'/'.$quizCampaign->state->letter, 0, 0, 'C' );
      $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );


      $pdf->SetFont( 'Arial', '', 20 );
      $pdf->Write( 19, utf8_decode("1 - Metodologia de Pesquisa:"));
      $pdf->Ln( 16 );
      $pdf->SetFont( 'Arial', '', 12 );
      $pdf->Write( 6, utf8_decode("A metodologia da pesquisa utilizada é quantitativa, do tipo 'survey', que consiste na aplicação domiciliar de questionários estruturados junto a uma amostra representativa dos eleitores." ));

      $pdf->Ln( 16 );

      $pdf->SetFont( 'Arial', '', 20 );
      $pdf->Write( 9, utf8_decode("2 - Plano amostral e ponderação quanto a sexo, idade, grau de instrução e nivel econômico do entrevistado; intervalo de confiança e margem de erro:"));
      $pdf->Ln( 16 );
      $pdf->SetFont( 'Arial', '', 12 );
      $pdf->Write( 6, utf8_decode("A amostra dos eleitores foi distribuida de forma a contemplar todas as regiões geográficas do minicipio pesquisado, a partir de quotas proporcionais ao universo, considerando as variáveis; sexo, faixa etária, escolaridade e renda dos entrevistados." ));



      /*

      ///tabela bairro/localidade - inicio
      $pdf->Ln( 10 );
      $pdf->SetFont( 'Arial', '', 12 );
      $pdf->Write( 6, utf8_decode("1 - Bairro/Localidade" ));

      $data = [];
      $rowLabels = ['Area Urbana - Centro e Bairros','Zona Rural - Faz,Chacaras etc','Nao Respondeu'];
      $area_urbana = 0;
      $area_rural = 0;
      $area_nao = 0;

      foreach ($answers as $answer) {

        if($answer->district_id){
          if($answer->district->type=='Area Urbana - Centro e Bairros'){
            $area_urbana++;
          }elseif($answer->district->type=='Zona Rural - Povoados,Chacaras,Fazendas e Outros'){
            $area_rural++;
          }
        }else{
          $area_nao++;
        }
      }
      $area_urbanaP = $area_urbana*100/$answers->count();
      $area_urbanaA = $area_urbana;
      $area_urbanaAP = $area_urbanaP;

      $area_ruralP = $area_rural*100/$answers->count();
      $area_ruralA = $area_urbana+$area_rural;
      $area_ruralAP = $area_urbanaP+$area_ruralP;

      $area_naoP = $area_nao*100/$answers->count();
      $area_naoA = $area_urbana+$area_rural+$area_nao;
      $area_naoAP = $area_urbanaP+$area_ruralP+$area_naoP;

      $data[] = [$area_urbana,$area_urbanaP,$area_urbanaA,$area_urbanaAP];
      $data[] = [$area_rural,$area_ruralP,$area_ruralA,$area_ruralAP];
      $data[] = [$area_nao,$area_naoP,$area_naoA,$area_naoAP];


      $columnLabels = array( "Freq.", "Perc", "Freq. Acumul", "Perc. Acumul" );
      $pdf->SetDrawColor( $tableBorderColour[0], $tableBorderColour[1], $tableBorderColour[2] );
      $pdf->Ln( 10 );
      // Create the table header row
      $pdf->SetFont( 'Arial', 'B', 10 );
      // "Resposta" cell
      $pdf->SetTextColor( $tableHeaderTopFirstLineTextColour[0], $tableHeaderTopFirstLineTextColour[1], $tableHeaderTopFirstLineTextColour[2] );
      $pdf->SetFillColor( $tableHeaderTopFirstLineFillColour[0], $tableHeaderTopFirstLineFillColour[1], $tableHeaderTopFirstLineFillColour[2] );
      $pdf->Cell( 75, 10, " Resposta", 1, 0, 'L', true );
      // Remaining header cells
      $pdf->SetTextColor( $tableHeaderTopTextColour[0], $tableHeaderTopTextColour[1], $tableHeaderTopTextColour[2] );
      $pdf->SetFillColor( $tableHeaderTopFillColour[0], $tableHeaderTopFillColour[1], $tableHeaderTopFillColour[2] );

      for ( $i=0; $i<count($columnLabels); $i++ ) {
        $pdf->Cell( 28, 10, $columnLabels[$i], 1, 0, 'C', true );
      }
      $pdf->Ln( 10 );
      $fill = false;
      $row = 0;
      foreach ( $data as $dataRow ) {
        // Create the left header cell
        $pdf->SetFont( 'Arial', 'B', 10 );
        $pdf->SetTextColor( $tableHeaderLeftTextColour[0], $tableHeaderLeftTextColour[1], $tableHeaderLeftTextColour[2] );
        $pdf->SetFillColor( $tableHeaderLeftFillColour[0], $tableHeaderLeftFillColour[1], $tableHeaderLeftFillColour[2] );
        $pdf->Cell( 75, 10, " " . utf8_decode($rowLabels[$row]), 1, 0, 'L', $fill );
        // Create the data cells
        $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
        $pdf->SetFillColor( $tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2] );
        $pdf->SetFont( 'Arial', '', 10 );
        for ( $i=0; $i<count($columnLabels); $i++ ) {
          //$pdf->Cell( 36, 10, ( '' . number_format( $dataRow[$i] ) ), 1, 0, 'C', $fill );
          if($i==1||$i==3){
            $pdf->Cell( 28, 10, ( '' . number_format( $dataRow[$i] ). '%' ), 1, 0, 'C', $fill );
          }else{
            $pdf->Cell( 28, 10, ( '' . number_format( $dataRow[$i] ) ), 1, 0, 'C', $fill );
          }
        }
        $row++;
        $fill = !$fill;
        $pdf->Ln( 10 );
      }
      ///tabela bairro/localidade - fim
      */
      $pdf->Ln( 10 );

        $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
        if($space_left<75){
          $pdf->AddPage();
          $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
          $pdf->SetFont( 'Arial', '', 22 );
          $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
          $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
          $pdf->Ln(17);
        }

      foreach($quizCampaign->questions as $question){

        $data = [];
        if($question->options_required=='1'&&$question->answers->count()>0&&$question->options->count()>0){

          foreach($question->options as $option){

            $data[utf8_decode($option->getDescription())] = round($option->answers->count()*100/$question->answers->count());
          }

          $pdf->SetFont('Arial', 'BIU', 12);
          $pdf->Cell(0, 5, utf8_decode($question->getDescription()), 0, 1);
          $pdf->Ln(8);
          $valX = $pdf->GetX();
          $valY = $pdf->GetY();
          $pdf->BarDiagram(190, 70, $data, '%l : %v (%p)', array(255,175,100));
          $pdf->SetXY($valX, $valY + 80);

          $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
          if($space_left<75){
            $pdf->AddPage();
            $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
            $pdf->SetFont( 'Arial', '', 22 );
            $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
            $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
            $pdf->Ln(17);
          }
        }
      }


      $pdf->Output('',$quizCampaign->slug.'-RELATORIO.pdf');
      exit;

    }
    public function espelho() {

      $quizCampaign = request()->session()->get('quizCampaign');

      $eleitores = $this->card::whereQuizCampaignId($quizCampaign->id)->get();

      $textColour = array( 0, 0, 0 );
      $headerColour = array( 100, 100, 100 );
      $tableHeaderTopTextColour = array( 255, 255, 255 );
      $tableHeaderTopFillColour = array( 125, 152, 179 );
      $tableHeaderTopFirstLineTextColour = array( 0, 0, 0 );
      $tableHeaderTopFirstLineFillColour = array( 143, 173, 204 );
      $tableHeaderLeftTextColour = array( 99, 42, 57 );
      $tableHeaderLeftFillColour = array( 184, 207, 229 );
      $tableBorderColour = array( 50, 50, 50 );
      $tableRowFillColour = array( 213, 170, 170 );
      $reportName = utf8_decode("Pesquisa de Opnião Pública - (Espelho) Campanha ".$quizCampaign->id);
      $reportNameYPos = 160;
      $logoFile = "*";
      $logoXPos = 50;
      $logoYPos = 108;
      $logoWidth = 110;

      $pdf = new PDF_Diag( 'P', 'mm', 'A4' );
      $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );

      $pdf->AddPage();

      $pdf->SetAutoPageBreak(false);
      $height_of_cell = 60; // mm
      $page_height = 286.93; // mm (portrait letter)
      $bottom_margin = 0; // mm

      $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
      $pdf->SetFont( 'Courier', '', 18 );
      $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
      $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );

      $pdf->Ln( 8 );
      $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
      $pdf->SetFont( 'Courier', '', 10 );
      $pdf->Cell( 0, 15, "Amostra utilizada de ".$eleitores->count()." eleitores", 0, 0, 'C' );
      $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );

      $pdf->Ln( 8 );
      $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
      $pdf->SetFont( 'Courier', '', 10 );
      $pdf->Cell( 0, 15, "PERGUNTAS E RESPOSTAS", 0, 0, 'C' );
      $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );


      foreach ($eleitores as $key => $eleitor) {

        //pula pagina - inicio
        $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
        if($space_left<50){
          $pdf->AddPage();
          $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
          $pdf->SetFont( 'Courier', '', 18 );
          $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
          $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
          $pdf->Ln(17);
        }
        //pula pagina - fim

        $pdf->Ln( 10 );
        $pdf->SetFont( 'Courier', '', 12 );
        $pdf->Write( 6, utf8_decode($eleitor->id.' - '.$eleitor->name ));

        //pula pagina - inicio
        $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
        if($space_left<50){
          $pdf->AddPage();
          $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
          $pdf->SetFont( 'Courier', '', 18 );
          $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
          $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
          $pdf->Ln(17);
        }
        //pula pagina - fim

        $pdf->Ln( 5 );
        $pdf->SetFont( 'Courier', '', 10 );
        $pdf->Write( 6, utf8_decode('       '));
        $pdf->Write( 6, utf8_decode($eleitor->address));

        //pula pagina - inicio
        $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
        if($space_left<50){
          $pdf->AddPage();
          $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
          $pdf->SetFont( 'Courier', '', 18 );
          $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
          $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
          $pdf->Ln(17);
        }
        //pula pagina - fim

        if($eleitor->district_id){
          $pdf->Ln( 5 );
          $pdf->SetFont( 'Courier', '', 10 );
          $pdf->Write( 6, utf8_decode('       '));
          $city = $eleitor->district->name?$eleitor->district->name.', ':'';
          $city .= $eleitor->district->city_id?', '.$eleitor->district->city->title.'/'.$eleitor->district->city->state->letter:'';
          $pdf->Write( 6, utf8_decode($eleitor->district->type.' '.$city));
        }

        //pula pagina - inicio
        $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
        if($space_left<50){
          $pdf->AddPage();
          $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
          $pdf->SetFont( 'Courier', '', 18 );
          $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
          $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
          $pdf->Ln(17);
        }
        //pula pagina - fim

          $pdf->Ln( 8 );
          $pdf->SetFont( 'Courier', '', 10 );
          $pdf->Write( 6, utf8_decode('        '));
          $pdf->Write( 6, utf8_decode('PERGUNTAS E RESPOSTAS:'));
          $pdf->Write( 6, utf8_decode(' '));
          $pdf->Ln( 3 );

          foreach ($eleitor->answers as $eleitorResposta) {

            //pula pagina - inicio
            $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page
            if($space_left<50){
              $pdf->AddPage();
              $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
              $pdf->SetFont( 'Courier', '', 18 );
              $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
              $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
              $pdf->Ln(17);
            }
            //pula pagina - fim

            $pdf->Ln( 5 );
            $pdf->SetFont( 'Courier', '', 10 );
            $pdf->Write( 6, utf8_decode('        '));
            $pdf->Write( 6, utf8_decode($eleitorResposta->question->id.' - '.$eleitorResposta->question->getDescription()));

            $pdf->Ln( 5 );
            $pdf->SetFont( 'Courier', '', 10 );
            $pdf->Write( 6, utf8_decode('        '));
            if($eleitorResposta->quiz_option_id){
              $pdf->Write( 6, utf8_decode($eleitorResposta->quiz_option_id.' - '.$eleitorResposta->option->getDescription()));
            }else{
              $pdf->Write( 6, utf8_decode($eleitorResposta->description));
            }

            $pdf->Ln( 5 );


          }



      }


      $pdf->Output('',$quizCampaign->slug.'-ESPELHO.pdf');
      exit;

    }

}
