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
$idaño_2 = $_POST['anio2'];  
$idaño=$_POST["idaño"];
$strsql = "SELECT idclase, nombre FROM clases WHERE idclase NOT IN (SELECT idclase FROM clase_curso_detalles where clase_curso_detalles.idaño=?) ORDER BY clases.observacion";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("i", $idaño_2);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota);
	while($stmt->fetch()){
	$htmldata_si= $htmldata_si ."<option value=\"$idcuota\">$cuota </option>";
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


	$strsql = "SELECT clases.idclase, clases.nombre FROM clases INNER JOIN clase_curso_detalles ON clase_curso_detalles.idclase = clases.idclase WHERE (clase_curso_detalles.idcurso=? and clase_curso_detalles.idaño=?)";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("ii", $idaño, $idaño_2);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota);
	while($stmt->fetch()){
	$htmldata_no= $htmldata_no ."<option value=\"$idcuota\">$cuota</option>";
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
					
                    $strsql = "INSERT INTO `clase_curso_detalles` (`idcurso`, `idclase`,`idaño`) VALUES (?,?,?)";
					if($stmt = $mysqli->prepare($strsql)){
					$stmt->bind_param("iii", $idaño, $idcuota, $idaño_2);
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
			$strsql = "SELECT clases.idclase, clases.nombre FROM clases INNER JOIN clase_curso_detalles ON clase_curso_detalles.idclase = clases.idclase WHERE (clase_curso_detalles.idcurso=? and clase_curso_detalles.idaño=?)";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("ii", $idaño, $idaño_2);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota);
	while($stmt->fetch()){
	$htmldata_si= $htmldata_si ."<option value=\"$idcuota\">$cuota</option>";
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
	$strsql = "SELECT idclase, nombre FROM clases WHERE idclase NOT IN (SELECT idclase FROM clase_curso_detalles where clase_curso_detalles.idaño=?)";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("i", $idaño_2);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota);
	while($stmt->fetch()){
	$htmldata_no= $htmldata_no ."<option value=\"$idcuota\">$cuota</option>";
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
                    $strsql = "DELETE FROM `clase_curso_detalles` WHERE idcurso=? and idclase=? and idaño=?";
					if($stmt = $mysqli->prepare($strsql)){
					$stmt->bind_param("iii", $idaño, $idcuota, $idaño_2);
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
			$strsql = "SELECT clases.idclase, clases.nombre FROM clases INNER JOIN clase_curso_detalles ON clase_curso_detalles.idclase = clases.idclase WHERE (clase_curso_detalles.idcurso=? and clase_curso_detalles.idaño=?)";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("ii", $idaño, $idaño_2);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota);
	while($stmt->fetch()){
	$htmldata_si= $htmldata_si ."<option value=\"$idcuota\">$cuota</option>";
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
	$strsql = "SELECT idclase, nombre FROM clases WHERE idclase NOT IN (SELECT idclase FROM clase_curso_detalles where clase_curso_detalles.idaño=?)";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("i", $idaño_2);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota);
	while($stmt->fetch()){
	$htmldata_no= $htmldata_no ."<option value=\"$idcuota\">$cuota</option>";
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
