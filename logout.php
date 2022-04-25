<?php
//iniciamos la sesion que estaba utilizando
require "funciones.class.php";
$funciones = new funciones($mysqli);  
$funciones->iniciarsesion();

//Borramos las variables de sesion asignando un arreglo vacio.
$_SESSION = array();

//destruimos la sesion iniciada
session_destroy();

//Regresamos al index
header("Location: ./index.php");
?>