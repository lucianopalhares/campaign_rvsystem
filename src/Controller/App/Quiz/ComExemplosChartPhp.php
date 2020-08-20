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
    public function downloadPDF() {
      
      $quizCampaign = request()->session()->get('quizCampaign');
      
      return view('app.quiz.dashboard2',compact('quizCampaign'));  
              
      //$pdf = PDF::loadView('app.quiz.dashboard2',compact('quizCampaign'));        
      //return $pdf->download($quizCampaign->slug.'.pdf');
        
    }
    public function downloadPDF99() {
      
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
      /*
      $pdf->AddPage();
      // Logo
      //$pdf->Image( $logoFile, $logoXPos, $logoYPos, $logoWidth );
      $pdf->SetFont( 'Arial', 'B', 24 );
      $pdf->Ln( $reportNameYPos );
      $pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
      */

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
      $pdf->Cell( 0, 15, "Amostra utilizada de ".$answers->count()." eleitores", 0, 0, 'C' );
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
      
      
      
        
            
            
            
            
      $pdf->Output();
      exit;      
      //$quizCampaign = request()->session()->get('quizCampaign');
      
      //return view('app.quiz.dashboard5',compact('quizCampaign'));  
              
      //$pdf = PDF::loadView('app.quiz.dashboard2',compact('quizCampaign'));        
      //return $pdf->download($quizCampaign->slug.'.pdf');
        
    }
    public function downloadPDF3(){
      
      $quizCampaign = request()->session()->get('quizCampaign');
      


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
$reportName = "2009 Widget Sales Report";
$reportNameYPos = 160;
$logoFile = "widget-company-logo.png";
$logoXPos = 50;
$logoYPos = 108;
$logoWidth = 110;
$columnLabels = array( "Q1", "Q2", "Q3", "Q4" );
$rowLabels = array( "WonderWidget  ", "WonderWidget", "MegaWidget", "HyperWidget" );
$chartXPos = 20;
$chartYPos = 250;
$chartWidth = 160;
$chartHeight = 80;
$chartXLabel = "Product";
$chartYLabel = "2009 Sales";
$chartYStep = 20000;


            
            

$chartColours = array(
                  array( 255, 100, 100 ),
                  array( 100, 255, 100 ),
                  array( 100, 100, 255 ),
                  array( 255, 255, 100 ),
                );

$data = array(
          array( 9940, 10100, 9490, 11730 ),
          array( 19310, 21140, 20560, 22590 ),
          array( 25110, 26260, 25210, 28370 ),
          array( 27650, 24550, 30040, 31980 ),
        );


$pdf = new FPDF( 'P', 'mm', 'A4' );
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->AddPage();

// Logo
//$pdf->Image( $logoFile, $logoXPos, $logoYPos, $logoWidth );

// Report Name
$pdf->SetFont( 'Arial', 'B', 24 );
$pdf->Ln( $reportNameYPos );
$pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );



$pdf->AddPage();
$pdf->SetTextColor( $headerColour[0], $headerColour[1], $headerColour[2] );
$pdf->SetFont( 'Arial', '', 17 );
$pdf->Cell( 0, 15, $reportName, 0, 0, 'C' );
$pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
$pdf->SetFont( 'Arial', '', 20 );
$pdf->Write( 19, "2009 Was A Good Year" );
$pdf->Ln( 16 );
$pdf->SetFont( 'Arial', '', 12 );
$pdf->Write( 6, "Despite the economic downturn, WidgetCo had a strong year. Sales of the HyperWidget in particular exceeded expectations. The fourth quarter was generally the best performing; this was most likely due to our increased ad spend in Q3." );
$pdf->Ln( 12 );
$pdf->Write( 6, "2010 is expected to see increased sales growth as we expand into other countries." );



$pdf->SetDrawColor( $tableBorderColour[0], $tableBorderColour[1], $tableBorderColour[2] );
$pdf->Ln( 15 );

