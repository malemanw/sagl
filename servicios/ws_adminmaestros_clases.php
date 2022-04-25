<?php
	header('Content-Type: application/json');
	$type = "error";
	$title = "Error!";
	$text = "Error desconocido";
	$timer = NULL;
	$showConfirmButton = true;
	$datareturn = "";
	$htmldata_si = "";
	$htmldata_no = "";
	require "../config.php";
	
	$accion = isset($_GET["accion"]) ? $_GET["accion"] : "default";
	
	switch($accion){
case "selectanio":  
$idaño=$_POST["idaño"];
$idaño_2 = $_POST['anio2'];
$strsql = "SELECT `idclase_curso`, cursos.nombre_curso, clases.nombre FROM `clase_curso_detalles` INNER JOIN cursos ON cursos.idcurso=clase_curso_detalles.idcurso INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase WHERE idclase_curso NOT IN (SELECT idclase_curso FROM maestro_grado_detalles where clase_curso_detalles.idaño=?) and idaño=? ORDER BY clases.nombre";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("ii", $idaño_2, $idaño_2);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota, $clase);
	while($stmt->fetch()){
	$htmldata_si= $htmldata_si ."<option value=\"$idcuota\">$clase - $cuota </option>";
	}
	$stmt->close();
	}
	else{
		echo "Error al ejecutar consulta: " . $stmt->error;
	}//Cierre de condicion de Ejecucion
}
else{
	echo "Error al preparar consulta: " . $mysqli->error;
}


	$strsql = "SELECT  clase_curso_detalles.idclase_curso,  cursos.nombre_curso, clases.nombre FROM `maestro_grado_detalles` INNER JOIN clase_curso_detalles ON clase_curso_detalles.idclase_curso = maestro_grado_detalles.idclase_curso INNER JOIN clases ON clases.idclase = clase_curso_detalles.idclase INNER JOIN cursos ON cursos.idcurso = clase_curso_detalles.idcurso WHERE (maestro_grado_detalles.idusuario=? and  clase_curso_detalles.idaño=?) and clase_curso_detalles.idaño=?";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("sii", $idaño, $idaño_2, $idaño_2);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota, $clase);
	while($stmt->fetch()){
	$htmldata_no= $htmldata_no ."<option value=\"$idcuota\">$clase - $cuota</option>";
	}
	$stmt->close();
	}
	else{
		echo "Error al ejecutar consulta: " . $stmt->error;
	}//Cierre de condicion de Ejecucion
}
else{
	echo "Error al preparar consulta: " . $mysqli->error;
}

break;
case "agregar":
$arr = $_POST['arv'];
$idaño = $_POST['anio'];
$idaño_2 = $_POST['anio2'];
$idcuota_recibida = explode(',',$arr); 
foreach($idcuota_recibida as $idcuota){
            if(isset($_POST["anio"])&&(isset($_POST["arv"]))){
				if(!empty($_POST["anio"])&&(!empty($_POST["arv"]))){
                    $strsql = "INSERT INTO `maestro_grado_detalles`(`idclase_curso`, `idusuario`,`idaño`) VALUES (?,?,?)";
					if($stmt = $mysqli->prepare($strsql)){
					$stmt->bind_param("isi", $idcuota, $idaño,$idaño_2);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se agregó Exitosamente.";
							$type = "success";
							$title = "Exito!";
						}
						else{
							$text = "No se pudo ejecutar la consulta: ". $stmt->error;
						}
					}
					else{
						$text = "No se puedo preparar la consulta: ". $mysqli->error;
					}
				}
				else{
					$text = "Se enviaron parametros vacios o nulos";
				}
			}
			else{
				$text = "No se envio el bloque que desea eliminar";
			}
				}
			$strsql = "SELECT `idclase_curso`, cursos.nombre_curso, clases.nombre FROM `clase_curso_detalles` INNER JOIN cursos ON cursos.idcurso=clase_curso_detalles.idcurso INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase WHERE idclase_curso NOT IN (SELECT idclase_curso FROM maestro_grado_detalles where clase_curso_detalles.idaño=?) and idaño=?";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("ii", $idaño_2, $idaño_2);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota, $clase);
	while($stmt->fetch()){
	$htmldata_si= $htmldata_si ."<option value=\"$idcuota\">$clase . $cuota</option>";
	}
	$stmt->close();
	}
	else{
		echo "Error al ejecutar consulta: " . $stmt->error;
	}//Cierre de condicion de Ejecucion
}
else{
	echo "Error al preparar consulta: " . $mysqli->error;
}

