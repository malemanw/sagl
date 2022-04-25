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
            case "editar":  
            if(isset($_POST["idusuario"])&&(isset($_POST["usuario"]))){
				if(!empty($_POST["idusuario"])&&(!empty($_POST["usuario"]))){
					$idusuario = $_POST["idusuario"];
                    $usuario = $_POST["usuario"];
                    $email = $_POST["email"];
                    $nacimiento = $_POST["nacimiento"];
                    $password = $_POST["password"];
                    $esadmin = $_POST["esadmin"];
					 $esactivo = $_POST["estado"];
					 $esmaestro = $_POST["esmaestro"];
                    $llave = rand();
                    $llave = hash("sha512", $llave);
                    $password = hash("sha512", $password.$llave);
                    $strsql = "UPDATE  usuarios SET idusuario=?, usuario=?, llave=?,  password=?, email=?, esadmin=?, estado=?, maestro=?, nacimiento=? where idusuario=?";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("sssssiiiss", $idusuario, $usuario, $llave, $password, $email, $esadmin, $esactivo, $esmaestro, $nacimiento, $idusuario);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se editó Exitosamente. si presenta problemas en cargar su nueva imagen de perfil, recargue la página.";
							$type = "success";
							$title = "Exito!";
                            
if(!empty($_FILES["avatar"])){
     $target_dir = "../uploads/avatar/";
$target_file = $target_dir . basename($_FILES["avatar"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
   $target_file = $target_dir.$idusuario.".jpg" ;                      
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if($check !== false) {
        $text =  "File is an image - " . $check["mime"] . ".";
        $type = "error";
		$title = "Error!";
        $uploadOk = 1;
    } else {
        $text =  "File is not an image.";
         $type = "error";
		$title = "Error!";
        $uploadOk = 0;
    }
}
                            
// Check file size
if ($_FILES["avatar"]["size"] > 500000000) {
     $text =  "Lo sentimos, su imagen es muy grande";
      $type = "error";
		$title = "Error!";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
     $text =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $type = "error";
		$title = "Error!";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
     $text =  "Sorry, your file was not uploaded.";
      $type = "error";
		$title = "Error!";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        //echo "The file  has been uploaded.";
    } else {
         $text =  "Sorry, there was an error uploading your file.";
          $type = "error";
		$title = "Error!";
    }
}
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
                
             
				else{
					$text = "Se enviaron parametros vacios o nulos";
				}
			}
			else{
				$text = "No se envio el bloque que desea crear";
			}
           
			break;
    
	  case "editar2":  
            if(isset($_POST["idusuario"])&&(isset($_POST["usuario"]))){
				if(!empty($_POST["idusuario"])&&(!empty($_POST["usuario"]))){
					$idusuario = $_POST["idusuario"];
                    $usuario = $_POST["usuario"];
                    $email = $_POST["email"];
                    $nacimiento = $_POST["nacimiento"];
                    $password = $_POST["password"];
                    $llave = $_POST["llave"];
                    $esadmin = $_POST["esadmin"];
					 $esactivo = $_POST["estado"];
					 $esmaestro = $_POST["esmaestro"];
                    
                    $strsql = "UPDATE  usuarios SET idusuario=?, usuario=?, llave=?,  password=?, email=?, esadmin=?, estado=?, maestro=?, nacimiento=? where idusuario=?";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("sssssiiiss", $idusuario, $usuario, $llave, $password, $email, $esadmin, $esactivo, $esmaestro, $nacimiento, $idusuario);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se editó Exitosamente. si presenta problemas en cargar su nueva imagen de perfil, recargue la página.";
							$type = "success";
							$title = "Exito!";
    if(!empty($_FILES["avatar"])){
     $target_dir = "../uploads/avatar/";
$target_file = $target_dir . basename($_FILES["avatar"]["name"]);
$uploadOk = 1;
$imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
   $target_file = $target_dir.$idusuario.".jpg" ;                      
// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["avatar"]["tmp_name"]);
    if($check !== false) {
         $text =  "File is an image - " . $check["mime"] . ".";
          $type = "error";
		$title = "Error!";
        $uploadOk = 1;
    } else {
         $text =  "File is not an image.";
          $type = "error";
		$title = "Error!";
        $uploadOk = 0;
    }
}
                            
// Check file size
if ($_FILES["avatar"]["size"] > 500000000) {
     $text =  "Lo sentimos, su imagen es muy grande";
      $type = "error";
		$title = "Error!";
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
&& $imageFileType != "gif" ) {
     $text =  "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
  $type = "error";
		$title = "Error!";
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
     $text =  "Sorry, your file was not uploaded.";
      $type = "error";
		$title = "Error!";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["avatar"]["tmp_name"], $target_file)) {
        //echo "The file  has been uploaded.";
    } else {
         $text =  "Sorry, there was an error uploading your file.";
          $type = "error";
		$title = "Error!";
    }
}
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
                
             
				else{
					$text = "Se enviaron parametros vacios o nulos";
				}
			}
			else{
				$text = "No se envio el bloque que desea crear";
			}

			break;
                           
	
            case "buscar":  
            if(isset($_POST["idusuario"])){
				if(!empty($_POST["idusuario"])){
					$idusuario = $_POST["idusuario"];
    
                    $strsql = "SELECT `idusuario`, `usuario`,  `email`, `esadmin`, `estado` FROM `usuarios` WHERE `idusuario` LIKE CONCAT('%',?,'%') OR `usuario` LIKE CONCAT('%',?,'%') OR  `email` LIKE CONCAT('%',?,'%') ";
                    if($stmt = $mysqli->prepare($strsql)){
                        $stmt->bind_param("sss", $idusuario, $idusuario, $idusuario);
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();		
						$stmt->bind_result($idusuario, $usuario, $email, $esadmin, $esactivo);
						while($stmt->fetch()){
                            $esadmin == 1 ? $esadmin="<i class=\"material-icons\">done</i>" : $esadmin="<i class=\"material-icons\">clear</i>";
                            $esactivo == 1 ? $esactivo="<i class=\"material-icons\">done</i>" : $esactivo="<i class=\"material-icons\">clear</i>";
						
							$htmldata= $htmldata."<tr id=\"rw-$idusuario\">
								<td>$idusuario</td>
								<td>$usuario</td>
                                <td>$email</td>
								<td>$esadmin</td>
                                <td>$esactivo</td>
								<td class=\"center\">
									<a href=\"?mod=perfilusuario&idusuario=$idusuario\" class=\"btn green\">
										<i class=\"material-icons\">assignment_ind</i>
                                        
									</a>
									<a href=\"javascript:eliminar('$idusuario')\" class=\"btn red\">
										<i class=\"material-icons\">delete</i>
									</a>
                                   
								</td>
							</tr>";
						
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
					$text = "Se enviaron parametros vacios o nulos";
				}
			}
			else{
				$text = "No se envio el bloque que desea eliminar";
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
                    $llave = rand();
                    $llave = hash("sha512", $llave);
                    $password = hash("sha512", $password.$llave);
                    $strsql = "INSERT INTO `usuarios`(`idusuario`, `usuario`, `llave`, `password`, `email`, `esadmin`, `estado`, `nacimiento`) VALUES (?,?,?,?,?,?,?,?)";
					if($stmt = $mysqli->prepare($strsql)){
						$stmt->bind_param("sssssiis",$idusuario, $usuario, $llave, $password, $email, $esadmin, $esactivo, $nacimiento);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El Registro se agrego Exitosamente.";
							$type = "success";
							$title = "Exito!";
                            $esadmin == 1 ? $ea="<i class=\"material-icons\">done</i>" : $ea="<i class=\"material-icons\">clear</i>";
                            $esactivo == 1 ? $es="<i class=\"material-icons\">done</i>" : $es="<i class=\"material-icons\">clear</i>";
                            $htmldata = "<tr id=\"rw-$idusuario\" style=\"display:none\">
								<td>$idusuario</td>
								<td>$usuario</td>
                                <td>$email</td>
                                <td>$ea</td>
                                <td>$es</td>
								<td class=\"center\">
									<a href=\"javascript:editar('$idusuario')\" class=\"btn green\">
										<i class=\"material-icons\">edit</i>
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
