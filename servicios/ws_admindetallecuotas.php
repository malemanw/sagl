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
$strsql = "SELECT cuotas.idcuota, cuotas.cuota, cuotas.precio
FROM   cuotas INNER JOIN
             cuota_year_detalle ON cuotas.idcuota = cuota_year_detalle.idcuota
WHERE (cuota_year_detalle.idaño = ?)";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("i", $idaño);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota, $precio);
	while($stmt->fetch()){
	$htmldata_si= $htmldata_si ."<option value=\"$idcuota\">$cuota - $precio </option>";
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


	$strsql = "SELECT idcuota, cuota, precio FROM cuotas WHERE idcuota NOT IN (SELECT idcuota FROM cuota_year_detalle where idaño=?)";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("i", $idaño);	
$stmt->execute();
if($stmt->errno == 0){
$stmt->store_result();		
	$stmt->bind_result($idcuota, $cuota, $precio);
	while($stmt->fetch()){
	$htmldata_no= $htmldata_no ."<option value=\"$idcuota\">$cuota - $precio</option>";
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
$idcuota_recibida = explode(',',$arr); 
foreach($idcuota_recibida as $idcuota){
            if(isset($_POST["anio"])&&(isset($_POST["arv"]))){
				if(!empty($_POST["anio"])&&(!empty($_POST["arv"]))){
					
                    $strsql = "INSERT INTO `cuota_year_detalle` (`idcuota`, `idaño`) VALUES (?,?)";
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
			$strsql = "SELECT cuotas.idcuota, cuotas.cuota
FROM   cuotas INNER JOIN
             cuota_year_detalle ON cuotas.idcuota = cuota_year_detalle.idcuota
WHERE (cuota_year_detalle.idaño = ?)";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("i", $idaño);	
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


	$strsql = "SELECT idcuota, cuota FROM cuotas WHERE idcuota NOT IN (SELECT idcuota FROM cuota_year_detalle where idaño=?)";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("i", $idaño);	
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
case "eliminar":
$arr = $_POST['arv'];
$idaño = $_POST['anio'];
$idcuota_recibida = explode(',',$arr); 
foreach($idcuota_recibida as $idcuota){
            if(isset($_POST["anio"])&&(isset($_POST["arv"]))){
				if(!empty($_POST["anio"])&&(!empty($_POST["arv"]))){
					
                    $strsql = "DELETE FROM `cuota_year_detalle` WHERE `cuota_year_detalle`.`idcuota` = ? AND `cuota_year_detalle`.`idaño` = ?";
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
			$strsql = "SELECT cuotas.idcuota, cuotas.cuota
FROM   cuotas INNER JOIN
             cuota_year_detalle ON cuotas.idcuota = cuota_year_detalle.idcuota
WHERE (cuota_year_detalle.idaño = ?)";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("i", $idaño);	
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


	$strsql = "SELECT idcuota, cuota FROM cuotas WHERE idcuota NOT IN (SELECT idcuota FROM cuota_year_detalle where idaño=?)";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("i", $idaño);	
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
