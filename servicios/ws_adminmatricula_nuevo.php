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
switch ($accion) {
    case "nuevo":
function CalculaEdad($fecha){
    list($Y, $m, $d) = explode("-", $fecha);
    return (date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y);
}
        $edad_correlativo = CalculaEdad($_POST["nacimiento"]);
        if ($edad_correlativo < 10) {
            $edad_correlativo = "0" . $edad_correlativo;
        }
        if ($edad_correlativo>=1) {
            //Obtener el ultino correlativo  
        if (!empty($_POST["nombre_alumno"]) && !empty($_POST["nacimiento"])) {       
        $strsql = "SELECT `idconfiguracion`, `correlativo_expediente` FROM `configuraciones`";
        if ($stmt = $mysqli->prepare($strsql)) {
            $stmt->execute();
            if ($stmt->errno == 0) {
                $stmt->store_result();
                if ($stmt->num_rows > 0) {
                    $stmt->bind_result($idconfiguracion, $correlativo_expediente_db);
                    $stmt->fetch();
                    $ultimos_digitos = substr($correlativo_expediente_db, 6, 9);
                    $primeros_digitos = substr($correlativo_expediente_db, 0, 6);
                    if ($ultimos_digitos <= 9999) {
                        $idexpediente = date("Y") . $edad_correlativo . $ultimos_digitos;
                        $correlativo_nuevo = date("Y") . $edad_correlativo . $ultimos_digitos + 1;
                    } else {
                        $ultimos_digitos = 0000;
                        $idexpediente = date("Y") . $edad_correlativo . $ultimos_digitos;
                        $correlativo_nuevo = date("Y") . $edad_correlativo . $ultimos_digitos + 1;
                    }
                    $stmt->close();
                } else {
                    $text = "No existe correlativo asociado en nuestra base de datos";
                } //cierre de consulta de valores retornados
                
            } else {
                $text = "No se puedo preparar la consulta: " . $stmt->error;
            } //Cierre de condicion de Ejecucion
            
        } else {
            $text = "No se puedo preparar la consulta: " . $mysqli->error;
        }
    } else {
        $text = "Se enviaron parametros vacios o nulos";
    }
//Actualizar el el ultimo correlativo   
            if (!empty($_POST["nombre_alumno"])) {     
        $strsql = "UPDATE `configuraciones` SET `correlativo_expediente`=? WHERE idconfiguracion=1";
        if ($stmt = $mysqli->prepare($strsql)) {
            $stmt->bind_param("s", $correlativo_nuevo);
            $stmt->execute();
            if ($stmt->errno == 0) {
                $htmldata="Correlativo agregado exitosamente";
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
//Insertar los valores a tabla Alumnos        
        if (isset($_POST["nacionalidad_alumno"]) && (isset($_POST["ciudad_alumno"])) && (isset($_POST["depto"])) && (isset($_POST["curso"])) && (isset($_POST["seccion"])) && (isset($_POST["añomilitar"])) && (isset($_POST["nombre_alumno"])) && (isset($_POST["institucion_previa"])) && (isset($_POST["ciudad_previa"])) && (isset($_POST["ciudad_padre"])) && (isset($_POST["nacionalidad_padre"])) && (isset($_POST["religion"])) && (isset($_POST["nacionalidad_madre"])) && (isset($_POST["ciudad_madre"]))) {
            if (!empty($_POST["nombre_alumno"]) && (!empty($_POST["nacionalidad_alumno"]))) {
                $nombre_alumno = $_POST["nombre_alumno"];
                $rtn = $_POST["rtn"];
                $email_alumno = $_POST["email_alumno"];
                $nacimiento = $_POST["nacimiento"];
                $edad = CalculaEdad($nacimiento);
                $tiposanbre = $_POST["tiposanbre"];
                $domicilio_alumno = $_POST["domicilio_alumno"];
                $sexo = $_POST["sexo"];
                $nacionalidad_alumno = $_POST["nacionalidad_alumno"];
                $ciudad_alumno = $_POST["ciudad_alumno"];
                $depto = $_POST["depto"];
                $telefono_alumno = $_POST["telefono_alumno"];
                $curso = $_POST["curso"];
                $seccion = $_POST["seccion"];
                $año_escolar = $_POST["año_escolar"];
                $añomilitar = $_POST["añomilitar"];
                $institucion_previa = $_POST["institucion_previa"];
                $ciudad_previa = $_POST["ciudad_previa"];
                $modalidad = $_POST["modalidad"];
                $promedio_previo = $_POST["promedio_previo"];
                $id_padre = $_POST["id_padre"];
                $nombre_padre = $_POST["nombre_padre"];
                $direccion_padre = $_POST["direccion_padre"];
                $ciudad_padre = $_POST["ciudad_padre"];
                $nacionalidad_padre = $_POST["nacionalidad_padre"];
                $telefono_padre = $_POST["telefono_padre"];
                $email_padre = $_POST["email_padre"];
                $id_madre = $_POST["id_madre"];
                $nombre_madre = $_POST["nombre_madre"];
                $direccion_madre = $_POST["direccion_madre"];
                $ciudad_madre = $_POST["ciudad_madre"];
                $nacionalidad_madre = $_POST["nacionalidad_madre"];
                $telefono_madre = $_POST["telefono_madre"];
                $email_madre = $_POST["email_madre"];
                $nombre_encargado = $_POST["nombre_encargado"];
                $direccion_encargado = $_POST["direccion_encargado"];
                $celular_encargado = $_POST["celular_encargado"];
                $correo_encargado = $_POST["correo_encargado"];
                $religion = $_POST["religion"];
                $strsql = "INSERT INTO `alumnos`(`idexpediente`, `rtn`, `anio_militar`, `nombre_completo`, `fecha_nacimiento_alumno`, `edad`, `tiposangre`, `sexo`, `telefono_alumno`, `email_alumno`, `residencia_alumno`, `idreligion`, `iddepto`, `idnacionalidad`, `idinstitucion_previa`, `ciudad_previa`, `modalidad`, `promedio_anterior`, `idciudad`, `id_padre`, `nombre_padre`, `direccion_padre`, `ciudad_padre`, `nacionalidad_padre`, `telefono_padre`, `email_padre`, `id_madre`, `nombre_madre`, `direccion_madre`, `ciudad_madre`, `nacionalidad_madre`, `telefono_madre`, `email_madre`,`nombre_encargado`,`direccion_encargado`,`telefono_encargado`,`correo_encargado`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                if ($stmt = $mysqli->prepare($strsql)) {
                    $stmt->bind_param("ssissisisssiiiisssisssiisssssiissssss", $idexpediente, $rtn, $añomilitar, $nombre_alumno, $nacimiento, $edad, $tiposanbre, $sexo, $telefono_alumno, $email_alumno, $domicilio_alumno, $religion, $depto, $nacionalidad_alumno, $institucion_previa, $ciudad_previa, $modalidad, $promedio_previo, $ciudad_alumno,$id_padre, $nombre_padre, $direccion_padre, $ciudad_padre, $nacionalidad_padre, $telefono_padre, $email_padre, $id_madre, $nombre_madre, $direccion_madre, $ciudad_madre, $nacionalidad_madre, $telefono_madre, $email_madre, $nombre_encargado, $direccion_encargado, $celular_encargado, $correo_encargado);
                    $stmt->execute();
                    if ($stmt->errno == 0) {
                        $htmldata= $htmldata. ", Alumnos agregado a tabla de Alumnos exitosamente";
                    } else {
                        $text = "No se pudo ejecutar la consulta: " . $stmt->error;
                    }
                } else {
                    $text = "No se puedo preparar la consulta: " . $mysqli->error;
                }
            } else {
                $text = "Se enviaron parametros vacios o nulos";
            }
        } else {
            $text = "No se enviaron parametros válidos, consulte con el administrador.";
        }
//Insertar los valores a tabla de alumnos matriculados      
        if (isset($_POST["año_escolar"]) && (isset($_POST["curso"])) && (isset($_POST["seccion"]))&& (isset($_POST["nombre_alumno"]))) {
            if (!empty($_POST["año_escolar"]) && !empty($_POST["añomilitar"])) {
                $beca = $_POST["beca"];
                $interno = $_POST["interno"];                
                $idcurso = $_POST["curso"]; 
                $idseccion = $_POST["seccion"]; 
                $año_escolar = $_POST["año_escolar"]; 
                $añomilitar = $_POST["añomilitar"];
                $fotografia = $_POST["fotografia"];
                $partida = $_POST["partida"];
                $certificado = $_POST["certificado"]; 
                $strsql = "INSERT INTO `alumnos_matriculados`(`idexpediente`, `idcurso`, `idseccion`, `idaño`, `idanio_militar`, `tienebeca`, `esinterno`, `fotografia`, `partida_nacimiento`, `certificacion_estudios`) VALUES (?,?,?,?,?,?,?,?,?,?)";
                if ($stmt = $mysqli->prepare($strsql)) {
                    $stmt->bind_param("siiiiiiiii", $idexpediente, $idcurso, $idseccion, $año_escolar, $añomilitar, $beca, $interno, $fotografia, $partida, $certificado);
                    $stmt->execute();
                    if ($stmt->errno == 0) {
                $text = "El alumno se matriculó Exitosamente.";
                $type = "success";
                $title = "Exito!";
                if(!empty($_FILES["avatar"])){
                    $target_dir = "../uploads/avatar/";
                    $target_file = $target_dir . basename($_FILES["avatar"]["name"]);
                    $uploadOk = 1;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    $target_file = $target_dir.$idexpediente.".".$imageFileType ;                      
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
                    $text =  "Sus datos se enviaron correctamente, a excepción de su imagen. Favor ponerse en contacto con el administrador del sitio.";
                        $type = "warning";
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
                    } else {
                        $text = "No se pudo ejecutar la consulta: " . $stmt->error;
                    }
                } else {
                    $text = "No se puedo preparar la consulta: " . $mysqli->error;
                }
            } else {
                $text = "Se enviaron parametros vacios o nulos";
            }
        } else {
            $text = "No se enviaron parametros válidos, consulte con el administrador.";
        }
        }else{
             $text = "Edad inválida!";
        }

    break;
    case "nuevo_institucion":
        if(isset($_POST["nombre_institucion"])){
            if(!empty($_POST["nombre_institucion"])){
                $nombre_institucion = $_POST["nombre_institucion"];
                $ciudad_institucion = $_POST["ciudad_institucion"];
                $strsql = "INSERT INTO `instituciones_previas`(`institucion_previa`, `localizacion`) VALUES (?,?)";
                if($stmt = $mysqli->prepare($strsql)){
                    $stmt->bind_param("ss", $nombre_institucion, $ciudad_institucion);
                    $stmt->execute();
                    if($stmt->errno == 0){
                        $text = "El Registro se agrego Exitosamente.";
                        $type = "success";
                        $title = "Exito!";
                        $idinstitucion = $stmt->insert_id;
                        $htmldata = "<option value=\"$idinstitucion\" selected>$nombre_institucion</option>";
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
$jsonreturn = array("type" => $type, "title" => $title, "text" => $text, "timer" => $timer, "showConfirmButton" => $showConfirmButton, "datareturn" => $datareturn, "htmldata" => $htmldata,);
echo json_encode($jsonreturn);
?>
