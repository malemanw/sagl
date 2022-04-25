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
            if(isset($_POST["year"])&&(isset($_POST["descripcion"]))){
				if(!empty($_POST["year"])&&(!empty($_POST["descripcion"]))){
					$year = $_POST["year"];
                    $descripcion = $_POST["descripcion"];
                    $fecha_inicio = $_POST["fecha_inicio"];
                    $fecha_final = $_POST["fecha_final"];
                    $esactivo = 1;
                    $strsql = "INSERT INTO `year_escolar`(`nombre`, `descripcion`,`fecha_inicio`,`fecha_final`) VALUES (?,?,?,?)";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("ssss", $year, $descripcion, $fecha_inicio, $fecha_final);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se agrego Exitosamente.";
							$type = "success";
							$title = "Exito!";
							$idenviar = $stmt->insert_id;
                    		$idaño = $stmt->insert_id;
                            $esactivo == 1 ? $es="<i class=\"material-icons\">done</i>" : $es="<i class=\"material-icons\">clear</i>";
                            $htmldata = "<tr id=\"rw-$idaño\">
								<td>$year</td>
								<td>$descripcion</td>
								<td>$fecha_inicio</td>
								<td>$fecha_final</td>								
                                <td class=\"center\">$es</td>
		<td class=\"center\">
			<a href=\"\" class=\"btn green\">
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
	}
	
	
	
	$jsonreturn = array(
					"type"=>$type,
					"title"=>$title,
					"text"=>$text,
					"timer"=>$timer,
					"showConfirmButton"=>$showConfirmButton,
					"datareturn"=>$datareturn,
					"htmldata"=>$htmldata,
					"id"=>$idenviar
				);
	
	echo json_encode($jsonreturn);
?>
