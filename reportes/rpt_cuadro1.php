<?php
header("Content-Type: text/html;charset=utf-8");
date_default_timezone_set('America/Tegucigalpa');

global $funciones;
global $mysqli;
global $urlweb;
require "../config.php";
require "../funciones.class.php";
$funciones = new funciones($mysqli);  
require "../config.php";
require "../recursos/fpdf/fpdf.php";
include "plantilla_cuadro1.php";

$idclase_curso = $_GET['idclase_curso'];
$idaño = $_GET['idaño'];
$parcial = $_GET['parcial'];
//query
$strsql = "SELECT year_escolar.nombre, cursos.nombre_curso, clases.nombre, clases.semestre, usuarios.usuario FROM `clase_curso_detalles` INNER JOIN cursos ON cursos.idcurso=clase_curso_detalles.idcurso INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase INNER JOIN year_escolar ON year_escolar.idaño=clase_curso_detalles.idaño INNER JOIN maestro_grado_detalles ON maestro_grado_detalles.idclase_curso=clase_curso_detalles.idclase_curso INNER JOIN usuarios ON usuarios.idusuario=maestro_grado_detalles.idusuario  WHERE clase_curso_detalles.idclase_curso=?";
if($st = $mysqli->prepare($strsql)){
    $st->bind_param("i", $idclase_curso);
	$st->execute();
	if($st->errno == 0){
		$st->store_result();
		if($st->num_rows > 0){
			$st->bind_result($añoescolar, $nombre_curso, $nombre_clase, $semestre, $maestro);
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
	$fecha = date('d-m-Y,g:i');

//if($prueba=="1"){
// Instanciation of inherited class
	$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);
$tmpfontsize=12;
$fontsize = 12;
$pdf->Cell(0, 8, 'CUADRO NO. 1', 0,0,'C');
$pdf->Ln(10);
$pdf->SetFont('Arial', '', 12);
$pdf->MultiCell(0, 5, "Hoy, día _____ del mes ____ del año ____ se ha realizado la entrega, resolución y discusión de la(s) notas de la asignatura: ".$nombre_clase." del curso: ".$nombre_curso." del: ".$parcial." Parcial, " .($semestre!=0 ? "$semestre semestre" : "")." del año: ".$añoescolar.", impartida por el docente: ".$maestro.".");
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(42, 142, 81);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0, 8, "Calificaciones", 0,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Ln();
//header table
$pdf->SetFont('Arial', 'B', 12);
$pdf->Cell(8, 5, '#', 1,0,'C');
$pdf->Cell(28, 5, 'Expediente', 1,0,'C');
$pdf->Cell(104, 5, 'Nombre del Estudiante', 1,0,'C');
$pdf->Cell(28, 5, 'Acumulado', 1,0,'C');
$pdf->Cell(20, 5, 'Examen', 1,0,'C');
$pdf->Cell(17, 5, 'Recup.', 1,0,'C');
$pdf->Cell(20, 5, 'Total', 1,0,'C');
$pdf->Cell(30, 5, 'Observación', 1,0,'C');
$pdf->Cell(0, 5, 'Firma', 1,0,'C');
$pdf->Ln();
//body table
$pdf->SetFont('Arial', '', 12);
//query2
$correlativo=0;
$strsql = "SELECT alumnos_matriculados.idexpediente, alumnos.nombre_completo  FROM `clase_curso_detalles` INNER JOIN alumnos_matriculados ON alumnos_matriculados.idcurso=clase_curso_detalles.idcurso INNER JOIN alumnos ON alumnos.idexpediente=alumnos_matriculados.idexpediente WHERE clase_curso_detalles.idclase_curso=? and alumnos_matriculados.idaño=? and alumnos_matriculados.lista_espera=0 ORDER BY alumnos.nombre_completo ASC";
if($st = $mysqli->prepare($strsql)){
    $st->bind_param("ii", $idclase_curso, $idaño);
	$st->execute();
	if($st->errno == 0){
		$st->store_result();
		if($st->num_rows > 0){
			$st->bind_result($idexpediente, $nombre_completo);
			while($st->fetch()){ 
				$pdf->Cell(8, 5,$correlativo+=1, 1);
				$pdf->Cell(28, 5,$idexpediente, 1);
				$pdf->Cell(104, 5, $nombre_completo, 1);
				$strsql_2 = "SELECT `sem1`, `sem2`, `sem3`, `sem4`, `sem5`, `sem6`, `sem7`,`examen`,`recup` FROM `notas` WHERE idclase_curso=? and idexpediente=? and idparcial=?";
				if ($stmt = $mysqli->prepare($strsql_2))
					{
					$stmt->bind_param("isi", $idclase_curso, $idexpediente, $parcial);
					$stmt->execute();
					if($stmt->errno == 0){
					$stmt->store_result();
					$stmt->bind_result($sem1, $sem2, $sem3, $sem4, $sem5, $sem6, $sem7, $examen,$recup);
					$stmt->fetch();
					}
				  else
					{
					echo "No se pudo ejecutar la consulta: " . $stmt->error;
					}
				}
				else{
					echo "Error al preparar consulta: " . $mysqli->error;
				}
				if ($stmt->num_rows > 0)
				{
					$pdf->Cell(28, 5,$acum= $sem1+$sem2+$sem3+$sem4+$sem5+$sem6+$sem7, 1);
					$pdf->Cell(20, 5,$examen, 1);
					$pdf->Cell(17, 5,$recup, 1);
					$pdf->Cell(20, 5,($recup>0) ? $total=$recup : $total= $acum+$examen, 1,0, 'C');
					$pdf->Cell(30, 5,($total>=70) ? "Aprobado" : "Reprobado", 1,0,'C');
					$pdf->Cell(0, 5,"", 1);
					$pdf->Ln();
				}else{
					$pdf->Cell(28, 5,"0", 1);
					$pdf->Cell(28, 5,"0", 1);
					$pdf->Cell(22, 5,"0", 1,0, 'C');
					$pdf->Cell(30, 5,"", 1);
					$pdf->Cell(0, 5,"", 1);
					$pdf->Ln();	
				}			
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
///NOTA
$pdf->Ln(2);
$pdf->SetFont('Arial', '', 10);
$pdf->MultiCell(0, 5, "Nota: Solo los estudiantes que se presenten a esta discusión en la fecha programada por el docente, tendrán derecho a reclamo en los días hábiles posteriores a la misma.");
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0,8,'Fecha impresión: '.$fecha,0,0,'L');
///FIRMAS
$pdf->Ln(5);
$pdf->SetFont('Arial', 'B', 14);
$pdf->Cell(0,8,'___________________________',0,0,'C');
$pdf->Ln();
$pdf->Cell(0,8,$maestro,0,0,'C');
$pdf->SetFont('Arial', '', 12);
$pdf->Ln();
$pdf->Cell(0,8,"Docente",0,0,'C');
//FINAL
$pdf->ln(5);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Ln();
$pdf->Cell(0,8,'-----------Última Línea-----------',0,0,'C');
//Salida PDF
$pdf->Ln(20);
$fecha = date('Y-m-d');
$pdf->Output('','rptCuadro1'.$fecha.'.pdf');
//}else{
//	echo "no ha iniciado sesión correctamente.";
//}
?>
