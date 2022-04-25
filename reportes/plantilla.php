<?php
class PDF extends FPDF
{
// Page headerx
function Header()
{
    $idexpediente = $_GET['idexpediente'];
    $dir = "../uploads/avatar/";
    if(file_exists($dir.$idexpediente.".jpg")){
        $direccion=$dir.$idexpediente.".jpg";
    }else{
        $direccion=$dir."default.jpg";
    }
    $this->SetTitle('BOLETA DE CALIFICACIONES', true);
    $this->SetAuthor('Marco Alemán Watters', true);
    date_default_timezone_set('America/Tegucigalpa');
    $fecha = date('d-m-Y g:i a');
    // Logo
    $this->Image('../temas/LMN2018/img/logo_lmh.png', 18 ,15 ,30 , 30,'PNG');
    // Arial bold 15
    $this->Ln(5);
    $this->SetFont('Arial','B',15);
    // Move to the right
    //$this->Cell(50);
    // Title
    $this->Cell(0, 10,'INSTITUTO DE PREVISION MILITAR', 0,0,'C');
    $this->Ln(5);
    $this->SetFont('Arial','',12);
    $this->Cell(0, 10, 'LICEO MILITAR DE HONDURAS', 0,0,'C');
    $this->Ln(5);
    $this->Cell(0, 10, 'SAN PEDRO SULA, CORTÉS', 0,0,'C');
    // Line break
    $this->SetFont('Arial', '', 9);
    $this->Image($direccion, 160 ,15 ,30 , 30,'JPG');
    $this->Ln(15);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    $this->Cell(0,10,'Tecnología educativa - Todos los derechos reservados. ',0,0,'C');
    // Page number
    $this->Cell(0,10,'Pag '.$this->PageNo().'/{nb}',0,0,'C');
}
}
?>
