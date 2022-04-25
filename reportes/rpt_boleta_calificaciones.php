<?php
header("Content-Type: text/html;charset=utf-8");
global $mysqli;
global $urlweb;
require "../config.php";
require "../recursos/fpdf/fpdf.php";
include "plantilla.php";
require "../funciones.class.php";
$idexpediente = $_GET['idexpediente'];
$idaño = $_GET['idaño'];
//query
$strsql = "SELECT alumnos.nombre_completo, year_escolar.nombre, cursos.nombre_curso, cursos.idcurso, cursos.nivel, secciones.nombre_seccion FROM alumnos INNER JOIN alumnos_matriculados ON alumnos_matriculados.idexpediente=alumnos.idexpediente INNER JOIN year_escolar ON year_escolar.idaño=alumnos_matriculados.idaño INNER JOIN cursos ON cursos.idcurso=alumnos_matriculados.idcurso INNER JOIN secciones ON secciones.idseccion=alumnos_matriculados.idseccion WHERE alumnos_matriculados.idexpediente=? and alumnos_matriculados.idaño=?";
if($st = $mysqli->prepare($strsql)){
    $st->bind_param("si", $idexpediente, $idaño);
	$st->execute();
	if($st->errno == 0){
		$st->store_result();
		if($st->num_rows > 0){
			$st->bind_result($nombre_completo, $anio_escolar, $nombre_curso, $idcurso, $modalidad, $seccion);
			$st->fetch();
				$st->close();
			}//cierre de consulta de valores retornados
		}
		else{
			echo "Error al ejecutar consulta: " . $st->error;
		}//Cierre de condicion de Ejecucion
	}
	else{
		echo "Error al preparar consulta: " . $mysqli->error;
	}			
$funciones = new funciones($mysqli);
$funciones->iniciarsesion();
	date_default_timezone_set('America/Tegucigalpa');
    $fecha = date('Y-m-d H:i:s');
// Instanciation of inherited class
	$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);
