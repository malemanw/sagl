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
	
	switch($accion){     
		case "agregar":
            if(isset($_POST["anual"])&&(isset($_POST["primer"]))){
					$año = $_POST["año"];
					$anual = $_POST["anual"];
                    $primer = $_POST["primer"];
					$segundo = $_POST["segundo"];
                    $strsql = "UPDATE clase_curso_detalles INNER JOIN clases ON (clases.idclase = clase_curso_detalles.idclase) SET clase_curso_detalles.activo=? WHERE clases.semestre=0 AND clase_curso_detalles.idaño=?";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("ii", $anual, $año);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se agrego Exitosamente.";
							$type = "success";
							$title = "Exito!";
							$stmt->close();
						}
						else{
							$text = "No se pudo ejecutar la consulta: ". $stmt->error;
						}
					}
					else{
						$text = "No se puedo preparar la consulta: ". $mysqli->error;
					}
					/////////////
					$strsql = "UPDATE clase_curso_detalles INNER JOIN clases ON (clases.idclase = clase_curso_detalles.idclase) SET clase_curso_detalles.activo=? WHERE clases.semestre=1 AND clase_curso_detalles.idaño=?";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("ii", $primer, $año);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se agrego Exitosamente.";
							$type = "success";
							$title = "Exito!";
							$stmt->close();
						}
						else{
							$text = "No se pudo ejecutar la consulta: ". $stmt->error;
						}
					}
					else{
						$text = "No se puedo preparar la consulta: ". $mysqli->error;
					}
					///////
					$strsql = "UPDATE clase_curso_detalles INNER JOIN clases ON (clases.idclase = clase_curso_detalles.idclase) SET clase_curso_detalles.activo=? WHERE clases.semestre=2 AND clase_curso_detalles.idaño=?";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("ii", $segundo, $año);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se agrego Exitosamente.";
							$type = "success";
							$title = "Exito!";
							$stmt->close();
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
				$text = "No se envio el bloque que desea eliminar";
			}

			break;
			case "año_predeterminado":
				if(isset($_POST["año"])){
						$año = $_POST["año"];
						$strsql = "UPDATE `year_escolar` SET `predeterminado`=0";
						if($stmt = $mysqli->prepare($strsql)){
							$stmt->execute();
							if($stmt->errno == 0){
								$stmt->close();
								$strsql2 = "UPDATE `year_escolar` SET `predeterminado`=1 where idaño=?";
								if($stmt = $mysqli->prepare($strsql2)){
									$stmt->bind_param("i", $año);
									$stmt->execute();
									if($stmt->errno == 0){
										$text = "Se preterminó el año escolar correctamente.";
										$type = "success";
										$title = "Exito!";
										$stmt->close();
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
								$text = "No se pudo ejecutar la consulta: ". $stmt->error;
							}
						}
						else{
							$text = "No se puedo preparar la consulta: ". $mysqli->error;
						}
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
					"htmldata"=>$htmldata
				);
	
	echo json_encode($jsonreturn);
?>
