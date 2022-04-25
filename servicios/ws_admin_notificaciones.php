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
            if(isset($_POST["cuota"])&&(isset($_POST["descripcion"]))){
				if(!empty($_POST["cuota"])&&(!empty($_POST["descripcion"]))){
					$cuota = $_POST["cuota"];
                    $descripcion = $_POST["descripcion"];
                    $strsql = "INSERT INTO `notificaciones`(`titulo`, `mensaje`) VALUES (?,?)";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("ss", $cuota, $descripcion);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se agrego Exitosamente.";
							$type = "success";
							$title = "Exito!";
							$idcuota = $stmt->insert_id;
							$fecha = date("Y-m-d H:i:s");
                            $htmldata = "<tr id=\"rw-$idcuota\" >
								<td>$idcuota</td>
								<td>$cuota</td>
								<td>$descripcion</td>
								<td>$fecha</td>
								<td><i class=\"material-icons\">done</i></td>
								<td class=\"center\">
								<a href=\"javascript:nuevo('$idcuota', '$cuota' , '$descripcion', '1')\" class=\"btn green\">
								<i class=\"material-icons\">edit</i>
								</a>
							</td>                              
							</tr>";
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

			break;
		case "editar":
            if(isset($_POST["idcuota"])&&(isset($_POST["precio"]))){
				if(!empty($_POST["cuota"])&&(!empty($_POST["idcuota"]))){
					$idcuota = $_POST["idcuota"];
					$cuota = $_POST["cuota"];
                    $descripcion = $_POST["descripcion"];
                    $precio = $_POST["precio"];
                    $strsql = "UPDATE notificaciones SET titulo=?, mensaje=?, activo=? where idnotificacion=?";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("ssii", $cuota, $descripcion, $precio, $idcuota);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se agrego Exitosamente.";
							$type = "success";
							$title = "Exito!";
							$precio == 1 ? $es="<i class=\"material-icons\">done</i>" : $es="<i class=\"material-icons\">clear</i>";
							$htmldata = "<td>$idcuota</td>
								<td>$cuota</td>
								<td>$descripcion</td>
								<td>Campo sin permisos para modificar.</td>
								<td>$es</td>
		<td class=\"center\">
			<a href=\"javascript:nuevo('$idcuota', '$cuota' , '$descripcion', '$precio')\" class=\"btn green\">
			<i class=\"material-icons\">edit</i>
			</a>
		</td>";
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
