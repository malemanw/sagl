<?php
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json; charset=UTF-8');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Accept: application/jason');
require "../../config.php";
$accion = isset($_GET["accion"]) ? $_GET["accion"] : "default";
switch ($accion) {
    case "deptos":
        $strsql = "SELECT iddepto, departamento FROM `departamentos` ORDER BY departamento ASC";
        if ($stmt = $mysqli->prepare($strsql)) {
            $resultado = $mysqli->query($strsql);
            //$stmt->bind_param("ssi",$idbloque, $bloque, $tipo);
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
    case "ciudades":
        $strsql = "SELECT idciudad, ciudad FROM `ciudades` ORDER BY ciudad ASC";
        if ($stmt = $mysqli->prepare($strsql)) {
            $resultado = $mysqli->query($strsql);
            //$stmt->bind_param("ssi",$idbloque, $bloque, $tipo);
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
        
        echo json_encode($outp);
        break;
    case "nacionalidades":
        $strsql = "SELECT idnacionalidad, nacionalidad FROM `nacionalidades` ORDER BY nacionalidad ASC";
        if ($stmt = $mysqli->prepare($strsql)) {
            $resultado = $mysqli->query($strsql);
            //$stmt->bind_param("ssi",$idbloque, $bloque, $tipo);
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
        
        echo json_encode($outp);
        break;
    case "escuelas_previas":
        $strsql = "SELECT `idinstitucion`, `institucion_previa` FROM `instituciones_previas` WHERE 1 ORDER BY institucion_previa ASC";
        if ($stmt = $mysqli->prepare($strsql)) {
            $resultado = $mysqli->query($strsql);
            //$stmt->bind_param("ssi",$idbloque, $bloque, $tipo);
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
        
        echo json_encode($outp);
        break;
    case "cursos":
        $strsql = "SELECT `idcurso`, `nombre_curso` FROM `cursos` ORDER BY idcurso DESC";
        if ($stmt = $mysqli->prepare($strsql)) {
            $resultado = $mysqli->query($strsql);
            //$stmt->bind_param("ssi",$idbloque, $bloque, $tipo);
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
        
        echo json_encode($outp);
        break;
    case "anio_militar":
        $strsql = "SELECT `idanio_militar`, `descripcion` FROM `anios_militares` ORDER BY idanio_militar ASC";
        if ($stmt = $mysqli->prepare($strsql)) {
            $resultado = $mysqli->query($strsql);
            //$stmt->bind_param("ssi",$idbloque, $bloque, $tipo);
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
        
        echo json_encode($outp);
        break;
}

?> 
