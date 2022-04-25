<?php
	global $mysqli;
	global $urlweb;
	global $idmodulo;
	global $idbloque;
?>
<div id="frmbloques" class="modal center">
	<div id="docentes" class="modal-content">
	<h4 class="center">Detalles de notas subidas por docentes</h4>
		<span class="green lighten-2">Docentes que ya subieron notas</span>
		<br>
		<span>Nota: Este detalle no muestra la totalidad de las notas subidas a sus clases.</span>
		<table id="si_subieron" class="display  responsive centered highlight striped" cellspacing="0">
		<thead>
          <tr>
		  	  <th>Código</th>				
              <th>Nombre Docente</th>
          </tr>
        </thead>
		<tbody>
		<?php
$strsql = 'SELECT DISTINCT notas.idusuario, usuarios.usuario FROM `notas` INNER JOIN usuarios ON usuarios.idusuario=notas.idusuario INNER JOIN clase_curso_detalles ON clase_curso_detalles.idclase_curso=notas.idclase_curso WHERE usuarios.maestro=1 and clase_curso_detalles.idaño=1 ORDER BY usuarios.usuario ASC';
if($stmt = $mysqli->prepare($strsql)){
	$stmt->execute();
	if($stmt->errno == 0){
		$stmt->store_result();
		if($stmt->num_rows > 0){
			$stmt->bind_result($idusuario, $nombre);
			while($stmt->fetch()){
			?>
				<tr id="rw-<?php echo $idusuario?>">
					<td><?php echo $idusuario?></td>
					<td><?php echo $nombre?></td>
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
<span class="red lighten-1">Docentes que no han subido notas</span>
<table id="si_subieron" class="display  responsive centered highlight striped" cellspacing="0" width="50%">
		<thead>
          <tr>
		  	  <th>Código</th>				
              <th>Nombre Docente</th>
          </tr>
        </thead>
		<tbody>
		<?php
$strsql = 'SELECT idusuario, usuario FROM usuarios WHERE idusuario NOT IN (SELECT idusuario FROM notas) and usuarios.maestro=1 ORDER BY usuarios.usuario ASC';
if($stmt = $mysqli->prepare($strsql)){
	$stmt->execute();
	if($stmt->errno == 0){
		$stmt->store_result();
		if($stmt->num_rows > 0){
			$stmt->bind_result($idusuario, $nombre);
			while($stmt->fetch()){
			?>
				<tr id="rw-<?php echo $idusuario?>">
					<td><?php echo $idusuario?></td>
					<td><?php echo $nombre?></td>
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
	<div class="modal-footer">
	</div>
</div>
<h3 class="center grey-text">Administrador de Notas por Clase</h3>
 <p class="flow-text">A continuación se muestran las clases asignadas por año escolar respectivamente junto con sus respectivas calificaciones.</span></p>
 <h5 class="center">Haga click en el año escolar.</h5>
  <ul  class="collapsible popout" data-collapsible="accordion">
<?php
        global $funciones;
if($funciones->login_check()){      
?>

		<?php
			$strsql = "SELECT `idaño`, `nombre`, `descripcion`, `fecha_inicio`, `fecha_final` FROM `year_escolar` WHERE activo=1 ORDER BY idaño ASC";
			if($stmt = $mysqli->prepare($strsql)){
				$stmt->execute();
				if($stmt->errno == 0){
					$stmt->store_result();
					if($stmt->num_rows > 0){
						$stmt->bind_result($idaño, $nombre, $descripcion, $fecha_inicio, $fecha_final);
						while($stmt->fetch()){
						?> 
    <li >
      <div id="<?php echo $idaño?>" class="collapsible-header"><i class="material-icons">event</i>
          <?php echo $nombre. " Liceo Militar de Honduras"?> 
        </div>
      <div class="collapsible-body" id="body-<?php echo $idaño?>">   
	  <div id="previsualizacion">
              <center>
  <a href="javascript:ver_detalles(<?php echo $idaño?>)" class="btn waves-effect waves-light">Ver Detalles
    <i class="material-icons right">aspect_ratio</i>
  </a>  
              </center>           
            </div>        
	  <table id="" class="display  responsive centered display" cellspacing="0" width="100%">
			  <thead>
          <tr>
		  	  <th>No.</th>				
              <th>Curso</th>
			  <th>Clase</th>
			  <th>Semestre</th>
			  <th>Docente</th>
			  <th>Cuadro No. 1</th>
          </tr>
        </thead>
              <tbody>
             		<?php
			$strsql = "SELECT DISTINCT clase_curso_detalles.idclase_curso, clase_curso_detalles.idclase, clase_curso_detalles.idcurso, cursos.nombre_curso, clases.nombre, usuarios.usuario, clases.semestre  FROM `maestro_grado_detalles` INNER JOIN clase_curso_detalles ON clase_curso_detalles.idclase_curso=maestro_grado_detalles.idclase_curso INNER JOIN cursos ON cursos.idcurso=clase_curso_detalles.idcurso INNER JOIN clases ON clases.idclase=clase_curso_detalles.idclase  INNER JOIN alumnos_matriculados ON alumnos_matriculados.idcurso=clase_curso_detalles.idcurso INNER JOIN usuarios ON usuarios.idusuario=maestro_grado_detalles.idusuario where clase_curso_detalles.idaño=?";                
			if($s = $mysqli->prepare($strsql)){
                $s->bind_param("i", $idaño);
				$s->execute();
				if($s->errno == 0){
					$s->store_result();
					if($s->num_rows > 0){
						$correlativo=0;
						$s->bind_result($idclase_curso, $idclase, $idcurso, $nombre_curso, $nombre_clase, $maestro, $semestre);
						while($s->fetch()){           
						?>
							<tr id="rw-<?php echo $idcurso."-".$idclase ?>">
								<td><?php echo $correlativo+=1?></td>
								<td><?php echo $nombre_curso?></td>
								<td><?php echo $nombre_clase?></td>
								<td><?php echo ($semestre!=0) ? $semestre : "Clase Anual"?></td>
								<td><?php echo $maestro?></td>
								<?php if(($semestre==1) || ($semestre==2)){?>
								<td class="center">
								<div class="col s12 l12">
<div class="input-field">
<select id="seleccionaño" name="seleccionaño" style="display: none;">
<option value="" disabled selected>Seleccione un parcial</option>
<option data-icon="temas/LMN2018/img/descargar_notas.png" class="left circle" value="<?php echo $urlweb?>reportes/rpt_cuadro1.php?&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=1">I PARCIAL</option>
<option data-icon="temas/LMN2018/img/descargar_notas.png" class="left circle" value="<?php echo $urlweb?>reportes/rpt_cuadro1.php?&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=2">II PARCIAL</option>
</select>
</div>
</div>
</div>
								</td>
								<?php }else{
								?>                
								<td class="center">
								<div class="col s12 l12">
<div class="input-field">
<select id="seleccionaño" name="seleccionaño" style="display: none;">
<option value="" disabled selected>Seleccione un parcial</option>
<option data-icon="temas/LMN2018/img/descargar_notas.png" class="left circle" value="<?php echo $urlweb?>reportes/rpt_cuadro1.php?&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=1">I PARCIAL</option>
<option data-icon="temas/LMN2018/img/descargar_notas.png" class="left circle" value="<?php echo $urlweb?>reportes/rpt_cuadro1.php?&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=2">II PARCIAL</option>
<option data-icon="temas/LMN2018/img/descargar_notas.png" class="left circle" value="<?php echo $urlweb?>reportes/rpt_cuadro1.php?&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=3">III PARCIAL</option>
<option data-icon="temas/LMN2018/img/descargar_notas.png" class="left circle" value="<?php echo $urlweb?>reportes/rpt_cuadro1.php?&idclase_curso=<?php echo $idclase_curso?>&&idaño=<?php echo $idaño?>&&parcial=4">IV PARCIAL</option>
</select>
</div>
</div>
</div>
								</td><?php }?>
							</tr>
				<?php
						}
                  
						$s->close();
					}else{
						echo "<p>No tiene clases matriculadas para este año escolar</p>";
                    }
                    
                    
                    //cierre de consulta de valores retornados
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
 </ul>
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
$(document).ready( function () {
	      // bind change event to select
		  $('#seleccionaño').on('change', function () {
          var url = $(this).val(); // get selected value
          if (url) { // require a URL
			window.open(url, '_blank');
          }
          return false;
      });
$('table.display').DataTable();
});	
$('#seleccionaño').material_select();

function ver_detalles(idaño){
	$('#frmbloques').modal('open');
}
</script>
