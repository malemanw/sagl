<?php
require "config.php";
require "funciones.class.php";
$funciones = new funciones($mysqli);  
$funciones->iniciarsesion();
$idmodulo = isset($_GET["mod"]) ? $_GET["mod"] : "inicio";
$idpanel = isset($_GET["panel"]) ? $_GET["panel"] : "dashboard";   
require "temas/$tema/index.tema.php";
?>