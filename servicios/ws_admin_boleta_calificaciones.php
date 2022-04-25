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
	
	switch($accion){            
		case "alumnos":	
$idaño = $_POST['idaño'];	
	$strsql = "SELECT alumnos.idexpediente, alumnos.rtn, alumnos.nombre_completo, cursos.nombre_curso, anios_militares.descripcion, if(alumnos_matriculados.al_dia =1,'AL DIA','MORA') as al_dia  FROM alumnos INNER JOIN alumnos_matriculados ON alumnos.idexpediente = alumnos_matriculados.idexpediente INNER JOIN cursos ON alumnos_matriculados.idcurso = cursos.idcurso INNER JOIN year_escolar ON alumnos_matriculados.idaño = year_escolar.idaño INNER JOIN anios_militares ON alumnos_matriculados.idanio_militar = anios_militares.idanio_militar WHERE (alumnos_matriculados.idaño=" . $idaño . ") and alumnos_matriculados.lista_espera=0";
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

	echo json_encode($arreglo);	
			break;								
	}
	
	
	

?>