// Create the table header row
$pdf->SetFont( 'Arial', 'B', 15 );

// "PRODUCT" cell
$pdf->SetTextColor( $tableHeaderTopFirstLineTextColour[0], $tableHeaderTopFirstLineTextColour[1], $tableHeaderTopFirstLineTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopFirstLineFillColour[0], $tableHeaderTopFirstLineFillColour[1], $tableHeaderTopFirstLineFillColour[2] );
$pdf->Cell( 46, 12, " PRODUCT", 1, 0, 'L', true );

// Remaining header cells
$pdf->SetTextColor( $tableHeaderTopTextColour[0], $tableHeaderTopTextColour[1], $tableHeaderTopTextColour[2] );
$pdf->SetFillColor( $tableHeaderTopFillColour[0], $tableHeaderTopFillColour[1], $tableHeaderTopFillColour[2] );

for ( $i=0; $i<count($columnLabels); $i++ ) {
  $pdf->Cell( 36, 12, $columnLabels[$i], 1, 0, 'C', true );
}

$pdf->Ln( 12 );

// Create the table data rows

$fill = false;
$row = 0;

foreach ( $data as $dataRow ) {

  // Create the left header cell
  $pdf->SetFont( 'Arial', 'B', 15 );
  $pdf->SetTextColor( $tableHeaderLeftTextColour[0], $tableHeaderLeftTextColour[1], $tableHeaderLeftTextColour[2] );
  $pdf->SetFillColor( $tableHeaderLeftFillColour[0], $tableHeaderLeftFillColour[1], $tableHeaderLeftFillColour[2] );
  $pdf->Cell( 46, 12, " " . $rowLabels[$row], 1, 0, 'L', $fill );

  // Create the data cells
  $pdf->SetTextColor( $textColour[0], $textColour[1], $textColour[2] );
  $pdf->SetFillColor( $tableRowFillColour[0], $tableRowFillColour[1], $tableRowFillColour[2] );
  $pdf->SetFont( 'Arial', '', 15 );

  for ( $i=0; $i<count($columnLabels); $i++ ) {
    $pdf->Cell( 36, 12, ( '$' . number_format( $dataRow[$i] ) ), 1, 0, 'C', $fill );
  }

  $row++;
  $fill = !$fill;
  $pdf->Ln( 12 );
}


  
            
            

// Compute the X scale
$xScale = count($rowLabels) / ( $chartWidth - 40 );

// Compute the Y scale

$maxTotal = 0;

foreach ( $data as $dataRow ) {
  $totalSales = 0;
  foreach ( $dataRow as $dataCell ) $totalSales += $dataCell;
  $maxTotal = ( $totalSales > $maxTotal ) ? $totalSales : $maxTotal;
}

$yScale = $maxTotal / $chartHeight;

// Compute the bar width
$barWidth = ( 1 / $xScale ) / 1.5;

// Add the axes:

$pdf->SetFont( 'Arial', '', 10 );

// X axis
$pdf->Line( $chartXPos + 30, $chartYPos, $chartXPos + $chartWidth, $chartYPos );

for ( $i=0; $i < count( $rowLabels ); $i++ ) {
  $pdf->SetXY( $chartXPos + 40 +  $i / $xScale, $chartYPos );
  $pdf->Cell( $barWidth, 10, $rowLabels[$i], 0, 0, 'C' );
}

// Y axis
$pdf->Line( $chartXPos + 30, $chartYPos, $chartXPos + 30, $chartYPos - $chartHeight - 8 );

for ( $i=0; $i <= $maxTotal; $i += $chartYStep ) {
  $pdf->SetXY( $chartXPos + 7, $chartYPos - 5 - $i / $yScale );
  $pdf->Cell( 20, 10, '$' . number_format( $i ), 0, 0, 'R' );
  $pdf->Line( $chartXPos + 28, $chartYPos - $i / $yScale, $chartXPos + 30, $chartYPos - $i / $yScale );
}

