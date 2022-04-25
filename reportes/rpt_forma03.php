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
$strsql = "SELECT year_escolar.nombre, alumnos.idexpediente, alumnos.id_padre, alumnos.id_madre, alumnos_matriculados.idcurso, cursos.nombre_curso, alumnos_matriculados.idseccion, secciones.nombre_seccion, alumnos_matriculados.idanio_militar, anios_militares.descripcion, year_escolar.nombre, alumnos.rtn, alumnos.nombre_completo, alumnos.fecha_nacimiento_alumno, alumnos.tiposangre, alumnos.sexo, alumnos.telefono_alumno, alumnos.email_alumno, alumnos.residencia_alumno, alumnos.idreligion, religiones.religion, alumnos.iddepto, departamentos.departamento, alumnos.idnacionalidad, nacionalidades.nacionalidad, alumnos.idinstitucion_previa, instituciones_previas.institucion_previa, alumnos.ciudad_previa, alumnos.modalidad, alumnos.promedio_anterior, alumnos.idciudad, ciudades.ciudad, alumnos.nombre_padre, alumnos.direccion_padre, ciu_padre.ciudad, nacio_padre.nacionalidad, alumnos.telefono_padre, alumnos.email_padre, alumnos.nombre_madre, alumnos.direccion_madre, ciu_madre.ciudad, nacio_madre.nacionalidad, alumnos.telefono_madre, alumnos.email_madre, alumnos_matriculados.tienebeca, alumnos_matriculados.esinterno, alumnos_matriculados.fecha_matricula, alumnos.nombre_encargado, alumnos.direccion_encargado, alumnos.telefono_encargado, alumnos.correo_encargado FROM `alumnos`INNER JOIN alumnos_matriculados ON alumnos.idexpediente = alumnos_matriculados.idexpediente  INNER JOIN cursos ON alumnos_matriculados.idcurso = cursos.idcurso INNER JOIN secciones ON alumnos_matriculados.idseccion = secciones.idseccion INNER JOIN anios_militares ON alumnos_matriculados.idanio_militar = anios_militares.idanio_militar INNER JOIN nacionalidades ON alumnos.idnacionalidad = nacionalidades.idnacionalidad INNER JOIN ciudades ON alumnos.idciudad = ciudades.idciudad INNER JOIN departamentos ON alumnos.iddepto = departamentos.iddepto INNER JOIN year_escolar ON alumnos_matriculados.idaño = year_escolar.idaño INNER JOIN instituciones_previas ON alumnos.idinstitucion_previa = instituciones_previas.idinstitucion INNER JOIN religiones ON alumnos.idreligion = religiones.idreligion INNER JOIN ciudades AS ciu_padre ON alumnos.ciudad_padre = ciu_padre.idciudad INNER JOIN nacionalidades as nacio_padre ON alumnos.nacionalidad_padre = nacio_padre.idnacionalidad INNER JOIN ciudades as ciu_madre ON alumnos.ciudad_madre = ciu_madre.idciudad INNER JOIN nacionalidades as nacio_madre ON alumnos.nacionalidad_madre = nacio_madre.idnacionalidad WHERE alumnos_matriculados.idexpediente=? and alumnos_matriculados.idaño=?";
if($st = $mysqli->prepare($strsql)){
    $st->bind_param("si", $idexpediente, $idaño);
	$st->execute();
	if($st->errno == 0){
		$st->store_result();
		if($st->num_rows > 0){
			$st->bind_result($anio_escolar, $idexpediente, $id_padre, $id_madre, $idcurso, $nombre_curso, $idseccion, $nombre_seccion, $idanio_militar, $anio_militar, $nombre, $rtn, $nombre_completo, $fecha_nacimiento_alumno, $tiposangre, $sexo, $telefono_alumno, $email_alumno, $residencia_alumno, $idreligion, $religion, $iddepto, $departamento, $idnacionalidad,$nacionalidad_alumno, $idinstitucion,$institucion_previa, $ciudad_previa, $modalidad, $promedio_anterior, $idciudad, $ciudad_alumno, $nombre_padre, $direccion_padre, $ciudad_padre, $nacionalidad_padre, $telefono_padre, $email_padre, $nombre_madre, $direccion_madre, $ciudad_madre, $nacionalidad_madre, $telefono_madre, $email_madre, $tienebeca, $esinterno, $fecha_matricula, $nombre_encargado, $direccion_encargado, $telefono_encargado, $correo__encargado);
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
    $fecha = date('d-m-Y,g:i');
// Instanciation of inherited class
	$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 15);
$tmpfontsize=12;
$fontsize = 12;
$pdf->Cell(190, 8, 'HOJA DE MATRÍCULA', 0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(42, 142, 81);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0, 8, "Datos Generales", 0,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 8, "Nombre del Estudiante", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $nombre_completo, 1,0,'L');
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 8, "Expediente", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 8, $idexpediente, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(50, 8, "Número de Cedúla", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $rtn, 1,0,'L');
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, 8, "Sangre", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 8, $tiposangre, 1,0,'L');
//
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(20, 8, "Sexo", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 8, ($sexo==1) ? "Masculino" : "Femenino", 1,0,'L');
//
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, 8, "Nacimiento", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $fecha_nacimiento_alumno, 1,0,'L');
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, 8, "Es Interno", 1,0,'L');
$pdf->SetFont('Arial', '', 10);
$pdf->Cell(30, 8, ($esinterno==1) ? "Si" : "No", 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(20, 8, "Beca", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 8, ($tienebeca==1) ? "Si" : "No", 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, 8, "Teléfono", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $telefono_alumno, 1,0,'L');
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, 8, "Nacionalidad", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 8, $nacionalidad_alumno, 1,0,'L');
//
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(20, 8, "Ciudad", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 8, $ciudad_alumno, 1,0,'L');
//
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, 8, "Departamento", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $departamento, 1,0,'L');
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, 8, "Domicilio", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$tmpfontsize=9;
while($pdf->GetStringWidth($residencia_alumno) > 50){
	$pdf->SetFontSize($tmpfontsize -= 0.1);
	}
