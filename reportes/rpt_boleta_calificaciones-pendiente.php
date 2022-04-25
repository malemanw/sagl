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
$strsql = "SELECT alumnos.nombre_completo, year_escolar.nombre, cursos.nombre_curso, cursos.nivel, secciones.nombre_seccion FROM alumnos INNER JOIN alumnos_matriculados ON alumnos_matriculados.idexpediente=alumnos.idexpediente INNER JOIN year_escolar ON year_escolar.idaño=alumnos_matriculados.idaño INNER JOIN cursos ON cursos.idcurso=alumnos_matriculados.idcurso INNER JOIN secciones ON secciones.idseccion=alumnos_matriculados.idseccion WHERE alumnos_matriculados.idexpediente=? and alumnos_matriculados.idaño=?";
if($st = $mysqli->prepare($strsql)){
    $st->bind_param("si", $idexpediente, $idaño);
	$st->execute();
	if($st->errno == 0){
		$st->store_result();
		if($st->num_rows > 0){
			$st->bind_result($nombre_completo, $anio_escolar, $nombre_curso, $modalidad, $seccion);
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
$pdf->Cell(190, 8, "Año Escolar: ".$anio_escolar, 0,0,'C');
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
$pdf->Cell(10, 15, "No.", 1,0,'C');
$pdf->Cell(80, 15, "ASIGNATURAS ", 1,0,'C');
$pdf->Cell(35, 10, "PARCIALES", 'T',0,'C');
$pdf->Cell(35, 15, "PROMEDIO FINAL", 1,0,'C');
$pdf->Cell(0, 15, "RECUPERACIÓN", 1,0,'C');
$pdf->Ln();
$pdf->Cell(90);
$pdf->SetFont('Arial', 'B', 7);
$pdf->Cell(17.5, -5, "I", 1,0,'C');
$pdf->Cell(17.5, -5, "II", 1,0,'C');
$pdf->Ln(0);
//query
$strsql = "SELECT clase_curso_detalles.idclase_curso, cursos.nombre_curso, clases.nombre FROM `clase_curso_detalles` INNER JOIN cursos ON cursos.idcurso=clase_curso_detalles.idcurso INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase INNER JOIN alumnos_matriculados ON alumnos_matriculados.idcurso=clase_curso_detalles.idcurso WHERE alumnos_matriculados.idexpediente=? and alumnos_matriculados.idaño=? and clase_curso_detalles.idcurso=alumnos_matriculados.idcurso and clases.semestre=1";
if($st = $mysqli->prepare($strsql)){
    $st->bind_param("si", $idexpediente, $idaño);
	$st->execute();
	if($st->errno == 0){
		$st->store_result();
		if($st->num_rows > 0){
			$st->bind_result($idclase_curso, $nombre_curso, $nombre_clase);
			$correlativo=1;
			while($st->fetch()){            
			  $pdf->SetFont('Arial', 'B', 9);
			  $pdf->Cell(10, 8, $correlativo++, 1,0,'C');
			  $tmpfontsize=9;
			  while($pdf->GetStringWidth($nombre_clase) > 80){
				$pdf->SetFontSize($tmpfontsize -= 0.1);
				}
			$pdf->SetFontSize($tmpfontsize);
			  $pdf->Cell(80, 8, $nombre_clase, 1);
			  //query			  
			  $stmt2 = $mysqli->prepare("SELECT COUNT(idparcial) FROM `notas` WHERE idclase_curso=? and idexpediente=?");
			  $stmt2->bind_param("is", $idclase_curso, $idexpediente); 
			  $stmt2->execute();
			  $stmt2->store_result();
			  $stmt2->bind_result($total_arreglo);
			  $stmt2->fetch();
			  $stmt2->close();
			  //query
$strsql2 = "SELECT (sem1 + sem2 + sem3 + sem4 + sem5 + sem6 + sem7 + examen) as acumulado, idparcial FROM `notas` WHERE idclase_curso=? and idexpediente=?";
if($stmt = $mysqli->prepare($strsql2)){
    $stmt->bind_param("is", $idclase_curso, $idexpediente);
	$stmt->execute();
	if($stmt->errno == 0){
		$stmt->store_result();
		$total_clase=0;
		if($stmt->num_rows > 0){
			$stmt->bind_result($total, $parcial);
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
				$pdf->Cell(0, 8,"", 1);
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
$pdf->ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0,8,'Fecha impresión: '.$fecha,0,0,'C');
$pdf->Ln();
$pdf->Cell(0,8,'-----------Última Línea-----------',0,0,'C');
//Salida PDF
$pdf->Ln(20);
$fecha = date('Y-m-d');
$pdf->Output('','rptMatricula'.$fecha.'.pdf');
?>
