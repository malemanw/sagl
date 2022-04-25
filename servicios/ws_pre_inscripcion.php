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
function CalculaEdad($fecha) {
    list($Y, $m, $d) = explode("-", $fecha);
    return (date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y);
}
        $edad_correlativo = CalculaEdad($_POST["nacimiento"]);
        if ($edad_correlativo < 10) {
            $edad_correlativo = "0" . $edad_correlativo;
        }
        if($edad_correlativo>=1){
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
        if (isset($_POST["nacionalidad_alumno"]) && (isset($_POST["ciudad_alumno"])) && (isset($_POST["depto"])) && (isset($_POST["curso"])) && (isset($_POST["seccion"])) && (isset($_POST["añomilitar"])) && (isset($_POST["nombre_alumno"]))) {
            if (!empty($_POST["nombre_alumno"]) && (!empty($_POST["nacionalidad_alumno"]))) {
                $nombre_alumno = $_POST["nombre_alumno"];
                $email_alumno = $_POST["email_alumno"];
                $nacimiento = $_POST["nacimiento"];
                $edad = CalculaEdad($nacimiento);
                $sexo = $_POST["sexo"];
                $nacionalidad_alumno = $_POST["nacionalidad_alumno"];
                $ciudad_alumno = $_POST["ciudad_alumno"];
                $depto = $_POST["depto"];
                $curso = $_POST["curso"];
                $seccion = $_POST["seccion"];
                $año_escolar = $_POST["año_escolar"];
                $añomilitar = $_POST["añomilitar"];

                $religion = 5;
                $institucion_previa = 162;
                $modalidad= "NO DEFINIDO";
                $ciudad_padre = 31;
                $nacionalidad_padre = 18;
                $ciudad_madre = 31;
                $nacionalidad_madre = 18;                
                $strsql = "INSERT INTO `alumnos`(`idexpediente`, `anio_militar`, `nombre_completo`, `fecha_nacimiento_alumno`, `edad`, `sexo`, `email_alumno`, `idreligion`, `iddepto`, `idnacionalidad`, `idinstitucion_previa`, `modalidad`, `idciudad`, `ciudad_padre`, `nacionalidad_padre`, `ciudad_madre`, `nacionalidad_madre`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                if ($stmt = $mysqli->prepare($strsql)) {
                    $stmt->bind_param("sissiisiiiisiiiii", $idexpediente, $añomilitar, $nombre_alumno, $nacimiento, $edad, $sexo, $email_alumno, $religion, $depto, $nacionalidad_alumno, $institucion_previa, $modalidad, $ciudad_alumno, $ciudad_padre, $nacionalidad_padre, $ciudad_madre, $nacionalidad_madre);
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
            	$idcurso = $_POST["curso"]; 
            	$idseccion = $_POST["seccion"]; 
				$año_escolar = $_POST["año_escolar"]; 
                $añomilitar = $_POST["añomilitar"]; 
                $lista_espera = 1;
                $primer_ingreso = 1;
                $beca = 0;
                $interno = 0;
                $strsql = "INSERT INTO `alumnos_matriculados`(`idexpediente`, `idcurso`, `idseccion`, `idaño`, `idanio_militar`, `tienebeca`, `esinterno`, `primer_ingreso`, `lista_espera`) VALUES (?,?,?,?,?,?,?,?,?)";
                if ($stmt = $mysqli->prepare($strsql)) {
                    $stmt->bind_param("siiiiiiii", $idexpediente, $idcurso, $idseccion, $año_escolar, $añomilitar, $beca, $interno,$primer_ingreso, $lista_espera);
                    $stmt->execute();
                    if ($stmt->errno == 0) {
                $text = "El alumno se matriculó Exitosamente.";
                $type = "success";
                $title = "Exito!";
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
        $text = "Edad inválida, revise la fecha de nacimiento!";
    }
    break;
}
$jsonreturn = array("type" => $type, "title" => $title, "text" => $text, "timer" => $timer, "showConfirmButton" => $showConfirmButton, "datareturn" => $datareturn, "htmldata" => $htmldata,);
echo json_encode($jsonreturn);
?>
