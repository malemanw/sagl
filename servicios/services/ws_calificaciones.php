<?php
	header('Content-Type: application/json; charset=UTF-8');
  header('Access-Control-Allow-Origin: *'); 
  header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Accept: application/jason');
	require "../../config.php";
$idexpediente = $_GET["expediente"];
$identidad = $_GET["identidad"];
                    
					$strsql = "SELECT alumnos.nombre_completo, notas.idparcial, clases.nombre, notas.idexpediente, notas.sem1, notas.sem2, notas.sem3, notas.sem4, notas.sem5, notas.sem6, notas.sem7, notas.examen, (notas.sem1 + notas.sem2 + notas.sem3 + notas.sem4 + notas.sem5 + notas.sem6 + notas.sem7 + notas.examen) as total FROM `notas` INNER JOIN clase_curso_detalles ON clase_curso_detalles.idclase_curso=notas.idclase_curso INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase INNER JOIN alumnos ON alumnos.idexpediente=notas.idexpediente INNER JOIN alumnos_matriculados ON alumnos_matriculados.idexpediente=notas.idexpediente WHERE notas.idexpediente=".$idexpediente." AND clase_curso_detalles.idaño=1 and alumnos_matriculados.al_dia=1 and clases.activo=1 ORDER BY notas.idparcial DESC";
					if($stmt = $mysqli->prepare($strsql)){
						$resultado = $mysqli->query($strsql);
				//$stmt->bind_param("ssi",$idbloque, $bloque, $tipo);
$stmt->execute();
$outp = array();
$stmt->store_result();
if($stmt->num_rows > 0){

$outp = $resultado->fetch_all(MYSQLI_ASSOC); 
}else
{
$outp = $resultado->fetch_all(MYSQLI_ASSOC); 
//$outp= "No hay datos disponibles".$stmt->error;  
}
        
						}
						else{
							$outp = "No se pudo ejecutar la consulta: ".$stmt->error;
						}
					
echo json_encode($outp);

?>