$tmpfontsize=12;
$fontsize = 12;
$pdf->Cell(190, 8, 'BOLETA DE CALIFICACIONES', 0,0,'C');
$pdf->Ln();
$pdf->Cell(190, 8, "".$anio_escolar, 0,0,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(42, 142, 81);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0, 8, "Datos Generales", 0,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(45, 8, "Nombre del Estudiante", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(75, 8, $nombre_completo, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, 8, "Sección", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $seccion, 1,0,'C');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(45, 8, "Grado", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(75, 8, $nombre_curso, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, 8, "Modalidad", 1,0,'L');
$pdf->SetFont('Arial', '', 8);
$pdf->Cell(0, 8, "EDUCACIÓN ".$modalidad, 1,0,'C');
/////
$pdf->Ln(12);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 5, "Después de revisar los cuadros de evaluación emitidos por cada docente, El Departamento de Secretaría Académica certifica que: ".$nombre_completo." ha sido acreedor de las siguientes calificaciones:");
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(6, 12, "No.", 1,0,'C');
$pdf->Cell(80, 12, "ASIGNATURAS ", 1,0,'C');
$pdf->SetFont('Arial', 'B', 5);
$pdf->Cell(10, 12, "SEMESTRE ", 1,0,'C');
$pdf->SetFont('Arial', 'B', 9);
$pdf->Cell(35, 12, "PARCIALES ", 1,0,'C');
$pdf->Cell(35, 12, "PROMEDIO FINAL", 1,0,'C');
$pdf->Cell(0, 12, "RECUP.", 1,0,'C');
$pdf->Ln();
//query
$strsql = "SELECT clase_curso_detalles.idclase_curso, cursos.nombre_curso, clases.nombre, clases.semestre FROM `clase_curso_detalles` INNER JOIN cursos ON cursos.idcurso=clase_curso_detalles.idcurso INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase INNER JOIN alumnos_matriculados ON alumnos_matriculados.idcurso=clase_curso_detalles.idcurso WHERE alumnos_matriculados.idexpediente=? and alumnos_matriculados.idaño=? and clase_curso_detalles.idaño=? and clase_curso_detalles.idcurso=? ORDER BY clases.semestre";
if($st = $mysqli->prepare($strsql)){
    $st->bind_param("siii", $idexpediente, $idaño, $idaño, $idcurso);
	$st->execute();
	if($st->errno == 0){
		$st->store_result();
		if($st->num_rows > 0){
			$st->bind_result($idclase_curso, $nombre_curso, $nombre_clase, $semestre);
			$correlativo=1;
			while($st->fetch()){            
			  $pdf->SetFont('Arial', 'B', 9);
			  $pdf->Cell(6, 8, $correlativo++, 1,0,'C');
			  $tmpfontsize=9;
			  while($pdf->GetStringWidth($nombre_clase) > 80){
				$pdf->SetFontSize($tmpfontsize -= 0.1);
				}
			$pdf->SetFontSize($tmpfontsize);
			  $pdf->Cell(80, 8, $nombre_clase, 1);
			  $pdf->Cell(10, 8, ($semestre==0) ? "-" : $semestre, 1,0,'C');
			  //query			  
			  $stmt2 = $mysqli->prepare("SELECT COUNT(idparcial) FROM `notas` WHERE idclase_curso=? and idexpediente=?");
			  $stmt2->bind_param("is", $idclase_curso, $idexpediente); 
			  $stmt2->execute();
			  $stmt2->store_result();
			  $stmt2->bind_result($total_arreglo);
			  $stmt2->fetch();
			  $stmt2->close();
			  //query
$strsql2 = "SELECT (sem1 + sem2 + sem3 + sem4 + sem5 + sem6 + sem7 + examen) as acumulado, recup, idparcial FROM `notas` WHERE idclase_curso=? and idexpediente=?";
if($stmt = $mysqli->prepare($strsql2)){
    $stmt->bind_param("is", $idclase_curso, $idexpediente);
	$stmt->execute();
	if($stmt->errno == 0){
		$stmt->store_result();
		$total_clase=0;
		if($stmt->num_rows > 0){
			$stmt->bind_result($total, $recup, $parcial);
			while($stmt->fetch()){
				$pdf->Cell(35/$total_arreglo, 8, $total, 1,0, 'C');
				$total_clase=$total_clase + $total;
			}
				$stmt->close();
			}//cierre de consulta de valores retornados
		}
		else{
			echo "Error al ejecutar consulta: " . $stmt->error;
		}//Cierre de condicion de Ejecucion
	}
	else{
		echo "Error al preparar consulta: " . $mysqli->error;
	}	
			if($total_clase!=0){
				$pdf->Cell(35, 8, ($total_clase!=0) ? round($total_clase/$total_arreglo)."%" : "", 1,0,'C');
				$pdf->Cell(0, 8,(round($total_clase/$total_arreglo <70 && $recup!=0)) ? $recup : "", 1,0,'C' );
			}else{
				$pdf->Cell(35, 8,"", 1);
				$pdf->Cell(35, 8,"", 1);
				$pdf->Cell(0, 8,"", 1);
			}
			  $pdf->Ln();
			}
				$st->close();
			}//cierre de consulta de valores retornados
		}
		else{
			echo "Error al ejecutar consulta: " . $st->error;
		}//Cierre de condicion de Ejecucion
	}
	else{
		echo "Error al preparar consulta: " . $mysqli->error;
	}


////
//FINAL
$pdf->ln(0);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0,8,'Este documento no tiene validez sin firmas y sellos autorizados.',0,0,'L');
$pdf->Ln(5);
if($modalidad=="MEDIA"){
	// Logo
	$pdf->Image('../temas/LMN2018/img/firmas/secretaria2020.jpeg', 40, null,45,45,'JPG');
	$pdf->Ln(-45);
	$pdf->Image('../temas/LMN2018/img/firmas/direccion2020.jpeg', 135 ,null,45 , 45,'JPG');
	///FIRMAS
	$pdf->Ln(-23);
	$pdf->SetFont('Arial', 'B', 10);
	$pdf->Cell(100,8,'___________________________',0,0,'C');
	$pdf->Cell(0,8,'___________________________',0,0,'C');
	$pdf->Ln();
	$pdf->Cell(100,8,"Secretaría",0,0,'C');
	$pdf->Cell(0,8,"Dirección Académica",0,0,'C');
}else{

}
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0,8,'-----------Última Línea-----------',0,0,'C');
$pdf->Ln();
//$pdf->Cell(0,8,'Fecha impresión: '.$fecha,0,0,'L');
//Salida PDF
$fecha = date('Y-m-d');
$pdf->Output('','rptboleta'.$fecha.'.pdf');
?>