if(!empty($_POST["anio"])&&(!empty($_POST["arv"]))){
	$strsql = "SELECT  clase_curso_detalles.idclase_curso,  cursos.nombre_curso, clases.nombre FROM `maestro_grado_detalles` INNER JOIN clase_curso_detalles ON clase_curso_detalles.idclase_curso = maestro_grado_detalles.idclase_curso INNER JOIN clases ON clases.idclase = clase_curso_detalles.idclase INNER JOIN cursos ON cursos.idcurso = clase_curso_detalles.idcurso WHERE (maestro_grado_detalles.idusuario=? and  clase_curso_detalles.idaño=?) and clase_curso_detalles.idaño=?";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("sii", $idaño, $idaño_2, $idaño_2);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota, $clase);
	while($stmt->fetch()){
	$htmldata_no= $htmldata_no ."<option value=\"$idcuota\">$clase . $cuota</option>";
	}
	$stmt->close();
	}
	else{
		echo "Error al ejecutar consulta: " . $stmt->error;
	}//Cierre de condicion de Ejecucion
}
else{
	echo "Error al preparar consulta: " . $mysqli->error;
} 
}
else{
	$text = "No se recibieron los parámetros correctos.";
}
break;
case "eliminar":
$arr = $_POST['arv'];
$idaño = $_POST['anio'];
$idaño_2 = $_POST['anio2'];
$idcuota_recibida = explode(',',$arr); 
foreach($idcuota_recibida as $idcuota){
            if(isset($_POST["anio"])&&(isset($_POST["arv"]))){
				if(!empty($_POST["anio"])&&(!empty($_POST["arv"]))){
					
                    $strsql = "DELETE FROM `maestro_grado_detalles` WHERE idclase_curso=? and idusuario=?";
					if($stmt = $mysqli->prepare($strsql)){
					$stmt->bind_param("ii", $idcuota, $idaño);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se agregó Exitosamente.";
							$type = "success";
							$title = "Exito!";
						}
						else{
							$text = "No se pudo ejecutar la consulta: ". $stmt->error;
						}
					}
					else{
						$text = "No se puedo preparar la consulta: ". $mysqli->error;
					}
				}
				else{
					$text = "Se enviaron parametros vacios o nulos";
				}
			}
			else{
				$text = "No se envio el bloque que desea eliminar";
			}
				}
			$strsql = "SELECT `idclase_curso`, cursos.nombre_curso, clases.nombre FROM `clase_curso_detalles` INNER JOIN cursos ON cursos.idcurso=clase_curso_detalles.idcurso INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase WHERE idclase_curso NOT IN (SELECT idclase_curso FROM maestro_grado_detalles where clase_curso_detalles.idaño=?) and idaño=?";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("ii", $idaño_2, $idaño_2);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota, $clase);
	while($stmt->fetch()){
	$htmldata_si= $htmldata_si ."<option value=\"$idcuota\">$clase . $cuota</option>";
	}
	$stmt->close();
	}
	else{
		echo "Error al ejecutar consulta: " . $stmt->error;
	}//Cierre de condicion de Ejecucion
}
else{
	echo "Error al preparar consulta: " . $mysqli->error;
}

if(!empty($_POST["anio"])&&(!empty($_POST["arv"]))){
	$strsql = "SELECT  clase_curso_detalles.idclase_curso,  cursos.nombre_curso, clases.nombre FROM `maestro_grado_detalles` INNER JOIN clase_curso_detalles ON clase_curso_detalles.idclase_curso = maestro_grado_detalles.idclase_curso INNER JOIN clases ON clases.idclase = clase_curso_detalles.idclase INNER JOIN cursos ON cursos.idcurso = clase_curso_detalles.idcurso WHERE (maestro_grado_detalles.idusuario=? and  clase_curso_detalles.idaño=?) and clase_curso_detalles.idaño=?";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("sii", $idaño, $idaño_2, $idaño_2);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota, $clase);
	while($stmt->fetch()){
	$htmldata_no= $htmldata_no ."<option value=\"$idcuota\">$clase . $cuota</option>";
	}
	$stmt->close();
	}
	else{
		echo "Error al ejecutar consulta: " . $stmt->error;
	}//Cierre de condicion de Ejecucion
}
else{
	echo "Error al preparar consulta: " . $mysqli->error;
} 
}
else{
	$text = "No se recibieron los parámetros correctos.";
}
break;
}
	
		
		$jsonreturn = array(
					"type"=>$type,
					"title"=>$title,
					"text"=>$text,
					"timer"=>$timer,
					"showConfirmButton"=>$showConfirmButton,
					"datareturn"=>$datareturn,
					"htmldata_si"=>$htmldata_si,
					"htmldata_no"=>$htmldata_no,
				);
	
	echo json_encode($jsonreturn);
?>