$pdf->SetFontSize($tmpfontsize);
$pdf->Cell(50, 8, $residencia_alumno, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Correo Electrónico", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $email_alumno, 1,0,'L');
//////
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(42, 142, 81);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0, 8, "Datos Académicos", 0,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Ln(10);
//
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 8, "Curso", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $nombre_curso, 1,0,'L');
$pdf->Ln();
//
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, 8, "Año Escolar", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 8, $anio_escolar, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, 8, "Sección", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(30, 8, $nombre_seccion, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(30, 8, "Año Militar", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $anio_militar, 1,0,'L');
$pdf->Ln(10);
//
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 8, "Institución Previa", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$tmpfontsize=9;
while($pdf->GetStringWidth($institucion_previa) > 50){
	$pdf->SetFontSize($tmpfontsize -= 0.1);
	}
$pdf->SetFontSize($tmpfontsize);
$pdf->Cell(50, 8, $institucion_previa, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Ciudad", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $ciudad_previa, 1,0,'L');
$pdf->Ln();
//
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(60, 8, "Modalidad", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(50, 8, $modalidad, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Promedio Obtenido", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, ($promedio_anterior==0) ? "N/A" : $promedio_anterior, 1,0,'L');
//////
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(42, 142, 81);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0, 8, "Datos Familiares", 0,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Ln(10);
//
$pdf->SetFont('Times','BIU', 14);
$pdf->Cell(70, 8, "Datos del Padre");
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Nombre Completo", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(85, 8, $nombre_padre, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 8, "# Identidad", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $id_padre, 1,0,'L');
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Dirección", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $direccion_padre, 1,0,'L');
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Número Telefónico", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 8, $telefono_padre, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "E-Mail", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $email_padre, 1,0,'L');
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Ciudad Nacimiento", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 8, $ciudad_padre, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Nacionalidad", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $nacionalidad_padre, 1,0,'L');
////////
$pdf->Ln();
$pdf->SetFont('Times','BIU', 14);
$pdf->Cell(70, 8, "Datos de la madre");
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Nombre Completo", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(85, 8, $nombre_madre, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(25, 8, "# Identidad", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $id_madre, 1,0,'L');
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Dirección", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $direccion_madre, 1,0,'L');
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Número Telefónico", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 8, $telefono_madre, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "E-Mail", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $email_madre, 1,0,'L');
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Ciudad Nacimiento", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(40, 8, $ciudad_madre, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(40, 8, "Nacionalidad", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $nacionalidad_madre, 1,0,'L');
$pdf->Ln();
//
$pdf->SetFont('Times','BIU', 14);
$pdf->Cell(70, 8, "Datos del Encargado");
$pdf->Ln();
//
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(45, 8, "Nombre Completo", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$tmpfontsize=9;
while($pdf->GetStringWidth($nombre_encargado) > 45){
	$pdf->SetFontSize($tmpfontsize -= 0.1);
	}
$pdf->SetFontSize($tmpfontsize);
$pdf->Cell(45, 8, $nombre_encargado, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(45, 8, "Dirección", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$tmpfontsize=9;
while($pdf->GetStringWidth($direccion_encargado) > 45){
	$pdf->SetFontSize($tmpfontsize -= 0.1);
	}
$pdf->SetFontSize($tmpfontsize);
$pdf->Cell(0, 8, $direccion_encargado, 1,0,'L');
$pdf->Ln();
//
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(45, 8, "Teléfono", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, 8, ($telefono_encargado==0) ? "N/A" : $telefono_encargado, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(45, 8, "Correo Electrónico", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $correo__encargado, 1,0,'L');
//////
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(42, 142, 81);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0, 8, "Otros Datos", 0,0,'C',true);
$pdf->SetTextColor(0,0,0);
//
$pdf->Ln();
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(45, 8, "Religión", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(45, 8, $religion, 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(45, 8, "Fecha de Matrícula", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 8, $fecha_matricula, 1,0,'L');
//////
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(42, 142, 81);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0, 8, "Autorización de Secretaría Educativa", 0,0,'C',true);
$pdf->SetTextColor(0,0,0);
$pdf->Ln();
//
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(45, 12, "Firma y Sello", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(60, 12, "", 1,0,'L');
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(45, 12, "Fecha de Revisión", 1,0,'L');
$pdf->SetFont('Arial', '', 9);
$pdf->Cell(0, 12, "", 1,0,'L');
$pdf->Ln();
//
$pdf->Ln(10);
$pdf->SetFont('Arial', 'B', 14);
$pdf->SetFillColor(42, 142, 81);
$pdf->SetTextColor(255,255,255);
$pdf->Cell(0, 8, "Observaciones Adicionales", 0,0,'C', true);
$pdf->Ln();
$pdf->SetTextColor(0,0,0);
$pdf->SetFont('Arial', 'B', 11);
$pdf->Cell(0, 40, "", 1,0,'L');
$pdf->Ln();
//FINAL
$pdf->ln(20);
$pdf->SetFont('Arial', 'B', 8);
$pdf->Cell(0,8,'Fecha impresión: '.$fecha,0,0,'C');
$pdf->Ln();
$pdf->Cell(0,8,'-----------Última Línea-----------',0,0,'C');
//Salida PDF
$pdf->Ln(20);
$fecha = date('Y-m-d');
$pdf->Output('','rptMatricula'.$fecha.'.pdf');
?>
