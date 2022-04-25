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
case "selectanio":
	$strsql = "SELECT alumnos_matriculados.idexpediente, alumnos.nombre_completo, cursos.nombre_curso, anios_militares.descripcion, if(alumnos_matriculados.al_dia =1,'AL DIA','MORA') as al_dia
FROM   alumnos INNER JOIN
             alumnos_matriculados ON alumnos.idexpediente = alumnos_matriculados.idexpediente INNER JOIN
             year_escolar ON alumnos_matriculados.idaño = year_escolar.idaño INNER JOIN cursos ON  alumnos_matriculados.idcurso = cursos.idcurso INNER JOIN secciones ON alumnos_matriculados.idseccion = secciones.idseccion INNER JOIN anios_militares ON alumnos_matriculados.idanio_militar = anios_militares.idanio_militar WHERE (alumnos_matriculados.idaño=" . $idaño . " AND alumnos_matriculados.lista_espera=0)";
	if ($stmt = $mysqli->prepare($strsql))
		{
		$resultado = $mysqli->query($strsql);

		// $stmt->bind_param("i",$idaño);

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

case "al_dia":
// Insertar los valores a tabla de alumnos matriculados
if (!empty($_POST["idexpediente"])) {   
	$idexpediente = $_POST['idexpediente'];  
	$año = $_POST['año_escolar'];   
	$strsql = "UPDATE `alumnos_matriculados` SET `al_dia`=1 WHERE idexpediente=? and idaño=?";
	if ($stmt = $mysqli->prepare($strsql)) {
		$stmt->bind_param("si", $idexpediente, $año);
		$stmt->execute();
		if ($stmt->errno == 0) {
			$text = "El alumno ya podrá revisar sus calificaciones online.";
			$type = "success";
			$title = "Exito!";
			$stmt->close();
		} else {
			$text = "No se pudo ejecutar la consulta: " . $stmt->error;
		}
	} else {
		$text = "No se puedo preparar la consulta: " . $mysqli->error;
	}
} else {
			$text = "Se enviaron parametros vacios o nulos";
		}
		$jsonreturn = array(
	"type" => $type,
	"title" => $title,
	"text" => $text,
	"timer" => $timer,
	"showConfirmButton" => $showConfirmButton,
	"datareturn" => $datareturn,
	"htmldata" => $htmldata,
);
echo json_encode($jsonreturn);
	break;
	case "mora":
		// Insertar los valores a tabla de alumnos matriculados
		if (!empty($_POST["idexpediente"])) {   
			$idexpediente = $_POST['idexpediente'];  
			$año = $_POST['año_escolar'];   
			$strsql = "UPDATE `alumnos_matriculados` SET `al_dia`=0 WHERE idexpediente=? and idaño=?";
			if ($stmt = $mysqli->prepare($strsql)) {
				$stmt->bind_param("si", $idexpediente, $año);
				$stmt->execute();
				if ($stmt->errno == 0) {
					$text = "El alumno NO podrá revisar sus calificaciones online.";
					$type = "success";
					$title = "Exito!";
					$stmt->close();
				} else {
					$text = "No se pudo ejecutar la consulta: " . $stmt->error;
				}
			} else {
				$text = "No se puedo preparar la consulta: " . $mysqli->error;
			}
		} else {
					$text = "Se enviaron parametros vacios o nulos";
				}
				$jsonreturn = array(
			"type" => $type,
			"title" => $title,
			"text" => $text,
			"timer" => $timer,
			"showConfirmButton" => $showConfirmButton,
			"datareturn" => $datareturn,
			"htmldata" => $htmldata,
		);
		echo json_encode($jsonreturn);
			break;
			case "reiniciar":
				// Insertar los valores a tabla de alumnos matriculados
				if (!empty($_POST["año_escolar"])) {   
					$año = $_POST['año_escolar'];   
					$strsql = "UPDATE `alumnos_matriculados` SET `al_dia`=0 WHERE idaño=?";
					if ($stmt = $mysqli->prepare($strsql)) {
						$stmt->bind_param("i", $año);
						$stmt->execute();
						if ($stmt->errno == 0) {
							$text = "Se reinicio exitosamente!";
							$type = "success";
							$title = "Exito!";
							$stmt->close();
						} else {
							$text = "No se pudo ejecutar la consulta: " . $stmt->error;
						}
					} else {
						$text = "No se puedo preparar la consulta: " . $mysqli->error;
					}
				} else {
							$text = "Se enviaron parametros vacios o nulos, seleccione el año escolar";
						}
						$jsonreturn = array(
					"type" => $type,
					"title" => $title,
					"text" => $text,
					"timer" => $timer,
					"showConfirmButton" => $showConfirmButton,
					"datareturn" => $datareturn,
					"htmldata" => $htmldata,
				);
				echo json_encode($jsonreturn);
					break;
	}



?>


