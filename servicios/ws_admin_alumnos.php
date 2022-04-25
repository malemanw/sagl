<?php
header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
$type = "error";
$title = "Error!";
$text = "Error desconocido";
$timer = NULL;
$showConfirmButton = true;
$datareturn = "";
$htmldata = "";
require "../config.php";
$accion = isset($_GET["accion"]) ? $_GET["accion"] : "default";
$idaño = $_POST["idaño"];
switch ($accion)
	{
case "lista_espera":
	$strsql = "SELECT alumnos.idexpediente, alumnos.nombre_completo, alumnos.rtn, cursos.nombre_curso, year_escolar.nombre, anios_militares.descripcion, alumnos.fecha_nacimiento_alumno, alumnos.residencia_alumno, CASE WHEN alumnos_matriculados.esinterno = 1 THEN 'INTERNO' ELSE  'EXTERNO' END AS esinterno, CASE WHEN alumnos_matriculados.primer_ingreso = 1 THEN 'PRIMER INGRESO' ELSE  'RE-INGRESO' END AS primer_ingreso, CASE WHEN alumnos_matriculados.al_dia = 1 THEN 'YA PAGÓ' ELSE  'NO PAGÓ' END AS aldia, alumnos.nombre_padre, alumnos.nombre_madre, alumnos.telefono_padre, alumnos.telefono_madre, alumnos.telefono_encargado, alumnos.email_padre, cursos.nivel, alumnos.email_madre, alumnos.telefono_alumno, alumnos_matriculados.idaño, alumnos_matriculados.fecha_matricula  FROM alumnos INNER JOIN alumnos_matriculados ON alumnos.idexpediente = alumnos_matriculados.idexpediente INNER JOIN cursos ON alumnos_matriculados.idcurso = cursos.idcurso INNER JOIN year_escolar ON alumnos_matriculados.idaño = year_escolar.idaño INNER JOIN anios_militares ON alumnos_matriculados.idanio_militar = anios_militares.idanio_militar WHERE alumnos_matriculados.lista_espera=0 ORDER BY alumnos_matriculados.fecha_matricula DESC";
	if ($stmt = $mysqli->prepare($strsql))
		{
		$resultado = $mysqli->query($strsql);
		$stmt->execute();
		$outp = array();
		$stmt->store_result();
		if ($stmt->num_rows > 0)
			{
			$outp = $resultado->fetch_all(MYSQLI_ASSOC);
			$arreglo["data"] = $outp;
			}
		  else
			{
			$outp = "No hay datos disponibles" . $stmt->error;
			}
		}
	  else
		{
		$outp = "No se pudo ejecutar la consulta: " . $stmt->error;
		}
$stmt->close();
	echo json_encode($arreglo);
	break;
	}



?>


