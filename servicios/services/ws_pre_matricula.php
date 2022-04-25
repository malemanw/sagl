<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Accept: application/jason');
require "../../config.php";
$type = "error";
$title = "Error!";
$text = "Error desconocido";
$timer = NULL;
$showConfirmButton = true;
$datareturn = "";
$htmldata = "";
$expediente = "";
$accion = isset($_GET["accion"]) ? $_GET["accion"] : "default";
switch ($accion) {
    case "nuevo":
    $json = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
  $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
function CalculaEdad($fecha) {
    list($Y, $m, $d) = explode("-", $fecha);
    return (date("md") < $m . $d ? date("Y") - $Y - 1 : date("Y") - $Y);
}
        $edad_correlativo = CalculaEdad($params->nacimiento);
        if ($edad_correlativo < 10) {
            $edad_correlativo = "0" . $edad_correlativo;
        }
//evaluar la edad, para que no arruine el correlativo
        if($edad_correlativo>=1 && $edad_correlativo<=50){
       //Obtener el ultino correlativo  
        if (!empty($params->nombre_alumno) && !empty($params->nacimiento)) {       
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
            if (!empty($params->nombre_alumno)) {     
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
        if (isset($params->nacionalidad_alumno) && (isset($params->ciudad_alumno)) && (isset($params->depto)) && (isset($params->curso)) && (isset($params->seccion)) && (isset($params->añomilitar)) && (isset($params->nombre_alumno))) {
            if (!empty($params->nombre_alumno) && (!empty($params->nacimiento))) {
                $nombre_alumno = $params->nombre_alumno;
                $email_alumno = $params->email;
                $telefono = $params->telefono;
                $nacimiento = $params->nacimiento;
                $edad = CalculaEdad($nacimiento);
                $sexo = $params->sexo;
                $nacionalidad_alumno = $params->nacionalidad_alumno;
                $ciudad_alumno = $params->ciudad_alumno;
                $depto = $params->depto;
                $curso = $params->curso;
                $seccion = $params->seccion;
                $año_escolar = $params->año_escolar;
                $añomilitar = $params->añomilitar;
                $rnp = $params->identidad;
                $religion = 5;
                $institucion_previa = $params->escuela_previa;
                $modalidad= "NO DEFINIDO";
                $ciudad_padre = 31;
                $nacionalidad_padre = 18;
                $ciudad_madre = 31;
                $nacionalidad_madre = 18;               
                $strsql = "INSERT INTO `alumnos`(`idexpediente`,`rtn`, `anio_militar`, `nombre_completo`, `fecha_nacimiento_alumno`, `edad`, `sexo`, `telefono_alumno`, `email_alumno`, `idreligion`, `iddepto`, `idnacionalidad`, `idinstitucion_previa`, `modalidad`, `idciudad`, `ciudad_padre`, `nacionalidad_padre`, `ciudad_madre`, `nacionalidad_madre`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                if ($stmt = $mysqli->prepare($strsql)) {
                    $stmt->bind_param("ssissiissiiiisiiiii", $idexpediente, $rnp, $añomilitar, $nombre_alumno, $nacimiento, $edad, $sexo, $telefono, $email_alumno, $religion, $depto, $nacionalidad_alumno, $institucion_previa, $modalidad, $ciudad_alumno, $ciudad_padre, $nacionalidad_padre, $ciudad_madre, $nacionalidad_madre);
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
        if (isset($params->año_escolar) && (isset($params->curso)) && (isset($params->seccion))&& (isset($params->nombre_alumno))) {
            if (!empty($params->año_escolar) && !empty($params->añomilitar)) {              
                $idcurso = $params->curso; 
                $idseccion = $params->seccion; 
                $año_escolar = 3; 
                $añomilitar = $params->añomilitar; 
                $lista_espera = 1;
                $beca = 0;
                $interno = $params->interno;
		$primer_ingreso=1; 
                $strsql = "INSERT INTO `alumnos_matriculados`(`idexpediente`, `idcurso`, `idseccion`, `idaño`, `idanio_militar`, `tienebeca`, `esinterno`,`primer_ingreso`, `lista_espera`) VALUES (?,?,?,?,?,?,?,?,?)";
                if ($stmt = $mysqli->prepare($strsql)) {
                    $stmt->bind_param("siiiiiiii", $idexpediente, $idcurso, $idseccion, $año_escolar, $añomilitar, $beca, $interno,$primer_ingreso, $lista_espera);
                    $stmt->execute();
                    if ($stmt->errno == 0) {
                $text = "Solicitud procesada exitosamente.";
                $type = "success";
                $title = "Exito!";
                $expediente = $idexpediente;
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
     $text = $text;
        }else{
            $text = "Edad inválida!";
        }
 
    
}
$jsonreturn = array("type" => $type, "title" => $title, "text" => $text, "timer" => $timer, "showConfirmButton" => $showConfirmButton, "datareturn" => $datareturn,"expediente" => $expediente, "htmldata" => $htmldata,);
echo json_encode($jsonreturn);
?>
