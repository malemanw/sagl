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
		case "facturar":
$arr = $_POST['arv'];
$idaño = $_POST['idaño'];
$idcuota_recibidas = explode(',',$arr); 
$idusuario = $_POST['idusuario'];
$idexpediente = $_POST['expediente'];
$monto = 233;
$idfactura=rand();
//insert a la tabla de facturas
            if(isset($_POST["expediente"])&&(isset($_POST["arv"]))){
				if(!empty($_POST["idaño"])&&(!empty($_POST["idusuario"]))){
					
                  $strsql = "INSERT INTO `facturas`(`idfactura`, `idexpediente`) VALUES (?,?)";
					if($stmt = $mysqli->prepare($strsql)){
					$stmt->bind_param("is", $idfactura, $idexpediente);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "Factura Creada, ";
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
//insert a la tabla detalle de facturas
foreach($idcuota_recibidas as $idcuota){
            if(isset($_POST["idaño"])&&(isset($_POST["arv"]))){
				if(!empty($_POST["idaño"])&&(!empty($_POST["arv"]))){
					
                    $strsql = "INSERT INTO `facturas_detalles`(`idfactura`, `idcuota`, `idaño`, `idusuario`, `monto`) VALUES (?,?,?,?,?)";
					if($stmt = $mysqli->prepare($strsql)){
					$stmt->bind_param("iiisi", $idfactura, $idcuota, $idaño, $idusuario, $monto);
						$stmt->execute();
						if($stmt->errno == 0){
							$text = "El pago se realizó satisfactoriamente.";
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
			break;
		case "ver_facturas":
$idexpediente = $_POST['expediente'];	
$idaño = $_POST['idaño'];	
	$strsql = "SELECT facturas.idfactura, cuotas.cuota, cuotas.precio  FROM facturas_detalles INNER JOIN facturas ON facturas.idfactura = facturas_detalles.idfactura INNER JOIN cuotas on facturas_detalles.idcuota = cuotas.idcuota WHERE (facturas.idexpediente=" . $idexpediente . " and facturas_detalles.idaño ="  . $idaño . ")";
	if ($stmt = $mysqli->prepare($strsql))
		{
		$resultado = $mysqli->query($strsql);
		$stmt->execute();
		$outp = array();
		$stmt->store_result();
		if ($stmt->num_rows > 0)
			{
			$outp = $resultado->fetch_all(MYSQLI_ASSOC);
			$arreglo["data"] = $outp;
			}
		  else
			{
			$outp = "No hay datos disponibles" . $stmt->error;
			}
		}
	  else
		{
		$outp = "No se pudo ejecutar la consulta: " . $stmt->error;
		}

	echo json_encode($arreglo);
			break;	
case "llenar_select":
$idaño = $_POST['idaño'];	
$idexpediente = $_POST['idexpediente'];		
	            if(isset($_POST["idaño"])){
				if(!empty($_POST["idexpediente"])){
                    $strsql = "SELECT idcuota, cuota, precio FROM cuotas WHERE idcuota NOT IN (SELECT facturas_detalles.idcuota FROM facturas_detalles INNER JOIN facturas ON facturas.idfactura = facturas_detalles.idfactura INNER JOIN cuota_year_detalle on facturas_detalles.idcuota=cuota_year_detalle.idcuota WHERE (facturas.idexpediente=? and facturas_detalles.idaño=?))";
                    if($stmt = $mysqli->prepare($strsql)){
                        $stmt->bind_param("si", $idexpediente, $idaño);
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();		
						$stmt->bind_result($idcuota, $cuota, $precio);
						while($stmt->fetch()){					
							$htmldata= $htmldata."<option value=\"$idcuota\"> $cuota "." - ".number_format($precio, 2, '.', ',')."</option>";						
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
			break;								
	}
	
	
	

?>
