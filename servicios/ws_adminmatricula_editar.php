<?php
header('Content-Type: application/json');
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
	$strsql = "SELECT alumnos_matriculados.idexpediente, alumnos.nombre_completo, cursos.nombre_curso, secciones.nombre_seccion, anios_militares.descripcion
FROM   alumnos INNER JOIN
             alumnos_matriculados ON alumnos.idexpediente = alumnos_matriculados.idexpediente INNER JOIN
             year_escolar ON alumnos_matriculados.idaño = year_escolar.idaño INNER JOIN cursos ON  alumnos_matriculados.idcurso = cursos.idcurso INNER JOIN secciones ON alumnos_matriculados.idseccion = secciones.idseccion INNER JOIN anios_militares ON alumnos_matriculados.idanio_militar = anios_militares.idanio_militar WHERE (alumnos_matriculados.idaño=" . $idaño . " and alumnos_matriculados.lista_espera=0)";
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

case "re_matricular":
// Insertar los valores a tabla de alumnos matriculados
	if (isset($_POST["idexpediente"]) && (isset($_POST["curso"])) && (isset($_POST["seccion"])) && (isset($_POST["año_escolar"])))
		{
		if (!empty($_POST["idexpediente"]) && !empty($_POST["curso"]))
			{
			$idexpediente = $_POST["idexpediente"];
			$curso = $_POST["curso"];
			$seccion = $_POST["seccion"];
			$año_escolar = $_POST["año_escolar"];
			$añomilitar = $_POST["añomilitar"];
            $beca = $_POST["beca"];
            $interno = $_POST["interno"]; 
			$strsql = "INSERT INTO `alumnos_matriculados`(`idexpediente`, `idcurso`, `idseccion`, `idaño`, `idanio_militar`, `tienebeca`, `esinterno`) VALUES (?,?,?,?,?,?,?)";
			if ($stmt = $mysqli->prepare($strsql))
				{
				$stmt->bind_param("siiiiii", $idexpediente, $curso, $seccion, $año_escolar, $añomilitar, $beca, $interno);
				$stmt->execute();
				if ($stmt->errno == 0)
					{
					$text = "El alumno se matriculó Exitosamente.";
					$type = "success";
					$title = "Exito!";
					}
				  else
					{
					$text = "No se pudo ejecutar la consulta: " . $stmt->error;
					}
				}
			  else
				{
				$text = "No se puedo preparar la consulta: " . $mysqli->error;
				}
			}
		  else
			{
			$text = "Se enviaron parametros vacios o nulos";
			}
		}
	  else
		{
		$text = "No se enviaron parametros válidos, consulte con el administrador.";
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


