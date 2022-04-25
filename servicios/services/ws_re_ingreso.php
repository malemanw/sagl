<?php
header('Content-Type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Accept: application/jason');
require "../../config.php";
$type              = "error";
$title             = "Error!";
$text              = "Error desconocido";
$timer             = NULL;
$showConfirmButton = true;
$datareturn        = "";
$htmldata          = "";
$expediente        = "";
$accion            = isset($_GET["accion"]) ? $_GET["accion"] : "default";
switch ($accion) {
    case "getName":
        $idexpediente = $_GET["expediente"];
        $strsql       = "SELECT alumnos.idexpediente, alumnos.nombre_completo, alumnos.residencia_alumno, alumnos.rtn, alumnos.fecha_creacion, alumnos_matriculados.idcurso, alumnos_matriculados.al_dia FROM alumnos_matriculados INNER JOIN alumnos ON alumnos_matriculados.idexpediente=alumnos.idexpediente  WHERE alumnos_matriculados.idexpediente='$idexpediente' AND alumnos.activo=1 ORDER BY alumnos_matriculados.fecha_matricula DESC LIMIT 1";
        if ($stmt = $mysqli->prepare($strsql)) {
            $resultado = $mysqli->query($strsql);
            //$stmt->bind_param("s",$idexpediente);
            $stmt->execute();
            $outp = array();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                
                $outp = $resultado->fetch_all(MYSQLI_ASSOC);
            } else {
                $outp = $resultado->fetch_all(MYSQLI_ASSOC);
                //$outp= "No hay datos disponibles".$stmt->error;  
            }
            
        } else {
            $outp = "No se pudo ejecutar la consulta: " . $stmt->error;
        }
        header('Content-Type: application/json');
        echo json_encode($outp);
        break;
    case "nuevo":
        $json   = file_get_contents('php://input'); // RECIBE EL JSON DE ANGULAR
        $params = json_decode($json); // DECODIFICA EL JSON Y LO GUARADA EN LA VARIABLE
        if (!empty($params->idexpediente) && !empty($params->curso)) {
            $idexpediente = $params->idexpediente;
            $idcurso      = $params->curso;
            $idseccion    = $params->seccion;
            $idaño       = 3;
            $añomilitar  = $params->añomilitar;
            $beca         = 0;
            $interno       = $params->interno;
            $aldia        = 0;
            $lista_espera = 1;
            $strsql       = "INSERT INTO `alumnos_matriculados`(`idexpediente`, `idcurso`, `idseccion`, `idaño`, `idanio_militar`, `tienebeca`, `esinterno`, `al_dia`, `lista_espera`) VALUES (?,?,?,?,?,?,?,?,?)";
            if ($stmt = $mysqli->prepare($strsql)) {
                $stmt->bind_param("siiiiiiii", $idexpediente, $idcurso, $idseccion, $idaño, $añomilitar, $beca, $interno, $aldia, $lista_espera);
                $stmt->execute();
                    if ($stmt->errno == 0) {
                $text = "Solicitud procesada exitosamente.";
                $type = "success";
                $title = "Exito!";
                        $htmldata= $htmldata. ", Alumnos agregado a tabla de Alumnos exitosamente";
                    } else {
                        $text = "No se pudo ejecutar la consulta: " . $stmt->error;
                    }
                
            } else {
                $outp = "No se pudo ejecutar la consulta: " . $stmt->error;
            }
        } else {
            $text = "Se enviaron parametros vacios o nulos";
        }
        
        $jsonreturn = array("type" => $type, "title" => $title, "text" => $text, "timer" => $timer, "showConfirmButton" => $showConfirmButton, "datareturn" => $datareturn,"expediente" => $expediente, "htmldata" => $htmldata,);
echo json_encode($jsonreturn);
        break;
}

?> 
