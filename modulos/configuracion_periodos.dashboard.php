<?php
	global $mysqli;
	global $urlweb;
	global $idmodulo;
	global $idbloque;
?>
 <p class="flow-text">A continuación se muestran características avanzadas para la configuración de las clases en los periodos académicos.</span></p>
<?php
        global $funciones;
if($funciones->login_admin()){
?>
<h3>Características avanzadas</h3>
<br>
<div>
<h5>Configuración de clases en los años escolares</h5>
<ul class="collapsible popout" data-collapsible="accordion">
<?php
			$strsql = "SELECT idaño, nombre, descripcion FROM year_escolar ORDER BY idaño";
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idaño, $nombre, $descripcion);
						while($stmt->fetch()){
						?> 
    <li>
      <div id="<?php echo $idaño ?>" class="collapsible-header"><i class="material-icons">today</i><?php echo "#".$idaño." - ".$nombre?></div>
	  <?php
	  				//query			  
				  $stmt2 = $mysqli->prepare("SELECT COUNT(clase_curso_detalles.idclase) as ANUAL FROM `clase_curso_detalles` INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase WHERE clases.semestre=0 AND clase_curso_detalles.idaño=? AND clase_curso_detalles.activo=1");
				  $stmt2->bind_param("i", $idaño);
				  $stmt2->execute();
				  $stmt2->store_result();
				  $stmt2->bind_result($anual);
				  $stmt2->fetch();
				  $stmt2->close();
				  //query			  
				  $stmt2 = $mysqli->prepare("SELECT COUNT(clase_curso_detalles.idclase) as PRIMER FROM `clase_curso_detalles` INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase WHERE clases.semestre=1 AND clase_curso_detalles.idaño=? AND clase_curso_detalles.activo=1");
				  $stmt2->bind_param("i", $idaño); 
				  $stmt2->execute();
				  $stmt2->store_result();
				  $stmt2->bind_result($primer);
				  $stmt2->fetch();
				  $stmt2->close();
				  //query			  
				  $stmt2 = $mysqli->prepare("SELECT COUNT(clase_curso_detalles.idclase) as SEGUNDO FROM `clase_curso_detalles` INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase WHERE clases.semestre=2 AND clase_curso_detalles.idaño=? AND clase_curso_detalles.activo=1");
				 $stmt2->bind_param("i", $idaño); 
				  $stmt2->execute();
				  $stmt2->store_result();
				  $stmt2->bind_result($segundo);
				  $stmt2->fetch();
				  $stmt2->close();
				  //query   				  
?>
<div class="collapsible-body">
   <div class="row center">
      <div class="col s6 m6 l6">
         <h6>Habilitar Clases <b>Anuales(<?php echo $anual ?>)</b></h6>
         <p>Si se habilita, las clases anuales aparecerán a los docentes y a los padres de familia en el pórtal lmh.edu.hn.</p>
      </div>
      <div class="col s6 m6 l6">
         <p>
            <input type="checkbox" id="check_anual<?php echo $idaño ?>" <?php echo $anual >=1 ? "checked='checked'" : "" ?> />
            <label for="check_anual<?php echo $idaño ?>">Valor por defecto: Activado</label>
         </p>
         <p>
      </div>
   </div>
   <div class="row center">
      <div class="col s6 m6 l6">
         <h6>Habilitar Clases <b>I Semestre(<?php echo $primer ?>)</b></h6>
         <p>Si se habilita, las clases del primer semestre aparecerán a los docentes y a los padres de familia en el pórtal lmh.edu.hn.</p>
      </div>
      <div class="col s6 m6 l6">
         <p>
            <input type="checkbox" id="check_primer<?php echo $idaño ?>" <?php echo $primer >=1 ? "checked='checked'" : "" ?> />
            <label for="check_primer<?php echo $idaño ?>">Valor por defecto: Activado</label>
         </p>
         <p>
      </div>
   </div>
   <div class="row center">
      <div class="col s6 m6 l6">
         <h6>Habilitar Clases <b>II Semestre(<?php echo $segundo ?>)</b></h6>
         <p>Si se habilita, las clases del segundo semestre aparecerán a los docentes y a los padres de familia en el pórtal lmh.edu.hn.</p>
      </div>
      <div class="col s6 m6 l6">
         <p>
            <input type="checkbox" id="check_segundo<?php echo $idaño ?>" <?php echo $segundo >=1 ? "checked='checked'" : "" ?>/>
            <label for="check_segundo<?php echo $idaño ?>">Valor por defecto: Activado</label>
         </p>
         <p>
      </div>
   </div>
   <a id="p" href="javascript:opciones_avanzadas(<?php echo $idaño ?>)" class="waves-effect waves-green btn green">Guardar Cambios</a> 	
</div>
    </li>
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
		<div>
		<h5>Configuración de año escolar predeterminado</h5>
		</ul>
  <ul class="collapsible popout" data-collapsible="accordion">
    <li>
      <div class="collapsible-header"><i class="material-icons">event_available</i>Seleccione el año escolar predeterminado</div>
      <div class="collapsible-body">
<div class="input-field col l6 s12">
<select id="seleccionaño" name="seleccionaño" style="display: none;">
  <?php
      $strsql = "SELECT idaño, nombre FROM year_escolar ORDER BY predeterminado DESC";
      if($stmt = $mysqli->prepare($strsql)){
        $stmt->execute();
        if($stmt->errno == 0){
          $stmt->store_result();
          if($stmt->num_rows > 0){
            $stmt->bind_result($idaño, $descripcion);
            while($stmt->fetch()){
            ?>
               <option value="<?php echo $idaño ?>"><?php echo $descripcion ?></option>
          <?php
            }
            ?>
</select>
</div>  
  <?php
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
	<br>
	<a id="p" href="javascript:predeterminado()" class="waves-effect waves-green btn green">Guardar Cambios</a> 	
	  </div>
    </li>
  </ul>
		</div>
</div>

<?php
        }else{
?>
      <h2>Ud no tiene permisos </h2>      
<?php
}
?>
<script src="./recursos/js/datatables.min.js"></script>
<script src="<?php echo $urlweb?>recursos/js/sweetalert2.min.js"></script>
<script>
$(function() {
  $(document).ready(function() {
$('#seleccionaño').material_select();
});

});


function opciones_avanzadas(año){
	var anual = $("#check_anual"+año).prop("checked") ? 1 : 0;
	var primer = $("#check_primer"+año).prop("checked") ? 1 : 0;
	var segundo = $("#check_segundo"+año).prop("checked") ? 1 : 0;
	swal({
	title:"¿Datos Correctos?",
	text: "¿Todos los cambios ingresados estan bien?",
	type: "warning",
	showCancelButton: true,
	closeOnConfirm: false,
	showLoaderOnConfirm: true
}).then(function(){
	$.ajax({
		url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=agregar",
		type: 'POST',
		data:{"anual":anual, "primer":primer, "segundo":segundo, "año":año},
		error:function(){
				swal.close();
				setTimeout(function(){
					swal({
							title:"Error!",
							text: "Tiempo Fuera, No se procesaron los datos",
							type:"error",
							showConfirmButton:true
						});
				}, 1000);
		},
		success: function(data){
			try{
				var retorno = data;
				swal(retorno);			
			}
			catch(err){
				swal({
					title:"Error!",
					text: err.message,
					type:"error",
					showConfirmButton:true
				});
			}
		},
		timeout: 5000
	});
	
})
}
function predeterminado(){
	var año = $("#seleccionaño").val();
	swal({
	title:"¿Datos Correctos?",
	text: "¿Todos los cambios ingresados estan bien?",
	type: "warning",
	showCancelButton: true,
	closeOnConfirm: false,
	showLoaderOnConfirm: true
}).then(function(){
	$.ajax({
		url:"<?php echo $urlweb?>/servicios/ws_<?php echo $idpanel?>.php?accion=año_predeterminado",
		type: 'POST',
		data:{"año":año},
		error:function(){
				swal.close();
				setTimeout(function(){
					swal({
							title:"Error!",
							text: "Tiempo Fuera, No se procesaron los datos",
							type:"error",
							showConfirmButton:true
						});
				}, 1000);
		},
		success: function(data){
			try{
				var retorno = data;
				swal(retorno);			
			}
			catch(err){
				swal({
					title:"Error!",
					text: err.message,
					type:"error",
					showConfirmButton:true
				});
			}
		},
		timeout: 5000
	});
	
})
}
</script>
