<?php
$servidor = "localhost";
$basedatos = "sagl_database";
$usuario = "malemanw";
$password = "malemanw";
$mysqli = new mysqli($servidor, $usuario, $password, $basedatos);
mysqli_set_charset($mysqli,"utf8");	
$urlweb = "http://localhost/LMN/";
$tema = "LMN2018";
$urltema = $urlweb."temas/".$tema."/";
?>
