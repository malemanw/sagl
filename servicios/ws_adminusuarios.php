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
            case "eliminarperfiles":
                    if(isset($_POST["idusuario"])){
                    if(!empty($_POST["idusuario"])){
                        $idusuario = $_POST["idusuario"];
                        $strsql = "DELETE FROM `perfilesusuario` WHERE `idusuario` = ?";
                        if($stmt = $mysqli->prepare($strsql)){
                            $stmt->bind_param("s",$idusuario);
                            $stmt->execute();
                            if($stmt->errno == 0){
                                $text = "El Registro se Elimino Exitosamente.";
                                $type = "success";
                                $title = "Exito!";
                                break;
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
        
        
        
            case "agregarperfiles":
                    if(isset($_POST["idusuario"])&&(isset($_POST["idperfil"]))){
				if(!empty($_POST["idusuario"])&&(!empty($_POST["idperfil"]))){
					$idusuario = $_POST["idusuario"];
                    $idperfil = $_POST["idperfil"];
                    
					$strsql = "INSERT INTO `perfilesusuario`(`idperfil`, `idusuario`) VALUES (?,?)";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("ss",$idperfil, $idusuario);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se agrego Exitosamente.";
							$type = "success";
							$title = "Exito!";
                            
                            break;
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
            
       case "permisos":
                if(isset($_POST["idusuario"])){
				if(!empty($_POST["idusuario"])){
					$idusuario = $_POST["idusuario"];
					$strsql = "SELECT idperfil,idusuario FROM perfilesusuario WHERE idusuario = ?
                        UNION
                        SELECT idperfil,null FROM perfiles 
                        WHERE idperfil NOT IN (SELECT idperfil FROM perfilesusuario WHERE idusuario = ?) ORDER BY idperfil";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("ss",$idusuario,$idusuario);
						$stmt->execute();
						if($stmt->errno == 0){
                            $text = "El Registro se Elimino Exitosamente.";
							$type = "success";
							$title = "Exito!";
					    $stmt->store_result();
						$stmt->bind_result($idperfil, $idusuario);
						while($stmt->fetch()){
                        if($idusuario!=null)
                        {
                        $htmldata = $htmldata."<div class=\"col s12\">
                                    <div class=\"switch\">
                                        <label>
                                            <input id =\"$idperfil\" checked=\"\" type=\"checkbox\">
                                            <span class=\"lever\"></span>
                                            $idperfil
                                        </label>
                                    </div>
                                    </div>";
                        }
                            else
                        {
                         $htmldata = $htmldata."<div class=\"col s12\">
                                    <div class=\"switch\">
                                        <label>
                                            <input id =\"$idperfil\" type=\"checkbox\">
                                            <span class=\"lever\"></span>
                                            $idperfil
                                        </label>
                                    </div>
                                    </div>";   
                        }
                            }
                        break;
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
				$text = "No se envio el usuario que desea eliminar";
			}
			
    
			

			break;
			
            	
		case "eliminar":
			if(isset($_POST["idusuario"])){
				if(!empty($_POST["idusuario"])){
					$idusuario = $_POST["idusuario"];
					$strsql = "DELETE FROM usuarios WHERE idusuario = ?";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("s",$idusuario);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se Elimino Exitosamente.";
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

			break;
		case "agregar":
            if(isset($_POST["idusuario"])&&(isset($_POST["usuario"]))){
				if(!empty($_POST["idusuario"])&&(!empty($_POST["usuario"]))){
					$idusuario = $_POST["idusuario"];
                    $usuario = $_POST["usuario"];
                    $email = $_POST["email"];
                    $nacimiento = $_POST["nacimiento"];
                    $password = $_POST["password"];
                    $esadmin = $_POST["esadmin"];
					 $esactivo = $_POST["esactivo"];
					 $esmaestro = $_POST["esmaestro"];
                    $llave = rand();
                    $llave = hash("sha512", $llave);
                    $password = hash("sha512", $password.$llave);
                    $strsql = "INSERT INTO `usuarios`(`idusuario`, `usuario`, `llave`, `password`, `email`, `esadmin`, `estado`,  `maestro`, `nacimiento`) VALUES (?,?,?,?,?,?,?,?,?)";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("sssssiiis",$idusuario, $usuario, $llave, $password, $email, $esadmin, $esactivo, $esmaestro, $nacimiento);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se agrego Exitosamente.";
							$type = "success";
							$title = "Exito!";
                            $esadmin == 1 ? $ea="<i class=\"material-icons\">done</i>" : $ea="<i class=\"material-icons\">clear</i>";
                            $esactivo == 1 ? $es="<i class=\"material-icons\">done</i>" : $es="<i class=\"material-icons\">clear</i>";
							$esmaestro == 1 ? $em="<i class=\"material-icons\">done</i>" : $em="<i class=\"material-icons\">clear</i>";
							$htmldata = "<tr id=\"rw-$idusuario\" style=\"display:none\">
								<td>$idusuario</td>
								<td>$usuario</td>
                                <td>$email</td>
                                <td class=\"center\">$ea</td>
								<td class=\"center\">$es</td>
								<td class=\"center\">$em</td>
                                 <td class=\"center\">
									<a href=\"javascript:permisos('<?php echo $idusuario?>')\" class=\"btn green\">
										<i class=\"material-icons\">vpn_key</i>
									</a>
                                    </td>
								<td class=\"center\">
									<a href=\"?mod=dashboard&panel=adminperfilusuario&idusuario=$idusuario\" class=\"btn green\">
										<i class=\"material-icons\">assignment_ind</i>
								
								</td>
                                
                                    <td class=\"center\">
                                	</a>
									<a href=\"javascript:eliminar('$idusuario')\" class=\"btn red\">
										<i class=\"material-icons\">delete</i>
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
					"htmldata"=>$htmldata
				);
	
	echo json_encode($jsonreturn);
?>
