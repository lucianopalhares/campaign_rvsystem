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
    
    public function __construct()
    {
        $this->campaign = \App::make('App\Domain\Quiz\Model\QuizCampaign');
        $this->question = \App::make('App\Domain\Quiz\Model\QuizQuestion');
        $this->option = \App::make('App\Domain\Quiz\Model\QuizOption');
        $this->answer = \App::make('App\Domain\Quiz\Model\QuizAnswer');
    }


    public function index()
    {        
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
  
      ///tabela sexo- inicio
      $pdf->Ln( 10 );
      $pdf->SetFont( 'Arial', '', 12 );
      $pdf->Write( 6, utf8_decode("2 - Sexo" ));

      $data = [];
      $rowLabels = ['Feminino','Masculino','Não Respondeu'];
      $male = 0;
      $femine = 0;
      $sex_nao = 0;
        
      foreach ($answers as $answer) {        

        if($answer->sex){
          if($answer->sex=='M'){
            $male++;
          }elseif($answer->sex=='M'){
            $femine++;
          }else{
            $sex_nao++;
          }
        }      
      }
      $maleP = $male*100/$answers->count();
      $maleA = $male;
      $maleAP = $maleP;

      $femineP = $femine*100/$answers->count();
      $femineA = $male+$femine;
      $femineAP = $maleP+$femineP;
      
      $sex_naoP = $sex_nao*100/$answers->count();
      $sex_naoA = $male+$femine+$sex_nao;
      $sex_naoAP = $maleP+$femineP+$sex_naoP;   
                  
      $data[] = [$male,$maleP,$maleA,$maleAP];
      $data[] = [$femine,$femineP,$femineA,$femineAP];
      $data[] = [$sex_nao,$sex_naoP,$sex_naoA,$sex_naoAP];     


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
      ///tabela sexo - fim  

        $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
        if($space_left<75){
          $pdf->AddPage();
          $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
          $pdf->SetFont( 'Arial', '', 22 );
          $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
          $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
          $pdf->Ln(17);
        }
          
      ///tabela idade- inicio
      $pdf->Ln( 10 );
      $pdf->SetFont( 'Arial', '', 12 );
      $pdf->Write( 6, utf8_decode("3 - Idade" ));

      $data = [];
      $rowLabels = ['16-24 Anos','25-34 Anos','35-44 Anos','45-59 Anos','Acima de 60 Anos','Não Respondeu'];
      $um = 0;
      $dois = 0;
      $tres = 0;
      $quatro = 0;
      $cinco = 0;
      $seis = 0;
        
      foreach ($answers as $answer) {        

        if($answer->years_old){
          if($answer->years_old=='16-24 Anos'){
            $um++;
          }elseif($answer->years_old=='25-34 Anos'){
            $dois++;
          }elseif($answer->years_old=='35-44 Anos'){
            $tres++;
          }elseif($answer->years_old=='45-59 Anos'){
            $quatro++;
          }elseif($answer->years_old=='Acima de 60 Anos'){
            $cinco++;
          }else{
            $seis++;
          }
        }      
      }
      $umP = $um*100/$answers->count();
      $umA = $um;
      $umAP = $umP;

      $doisP = $dois*100/$answers->count();
      $doisA = $um+$dois;
      $doisAP = $umP+$doisP;
      
      $tresP = $tres*100/$answers->count();
      $tresA = $um+$dois+$tres;
      $tresAP = $umP+$doisP+$tresP;  
      
      $quatroP = $quatro*100/$answers->count();
      $quatroA = $um+$dois+$tres+$quatro;
      $quatroAP = $umP+$doisP+$tresP+$quatroP; 

      $cincoP = $cinco*100/$answers->count();
      $cincoA = $um+$dois+$tres+$quatro+$cinco;
      $cincoAP = $umP+$doisP+$tresP+$quatroP+$cincoP;
      
      $seisP = $seis*100/$answers->count();
      $seisA = $um+$dois+$tres+$quatro+$cinco+$seis;
      $seisAP = $umP+$doisP+$tresP+$quatroP+$cincoP+$seisP;
                  
      $data[] = [$um,$umP,$umA,$umAP];
      $data[] = [$dois,$doisP,$doisA,$doisAP];
      $data[] = [$tres,$tresP,$tresA,$tresAP];
      $data[] = [$quatro,$quatroP,$quatroA,$quatroAP];  
      $data[] = [$cinco,$cincoP,$cincoA,$cincoAP];  
      $data[] = [$seis,$seisP,$seisA,$seisAP];       


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
      $pdf->Ln( 10 );
      ///tabela idade - fim  

        $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
        if($space_left<75){
          $pdf->AddPage();
          $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
          $pdf->SetFont( 'Arial', '', 22 );
          $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
          $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
          $pdf->Ln(17);
        }
        
      ///tabela escolaridade- inicio
      $pdf->Ln( 10 );
      $pdf->SetFont( 'Arial', '', 12 );
      $pdf->Write( 6, utf8_decode("4 - Escolaridade" ));

      $data = [];
      $rowLabels = ['Ensino Fundamental / Incompleto','Ensino Fundamental / Completo','Ensino Médio / Incompleto','Ensino Médio / Completo','Nunca Estudou','Superior / Incompleto','Superior / Completo','Não Respondeu'];
      $um = 0;
      $dois = 0;
      $tres = 0;
      $quatro = 0;
      $cinco = 0;
      $seis = 0;
      $sete = 0;
      $oito = 0;
        
      foreach ($answers as $answer) {        

        if($answer->education_level){
          if($answer->education_level=='Ensino Fundamental / Incompleto'){
            $um++;
          }elseif($answer->education_level=='Ensino Fundamental / Completo'){
            $dois++;
          }elseif($answer->education_level=='Ensino Médio / Incompleto'){
            $tres++;
          }elseif($answer->education_level=='Ensino Médio / Completo'){
            $quatro++;
          }elseif($answer->education_level=='Nunca Estudou'){
            $cinco++;
          }elseif($answer->education_level=='Superior / Incompleto'){
            $seis++;
          }elseif($answer->education_level=='Superior / Completo'){
            $sete++;
          }else{
            $oito++;
          }
        }      
      }
      $umP = $um*100/$answers->count();
      $umA = $um;
      $umAP = $umP;

      $doisP = $dois*100/$answers->count();
      $doisA = $um+$dois;
      $doisAP = $umP+$doisP;
      
      $tresP = $tres*100/$answers->count();
      $tresA = $um+$dois+$tres;
      $tresAP = $umP+$doisP+$tresP;  
      
      $quatroP = $quatro*100/$answers->count();
      $quatroA = $um+$dois+$tres+$quatro;
      $quatroAP = $umP+$doisP+$tresP+$quatroP; 

      $cincoP = $cinco*100/$answers->count();
      $cincoA = $um+$dois+$tres+$quatro+$cinco;
      $cincoAP = $umP+$doisP+$tresP+$quatroP+$cincoP;
      
      $seisP = $seis*100/$answers->count();
      $seisA = $um+$dois+$tres+$quatro+$cinco+$seis;
      $seisAP = $umP+$doisP+$tresP+$quatroP+$cincoP+$seisP;

      $seteP = $sete*100/$answers->count();
      $seteA = $um+$dois+$tres+$quatro+$cinco+$seis+$sete;
      $seteAP = $umP+$doisP+$tresP+$quatroP+$cincoP+$seisP+$seteP;

      $oitoP = $sete*100/$answers->count();
      $oitoA = $um+$dois+$tres+$quatro+$cinco+$seis+$sete+$oito;
      $oitoAP = $umP+$doisP+$tresP+$quatroP+$cincoP+$seisP+$seteP+$oitoP;
                              
      $data[] = [$um,$umP,$umA,$umAP];
      $data[] = [$dois,$doisP,$doisA,$doisAP];
      $data[] = [$tres,$tresP,$tresA,$tresAP];
      $data[] = [$quatro,$quatroP,$quatroA,$quatroAP];  
      $data[] = [$cinco,$cincoP,$cincoA,$cincoAP];  
      $data[] = [$seis,$seisP,$seisA,$seisAP];       
      $data[] = [$sete,$seteP,$seteA,$seteAP];  
      $data[] = [$oito,$oitoP,$oitoA,$oitoAP];  

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
      $pdf->Ln( 10 );
      ///tabela escolaridade - fim    
  
        $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
        if($space_left<75){
          $pdf->AddPage();
          $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
          $pdf->SetFont( 'Arial', '', 22 );
          $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
          $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
          $pdf->Ln(17);
        }  
  
      ///tabela renda- inicio
      $pdf->Ln( 10 );
      $pdf->SetFont( 'Arial', '', 12 );
      $pdf->Write( 6, utf8_decode("5 - Renda" ));

      $data = [];
      $rowLabels = ['Até 1 Salário Minimo','Entre 1 e 2 Salários Minimos','Entre 2 e 5 Salários Minimos','Entre 5 e 10 Salários Minimos','Mais de 10 Salários Minimos','Não Respondeu'];
      $um = 0;
      $dois = 0;
      $tres = 0;
      $quatro = 0;
      $cinco = 0;
      $seis = 0;
      $sete = 0;
      $oito = 0;
        
      foreach ($answers as $answer) {        

        if($answer->salary){
          if($answer->salary=='Até 1 Salário Minimo'){
            $um++;
          }elseif($answer->salary=='Entre 1 e 2 Salários Minimos'){
            $dois++;
          }elseif($answer->salary=='Entre 2 e 5 Salários Minimos'){
            $tres++;
          }elseif($answer->salary=='Entre 5 e 10 Salários Minimos'){
            $quatro++;
          }elseif($answer->salary=='Mais de 10 Salários Minimos'){
            $cinco++;
          }else{
            $seis++;
          }
        }      
      }
      $umP = $um*100/$answers->count();
      $umA = $um;
      $umAP = $umP;

      $doisP = $dois*100/$answers->count();
      $doisA = $um+$dois;
      $doisAP = $umP+$doisP;
      
      $tresP = $tres*100/$answers->count();
      $tresA = $um+$dois+$tres;
      $tresAP = $umP+$doisP+$tresP;  
      
      $quatroP = $quatro*100/$answers->count();
      $quatroA = $um+$dois+$tres+$quatro;
      $quatroAP = $umP+$doisP+$tresP+$quatroP; 

      $cincoP = $cinco*100/$answers->count();
      $cincoA = $um+$dois+$tres+$quatro+$cinco;
      $cincoAP = $umP+$doisP+$tresP+$quatroP+$cincoP;
      
      $seisP = $seis*100/$answers->count();
      $seisA = $um+$dois+$tres+$quatro+$cinco+$seis;
      $seisAP = $umP+$doisP+$tresP+$quatroP+$cincoP+$seisP;
                              
      $data[] = [$um,$umP,$umA,$umAP];
      $data[] = [$dois,$doisP,$doisA,$doisAP];
      $data[] = [$tres,$tresP,$tresA,$tresAP];
      $data[] = [$quatro,$quatroP,$quatroA,$quatroAP];  
      $data[] = [$cinco,$cincoP,$cincoA,$cincoAP];  
      $data[] = [$seis,$seisP,$seisA,$seisAP];      

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
      $pdf->Ln( 10 );
      ///tabela renda - fim    
  
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

      $eleitores = $this->answer::whereQuizCampaignId($quizCampaign->id)->get()->groupBy('name');
      

      
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
      $pdf->SetFont( 'Arial', '', 22 );
      $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
      $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );

      $pdf->Ln( 8 );
      $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
      $pdf->SetFont( 'Arial', '', 10 );
      $pdf->Cell( 0, 15, "Amostra utilizada de ".$eleitores->count()." eleitores", 0, 0, 'C' );
      $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
            
      $pdf->Ln( 8 );
      $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
      $pdf->SetFont( 'Arial', '', 10 );
      $pdf->Cell( 0, 15, "PERGUNTAS E RESPOSTAS", 0, 0, 'C' );
      $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
      

      ///inicio
      $count = 1;
      foreach ($eleitores as $respostas) {

        //pula pagina - inicio
        $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
        if($space_left<50){
          $pdf->AddPage();
          $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
          $pdf->SetFont( 'Arial', '', 22 );
          $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
          $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
          $pdf->Ln(17);
        }
        //pula pagina - fim
        
        foreach ($respostas as $resposta) {

          //pula pagina - inicio
          $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
          if($space_left<50){
            $pdf->AddPage();
            $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
            $pdf->SetFont( 'Arial', '', 22 );
            $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
            $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
            $pdf->Ln(17);
          }
          //pula pagina - fim
                    
          $pdf->Ln( 10 );
          $pdf->SetFont( 'Arial', '', 12 );
          $pdf->Write( 6, utf8_decode($count." - ".$resposta->name ));

          //pula pagina - inicio
          $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
          if($space_left<50){
            $pdf->AddPage();
            $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
            $pdf->SetFont( 'Arial', '', 22 );
            $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
            $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
            $pdf->Ln(17);
          }
          //pula pagina - fim
      
          $pdf->Ln( 5 );
          $pdf->SetFont( 'Arial', '', 10 );
          $pdf->Write( 6, utf8_decode('       '));
          $pdf->Write( 6, utf8_decode($resposta->address));

          //pula pagina - inicio
          $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
          if($space_left<50){
            $pdf->AddPage();
            $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
            $pdf->SetFont( 'Arial', '', 22 );
            $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
            $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
            $pdf->Ln(17);
          }
          //pula pagina - fim
          
          if($resposta->district_id){
            $pdf->Ln( 5 );
            $pdf->SetFont( 'Arial', '', 10 );
            $pdf->Write( 6, utf8_decode('       '));
            $city = $resposta->district->name?$resposta->district->name.', ':'';
            $city .= $resposta->district->city_id?', '.$resposta->district->city->title.'/'.$resposta->district->city->state->letter:'';
            $pdf->Write( 6, utf8_decode($resposta->district->type.' '.$city));
          }

          //pula pagina - inicio
          $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
          if($space_left<50){
            $pdf->AddPage();
            $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
            $pdf->SetFont( 'Arial', '', 22 );
            $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
            $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
            $pdf->Ln(17);
          }
          //pula pagina - fim
                              
          $pdf->Ln( 10 );
          $pdf->SetFont( 'Arial', '', 10 );
          $pdf->Write( 6, utf8_decode('        '));
          $pdf->Write( 6, utf8_decode('SEXO:'));
          $pdf->Write( 6, utf8_decode(' '));
          $pdf->Write( 6, utf8_decode($resposta->sex=='M'?'Masculino':$resposta->sex=='F'?'Feminino':'Não Respondeu'));

          //pula pagina - inicio
          $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
          if($space_left<50){
            $pdf->AddPage();
            $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
            $pdf->SetFont( 'Arial', '', 22 );
            $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
            $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
            $pdf->Ln(17);
          }
          //pula pagina - fim
          
          $pdf->Ln( 5 );
          $pdf->SetFont( 'Arial', '', 10 );
          $pdf->Write( 6, utf8_decode('        '));
          $pdf->Write( 6, utf8_decode('IDADE:'));
          $pdf->Write( 6, utf8_decode(' '));
          $pdf->Write( 6, utf8_decode($resposta->years_old));

          //pula pagina - inicio
          $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
          if($space_left<50){
            $pdf->AddPage();
            $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
            $pdf->SetFont( 'Arial', '', 22 );
            $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
            $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
            $pdf->Ln(17);
          }
          //pula pagina - fim
          
          $pdf->Ln( 5 );
          $pdf->SetFont( 'Arial', '', 10 );
          $pdf->Write( 6, utf8_decode('        '));
          $pdf->Write( 6, utf8_decode('ESCOLARIDADE:'));
          $pdf->Write( 6, utf8_decode(' '));
          $pdf->Write( 6, utf8_decode($resposta->education_level));                    

          //pula pagina - inicio
          $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
          if($space_left<50){
            $pdf->AddPage();
            $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
            $pdf->SetFont( 'Arial', '', 22 );
            $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
            $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
            $pdf->Ln(17);
          }
          //pula pagina - fim
          
          $pdf->Ln( 5 );
          $pdf->SetFont( 'Arial', '', 10 );
          $pdf->Write( 6, utf8_decode('        '));
          $pdf->Write( 6, utf8_decode('RENDA:'));
          $pdf->Write( 6, utf8_decode(' '));
          $pdf->Write( 6, utf8_decode($resposta->salary));  

          //pula pagina - inicio
          $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
          if($space_left<50){
            $pdf->AddPage();
            $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
            $pdf->SetFont( 'Arial', '', 22 );
            $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
            $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
            $pdf->Ln(17);
          }
          //pula pagina - fim
          
          $pdf->Ln( 8 );
          $pdf->SetFont( 'Arial', '', 10 );
          $pdf->Write( 6, utf8_decode('        '));
          $pdf->Write( 6, utf8_decode('PERGUNTAS E RESPOSTAS:'));
          $pdf->Write( 6, utf8_decode(' '));
          $pdf->Ln( 3 );
                    
          foreach ($this->answer::whereName($resposta->name)->get() as $eleitorResposta) {

            //pula pagina - inicio
            $space_left=$page_height-($pdf->GetY()+$bottom_margin); // space left on page 
            if($space_left<50){
              $pdf->AddPage();
              $pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
              $pdf->SetFont( 'Arial', '', 22 );
              $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
              $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
              $pdf->Ln(17);
            }
            //pula pagina - fim
          
            $pdf->Ln( 5 );
            $pdf->SetFont( 'Arial', '', 10 );
            $pdf->Write( 6, utf8_decode('        '));
            $pdf->Write( 6, utf8_decode($eleitorResposta->question->getDescription()));
            $pdf->Write( 6, utf8_decode(' '));
            if($eleitorResposta->quiz_option_id){
              $pdf->Write( 6, utf8_decode($eleitorResposta->option->getDescription()));   
            }else{
              $pdf->Write( 6, utf8_decode($eleitorResposta->description)); 
            }
                               
                
          }
                    
          $count++;
        }
      }
  
    
      $pdf->Output('',$quizCampaign->slug.'-ESPELHO.pdf');
      exit;      
        
    }
  
}
