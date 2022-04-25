<?php
global $mysqli;
global $urlweb;
global $idmodulo;
global $idbloque;
global $funciones;
if($funciones->login_estado()){   
?>
<h3 class="center grey-text">Efectuar Pagos</h3>
 <p class="flow-text">Bienvenido al módulo de pagos, aquí ud. podra tener acceso a los alumnos matriculados por año escolar para que se pueda generar la factura propia de cada pago realizado por el responsable de dicho alumno.<span>Si el alumno no ha entregado papeles y no ha realizado ningún pago, acceda al módulo <a href="?mod=dashboard&panel=pre_inscripcion">matricula en lista de espera</a> para efectuar el pago.</span></p>
 <h5 class="center">Seleccione el año escolar</h5>
      <div class="col s12 m12 l12">
      <table class="bordered highlight centered responsive-table striped">
        <thead>
          <tr>
              <th>Año Escolar</th>
              <th>Descripción</th>
              <th>Fecha Inicial</th>
              <th>Fecha Final</th>
              <th>Seleccionar</th>
          </tr>
        </thead>

        <tbody>
        <?php
$strsql = 'SELECT `idaño`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_final` FROM `year_escolar` where activo=1 ORDER BY fecha_creacion DESC';
if($stmt = $mysqli->prepare($strsql)){
    $stmt->execute();
    if($stmt->errno == 0){
        $stmt->store_result();
        if($stmt->num_rows > 0){
            $stmt->bind_result($idaño, $nombre, $descripcion, $fecha_inicio, $fecha_final);
            while($stmt->fetch()){
            ?>
                <tr id="rw-<?php echo $idaño?>">
                    <td><?php echo $nombre?></td>
                    <td><?php echo $descripcion?></td>
                    <td><?php echo $fecha_inicio?></td>
                    <td><?php echo $fecha_final?></td>
                        <td class="center">
                        <a href="?mod=dashboard&panel=adminfactura_main&idaño=<?php echo $idaño?>" class="btn green">
                            <i class="material-icons">event_available</i>                     
                        </a>
                        </td>
                </tr>
            <?php
            }
            $stmt->close();
        }//cierre de consulta de valores retornados
    }
    else{
        echo "Error al ejecutar consulta: " . $stmt->error;
    }//Cierre de condicion de Ejecucion
}
else{
    echo "Error al preparar consulta: " . $mysqli->error;
}
?>
        </tbody>
      </table>
	</div>	
<?php
}else{
?>
<h2 class="center">Ud no tiene permisos o su cuenta ha sido desactivada, comuniquese con el administrador.</h2> 
<?php
}
?>
<script src="./recursos/js/sha512.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>
$(function() {
    $("ul.tabs").tabs({
        swipeable: true
    });
    $("#txtfechanac").datepicker({
        changeMonth: true,
        changeYear: true,
        dateFormat: "yy-mm-dd",
        yearRange: "1900:2100"
    });
    $("#txtfechanac").datepicker($.datepicker.regional["es"]);
});

</script>