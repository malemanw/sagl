<?php
	header('Content-Type: application/json');
	header("Access-Control-Allow-Origin: *");
	$type = "error";
	$title = "Error!";
	$text = "Error desconocido";
	$timer = NULL;
	$showConfirmButton = true;
	require "../config.php";
	$accion = isset($_GET["accion"]) ? $_GET["accion"] : "default";
	
	switch($accion){
case "asignar_notas":
$idclase_curso = $_POST['idclase_curso'];  
$idexpediente = $_POST['rowId']; 
$sem1 = $_POST['sem1'];  
$sem2 = $_POST['sem2'];  
$sem3 = $_POST['sem3'];  
$sem4 = $_POST['sem4'];  
$sem5 = $_POST['sem5'];  
$sem6 = $_POST['sem6'];  
$sem7 = $_POST['sem7'];  
$exa = $_POST['exa'];  
$recup = $_POST['recup']; 
$parcial = $_POST['parcial'];  
$idusuario = $_POST['idusuario'];  
$strsql = "REPLACE INTO `notas`(`idclase_curso`, `idexpediente`, `idusuario`, `sem1`, `sem2`, `sem3`, `sem4`, `sem5`, `sem6`, `sem7`, `examen`, `recup`, `idparcial`) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)";
if($stmt = $mysqli->prepare($strsql)){
$stmt->bind_param("issiiiiiiiiii", $idclase_curso, $idexpediente, $idusuario, $sem1, $sem2, $sem3, $sem4, $sem5, $sem6, $sem7, $exa, $recup, $parcial);
	$stmt->execute();
	if($stmt->errno == 0){
		$text = "Nota agregada exitosamente!";
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

break;
}
	
		
		$jsonreturn = array(
					"type"=>$type,
					"title"=>$title,
					"text"=>$text,
					"timer"=>$timer,
					"showConfirmButton"=>$showConfirmButton,
				);
	
	echo json_encode($jsonreturn);
?>