// Add the axis labels
$pdf->SetFont( 'Arial', 'B', 12 );
$pdf->SetXY( $chartWidth / 2 + 20, $chartYPos + 8 );
$pdf->Cell( 30, 10, $chartXLabel, 0, 0, 'C' );
$pdf->SetXY( $chartXPos + 7, $chartYPos - $chartHeight - 12 );
$pdf->Cell( 20, 10, $chartYLabel, 0, 0, 'R' );

// Create the bars
$xPos = $chartXPos + 40;
$bar = 0;

foreach ( $data as $dataRow ) {

  // Total up the sales figures for this product
  $totalSales = 0;
  foreach ( $dataRow as $dataCell ) $totalSales += $dataCell;

  // Create the bar
  $colourIndex = $bar % count( $chartColours );
  $pdf->SetFillColor( $chartColours[$colourIndex][0], $chartColours[$colourIndex][1], $chartColours[$colourIndex][2] );
  $pdf->Rect( $xPos, $chartYPos - ( $totalSales / $yScale ), $barWidth, $totalSales / $yScale, 'DF' );
  $xPos += ( 1 / $xScale );
  $bar++;
}



$pdf->Output( "report.pdf", "I" );
/*





$pdf = new FPDF('P','mm','A4'); //use new class
$pdf->AddPage();

//			chart properties
//position
$chartX=3;
$chartY=10;

//dimension
$chartWidth=205;
$chartHeight=100;

//padding
$chartTopPadding=10;
$chartLeftPadding=20;
$chartBottomPadding=20;
$chartRightPadding=5;

//chart box
$chartBoxX=$chartX+$chartLeftPadding;
$chartBoxY=$chartY+$chartTopPadding;
$chartBoxWidth=$chartWidth-$chartLeftPadding-$chartRightPadding;
$chartBoxHeight=$chartHeight-$chartBottomPadding-$chartTopPadding;

//bar width
$barWidth=20;

//chart data
$data=Array(
	'lorem'=>[
		'color'=>[255,0,0],
		'value'=>100],
	'ipsum'=>[
		'color'=>[255,255,0],
		'value'=>300],
	'dfkldkfl ççdfçç'=>[
		'color'=>[50,0,255],
		'value'=>150],
	'sit'=>[
		'color'=>[255,0,255],
		'value'=>50],
	'amet'=>[
		'color'=>[0,255,0],
		'value'=>240]
	);

//$dataMax
$dataMax=0;
foreach($data as $item){
	if($item['value']>$dataMax)$dataMax=$item['value'];
}

//data step
$dataStep=50;

//set font, line width and color
$pdf->SetFont('Arial','',7);
$pdf->SetLineWidth(0.2);
$pdf->SetDrawColor(0);

//chart boundary
$pdf->Rect($chartX,$chartY,$chartWidth,$chartHeight);

//vertical axis line
$pdf->Line(
	$chartBoxX ,
	$chartBoxY , 
	$chartBoxX , 
	($chartBoxY+$chartBoxHeight)
	);
//horizontal axis line
$pdf->Line(
	$chartBoxX-2 , 
	($chartBoxY+$chartBoxHeight) , 
	$chartBoxX+($chartBoxWidth) , 
	($chartBoxY+$chartBoxHeight)
	);

///vertical axis
//calculate chart's y axis scale unit
$yAxisUnits=$chartBoxHeight/$dataMax;

//draw the vertical (y) axis labels
for($i=0 ; $i<=$dataMax ; $i+=$dataStep){
	//y position
	$yAxisPos=$chartBoxY+($yAxisUnits*$i);
	//draw y axis line
	$pdf->Line(
		$chartBoxX-2 ,
		$yAxisPos ,
		$chartBoxX ,
		$yAxisPos
	);
	//set cell position for y axis labels
	$pdf->SetXY($chartBoxX-$chartLeftPadding , $yAxisPos-2);
	//$pdf->Cell($chartLeftPadding-4 , 5 , $dataMax-$i , 1);---------------
	$pdf->Cell($chartLeftPadding-4 , 5 , $dataMax-$i, 0 , 0 , 'R');
}

///horizontal axis
//set cells position
$pdf->SetXY($chartBoxX , $chartBoxY+$chartBoxHeight);

//cell's width
$xLabelWidth=$chartBoxWidth / count($data);

//$pdf->Cell($xLabelWidth , 5 , $itemName , 1 , 0 , 'C');-------------
//loop horizontal axis and draw the bar
$barXPos=0;
foreach($data as $itemName=>$item){
	//print the label
	//$pdf->Cell($xLabelWidth , 5 , $itemName , 1 , 0 , 'C');--------------
	$pdf->Cell($xLabelWidth , 5 , $itemName , 0 , 0 , 'C');
	
	///drawing the bar
	//bar color
	$pdf->SetFillColor($item['color'][0],$item['color'][1],$item['color'][2]);
	//bar height
	$barHeight=$yAxisUnits*$item['value'];
	//bar x position
	$barX=($xLabelWidth/2)+($xLabelWidth*$barXPos);
	$barX=$barX-($barWidth/2);
	$barX=$barX+$chartBoxX;
	//bar y position
	$barY=$chartBoxHeight-$barHeight;
	$barY=$barY+$chartBoxY;
	//draw the bar
	$pdf->Rect($barX,$barY,$barWidth,$barHeight,'DF');
	//increase x position (next series)
	$barXPos++;
}

//axis labels
$pdf->SetFont('Arial','B',12);
$pdf->SetXY($chartX,$chartY);
//$pdf->Cell(100,5,"Amount",0,0,'C');
$pdf->SetXY(($chartWidth/2)-50+$chartX,$chartY+$chartHeight-($chartBottomPadding/2));
$pdf->Cell(100,5,"Series",0,0,'C');


$pdf->Output();
*/
      exit;
    }
    public function downloadPDF2(Request $request) {
                  
      $quizCampaign = request()->session()->get('quizCampaign');
      
      if(isset($request->hidden_html) && $request->hidden_html != '')
      {
       $file_name = 'google_chart.pdf';
       $html = '';
       //$html = '<link rel="stylesheet" href="bootstrap.min.css">';
       $html .= $request->hidden_html;
       
      // return $html;
              
        PDF::SetAuthor('Nicola Asuni');
        PDF::SetTitle('TCPDF Example 031');
        PDF::SetSubject('TCPDF Tutorial');
        PDF::SetKeywords('TCPDF, PDF, example, test, guide');
        // set font
        PDF::SetFont('helvetica', 'B', 20);
        // add a page
        PDF::AddPage();
        // output the HTML content
        PDF::writeHTML($html, true, 0, true, 0);

        // write some JavaScript code
        $js = "app.alert('JavaScript Popup Example', 3, 0, 'Welcome');";
        $js .= "var cResponse = app.response({
            cQuestion: 'How are you today?',
            cTitle: 'Your Health Status',
            cDefault: 'Fine',
            cLabel: 'Response:'
        });";
        $js .= "if (cResponse == null) {";
        $js .= "app.alert('Thanks for trying anyway.', 3, 0, 'Result');";
        $js .= "} else {";
        $js .= "app.alert('You responded, to the health question.', 3, 0, 'Result');";
        $js .= "}";

        // force print dialog
        $js .= 'print(true);';

        // set javascript
        PDF::IncludeJS($js);

        // reset pointer to the last page
        PDF::lastPage();

        // ---------------------------------------------------------

        //Close and output PDF document
        PDF::Output('example_021.pdf', 'I');
      
     }else{
       return 'nao tem';
     }
              
      //$pdf = PDF::loadView('app.quiz.dashboard2',compact('quizCampaign'));        
      //return $pdf->download($quizCampaign->slug.'.pdf');
        
    }
}
