<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta http-equiv="Content-Language" content="es_HN" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <meta name="Author" content="Marco Alemán Watters - Ingeniero en Ciencias de la Computación"/>
    <meta name="description" content="Sistema para la Automatización de Gestiones en Línea">
	<title>SAGL - Liceo Militar de Honduras</title>
	<link rel="icon" href="<?php echo $urltema?>img/ico.png"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $urltema?>css/main.css"  media="screen,projection"/>
    <link type="text/css" rel="stylesheet" media="print" href="<?php echo $urltema?>css/print.css"/>
    <link type="text/css" rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons"/>
    <link type="text/css" rel="stylesheet" href="<?php echo $urlweb?>recursos/css/materialize.css"  media="screen,projection"/>  
    <link type="text/css" rel="stylesheet" href="<?php echo $urlweb?>recursos/css/datatables.min.css"  media="screen,projection"/>
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css"> 
    <link rel="stylesheet" type="text/css" href="<?php echo $urlweb?>recursos/css/sweetalert2.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.2.3/css/responsive.dataTables.min.css">
       <!-- searchPanes -->
    <link rel="stylesheet" href="https://cdn.datatables.net/searchpanes/1.0.1/css/searchPanes.dataTables.min.css">
    <!-- select -->
    <link href="https://cdn.datatables.net/select/1.3.1/css/select.dataTables.min.css">
        <!-- fixedcolumns -->
    <link href="https://cdn.datatables.net/fixedcolumns/4.0.0/css/fixedColumns.dataTables.min.css">
    <script type="text/javascript" src="<?php echo $urlweb?>recursos/js/jquery.js"></script>  
    <script type="text/javascript" src="<?php echo $urlweb?>recursos/js/jquery-ui.min.js"></script>
	  <script type="text/javascript" src="<?php echo $urlweb?>recursos/js/materialize.min.js"></script>   
</head>
<body class="cover" style="background-image: url(<?php echo $urltema?>img/fachada-min.png);">
	<div id="main-container" class="">
<?php 
$funciones->modulo($idmodulo,"row","inicio");
?>	
	</div>
</body>
<footer>
</footer>
<script>
$(function(){
 $('.modal').modal();
});
</script>
</html>