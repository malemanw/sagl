<?php
	class funciones{
		var $mysqli;
		
function __construct($mysqli) {
	$this->mysqli = $mysqli;
}


function modulo($idmodulo, $cssclass="", $cssid=""){
	$cssclass = !empty($cssclass) ? "class=\"$cssclass\"" : "";
	$cssid = !empty($cssid) ? "id=\"$cssid\"" : "";
	if(file_exists("modulos/$idmodulo.modulo.php")){
		require "modulos/$idmodulo.modulo.php";
	}
	else{
		echo "no existe el modulo";
	}
}

function dashboard_panel($idpanel){
	if(file_exists("modulos/$idpanel.dashboard.php")){
		require "modulos/$idpanel.dashboard.php";
	}
	else{
		echo"<center><h4>No existe el panel solicitado</h4></center>";
	}
}
function login($idusuario, $password){
	$strsql = "SELECT usuario, password, llave
			   FROM usuarios WHERE idusuario = ?";
	if($stmt = $this->mysqli->prepare($strsql)){
		$stmt->bind_param("s", $idusuario);
		$stmt->execute();
		if($stmt->errno == 0){
			$stmt->store_result();
			$stmt->bind_result($usuario, $passwdb, $llave);
			$stmt->fetch();
			if($stmt->num_rows == 1){
				$password = hash("sha512",$password.$llave);
				if($password == $passwdb){
					  $id= session_id();
					$navegador = $_SERVER['HTTP_USER_AGENT'];
					$_SESSION["idusuario"] = $idusuario;
					$_SESSION["usuario"] = $usuario;
					$_SESSION["login_string"] = hash('sha512', $password.$navegador.$id);
					return true;
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
		}
		else{
            $stmt->close();
			return false;
		}
		$stmt->close();
	}
	else{
		return false;
	}
}
function login_check(){
	if(isset($_SESSION["idusuario"], $_SESSION["usuario"], $_SESSION["login_string"])){
		$idusuario = $_SESSION["idusuario"];
		$usuario = $_SESSION["usuario"];
		$loginstring = $_SESSION["login_string"];
		$navegador = $_SERVER['HTTP_USER_AGENT'];
		 $id= session_id();
		$strsql = "SELECT password FROM usuarios WHERE idusuario = ?";
		if($stmt = $this->mysqli->prepare($strsql)){
			$stmt->bind_param("s", $idusuario);
			$stmt->execute();
			if($stmt->errno == 0){
				$stmt->store_result();
				if($stmt->num_rows == 1){
					$stmt->bind_result($password);
					$stmt->fetch();
					$login_check = hash('sha512', $password.$navegador.$id);
					if($login_check == $loginstring){
						return true;
					}
					else{
						return false;
					}
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
			$stmt->close();
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
}
function login_admin(){
	if(isset($_SESSION["idusuario"], $_SESSION["usuario"])){
$idusuario = $_SESSION["idusuario"];
		
		$strsql = "SELECT esadmin FROM usuarios WHERE idusuario = ?";
		if($stmt = $this->mysqli->prepare($strsql)){
			$stmt->bind_param("s", $idusuario);
			$stmt->execute();
			if($stmt->errno == 0){
				$stmt->store_result();
				if($stmt->num_rows == 1){
					$stmt->bind_result($esadmin);
					$stmt->fetch();
					if($esadmin == true){
						return true;
					}else{
                        return false;
                    }
				
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
			$stmt->close();
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
}
function login_estado(){
if(isset($_SESSION["idusuario"], $_SESSION["usuario"])){
$idusuario = $_SESSION["idusuario"];
	
	$strsql = "SELECT estado FROM usuarios WHERE idusuario = ?";
	if($stmt = $this->mysqli->prepare($strsql)){
		$stmt->bind_param("s", $idusuario);
		$stmt->execute();
		if($stmt->errno == 0){
			$stmt->store_result();
			if($stmt->num_rows == 1){
				$stmt->bind_result($estado);
				$stmt->fetch();
				if($estado == true){
					return true;
				}else{
                    return false;
                }
			
			}
			else{
				return false;
			}
		}
		else{
			return false;
		}
		$stmt->close();
	}
	else{
		return false;
	}
}
else{
	return false;
}
}
function es_maestro(){
	if(isset($_SESSION["idusuario"], $_SESSION["usuario"])){
$idusuario = $_SESSION["idusuario"];
		
		$strsql = "SELECT maestro FROM usuarios WHERE idusuario = ?";
		if($stmt = $this->mysqli->prepare($strsql)){
			$stmt->bind_param("s", $idusuario);
			$stmt->execute();
			if($stmt->errno == 0){
				$stmt->store_result();
				if($stmt->num_rows == 1){
					$stmt->bind_result($esadmin);
					$stmt->fetch();
					if($esadmin == true){
						return true;
					}else{
                        return false;
                    }
				
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
			$stmt->close();
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
}
function clase_activa($idclase_curso){
	if(isset($_SESSION["idusuario"], $_SESSION["usuario"])){
		
		$strsql = "SELECT idclase_curso FROM clase_curso_detalles WHERE idclase_curso =? and activo=1";
		if($stmt = $this->mysqli->prepare($strsql)){
			$stmt->bind_param("s", $idclase_curso);
			$stmt->execute();
			if($stmt->errno == 0){
				$stmt->store_result();
				if($stmt->num_rows == 1){
					$stmt->bind_result($clase);
					$stmt->fetch();
					if($clase == true){
						return true;
					}else{
                        return false;
                    }
				
				}
				else{
					return false;
				}
			}
			else{
				return false;
			}
			$stmt->close();
		}
		else{
			return false;
		}
	}
	else{
		return false;
	}
}
function iniciarsesion(){
	session_name("LMN_2018");
	session_start();
}

}